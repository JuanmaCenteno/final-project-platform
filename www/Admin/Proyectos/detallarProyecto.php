

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Proyecto.php";
	include_once $server . "Clases/Valoracion.php";

	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
			$proyecto = Proyecto::get($_GET['id']);
			$idProyecto = $proyecto->getID();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Detalle del proyecto</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la informacion del proyecto-->
	<section>

		<div class="container containerEntregas">
			<div id="idProyecto" value="<?=$idProyecto;?>"></div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Proyecto</label>
				<div class="col-md-6 col-xs-6">
					<p><?=  $proyecto->getNombre(); ?></p>
				</div>
			</div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Tutor/es asignado/s</label>
				<div class="col-md-6 col-xs-6">
					<p><?=  $proyecto->getLinkTutor(); ?></p>
				</div>
			</div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Alumno/s asignado/s</label>
				<div class="col-md-6 col-xs-6">
					<p><?= $proyecto->getLinkAlumno(); ?></p>
				</div>
			</div>

			<br><br>

			<div class="row">
				<label class="col-md-10 col-md-offset-2 control-label">Descripción del proyecto</label>
			</div><br>

			<div class="row">
				<div class="col-md-8 col-md-offset-2 well well-sm">
					<p><?= $proyecto->getDescripcion(); ?></p>
				</div>
			</div>
			<br><br><br>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Lectura</label>
				<div class="col-md-6 col-xs-6">
					<?php
						$estado = $proyecto->getEstado();
						if($estado == 'Lectura'){
							$idLectura = $proyecto->getConvocatoria();
					?>
						<a href="../Convocatorias/Lectura/detallarLectura.php?idL=<?=$idLectura;?>">
							Lectura asignada
						</a>
					<?php
						}
					?>
				</div>
			</div><br>
			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label ">Nota final</label>
				<div class="col-md-6 col-xs-6">
					<p class="badge"><?=  $proyecto->getNotaFinal(); ?></p>
				</div>
			</div>
			<br><br><br>
			<?php
				if($proyecto->getNotaFinal() > 0){
			?>
			<div class="row">
				<h4 class="col-md-7 col-md-offset-2 col-xs-12">Sección de valoración del/los tutor/es</h4>
			</div>
			<div class="hueco"></div>
			<?php
					$tipo = 'Tutor'; 
					$valoraciones = Valoracion::getByProyectoRol($idProyecto,$tipo);
					if(sizeof($valoraciones) > 0){
			?>
			
			<div class="row">
				<h4 class="col-md-7 col-md-offset-2 col-xs-12">Valoración del/los tutor/es</h4>
			</div>
			<div class="hueco"></div>
			<?php
						include($server . "www/Comun/Presentacion/rellenarValTutor.php");		
					}
			?>

			<?php
					$tipo = 'Tribunal';  
					$valoraciones = Valoracion::getByProyectoRol($idProyecto,$tipo);
					if(sizeof($valoraciones) > 0){
			?>
			<br>
			<div class="row">
				<h4 class="col-md-7 col-md-offset-2 col-xs-12">Valoración del/los tribunal/es</h4>
			</div>
			<div class="hueco"></div>
			<?php
						include($server . "www/Comun/Presentacion/rellenarValTutor.php");
					}
				}
			?>

			<div class="row">
				<button type="button" class="btn btn-success col-md-3 col-md-offset-2 col-xs-10 col-xs-offset-1" id="cambiarDatos">
					Modificar datos
				</button>
				<button type="button" class="btn btn-danger col-md-3 col-md-offset-2 col-xs-10 col-xs-offset-1" id="confirmarEliminacion">
					Eliminar proyecto
				</button>
			</div>

		</div>

		<!-- Modal para confirmar eliminacion -->
		<div class="modal fade" id="modalEliminacion" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modalP-header">
						<h4 class="modal-title" id="myModalLabel">Eliminar proyecto</h4>
					</div>
					<div class="modal-body">
						Desea realmente eliminar el proyecto: <?= $proyecto->getNombre(); ?>
					</div>
					<div class="modal-footer modalP-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="button" id="eliminarProyecto" class="btn btn-success">Eliminar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal para modificar datos del proyecto -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modalDatos">
		    <div class="modal-dialog modal-lg" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Cambiar datos del proyecto</h4>
		            </div>
		            <div class="modal-body">
		                <div class="row">
							<label for="inputNombre" class="col-md-2 col-md-offset-1">Nombre</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="nuevoNombre" value="<?=$proyecto->getNombre();?>">
							</div>
						</div><br>
						<div class="row">
							<label for="nuevaDescripcion" class="col-md-2 col-md-offset-1">Descripcion</label>
							<div class="col-md-8">
								<textarea class="form-control" rows="10" id="nuevaDescripcion"><?=$proyecto->getDescripcion();?></textarea>
							</div>
						</div><br>
						<div class="row">
							<label for="nuevasPalabras" class="col-md-2 col-md-offset-1">Palabras clave</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="nuevasPalabras" value="<?=$proyecto->getPalabrasClave();?>">
							</div>
						</div><br>
						<div class="row">
							<label for="nuevaNota" class="col-md-2 col-md-offset-1">Nota final</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="nuevaNota" value="<?=$proyecto->getNotaFinal();?>">
							</div>
						</div><br>
						
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<div class="panel" style="background-color:#D8D8D8;">
				                    <div class="panel-heading labelPanel">
				                        <div class="modal-title">Tutores asignados</div>
				                    </div>
				                    <div class="panel-body">
				                    	<div class="input-group">
											<input type="text" class="form-control" id="busquedaProfe" placeholder="Añadir a...">
											<span class="input-group-btn">
												<button type="button" class="btn btn-primary" id="buscarProfe">Buscar</button>
											</span>
										</div>
										<ul id="listaProfesor" class="media-list"></ul>
										<br>
				                        <ul class="media-list" id="listaP">
				                            <?php
				                                $usuarios = [];
				                                $usuarios = $proyecto->getTutor();
				                                include('rellenarUsuarios.php');
				                            ?>
				                        </ul>
				                    </div>
				                </div>
				            </div>
				            <div class="col-md-10 col-md-offset-1">
				                <div class="panel" style="background-color:#D8D8D8;">
				                    <div class="panel-heading labelPanel">
				                        <div class="modal-title">Alumnos asignados</div>
				                    </div>
				                    <div class="panel-body">
				                    	<div class="input-group">
											<input type="text" class="form-control" id="busquedaAlumno" placeholder="Añadir a...">
											<span class="input-group-btn">
												<button type="button" class="btn btn-primary" id="buscarAlumno">Buscar</button>
											</span>
										</div>
										<ul id="listaAlumno" class="media-list"></ul>
										<br>
				                        <ul class="media-list" id="listaA">
				                            <?php
				                                $usuarios = [];
				                                $usuarios = $proyecto->getAlumno();
				                                include('rellenarUsuarios.php');
				                            ?>
				                        </ul>
				                    </div>
				                </div>
				            </div>
			            </div>
		            </div>

		            </div>
		            <div class="modal-footer modalP-footer">
		                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		                <button type="button" class="btn btn-success" id="confirmarDatos">Guardar</button>
		            </div>
		        </div>
		    </div>
		</div>



	</section>

	<footer>
		
	</footer>

	<script type="application/javascript" src="<?=$server_name;?>static/js/completar.js"></script>
	<script type="application/javascript" src="<?=$server_name;?>static/js/Proyecto/detallarProyecto.js"></script>
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