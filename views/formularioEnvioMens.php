<?php 

session_start();
 ?>




<form role='form' id='formEnvioMens'>
		<legend>Nuevo Mensaje</legend>
		<div class='form-group'>
		 	<label for='nomUser'>Nombre de Usuario:</label>
		    <input type='text' class='form-control' id='destinatario'>
		</div>
		<div class='form-group'>
	    	<label for='Asunto'>Asunto:</label>
	    	<input type="text" class='form-control' placeholder='Asunto...' id='AsuntoMens' rows = '5'/>
	  	</div>
	  	<div class='form-group'>
	    	<label for='Cuerpo'>Mensaje</label>
	    	<textarea class='form-control' placeholder='Inserte su mensaje...' id='CuerpoMens' rows = '5'/>
	  	</div>
	  	</fieldset>
	  	<br/>
	    <button type='submit' class='btn btn-default center-block' id='btnEnviarMens'>Enviar</button>
</form> 

