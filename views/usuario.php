<?php
session_start();
 ?>




<div id="pLater" class="panel panel-default">
  <div class="panel-heading">

  	<?php 
  		if(isset($_SESSION['usuario'])){
			echo 'Bienvenido '.$_SESSION['nombre']."<a href='#' class='scroll' id='cerrarSesion'><img src = 'Img/exit.png' id='iconExit' alt='iconSalida' title='Cerrar Sesion'/></a>";
		}
    ?>	
 </div>

	 <div class="panel-body">
	    <ul>
	    	<li>
	    		<a href="#" id='datosPers'>Mis Datos</a>
	    		<img src = 'Img/user.jpg' alt='datosUsuario' title='Perfil' class="imagenes" />
	    	</li>
	    	<li>
	    		<a href="#" id='mensajes'>Mis mensajes</a>
	    		<img src = 'Img/sobre.png' alt='datosMensajes' title='Mensajes' class = "imagenes"/>
	    	</li>
	    	<li>
	    		<a href="#">Publicar</a>
	    		<img src = 'Img/publicar.png' alt='publicar' title='Publicar' class = "imagenes"/>
	    	</li>
	  		<li>
	  			<a href="#">Mis Publicaciones</a>
	  			<img src = 'Img/publicaciones.jpg' alt='datosPubli' title='Publicaciones' class = "imagenes"/>
	  		</li>
	  	</ul>
	 </div>
 </div>


