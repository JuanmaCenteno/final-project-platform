
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Lectura.php";

	if(!empty($_SESSION['usuario']) && !empty($_GET['idL'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
			$lectura = Lectura::get($_GET['idL']);
			if($lectura){
				$proyecto = $lectura->getProyecto();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Detalle de la lectura</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<section>

		<div class="container">

			<div id="idLectura" value="<?=$lectura->getID();?>"></div>
			<div id="idProyecto" value="<?=$proyecto->getID();?>"></div>
			<div id="idConvocatoria" value="<?=$lectura->getIDConvocatoria();?>"></div>

			<div class="panel">
				<div class="panel-heading labelPanel">
					<div class="modal-title row">
	                    <h4 class="col-md-10 col-xs-12"><?= $proyecto->getNombre();?></h4>
	                    <a type="button" class="btn btn-danger col-md-2 col-xs-12" id="eliminarLectura">
	                        <span class="glyphicon glyphicon-trash"></span> Eliminar lectura
	                    </a>
	                </div>
	            </div>
				<div class="panel-body">
					<div class="modal-body">
		                <div class="row">
							<label class="col-md-2 col-xs-6 control-label">Día de la lectura</label>
							<div class="col-md-2 col-xs-6"><?=$lectura->getFechaLectura();?></div>
						</div>
						<div class="row">
							<label class="col-md-2 col-xs-6 control-label">Hora</label>
							<div class="col-md-2 col-xs-6"><?=$lectura->getHora();?></div>
						</div>
						<div class="row" style="margin-bottom:2%;">
							<label class="col-md-2 col-xs-6 control-label">Aula asignada</label>
							<div class="col-md-2 col-xs-6"><?=$lectura->getAula();?></div>
						</div>

						<?php include_once($server . "www/Admin/Convocatorias/Lectura/panelTribunal.php") ?>
						<?php include_once($server . "www/Admin/Convocatorias/Lectura/panelPosibles.php") ?>
		                
		            </div>
				</div>
			</div>
		</div>

		<!-- Modal para confirmar la eliminacion de la lectura -->
        <div class="modal fade" id="modalEliminarLectura" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Eliminar lectura</h4>
		            </div>
		            <div class="modal-body">
		                <p>¿Desea realmente eliminar la lectura del <?=$proyecto->getNombre();?>?</p>
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
	
	<script type="text/javascript" src="<?=$server_name;?>static/js/completar.js"></script>
	<script type="text/javascript" src="<?=$server_name;?>static/js/Lectura/detallarLectura.js"></script>
</body>


</html>
<?php	
			}else{
				echo "La lectura no existe";
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