

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Usuario.php";


	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
			if( !empty($_GET['dia']) && !empty($_GET['idC']) ){
				$dia = $_GET['dia'];
				$idConvocatoria = $_GET['idC'];		
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Crear nueva lectura</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
	<script type="text/javascript" src="<?=$server_name;?>static/js/jquery.timepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$server_name;?>static/css/jquery.timepicker.css">
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>
	
		<div class="container containerEntregas">
			<form class="form-horizontal" enctype="multipart/form-data">

				<div id="inputConvocatoria" value="<?=$idConvocatoria;?>"></div>

				<div class="form-group">
					<label class="col-md-2 col-xs-3 control-label">Fecha asignada</label>
					<div class="col-md-8 col-xs-9">
						<p id="inputFecha" value="<?=$dia;?>"><?=$dia;?></p>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 col-xs-3 control-label">Proyecto</label>
					<div class="col-md-8 col-xs-9" id="proyectoSeleccionado">
						<div id="inputProyecto">
							<input type="text" class="form-control" id="buscarProyecto" name="Proyecto" placeholder="Nombre del proyecto">
							
							<div style="position:relative; display:block;">
								<div class="list-group looking-result" id="listaProyectos">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 col-xs-3 control-label">Hora</label>
					<div class="col-md-8 col-xs-9">
						<input id="inputHora" type="text" class="time1 form-control time ui-timepicker-input" placeholder="Indique la hora" autocomplete="off">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 col-xs-3 control-label">Aula</label>
					<div class="col-md-8 col-xs-9">
						<div id="inputProyecto">
							<input type="text" class="form-control" id="inputAula" placeholder="Indique el aula donde se realizara la lectura">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-5 col-xs-offset-2 control-label">
						<button id="btn-add" class="btn btn-primary">Añadir lectura</button>
						<a href="javascript:history.back()">
							<button type="button" class="btn btn-danger">Cancelar</button>
						</a>
					</div>
				</div>
				
			</form>
		</div>

	</section>

	<footer>
		
	</footer>

	<script type="text/javascript" src="<?=$server_name;?>static/js/completar.js"></script>
	<script type="application/javascript" src="<?=$server_name;?>static/js/Lectura/addLectura.js"></script>
	<script type="text/javascript">
		$('.time1').timepicker({ 'timeFormat': 'H:i' });
	</script>
</body>
</html>

<?php
			}else{
				echo 'Faltan datos';
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