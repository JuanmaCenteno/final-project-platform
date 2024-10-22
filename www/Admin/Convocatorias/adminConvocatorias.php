

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Convocatoria.php";

	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol() == 'Admin'){
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Gestión de convocatorias</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la lista de convocatorias abiertas -->
	<section>

		<div class="container">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-heading labelPanel">
		                <div class="modal-title row">
		                    <h4 class="col-md-8 col-xs-12">Convocatorias abiertas</h4>
		                    <a href="addConvocatoria.php" type="button" class="btn btn-warning col-md-4 col-xs-12">
		                        <span class="glyphicon glyphicon-plus"></span> Añadir convocatoria
		                    </a>
		                </div>
		            </div>
					<div class="panel-body">
						<div class="list-group">
							<?php
								$convocatorias = Convocatoria::getConvocatorias();

								foreach ($convocatorias as $convo) {
									$id = $convo->getID();
									$nombre = $convo->getNombre();
									$fecha_inicio = $convo->getFechaInicio();
									$fecha_fin = $convo->getFechaFin();	
								
							?>
								<a class="cajaEntregas" href="detallarConvocatoria.php?id=<?=$id;?>">
									<h4 class="list-group-item elemEntregas">
										<?=$nombre;?>
										<span class="badge"><?=$fecha_inicio;?> hasta <?=$fecha_fin;?></span>
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