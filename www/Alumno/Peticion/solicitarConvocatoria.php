

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Alumno.php";
	include_once $server . "Clases/Convocatoria.php";

	if(!empty($_SESSION['usuario'])){
		$alumno = new Alumno($_SESSION['usuario']);
		if($alumno->getRol() == 'Alumno'){
			$proyecto = $alumno->getProyecto(1);
			$idProyecto = $proyecto->getID();
			$estado = $proyecto->getEstado();
			if($estado == 'Aceptado'){
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Seleccion de convocatoria</title>
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
								<a type="button" href="#" class="seleccion" value="<?=$id;?>">
									<h4 class="list-group-item elemEntregas">
										<?=$nombre;?>
										<span class="badge">Desde <?=$fecha_inicio;?> hasta <?=$fecha_fin;?></span>
									</h4>
								</a>

								<!-- Modal para confirmar de la eleccion -->
						        <div class="modal fade" id="modalSeleccion<?=$id;?>" tabindex="-1" role="dialog">
								    <div class="modal-dialog" role="document">
								        <div class="modal-content">
								            <div class="modal-header modalP-header">
								                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								                <h4 class="modal-title">Seleccionar convocatoria</h4>
								            </div>
								            <div class="modal-body">
								                <h5>Seleccionó la convocatoria de <b><?=$nombre;?></b> para la presentación de su proyecto</h5>
								                <small>
													<span class="glyphicon glyphicon-info-sign"></span> 
													Se le notificará la convocatoria cuando la lectura este asignada y confirmada	
												</small>
								            </div>
								            <div class="modal-footer modalP-footer">
								                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
								                <button type="button" class="btn btn-success confirmar" value="<?=$id;?>">Confirmar</button>
								            </div>
								        </div>
								    </div>
								</div>

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

	<script type="application/javascript" src="<?=$server_name;?>static/js/Convocatoria/solicitarConvocatoria.js"></script>

</body>
</html>

<?php
			}else{
				echo "Su proyecto aun no fue aceptado por el profesor";
			}
		}else{
			echo "Sesion incorrecta";
		}
	}else{
		echo "No ha iniciado sesion";
	}
?>