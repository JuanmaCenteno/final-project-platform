
<?php
	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Solicitar Proyecto</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		
	</header>


	<section>
	
		<div class="container containerEntregas">
			<form class="form-horizontal" action="ctrlSolicitud.php" method="post" enctype="multipart/form-data">
				<h4 class="col-md-offset-1">Solicitud de petición para realizar el proyecto</h4>
				<div class="col-md-offset-2">
					<p class="help-block">
						Si son 2 o más alumnos o profesores, inserte cada dato separado por comas (Nombre1, Nombre2 ...)
					</p>
					<p class="help-block">
						Una vez creado su usuario podrá modificar cada campo, a exepción del DNI
					</p>
				</div>
				<div class="hueco"></div>


				<!-- Seccion para el usuario -->
				<div class="form-group">
					<label for="inputDNI" class="col-md-2 control-label">DNI</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="dni" placeholder="DNI del/los alumnos" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputNombre" class="col-md-2 control-label">Nombre y apellidos</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="alumno" placeholder="Nombre y apellidos del/los alumnos" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail" class="col-md-2 control-label">Email</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="email" placeholder="Email de usuario" required>
					</div>
				</div>

				<!-- Seccion para el proyecto -->
				<div class="form-group">
					<label class="col-md-2 control-label">Proyecto</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="proyecto" placeholder="Nombre del proyecto" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDescripcion" class="col-md-2 control-label">Descripción</label>
					<div class="col-md-8">
						<textarea class="form-control" rows="5" name="descripcion" placeholder="Descripcion del proyecto" required></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPalabras_clave" class="col-md-2 control-label">Palabras clave</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="palabras_clave" placeholder="Añada palabras que describan el proyecto" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPalabras_clave" class="col-md-2 control-label">Tutor/es</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="tutor" placeholder="Escriba el/los nombres de su/s tutor/es" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Clave de solicitud</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="clave" placeholder="Clave de solicitud" required>
						<p class="help-block">Solicite la clave en secretaria</p>
					</div>
				</div>

				<!-- Seccion para el anteproyecto -->
				<div class="form-group">
					<label class="col-md-2 control-label">Adjuntar archivo</label>
					<div class="col-md-8">
						<input type="file" name="archivo">
						<p class="help-block">Añada los archivos correspondientes al Anteproyecto</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5 col-xs-offset-2 control-label">
						<button type="submit" class="btn btn-success">Enviar solicitud</button>
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
</body>
</html>