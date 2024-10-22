<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Profesor.php";
	include_once $server . "Clases/Proyecto.php"; 

	if(!empty($_SESSION['usuario'])){
		$profesor = new Profesor($_SESSION['usuario']);
		if($profesor->getRol()=='Profesor'){
			$lecturas = $profesor->getLecturas();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Confirmar lecturas</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<section>

		<div class="container">

			<div id="idUsuario" value="<?=$_SESSION['usuario'];?>"></div>

			<div class="panel">
				<div class="panel-heading labelPanel">
                    <div class="modal-title row">
                        <h4 class="col-md-8 col-xs-12">Lista de lecturas abiertas</h4>
                    </div>
                </div>
				<div class="panel-body">
					<?php
		                        	 
                        foreach($lecturas as $lectura){
                        	$idLectura = $lectura->getID();
                        	$respuesta = $profesor->getRespuesta($idLectura);
                        	$proyecto = Proyecto::get($lectura->getIDProyecto());
                        	$class = '';

                            if($respuesta->getAsistencia()=='si'){
                                $style = 'background-color: rgba(0, 255, 0, 0.4)';
                                $motivo = 'Asistencia confirmada';
                                $icon = 'glyphicon-ok';
                                if($respuesta->getRol() != null){
                                	$motivo = 'Lectura confirmada';
                                }
                            }else if($respuesta->getAsistencia()=='no'){
                                $style = 'background-color: rgba(255, 0, 0, 0.4)';
                                $motivo = 'Motivo: '.$respuesta->getMotivo();
                                $icon = 'glyphicon-remove';
                            }else {
                            	$style = 'background-color: rgba(150, 150, 150, 0.4)';
                                $motivo = 'Sin confirmar';
                                $icon = 'glyphicon-minus';
                                $class = 'sinConfirmar';
                            }

                    ?>
                        <a type="button" href="#" class="list-group-item <?=$class;?>" value="<?=$idLectura;?>" style="<?=$style;?>">
                            <div class="row">
                            	<div id="inputIDProyecto<?=$idLectura;?>" value="<?=$proyecto->getID();?>"></div>
                                <div class="col-md-2" id="inputProyecto<?=$idLectura;?>"><?=$proyecto->getNombre();?></div>
                                <div class="col-md-2">
                                    <?=$lectura->getFechaLectura();?>
                                </div>
                                <div class="col-md-2">
                                    <?=$lectura->getHora();?>
                                </div>
                                <div class="col-md-2">
                                    <?=$lectura->getAula();?>
                                </div>
                                <div class="col-md-4">
                                	<div class="row">
                                		<div class="col-md-4">
                                			<span class="glyphicon <?=$icon;?>"></span>
                                		</div>
                                    	<div class="col-md-8"><?=$motivo;?></div>
                                    </div>
                                </div>
                            </div>
						</a>
                    <?php
                        }
                    ?>
                </div>

                <div class="panel-footer" style="background-color:#D8D8D8;">
					<small>
						<span class="glyphicon glyphicon-info-sign"></span>
							Confirme la asistencia en las lecturas a las que puede asistir como tribunal
					</small>
				</div>
			</div>
		</div>


		<!-- Modal para gestionar asistencia -->
        <div class="modal fade" id="gestionAsistencia" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Gestión de asistencia a la lectura</h4>
		            </div>
		            <div class="modal-body">

		            	<div class="row">
		            		<div class="col-md-5 col-xs-8">Asistirá como tribunal al proyecto: </div> 
		            		<a type="button" href="#" id="detallarProyecto">
		            			<div class="col-md-4 col-xs-4 badge" id="modalProyecto"></div>
		            		</a>
		            	</div><br>

		            	<div class="row">
							<div class="btn-group col-md-12" data-toggle="buttons">
								<label class="btn btn-primary active" id="opcSi">
									<input type="radio" autocomplete="off" checked> Si
								</label>
								<label class="btn btn-danger" id="opcNo">
									<input type="radio" autocomplete="off"> No
								</label>
							</div>
						</div><br>
						<div class="row" id="panelMotivo" style="display:none">
							<div class="col-md-1"><h5>Motivo: </h5></div>
							<div class="col-md-11">
								<input type="text" class="form-control" id="inputMotivo" name="titulo" placeholder="Introduzca el motivo">
							</div>
						</div>
						
		            </div>
		            <div class="modal-footer modalP-footer">
		            	<button type="button" class="btn btn-success" id="guardarRespuesta">Guardar</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		            </div>
		        </div>
		    </div>
		</div>

	</section>

	<footer>
		
	</footer>

	<script type="application/javascript" src="<?=$server_name;?>static/js/Lectura/pujarLectura.js"></script>

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