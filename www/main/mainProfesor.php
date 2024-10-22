
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Profesor.php"; 

	if(!empty($_SESSION['usuario'])){
		$profesor = new Profesor($_SESSION['usuario']);
		$rol = $profesor->getRol();
		if( $rol == 'Profesor'){
			$proyectos = $profesor->getProyectos();
			$lecturas = $profesor->getLecturasAsignadas();
			$notificaciones = $profesor->getNotificaciones();
			
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Principal</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
	
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_principal.php") ?>
	</header>

	<section>

		<div class="container-fluid">

			<div class="row">

				<!-- Panel izquierdo-->
				<div class="col-md-4">
					<!-- Panel de identificacion -->
					<div class="panel">
						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Identificación</h3>
						</div>
						<div class="panel-body">
					    	<p class="col-md-4 col-xs-4"><b>Usuario:</b></p> 
					    		<p class="col-md-8 col-xs-8"><?= $profesor->getNombreCompleto(); ?></p>
					    	<p class="col-md-4 col-xs-4"><b>Rol:</b></p> 
					    		<p class="col-md-8 col-xs-8"><?= $profesor->getRol(); ?></p>
					  	</div>
					</div>
					<!-- Panel de notificaciones -->
					<div class="panel">
						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Notificaciones</h3>
						</div>
						<div class="panel-body" id="listaNotificaciones">
						    <!-- Lista de notificaciones -->
						    <?php include_once($server . "www/Comun/Notificaciones/rellenarNotificaciones.php") ?>
					  	</div>
					</div>
				</div>

				<!-- Panel derecho -->
				<div class="col-md-8">
					<!-- Panel de entregas realizadas por el alumno -->
					<div class="panel">
						<div class="panel-heading labelPanel">
	                        <div class="modal-title row">
	                            <h4 class="col-md-8 col-xs-12">Tutor de</h4>
	                        </div>
	                    </div>
						<div class="panel-body">
							<div class="list-group" id="listaProyectos">
								<!--Lista de proyectos que tiene el profesor asignados -->
								<?php
									foreach ($proyectos as $proyecto) {
										$idproyecto = $proyecto->getID();
										$nombre = $proyecto->getNombre();
										$entregas = sizeof($proyecto->getEntregas());
								?>
									<a href="../Profesor/detallarProyecto.php?id=<?=$idproyecto;?>" class="cajaEntregas">
										<h4 class="list-group-item elemEntregas">
											<?=$nombre;?>
											<span class="badge">Entregas realizadas: <?=$entregas?></span>
										</h4>
									</a>

									<!-- Avisos para cada proyecto -->
									<?php include("../Profesor/aviso.php"); ?>

								<?php
									}
								?>

							</div>
						</div>
					</div>

					<!-- Panel de las convocatorias que tiene un profesor como tribunal -->
					<div class="panel">
						<div class="panel-heading labelPanel">
	                        <div class="modal-title row">
	                            <h4 class="col-md-8 col-xs-12">Tribunal de</h4>
	                            <a href="../Profesor/pujarLecturas.php" type="button" class="btn btn-warning col-md-4 col-xs-12">
	                                Pujar
	                            </a>
	                        </div>
	                    </div>
						<div class="panel-body">
							<div class="list-group" id="listaProyectos">
								<!--Lista de lecturas -->

								<?php
									foreach ($lecturas as $lectura) {
										$proyecto = $lectura->getProyecto();
										$convocatoria = $lectura->getConvocatoria();
								?>
									<a href="../Comun/detallarLectura.php?idL=<?=$lectura->getID();?>" class="cajaEntregas">
										<h4 class="list-group-item elemEntregas">
											<?=$proyecto->getNombre();?>
											<span class="badge">Fecha: <?=$lectura->getFechaLectura();?></span>
											
										</h4>	
									</a>
								<?php
									}
								?>
							</div>
						</div>
					</div>
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
		header("Location: '../../index.php'");
	}
?>