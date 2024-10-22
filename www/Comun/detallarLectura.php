
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Usuario.php";
	include_once $server . "Clases/Lectura.php";

	if(!empty($_SESSION['usuario']) && !empty($_GET['idL'])){
		$lectura = Lectura::get($_GET['idL']);
		if($lectura){
			if(Usuario::acessoLectura($_SESSION['usuario'],$_GET['idL'])){
				$proyecto = $lectura->getProyecto();
				$tribunales = $lectura->getTribunal();
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

			<div class="panel">
				<div class="panel-heading labelPanel">
					<div class="modal-title row">
                        <h4 class="col-md-8 col-xs-12"><?=$proyecto->getNombre();?></h4>
                        <a type="button" class="btn btn-info col-md-4 col-xs-12" href="Presentacion/detallarPresentacion.php?id=<?=$proyecto->getID();?>">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            Detalles de la presentación
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

		                <div class="panel" style="background-color:#D8D8D8;">

		                    <div class="panel-heading labelPanel">
								<div class="modal-title row">
				                    <h5 class="col-md-10 col-xs-12">Tribunal asignado</h5>
				                </div>
				            </div>

		                    <div class="panel-body">
		                        <?php
		                        	 
		                            foreach($tribunales as $tribunal){
		                            	$id='';
		                                if($tribunal->getAsistencia()=='si'){
		                        ?>
		                            <div class="list-group-item" style="background-color: rgba(0, 255, 0, 0.4);">
		                                <div class="row">
		                                    <div class="col-md-4">
		                                        <h5><?=$tribunal->getLinkNombre();?></h5>
		                                    </div>
		                                    <div class="col-md-5">
		                                        Asistencia confirmada
		                                    </div>
		                                    <div class="col-md-2">
		                                        <?=$tribunal->getRol();?>
		                                    </div>
		                                    <div class="col-md-1">
		                                        <span class="glyphicon glyphicon-ok"></span>
		                                    </div>
		                                </div>
									</div>
		                        <?php
		                        		}
		                            }
		                        ?>
		                    </div>
		                </div>
		            </div>
				</div>
			</div>
		</div>
</body>


</html>
<?php	
			}else{
				echo 'No tiene acceso a la lectura';
			}
		}else{
			echo "La lectura no existe";
		}
	}else{
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>