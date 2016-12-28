<?php 

session_start();
$accion = $_POST['accion'];
require_once('conectar.php');


$mysqli= new mysqli($DB["servidor"], $DB["usuario"], $DB["password"], $DB["nombre"]);

if ($mysqli -> connect_errno) {
	die('Fallo de conexion: '.$mysqli -> connect_error);
	exit();
}


/* ----------Login de Usuarios -------------- */
function LoginUsuario($mysqli, $email, $pass){

	$consulta=$mysqli->prepare("SELECT id_User, nombre, pass FROM usuario WHERE correo = ?");
	$consulta->bind_param('s', $email);
	$consulta->execute();
	$resultado=$consulta->get_result();
	$fila = mysqli_fetch_row($resultado);
	
	if (password_verify($pass, $fila[2])){

	 	$_SESSION['usuario'] = $fila[0];
	 	$_SESSION['nombre'] = $fila[1];
	 	$_SESSION['pass'] = $pass;
	 	echo "<script>alert ('Bienvenido a la web')</script>";
		echo "<script>$('#Panel').load('views/usuario.php')</script>";
		echo "<script>$('#Contenido').load('views/inicioSesion.php')</script>";
		
    }else {
    	echo "<script>alert ('El usuario no existe')</script>";
	 	echo "<script>$('#Contenido').load('views/inicioSesion.php')</script>";
	}$mysqli->close();
}
/* ---------- Registro de Usuarios -------------- */
function RegistroUsuario($mysqli, $nombre, $email, $pass, $rpass){
	
	if ($pass != $rpass) 
		{
 		echo "<script>alert ('Error, las contraseñas deben de coincidir')</script>";
 		
		}else{			

	if(isset($_SESSION['usuario'])){
			echo "<script>$('#Panel').load('views/usuario.php')</script>";
		}		

			$busque = $mysqli->prepare("SELECT * FROM usuario where correo = ?");
			$busque ->bind_param("s",$email);
			$busque ->execute();
			$resul=$busque->get_result();
			
			if ($resul->num_rows >0) 
	 		{
	 		echo "<script>alert ('El email ya existe, intentelo de nuevo')</script>";
	 		echo "<script>$('#Contenido').load('views/registroUser.php')</script>";
 			
	 		}else {

	 			$cif = password_hash($pass, PASSWORD_DEFAULT);

	 			$insercion = $mysqli->prepare("INSERT INTO usuario VALUES(?,?,?,?)");
				$insercion->bind_param("isss",$id_User, $nombre, $email, $cif);
				$insercion->execute();
				$mysqli->close();
				echo "<script>alert ('Usuario registrado')</script>";
				echo "<script>$('#Contenido').load('views/registroUser.php')</script>";
	 		}
	 	}
	 		
}

/* ---------------- Recuperacion de datos de usuario ----------------- */
function RecupDatos($mysqli, $correo){

require_once('../clases/class.phpmailer.php');
require_once('../clases/class.smtp.php');
require_once('mensajes.php');

			$busque = $mysqli->prepare("SELECT * FROM usuario where correo = ?");
			$busque ->bind_param("s",$correo);
			$busque ->execute();
			$resul=$busque->get_result();
			if($resul -> num_rows > 0){
				
				/*Creacion de nueva contraseña encriptada*/
				$fila = mysqli_fetch_row($resul);
				$cif = password_hash($fila[3], PASSWORD_DEFAULT);

				$actualizar = $mysqli->prepare("UPDATE usuario SET pass=? WHERE correo = ?");
				$actualizar ->bind_param("ss",$cif, $correo);
				$actualizar ->execute();
				$result=$actualizar->get_result();

				/////////
				EnvioMensaje($fila, $correo);
				
			}else{
				echo "<script>alert('El usuario no existe')</script>";
			}$mysqli->close();
}


/* -------------- Cierre de Sesion --------------*/
function CierreSesion(){

	
	unset($_SESSION['usuario']);
	session_destroy();

	echo "<script>alert ('Has cerrado sesion')</script>";
	echo "<script>location.href='index.php'</script>";
}



/* ------------- Datos de Usuario --------------- */
function Perfil($mysqli, $id){

	$busque = $mysqli->prepare("SELECT nombre, correo, pass FROM usuario where id_User = ?");
	$busque ->bind_param("s",$id);
	$busque ->execute();
	$resul=$busque->get_result();
	$fila = mysqli_fetch_row($resul);
	if($resul -> num_rows > 0){
		
		$html = "
			<div id='TablaUsuario'>
				<h3>Datos de usuario:</h3>
				<table class='table'>
					<tr>
						<td>Nombre: </td>
						<td>".$fila[0]."</td>
					</tr>
					<tr>
						<td>Correo: </td>
						<td>".$fila[1]."</td>
					</tr>
					<tr>
						<td>Contraseña: </td>
						<td>".$_SESSION['pass']."</td>
					</tr>
					<tr>
						<td><button type='submit' id='btnCamPass' class='btn btn-default center-block'>Cambiar Contraseña</button></td>
					</tr>
				</table>
			</div>
		";
		echo $html;
		//echo BandejaEntrada($mysqli, $_SESSION['nombre']);
    }$mysqli->close();

}

/* ------------- Cambio de Contraseña ------------ */
function CambioPass($mysqli, $newPass, $id){

	$cif = password_hash($newPass, PASSWORD_DEFAULT);

	$busque = $mysqli->prepare("UPDATE usuario SET pass =? WHERE id_User = ?");
	$busque ->bind_param("si",$cif, $_SESSION['usuario']);
	$busque ->execute();
	$resul=$busque->get_result();
	$_SESSION['pass'] = $newPass;
	$mysqli->close();
}



/* -------------- Envio de Mensajes entre usuarios ------------ */


function MensajesUser($mysqli, $destino, $asunto, $mensaje){

		$envio = $mysqli->prepare('SELECT nombre FROM usuario WHERE nombre = ?');
    	$envio->bind_param('s', $destino);
    	$envio->execute();
    	$resul = $envio->get_result();

    	if($resul->num_rows > 0){

    		$priv = $mysqli->prepare("INSERT INTO mensajesUsuario VALUES(?,?,?,?,?)");
			$priv ->bind_param("issss", $id_mensaje,$destino, $_SESSION['nombre'],$asunto,$mensaje);
			$priv ->execute();
			$resul=$priv->get_result();
			echo "<script>alert('Mensaje enviado')</script>";
			BandejaEntrada($mysqli, $_SESSION['nombre']);
			echo "<script>$('#Contenido').append($('<div>').load('views/formularioEnvioMens.php'))";

    	}else {
    		echo "<script>alert('El usuario no existe')</script>";
    	} 		
}

/* ------------ Aviso de Bandeja de entrada llena ---------------- */
function BandejaEntrada($mysqli, $nombre){

		$aviso = $mysqli->prepare('SELECT id_mensaje, remitente, asunto, mensaje FROM mensajesUsuario WHERE destinatario = ?');
    	$aviso->bind_param('s', $_SESSION['nombre']);
    	$aviso->execute();
    	$resul = $aviso->get_result();

    		$html = "<div id='BandejaEntrada'>
						<h3>Buzon</h3>
						<table class='table'>
							<tr>
								<td>Remitente</td>
								<td>Asunto</td>
								<td>Mensaje</td>
								<td></td>
							</tr>";
			echo $html;


			if($resul -> num_rows > 0){
				
       			while($row = $resul->fetch_assoc()) {
        			echo "<tr id=".$row["id_mensaje"].">
        					<td>".$row["remitente"]."</td>
        					<td>".$row["asunto"]."</td>
        					<td>".$row["mensaje"]."</td>
        					<td>
        						<a href='#' id='delMsn'>
        							<img id='imgBorrar' src='Img/borrarmsn.png' alt='borradoMsn' title='borradoMensajes'>
        						</a>
        					</td>
        				 </tr>";
        		}    		
    		}else{
        			echo "<tr>
        					<td><span id='BandejaVacia'>No hay mensajes en su bandeja</span></td>
        				 </tr>";
        		}  
    		$finTabla = "</table></div>";
			echo $finTabla;					    	    	
}


/* ---------------- Borrado de Mensajes ------------ */
function BorrarMensaje($mysqli, $id){
		
	$borrado = $mysqli->prepare('DELETE FROM mensajesUsuario WHERE id_mensaje = ?');
    $borrado->bind_param('i', $id);
    $borrado->execute();
    $resul = $borrado->get_result();

    	echo "<script>alert('Mensaje eliminado')</script>";
    	BandejaEntrada($mysqli, $_SESSION['nombre']);
		echo "<script>$('#Contenido').append($('<div>').load('views/formularioEnvioMens.php'))";    	


}

///CASOS AJAX ////
switch ($accion) {

    case "InicioSesion": 
        $correo=$_POST['email'];
        $pass=$_POST['pass'];              
        $html=LoginUsuario($mysqli, $correo, $pass);                         
        break;                

    case "RegistroUser": 
    	$nomUser=$_POST['nombre'];
    	$emailUser=$_POST['email'];
    	$passUser=$_POST['pass'];
        $rpassUser=$_POST['rpass'];      
        $html=RegistroUsuario($mysqli, $nomUser, $emailUser, $passUser, $rpassUser);                         
        break;   

    case "RecupDatos":
    	$emailUser=$_POST['email'];
    	$html=RecupDatos($mysqli, $emailUser); 
    	break;

    case "CierreSesion":
    	$html=CierreSesion();
    	break;

    case "PerfilUsuario":
    	$html = Perfil($mysqli,$_SESSION['usuario']);
    	break;

    case "CambioPass":
    	$newPass = $_POST['nuevaPass'];
    	$html = CambioPass($mysqli, $newPass, $_SESSION['usuario']);
    	break;

    case "MensajeUser":
    	$destino = $_POST['destino'];
    	$asunto = $_POST['asunto'];
    	$mensaje = $_POST['mensaje'];
    	$html = MensajesUser($mysqli, $destino, $asunto, $mensaje);
    	break;

    case 'BandejaEntrada':
    	$html = BandejaEntrada($mysqli, $_SESSION['nombre']);
    	break;

    case 'BorrarMensaje':
    	$id = $_POST['id'];
    	$html = BorrarMensaje($mysqli, $id);
    	break;
}


?>