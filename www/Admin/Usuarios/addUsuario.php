

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Usuario.php";


	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
		
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Crear nuevo usuario</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>
	
		<div class="container containerEntregas">
			<form class="form-horizontal" enctype="multipart/form-data">
				<!-- seccion a rellenar por el autor -->
				<div class="form-group">
					<label for="inputNombre" class="col-md-2 control-label">Nombre</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputNombre" name="Nombre" placeholder="Nombre de usuario" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputApellidos" class="col-md-2 control-label">Apellidos</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputApellidos" name="Apellidos" placeholder="Apellidos de usuario" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail" class="col-md-2 control-label">Email</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputEmail" name="Email" placeholder="Email de usuario" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDNI" class="col-md-2 control-label">DNI</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputDNI" name="DNI" placeholder="DNI de usuario" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputRol" class="col-md-2 control-label">Rol</label>
					<div class="col-md-8">
						<select class="form-control" id="inputRol">
							<option>Alumno</option>
							<option>Profesor</option>
							<option>Admin</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-8 col-md-offset-2">
						<p class="help-block">Aviso: La contraseña del usuario será su DNI</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5 col-xs-offset-2 control-label">
						<button id="btn-add" class="btn btn-primary">Añadir usuario</button>
						<a href="javascript:history.back()">
							<button type="button" class="btn btn-danger">Cancelar</button>
						</a>
					</div>
				</div>
				
			</form>
		</div>

	</section>

	<footer>
		
	</footer>

	<script type="application/javascript">
		$('#btn-add').on('click',function(){

		var user = new Object({
			nombre: $('#inputNombre').val(),
			apellidos: $('#inputApellidos').val(),
			email: $('#inputEmail').val(),
			dni: $('#inputDNI').val(),
			rol: $('#inputRol').val(),
			action: 'guardar'
			});

		//Crear usuarios
		$.post("ctrlUsuarios.php",user)
			.success(function(resp,estado,jqXHR){
				if(resp === "ok"){
					window.location='adminUsuarios.php';
				} else {
					console.log(resp);
				}
			})
			.error(function(xhr, textStatus, error){
					console.log(xhr.statusText);
					console.log(textStatus);
					console.log(error);
			});

	});
	</script>
</body>
</html>

<?php
		}else{
			echo "Sesion incorrecta";
		}
	}else{
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>