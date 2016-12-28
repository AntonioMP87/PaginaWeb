<?php 

function EnvioMensaje($fila, $correo){

		//$fila = mysqli_fetch_row($fila);
	 	$asunto = "Cambiar contraseña";
	 	$destino = $correo;
		$mensaje = "<!DOCTYPE html>
			 		<html>
			 		<head>
			 			<title>Datos de inicio de Sesion</title>
			 		</head>
			 		<body>
			 			<h2>Datos de usuario</h2>
			 			<table>
			 				<tr>
			 					<td style='font-weight: bold';>Nombre:</td>
			 					<td>".$fila[2]."</td>
			 				</tr>
			 				<tr>
			 					<td style='font-weight: bold';>Contraseña:</td>
			 					<td>".$fila[3]."</td>
			 				</tr>
			 			</table>
			 			<p>Por favor, no olvide cambiar la contraseña en su proximo inicio de sesion.</p>
			 		</body>
			 		</html>";


	 	
	 	$mail = new  PHPMailer();
	 	$mail->IsSMTP();
	 	$mail->SMTPAuth = true;
	 	$mail->SMTPSecure = "ssl";
	 	$mail->Host = "smtp.gmail.com";
	 	$mail->Port = 465;
	 	$mail->CharSet = 'UTF-8';

	 	$mail->From = 'Correo a usar para enviar mensajes';
	 	$mail->FromName = 'Nombre de remitente';
	 	$mail->Username ='Nombre de usuario SMTP';
	 	$mail->Password ='Contraseña de la cuenta de correo a usar';

	 	$mail->AddAddress($destino);
	 	$mail->Subject = $asunto;
	 	$mail->MsgHTML($mensaje);

	 	if($mail->Send()){
	 		
	 		echo "<script>$('#Contenido').load('views/inicioSesion.php')</script>";
					               
	 	}else
	 		{
	 		echo "<script>alert ('El correo no existe')</script>";
	 		}
	
	 
}


?>