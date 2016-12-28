<?php

$html =	"<form role='form' class='formulario' id='formIniSesion'>
		<legend>Inicio de Sesion</legend>
		<div class='form-group'>
		 	<label for='nomUser'>Usuario</label>
		    <input type='email' class='form-control' placeholder='Introduce tu Email' id='emailUser'>
		</div>
	  	<div class='form-group'>
	    	<label for='passUser'>Contraseña</label>
	    	<input type='password' class='form-control' id='passUser' placeholder='Contraseña'>
	  	</div>
	  	</fieldset>
	    <a href = '#' id='btnRecord'>¿Has olvidado tus datos?</a><button type='submit' id='btnIniSesion' class='btn btn-default center-block'>Enviar</button>
	</form>" ;

echo $html;



?>