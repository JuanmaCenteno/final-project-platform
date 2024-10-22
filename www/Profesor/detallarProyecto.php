
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Profesor.php";
	include_once $server . "Clases/Proyecto.php"; 

	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$profesor = new Profesor($_SESSION['usuario']);
		if($profesor->getRol()=='Profesor'){
			$proyecto = $profesor->getProyecto($_GET['id']);
			$estado = $proyecto->getEstado();
			//Comprobar acceso al proyecto, si el proyecto es null significa que no tiene acceso a ese proyecto
			$idProyecto = $proyecto->getID();
			if($idProyecto!=null){
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

				<?php
					if($estado == 'Pendiente aceptar'){
				?>
					<div>
						<a type="button" class="btn btn-success col-md-2 col-xs-12" href="../Alumno/Peticion/ctrlPeticion.php?action=aceptar&&idP=<?=$idProyecto;?>">
							<span class="glyphicon glyphicon-ok"></span>
							Aceptar para lectura
						</a>
					</div>

				<?php
					}
				?>
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

			<br><br><br>

			<!-- Entregas del proyecto -->

			<div class="col-md-10 col-md-offset-1">
				<!-- Panel de entregas realizadas por el alumno -->
				<div class="panel">
					<div class="panel-heading labelPanel">
						<h3 class="panel-title">Entregas del proyecto</h3>
					</div>
					<div class="panel-body">
						<div class="list-group" id="listaEntregas">
							<!--Lista de entregas que realiza el alumno-->
							<?php
								//Recuperamos las entregas y el id del proyecto
								$idproyecto = $proyecto->getID();
								$entregas = $proyecto->getEntregas();

								foreach($entregas as $entrega){
									//Recuperamos los datos a mostrar
									$identrega = $entrega->getID();
									$titulo = $entrega->getTitulo();
									$fecha = $entrega->getFecha(); 	
							?>

								<a href="../Comun/detallarEntrega.php?idE=<?=$identrega;?>&&idP=<?=$idproyecto;?>" class="cajaEntregas">
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
				//Redireccion porque no pertenece esa entrega al usuario
				//header("Location: '../../index.php'");
				echo "No tiene acceso a este proyecto";
			}
		}else{
			echo "Sesion incorrecta";
		}
	}else{
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>