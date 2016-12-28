<?php 

$html =	"<form role='form' class='formulario' id='formRegistro'>
		<legend>Nuevo Usuario</legend>
		<div class='form-group'>
		 	<label for='nomUser'>Nombre de Usuario</label>
		    <input type='text' class='form-control' placeholder='Nombre...' id='nomUser'>
		</div>
	  	<div class='form-group'>
	    	<label for='emailUser'>Email</label>
	    	<input type='text' class='form-control' placeholder='Correo...' id='emailUser'>
	  	</div>
	  	<div class='form-group'>
	    	<label for='passUser'>Contraseña</label>
	    	<input type='password' class='form-control' placeholder='Repita la contraseña...' id='passUser'>
	  	</div>
	  	<div class='form-group'>
	    	<label for='rpassUser'>Repita Contraseña</label>
	    	<input type='password' class='form-control' placeholder='Repita la contraseña...' id='rpassUser'>
	  	</div>
	  	</fieldset>
	  	<br/>
	    <button type='submit' class='btn btn-default center-block' id='btnRegistro'>Registrar</button>
	</form> ";

echo $html;



?>