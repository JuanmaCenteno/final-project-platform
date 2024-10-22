

<?php
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Proyecto.php"; 

	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$idProyecto = $_GET['id'];
		$proyecto = Proyecto::get($idProyecto);
		if($proyecto->getID()!=null){
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Detallar proyecto</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la informacion del proyecto-->
	<section>

		<div class="container containerEntregas">
			<div class="row">
				<h4 class="col-md-7 col-md-offset-2 col-xs-12">Detalles del proyecto</h4>
			</div>
			<div class="hueco"></div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Proyecto</label>
				<div class="col-md-6 col-xs-6">
					<p><?=  $proyecto->getNombre(); ?></p>
				</div>
			</div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Tutor</label>
				<div class="col-md-6 col-xs-6">
					<p><?=  $proyecto->getLinkTutor(); ?></p>
				</div>
			</div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Alumno asignado</label>
				<div class="col-md-6 col-xs-6">
					<p><?= $proyecto->getLinkAlumno(); ?></p>
				</div>
			</div>

			<br><br>

			<div class="row">
				<label class="col-md-10 col-md-offset-2 control-label">Descripción del proyecto</label>
			</div><br>

			<div class="row">
				<div class="col-md-8 col-md-offset-2 well">
					<p><?= $proyecto->getDescripcion(); ?></p>
				</div>
			</div>
			<br><br><br><br>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label ">Nota final</label>
				<div class="col-md-6 col-xs-6">
					<p class="badge"><?=  $proyecto->getNotaFinal(); ?></p>
				</div>
			</div>
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
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>