

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Alumno.php";

	if(!empty($_SESSION['usuario'])){
		$alumno = new Alumno($_SESSION['usuario']);
		if($alumno->getRol()=='Alumno'){
			$proyecto = $alumno->getProyecto(1);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Realizar Entrega</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>
		<div class="container containerEntregas">

			<form action="ctrlEntregas.php" method="post" class="form-horizontal" enctype="multipart/form-data">
				<input type="text" class="form-control" name="action" value="guardar" style="display:none">
				<div class="form-group">
					<label class="col-md-2 control-label">Proyecto</label>
					<div class="col-md-8">
						<p class="form-control-static"><?= $proyecto->getNombre(); ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Autor</label>
					<div class="col-md-8">
						<p class="form-control-static"><?= $alumno->getNombreCompleto(); ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Tutor/es</label>
					<div class="col-md-8">
						<p class="form-control-static"><?= $proyecto->getLinkTutor(); ?></p>
					</div>
				</div>
				<!-- seccion a rellenar por el autor -->
				<div class="form-group">
					<label for="inputTitulo" class="col-md-2 control-label">Titulo de la entrega</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputTitulo" name="titulo" placeholder="Titulo de la entrega" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDescripcion" class="col-md-2 control-label">Descripción</label>
					<div class="col-md-8">
						<textarea class="form-control" rows="10" id="inputDescripcion" name="descripcion" placeholder="Haga una descripción de la entrega" required></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Adjuntar archivo</label>
					<div class="col-md-8">
						<input type="file" name="archivo">
						<p class="help-block">Añada los archivos correspondientes a la entrega para su corrección</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5 col-xs-offset-2 control-label">
						<button type="submit" class="btn btn-primary">Subir entrega</button>
						<a href="../../main/mainAlumno.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
					</div>
				</div>
			</form>
		</div>

	</section>

	<footer>
		
	</footer>

</body>
</html>

<?php
		}else{
			echo "Sesion incorrecta";
		}
	}else{
		$redir = $server . "index.php";
		header("Location: '$redir'");
	}
?>