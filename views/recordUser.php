<?php 

$html = "

	<form role='form' class='formulario' id='recordUser'>
		<legend>Inicio de Sesion</legend>
		<div class='form-group'>
		 	<label for='nomUser'>Usuario</label>
		    <input type='email' class='form-control' placeholder='Introduce tu Email' id='emailUser'>
		</div>
	  	</fieldset>
	    	<button type='submit' id='btnRecordUser' class='btn btn-default center-block'>Enviar</button>
	</form>";

echo $html;

?>