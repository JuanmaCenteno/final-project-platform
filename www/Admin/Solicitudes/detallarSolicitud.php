

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Solicitud.php";

	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
			$solicitud = Solicitud::get($_GET['id']);
			$idArchivo = $solicitud->getArchivo();
			$alumno = Usuario::getUsuarioByNombre($solicitud->getAlumno());
			$tutor = Usuario::getUsuarioByNombre($solicitud->getTutor());
			$dniTutor = [];
			foreach ($tutor as $t) {
				array_push($dniTutor, $t->getDNI());
			}
			$dniAlumno = [];
			foreach ($alumno as $a) {
				array_push($dniAlumno, $a->getDNI());
			}
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
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la informacion del proyecto-->
	<section>

		<div class="container containerEntregas">

			<div id="inputDNITutores" style="display:none;"><?=json_encode($dniTutor);?></div>
			<div id="inputDNIAlumno" style="display:none;"><?=json_encode($dniAlumno);?></div>
			<div id="inputID" value="<?=$solicitud->getID();?>"></div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Alumno/s</label>
				<div class="col-md-6 col-xs-6">
					<p id="inputAlumno"><?=  $solicitud->getAlumno(); ?></p>
				</div>
			</div>
			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">DNI del/los alumnos</label>
				<div class="col-md-6 col-xs-6">
					<p id="inputDNI"><?= $solicitud->getDNI(); ?></p>
				</div>
			</div>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Email del/los alumnos</label>
				<div class="col-md-6 col-xs-6">
					<p id="inputEmail"><?= $solicitud->getEmail(); ?></p>
				</div>
			</div>

			<br><br>

			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Tutor/es</label>
				<div class="col-md-6 col-xs-6">
					<p id="inputTutor"><?=  $solicitud->getTutor(); ?></p>
				</div>
			</div>
			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Proyecto</label>
				<div class="col-md-6 col-xs-6">
					<p id="inputProyecto"><?=  $solicitud->getProyecto(); ?></p>
				</div>
			</div>
			<div class="row">
				<label class="col-md-10 col-md-offset-2 control-label">Descripción del proyecto</label>
			</div><br>
			<div class="row">
				<div class="col-md-8 col-md-offset-2 well well-sm">
					<p id="inputDescripcion"><?= $solicitud->getDescripcion(); ?></p>
				</div>
			</div>
			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Palabras clave</label>
				<div class="col-md-6 col-xs-6">
					<p id="inputPalabrasClave"><?= $solicitud->getPalabrasClave(); ?></p>
				</div>
			</div>
			<br><br><br>


			<div class="row">
				<label class="col-md-2 col-md-offset-2 control-label">Archivo adjunto</label>
				<div class="col-md-6">
					<?php
						if($idArchivo != NULL){
							$_SESSION['idA'] = $idArchivo;
					?>
						<a href="../../Funciones/descargarArchivo.php">
							<span class="glyphicon glyphicon-download-alt"></span> 
							Descargar archivo
						</a>
					<?php
						}else{
					?>
						<span class="glyphicon glyphicon-remove"></span>
						No hay archivos
					<?php
						}
					?>
						<p class="help-block">Se descargaran los archivos correspondientes al anteproyecto</p>
				</div>
			</div>
			<br><br>
			<div class="form-group">
				<div class="col-md-8 col-md-offset-2 control-label">

					<?php
						if($solicitud->getAceptado()!='si'){
					?>
					<button id="btn-validar" class="col-xs-12 col-md-4 btn btn-success">Validar y generar proyecto</button>
					<button id="btn-usuario" class="col-xs-12 col-md-4 btn btn-primary">Generar usuario</button>
					<a href="javascript:history.back()"><button type="button" class="col-xs-12 col-md-4 btn btn-danger">Cancelar</button></a>
					<?php
						}else{
					?>
						<button id="btn-eliminar" class="col-xs-12 col-md-12 btn btn-danger">Eliminar solicitud</button>
					<?php
						}
					?>
				</div>
			</div>
		</div>

		<!-- Modal de para generar usuarios -->
		<?php include_once($server . "www/Admin/Solicitudes/modalGenerarUsuarios.php"); ?>

		<!-- Modal para confirmar la creacion del proyecto -->
		<?php include_once($server . "www/Admin/Solicitudes/modalGenerarProyecto.php"); ?>

		<!-- Modal para confirmar la eliminacion -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Eliminar solicitud</h4>
		            </div>
		            <div class="modal-body">
		                <p>¿Desea realmente eliminar la solicitud del TFG <?=$solicitud->getProyecto();?>?</p>
		            </div>
		            <div class="modal-footer modalP-footer">
		                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
		                <button type="button" id="confirmarEliminacion" class="btn btn-danger">Confirmar</button>
		            </div>
		        </div>
		    </div>
		</div>

	</section>

	<footer>
		
	</footer>
	
	<script type="text/javascript" src="<?=$server_name;?>static/js/Solicitud/detallarSolicitud.js"></script>
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