<script type="text/javascript">
			
			$(document).ready(function(){
				var urlPHP = 'controllers/funciones.php';
				$('#reloj').hide();
			/* ------- Carga formulario Login ------------*/
			$('#MenuEncabezado').on("click",'#btnCallLogin', function(ev) {  									
    			ev.preventDefault();
   				$('#Contenido').html('');
   				$("#Contenido").load("views/inicioSesion.php");

    		});

			/* ------- Verificar datos usuarios -----------*/
			$("#Contenido").on('click', '#btnIniSesion', function(ev){
    			ev.preventDefault()
    			var validMail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    			$('.mnsError').remove();

    			
    			if($('#emailUser').val() == '' || !validMail.test($('#emailUser').val())){
    				$('#emailUser').focus().after("<span class='mnsError' id='error3'>Introduzca un email valido</span>"); 
    				
    				$('#emailUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error3').fadeOut();
	    				}
					});
    			}
    			if($('#passUser').val() == ''){
    				$('#passUser').focus().after("<span class='mnsError' id='error4'>Debe de introducir una contraseña</span>"); 
    				
    				$('#passUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error4').fadeOut();
	    				}
					});
    			}
    			
    			
    			if($('.mnsError').length){
    				alert('Por favor, rellene todos los campos');
  					ev.preventDefault();
    					return false;
    				}else 
    					{
    						var datos={
              					"email":$('#emailUser').val(),
              					"pass":$('#passUser').val(),
              					"accion":"InicioSesion"
              			}
              			$.ajax({
                					type:"post",   
					                url:urlPHP,    
					                data:datos,
					                success: function(data){
					                  $('#Contenido').html(data);					                  
					            	}
					            });
    					}
			});

			/* ------- Carga formulario Registro ------------*/
			$('#MenuEncabezado').on("click",'#btnCallRegister', function(ev) {
    			ev.preventDefault();

    			$('#Contenido').html('');
    			$('#Contenido').load("views/registroUser.php");
    			
			});


			/* ------- Validacion de campos de Registro + Insercion en BDD ------------ */
			$("#Contenido").on('click', '#btnRegistro', function(ev){
    			ev.preventDefault()
    			var validMail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    			$('.mnsError').remove();

    			if($('#nomUser').val() == ''){
    				$('#nomUser').focus().after("<span class='mnsError' id='error1'>El nombre de usuario esta vacio</span>");
   
    				$('#nomUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error1').fadeOut();
    					}
					});
    			}
    			
    			if($('#emailUser').val() == '' || !validMail.test($('#emailUser').val())){
    				$('#emailUser').focus().after("<span class='mnsError' id='error2'>Introduzca un email valido</span>"); 
    				
    				$('#emailUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error3').fadeOut();
	    				}
					});
    			}
    			if($('#passUser').val() == ''){
    				$('#passUser').focus().after("<span class='mnsError' id='error3'>Debe de introducir una contraseña</span>"); 
    				
    				$('#passUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error4').fadeOut();
	    				}
					});
    			}
    			if($('#rpassUser').val() == '' || $('#passUser').val() != $('#rpassUser').val()){
    				$('#rpassUser').focus().after("<span class='mnsError' id='error4'>Las contraseñas deben coincidir</span>"); 

    				$('#rpassUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error4').fadeOut();
	    				}
					});
    				
    			}
    			
    			if($('.mnsError').length){
    				alert('Faltan datos por rellenar');
  					ev.preventDefault();
    					return false;
    				}else 
    					{
    						var datos={
              					"nombre":$('#nomUser').val(),
              					"email":$('#emailUser').val(),
              					"pass":$('#passUser').val(),
              					"rpass":$('#rpassUser').val(),
              					"accion":"RegistroUser"
              			}
              			$.ajax({
                					type:"post",   
					                url:urlPHP,    
					                data:datos,
					                success: function(data){
					                  $('#Contenido').html(data);
					                  
					            	}
					            });
    					}
			});

			/* ------ Carga de formulario de Recordar Datos  -----------*/
			$('#Contenido').on("click",'#btnRecord', function(ev) {  									
    			ev.preventDefault();
   				$('#Contenido').html('');
   				$("#Contenido").load("views/recordUser.php");
    		});

			/* ------ Envio de datos de Recordatorio mas validacion ---------*/

			$("#Contenido").on('click', '#btnRecordUser', function(ev){
    			ev.preventDefault()
    			var validMail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    			$('.mnsError').remove();

    			
    			if($('#emailUser').val() == '' || !validMail.test($('#emailUser').val())){
    				$('#emailUser').focus().after("<span class='mnsError' id='error3'>Introduzca un email valido</span>"); 
    				
    				$('#emailUser').keyup(function(){
						if($(this).val() != ''){
	    					$('#error3').fadeOut();
	    				}
					});
    			}
    			
    			if($('.mnsError').length){
    				alert('Por favor, rellene todos los campos');
  					ev.preventDefault();
    					return false;
    				}else 
    					{
    						var datos={
              					"email":$('#emailUser').val(),
              					"accion":"RecupDatos"
              			}
              			$.ajax({
                					type:"post",   
					                url:urlPHP,    
					                data:datos,
					                success: function(data){
					                  $('#Mensajes').html("<span id='MensajeEnvio'>Se ha enviado un correo con sus datos</span>");
					                  $('#MensajeEnvio').fadeOut(5000);
					                  $('#Contenido').html(data);
					                  
					            	}
					            });
    					}
			});

			/* ------------ Llamada a Cierre de Sesion -------------- */
			$('#Panel').on('click', '#cerrarSesion', function(ev){
				ev.preventDefault();
				var datos = {
					"accion": "CierreSesion"
				}
				$.ajax({
						type:"post",   
					    url:urlPHP,    
					    data:datos,
					    success: function(data){
					          $('#pLater').html('');
					          $('#Contenido').html(data);
					    }	
				});
			});			

			/* --------------- Perfil de usuario -------------------- */
			$('#Panel').on('click', '#datosPers', function(ev){
				ev.preventDefault();
				var datos = {
					"accion": "PerfilUsuario"
				}
				$.ajax({
						type:"post",   
					    url:urlPHP,    
					    data:datos,
					    success: function(data){
					           $('#Contenido').html(data);
					    }	
				});
			});

			/* ------------- Cambio de contraseña desde perfil -------*/
			$('#Contenido').on('click', '#btnCamPass', function(ev){
				ev.preventDefault();
				
				$("#Contenido tr:last").append(
					"<td><input type='password' id='newPass' class='form-control' placeholder='Nueva Contraseña'></input></td><td></td>"

				);
				$("#TablaUsuario").append(
					"<button type='submit' id='GCambios' class='btn btn-default center-block'>Guardar Cambios</button>"
				);
				$('#btnCamPass').attr("disabled", true);

			});


			/* ---------- Ejecucion cambio de contraseña --------- */
			$('#Contenido').on('click', '#GCambios', function(ev){
				ev.preventDefault();
				var datos = {
					"nuevaPass": $('#newPass').val(),
					"accion": "CambioPass"
				}
				$.ajax({
						type:"post",
						url:urlPHP,
						data:datos,
						success:function(data){
								$('#Contenido').html(data);
						}
				});
			});


			/* ---------- Carga de formulario de mensajes entre users -------- */
			$('#Panel').on('click', '#mensajes', function(ev){
				ev.preventDefault();
				$('#Contenido').html('');
				/*Visualizacion Bandeja*/
				var datos = {
					"accion": "BandejaEntrada"
				}
				$.ajax({
						type:"post",
						url:urlPHP,
						data:datos,
						success:function(data){
								$('#Contenido').html(data);
								$("#Contenido").append($("<div>").load("views/formularioEnvioMens.php"));

						}
				});
			});

			/* --------- Envio de mensaje + Comprobacion de bandeja de entrada ----- */
			$('#Contenido').on('click', '#btnEnviarMens', function(ev){
				ev.preventDefault();
				var datos = {
					"destino": $('#destinatario').val(),
					"asunto": $('#AsuntoMens').val(),
					"mensaje": $('#CuerpoMens').val(),
					"accion": "MensajeUser"
				}
				$.ajax({
						type:"post",
						url:urlPHP,
						data:datos,
						success:function(data){
								$('#Contenido').html(data);
						}
				});
			});

			/* -------- Borrado de Mensajes -------------- */
			$('#Contenido').on('click', '#delMsn', function(ev){
				
				if(confirm("¿Deseas borrar este mensaje?")){
					
					var datos = {
						
					"id":($(this).parent().parent().attr('id')),
					"accion": "BorrarMensaje"
					}
					$.ajax({
						type:"post",
						url:urlPHP,
						data:datos,
						success:function(data){
								$('#Contenido').html(data);
						}
					});
				
				}
			
			});



		/////




   });


</script>