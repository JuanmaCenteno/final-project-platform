

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Usuario.php";
	include_once $server . "Clases/Proyecto.php";
	include_once $server . "Clases/Presentacion.php";
	include_once $server . "Clases/Valoracion.php";

	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$dni = $_SESSION['usuario'];
		$usuario = Usuario::get($dni);
		$rol = $usuario->getRol();
		$idProyecto = $_GET['id'];
		$proyecto = Proyecto::get($idProyecto);
		if($proyecto->getID()!=null){
			$tipoAcceso = $proyecto->getAcceso($dni,$rol);
			if($tipoAcceso != false){
				$estado = $proyecto->getEstado();
				if($estado == 'Lectura'){
					$idLectura = $proyecto->getConvocatoria();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Detallar presentación</title>
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
			</div><br>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Nota final del Proyecto</label>
				<div class="col-md-6 col-xs-6">
					<p class="badge"><?= $proyecto->getNotaFinal(); ?></p>
				</div>
			</div>
			<br><br><br>

			<?php
				switch ($tipoAcceso) {
					case 'Alumno':
						include_once('entregarAlumno.php');
						break;
					case 'Tutor':
						include_once('entregarTutor.php');
						break;
					case 'Tribunal':
						include_once('entregarTribunal.php');
						break;
					default:
						break;
				}
			?>

		</div>

	</section>

	<footer>
		
	</footer>

</body>
</html>



<?php
			}else{
				header("Location: ../detallarProyecto.php?id=".$idProyecto);
			}
		}else{
			header("Location: ../detallarProyecto.php?id=".$idProyecto);
		}
	}else{
		echo "No existe el proyecto";
	}
}else{
	echo "No ha iniciado sesion";
}
?>
