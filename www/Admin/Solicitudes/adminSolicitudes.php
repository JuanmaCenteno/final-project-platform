

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Solicitud.php";

	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol() == 'Admin'){
			$solicitudesPendientes = Solicitud::getPendientes();
			$solicitudesAceptadas = Solicitud::getAceptadas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Gestion de usuarios</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la gestion de Solicitudes -->
	<section>

		<div class="container">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-heading labelPanel">
		                <div class="modal-title row">
		                    <h4 class="col-md-8 col-xs-12">Solicitudes pendientes</h4>
		                </div>
		            </div>
					<div class="panel-body">
						<!-- Lista de solicitudes -->
						<div class="list-group">
							<?php
									foreach ($solicitudesPendientes as $solicitud) {
										$idSolicitud = $solicitud->getID();
										$proyecto = $solicitud->getProyecto();
										$nombre = $solicitud->getAlumno();
										$pc = $solicitud->getPalabrasClave();
								?>
									<a href="detallarSolicitud.php?id=<?=$idSolicitud;?>">
										<h4 class="list-group-item elemEntregas">
											<?=$proyecto;?>
											<span class="badge">Autor: <?=$nombre;?></span>
										</h4>	
									</a>
								<?php
									}
								?>
						</div>
					</div>
					<div class="panel-footer" style="background-color:#D8D8D8;">
						<small>
							<span class="glyphicon glyphicon-info-sign"></span>
							Se muestran todas las solicitudes pendientes.
						</small>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="panel">
					<div class="panel-heading labelPanel">
		                <div class="modal-title row">
		                    <h4 class="col-md-8 col-xs-12">Solicitudes aceptadas</h4>
		                </div>
		            </div>
					<div class="panel-body">
						<!-- Lista de solicitudes -->
						<div class="list-group">
							<?php
									foreach ($solicitudesAceptadas as $solicitud) {
										$idSolicitud = $solicitud->getID();
										$proyecto = $solicitud->getProyecto();
										$nombre = $solicitud->getAlumno();
										$pc = $solicitud->getPalabrasClave();
								?>
									<a href="detallarSolicitud.php?id=<?=$idSolicitud;?>">
										<h4 class="list-group-item elemEntregas">
											<?=$proyecto;?>
											<span class="badge">Autor: <?=$nombre;?></span>
										</h4>	
									</a>
								<?php
									}
								?>
						</div>
					</div>
					<div class="panel-footer" style="background-color:#D8D8D8;">
						<small>
							<span class="glyphicon glyphicon-info-sign"></span>
							Se muestran todas las solicitudes que ya fueron aceptadas.
						</small>
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
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>