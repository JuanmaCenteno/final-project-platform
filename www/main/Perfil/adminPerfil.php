
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Usuario.php";


	if(!empty($_SESSION['usuario'])){
		$usuario = new Usuario($_SESSION['usuario']);
		
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Perfil</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>
		<div class="container">
			<div id="dni" value="<?=$usuario->getDNI();?>"></div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2" >

					<div class="panel">

						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Informacion personal</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<!-- Imagen -->
								<div class="col-md-3 col-lg-3" align="center">
									<img alt="Foto usuario" src="<?=$usuario->getFoto();?>" class="img-rounded img-responsive"> 
								</div>
								<div class=" col-md-9 col-lg-9"> 
									<table class="table table-user-information">
										<tbody>
											<tr>
												<td>Nombre</td>
												<td><?= $usuario->getNombre();?></td>
											</tr>
											<tr>
												<td>Apellidos</td>
												<td><?= $usuario->getApellidos();?></td>
											</tr>
											<tr>
												<td>DNI</td>
												<td><?= $usuario->getDNI();?></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><a href="mailto:<?= $usuario->getEmail();?>"><?= $usuario->getEmail();?></a></td>
											</tr>
											
										</tbody>
									</table>
									<a href="#" class="col-xs-12 col-md-12 btn btn-success" id="cambiarDatos">Cambiar</a>
								</div>
							</div>
						</div>

						<div class="panel-heading labelPanel labelPanelSB">
							<h3 class="panel-title">Cambiar contraseña</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3 col-lg-3" align="center">
									<div id="pswd_info">
										<h4>La contraseña debería cumplir con los siguientes requerimientos:</h4>
										<ul>
											<li>Al menos debería tener <strong>una letra</strong></li>
											<li>Al menos debería tener <strong>una letra en mayúsculas</strong></li>
											<li>Al menos debería tener <strong>un número</strong></li>
											<li>Debería tener <strong>8 carácteres</strong> como mínimo</li>
										</ul>
									</div> 
								</div>
								<div class=" col-md-9 col-lg-9 "> 
									<table class="table table-user-information">
										<tbody>
											<tr>
												<td>Nueva Contraseña:</td>
												<td><input type="password" class="form-control" id="newPass1"></td>
											</tr>

											<tr>
												<td>Confirmar Nueva Contraseña:</td>
												<td><input type="password" class="form-control" id="newPass2"></td>
											</tr>
										</tbody>
									</table>

									<a href="#" class="col-xs-12 col-md-12 btn btn-success" id="cambiarPass">Cambiar Contraseña</a>

								</div>
							</div>
						</div>
	                    <div class="panel-footer" style="background-color:#D8D8D8;" id="infoPass">
							<small>
								<span class="glyphicon glyphicon-info-sign"></span> 
								Las contraseñas no coinciden
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>



		<!-- Modal para rellenar datos del perfil -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modalDatos">
		    <div class="modal-dialog modal-lg" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Cambiar datos del perfil</h4>
		            </div>
		            <div class="modal-body">
		                <div class="row">
							<label for="inputNombre" class="col-md-2 col-md-offset-1">Nombre</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="inputNombre" value="<?= $usuario->getNombre();?>">
							</div>
						</div><br>
						<div class="row">
							<label for="inputApellidos" class="col-md-2 col-md-offset-1">Apellidos</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="inputApellidos" value="<?= $usuario->getApellidos();?>">
							</div>
						</div><br>
						<div class="row">
							<label for="inputEmail" class="col-md-2 col-md-offset-1">Email</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="inputEmail" value="<?= $usuario->getEmail();?>">
							</div>
						</div><br>
						<div class="row">
							<label class="col-md-2 col-md-offset-1">Cambiar foto</label>
							<div class="col-md-8">
								<input type="file" id="inputArchivo">
								<p class="help-block">Añada la foto que quiere que se muestre como perfil</p>
							</div>
						</div><br>
		            </div>
		            <div class="modal-footer modalP-footer">
		                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		                <button type="button" class="btn btn-success" id="confirmarDatos">Guardar</button>
		            </div>
		        </div>
		    </div>
		</div>

	</section>

	<footer>
		
	</footer>

	<script type="text/javascript">

		$(document).ready(function(){

			$('#cambiarDatos').on('click',function(){
				$('#modalDatos').modal('show');
			});

			$('#confirmarDatos').on('click',function(){

				var inputFileImage = document.getElementById("inputArchivo");
				var file = inputFileImage.files[0];
				var data = new FormData();

				data.append('archivo',file);
				data.append('dni',$('#dni').attr('value'));
				data.append('nombre', $('#inputNombre').val());
				data.append('apellidos', $('#inputApellidos').val());
				data.append('email', $('#inputEmail').val());
				data.append('action', 'cambiarDatos');

				var url = 'ctrlPerfil.php';
				$.ajax({
					url:url,
					type:'POST',
					contentType:false,
					data:data,
					processData:false,
					cache:false
				})
					.success(function(resp,estado,jqXHR){
						console.log(resp);
						if(resp){
							$('#modalDatos').modal('hide');
							window.location.reload();
						} else {
							console.log(resp);
						}
					})
					.error(function(){
						console.log("Error en la peticion");
					});
			});


			//Gestion de la contraseña
			$('#newPass1').on('keyup',function(){
				validarPass($(this).val());
			}).focus(function() {
		        $('#pswd_info').show();
		    }).blur(function() {
		        $('#pswd_info').hide();
		    });

			//Validador de contraseñas
			function validarPass(password){
				if(password.length >= 8){
			        var regex = /^(?=.*[a-z]).+$/; //Minusculas
			        if(regex.test(password) ) {
			        	var regex = /^(?=.*[A-Z]).+$/; // Mayusculas
			            if( regex.test(password) ) {
			            	var regex = /^(?=.*[0-9_\W]).+$/; // Caracter especial
				            if( regex.test(password) ) {
				                $('#newPass1').css('border-color','green');
				                $('#infoPass').hide();
				            }else{
				            	$('#newPass1').css('border-color','red');
				            }  
			            }else{
			            	$('#newPass1').css('border-color','red');
			            }  
					}else{
						$('#newPass1').css('border-color','red');
					}
			    }else{
			    	$('#newPass1').css('border-color','red');
			    }
			};

			$('#newPass2').on('keyup',function(){
				validar2Pass($(this).val(),$('#newPass1').val());
			});

			//Comprobador de passwords
			function validar2Pass(pass1,pass2){
				if((pass1 != pass2) || (pass1 == "")){
					$('#newPass2').css('border-color','red');
				}else{
					$('#newPass2').css('border-color','green');
					$('#infoPass').hide();
				}
			};

			//Cambiar contraseña
			$('#cambiarPass').on('click',function(){
				
				if( $('#newPass1').css('border-color')=='rgb(0, 128, 0)' && 
					$('#newPass2').css('border-color')=='rgb(0, 128, 0)'
					){
					
					var user = new Object({
						dni: $('#dni').attr('value'),
						pass: $('#newPass1').val(),
						action: 'cambiarPass'
						});

					//Cambiar contraseña
					$.post("ctrlPerfil.php",user)
						.success(function(resp,estado,jqXHR){
							console.log(resp);
							if(resp){
								//window.location.reload();
								$('.panel-footer').empty();
								$('.panel-footer').show();
								$('.panel-footer').html('Su contraseña ha sido actualizada.');
							} else {
								console.log(resp);
							}
						})
						.error(function(){
							console.log("Error en la peticion");
						});

				}else{
					$('#infoPass').show();
				}
			});
		});
	</script>
</body>
</html>

<?php
	}else{
		$redir = $server . "index.php";
		header("Location: '$redir'");
	}
?>
