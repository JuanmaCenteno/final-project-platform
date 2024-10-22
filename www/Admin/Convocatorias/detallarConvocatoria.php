
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Convocatoria.php";

	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$idConvocatoria = $_GET['id'];
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
			$convocatoria = Convocatoria::get($idConvocatoria);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Detalle de la convocatoria</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<section>

		<div class="container">
			<div id="idConvocatoria" value="<?=$idConvocatoria;?>"></div>
			<div class="panel" style="background-color:#D8D8D8;">

				<div class="panel-heading labelPanel">
					<div class="modal-title row">
	                    <h4 class="col-md-8 col-xs-12">Convocatoria de <?=$convocatoria->getNombre();?></h4>
	                    <a type="button" class="btn btn-danger col-md-4 col-xs-12" id="eliminarConvocatoria">
	                        <span class="glyphicon glyphicon-trash"></span> Eliminar convocatoria
	                    </a>
	                </div>
				</div>

				<div class="panel-body">

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

						<?php
							//Creamos los menus desplegables por dia
							$dia = $convocatoria->getDias();
							for($i=0;$i<sizeof($dia);$i++){
								//Cargamos las lecturas por dia
								$lecturas = $convocatoria->getLecturasByDia($dia[$i]);
								?>
									<div class="panel">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i;?>" aria-expanded="true" aria-controls="collapse<?=$i;?>">
											<div class="panel-heading labelPanel" role="tab" id="heading<?=$i;?>">
												<h4 class="panel-title"><?= $dia[$i]; ?><span class="badge convos">Lecturas: <?= sizeof($lecturas); ?></span></h4>
											</div>
										</a>
										<div id="collapse<?=$i;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$i;?>">
											<div class="panel-body" >
												<div class="list-group">
													<?php
														//Mostramos las lecturas del dia
														foreach ($lecturas as $lectura) {
															$idLectura = $lectura->getID();
															$hora = $lectura->getHora();
															$aula = $lectura->getAula();
															$proyecto = $lectura->getProyecto();
															$tribunales = $lectura->getTribunal();
													?>
														<a id="listaLecturas" value="<?=$idLectura;?>">
															<div class="list-group-item elemEntregas">
																<span class="badge">Hora: <?=$hora;?></span>
																<h4><?=$proyecto->getNombre();?></h4>
																<span class="badge">Aula: <?=$aula;?></span>
																<h5>
																	Tribunal asignado: <?=sizeof($tribunales);?>
																</h5>
																
															</div>
														</a>

													<?php
														include($server . "www/Admin/Convocatorias/modalLectura.php");
														}
													?>
												</div>
											</div>
											<div class="panel-footer">
												<button type="button" class="btn btn-success" id="addLectura" value="<?=$dia[$i]?>"style="width:100%;">
													<span class="glyphicon glyphicon-plus-sign"></span> Añadir nueva lectura
												</button>
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

		<!-- Modal para confirmar la eliminacion de la lectura -->
        <div class="modal fade" id="modalEliminarConvocatoria" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Eliminar convocatoria</h4>
		            </div>
		            <div class="modal-body">
		                <p>¿Desea realmente eliminar la convocatoria de <?=$convocatoria->getNombre();?>?</p>
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

	<script type="application/javascript" src="<?=$server_name;?>static/js/Convocatoria/detallarConvocatoria.js"></script>
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