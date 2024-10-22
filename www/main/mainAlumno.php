
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Alumno.php"; 

	if(!empty($_SESSION['usuario'])){
		$alumno = new Alumno($_SESSION['usuario']);
		$rol = $alumno->getRol();
		if($rol == 'Alumno'){
			$proyecto = $alumno->getProyecto(1);
			$notificaciones = $alumno->getNotificaciones();
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
						    	<p class="col-md-8 col-xs-8"><?= $alumno->getNombreCompleto(); ?></p>
						    <p class="col-md-4 col-xs-4"><b>Proyecto:</b> </p>
						    	<a href="../Comun/detallarProyecto.php?id=<?=$proyecto->getID();?>">
						    		<p class="col-md-8 col-xs-8 badge"><?=$proyecto->getNombre();?></p>
						    	</a>

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
					<?php
						if($proyecto->getID()!=null){
							$lectura = $proyecto->getLectura();
							
					?>
					<div class="panel">
						<div class="panel-heading labelPanel">
	                        <div class="modal-title row">
	                            <h4 class="col-md-5 col-xs-12">Entregas realizadas</h4>
	                            <?php include_once($server . "www/Alumno/Peticion/peticion.php"); ?>
	                            <a href="../Alumno/Entregas/realizarEntrega.php" type="button" class="btn btn-warning col-md-3 col-md-offset-1 col-xs-12" style="float:right;">
	                                <span class="glyphicon glyphicon-plus"></span> Realizar entrega
	                            </a>
	                        </div>
	                    </div>
						<div class="panel-body">
							<?php include_once($server . "www/Alumno/aviso.php"); ?>

							<div class="list-group" id="listaEntregas">
								<!--Lista de entregas que realiza el alumno-->
							<?php
								//Recuperamos las entregas y el id del proyecto
								$idProyecto = $proyecto->getID();
								$entregas = $proyecto->getEntregas();

								for($e=0;$e<sizeof($entregas);$e++){
									//Recuperamos los datos a mostrar
									$idEntrega = $entregas[$e]->getID();
									$titulo = $entregas[$e]->getTitulo();
									$fecha = $entregas[$e]->getFecha(); 	
							?>

								<a href="../Comun/detallarEntrega.php?idP=<?=$idProyecto;?>&&idE=<?=$idEntrega;?>">
									<h4 class="list-group-item elemEntregas">
										<?=$titulo;?>
										<span class="badge"><?=$fecha;?></span>
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
								Solo podrá solicitar su lectura si su tutor acepto su solicitud, la cual se podrá pedir
								cuando realice 1 ó más entregas.
							</small>
						</div>
					</div>

					<?php
						}else{	
					?>
						<div class="panel">
						<div class="panel-heading labelPanel">
	                        <div class="modal-title row">
	                            <h4 class="col-md-8 col-xs-12">Sin proyecto asignado</h4>
	                        </div>
	                    </div>
						<div class="panel-body">
							Espere a que se confirme su proyecto, o pregunte en secretaria.
						</div>
					<?php
						}
					?>
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