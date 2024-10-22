
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Alumno.php";
	include_once $server . "Clases/Profesor.php";
	include_once $server . "Clases/Proyecto.php";

	//Inicio de sesion
	if(!empty($_SESSION['usuario'])){
		$dni = $_SESSION['usuario'];
		$rol = Usuario::getRolUsuario($dni);
		if($rol == 'Alumno'){
			$usuario = new Alumno($dni);
		}else{
			$usuario = new Profesor($dni);
		}

		if(!empty($_GET['idP']) && !empty($_GET['idE'])){

			$idProyecto = $_GET['idP'];
			$idEntrega = $_GET['idE'];

			$proyecto = $usuario->getProyecto($idProyecto);

			if($proyecto->getID()!=null){
				
				$alumno = $proyecto->getLinkAlumno();
				$tutor = $proyecto->getLinkTutor();
				$destino = $proyecto->getDestinos($dni);
				$entrega = $proyecto->getEntregaByID($idEntrega);

				if($entrega->getID() != null){
					
					$autor = $entrega->getAutor();
					$archivo = $entrega->getArchivo();
					$idArchivo = $archivo->getID();
					$comentarios = $entrega->getComentariosJSON();

					//Cargamos la vista
?>

<!-- Vista -->

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

	<!-- Seccion para mostrar la informacion de la entrega-->
	<section>

		<div class="container containerEntregas">

			<div class="row">
				<h4 class="col-md-7 col-md-offset-2 col-xs-12">Detalles de la entrega</h4>

				<?php
					if(($rol == 'Alumno') && ($usuario->getNombreCompleto() == $autor->getNombreCompleto())){
				?>
					<div>
						<button type="button" class="btn btn-danger col-md-2 col-xs-12" id="eliminarEntrega">
							<span class="glyphicon glyphicon-trash"></span>
							Eliminar entrega
						</button>
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
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Tutor/es</label>
				<div class="col-md-6 col-xs-6">
					<p><?= $tutor; ?></p>
				</div>
			</div>
			<div class="row">
				<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Alumno/s</label>
				<div class="col-md-6 col-xs-6">
					<p><?= $alumno; ?></p>
				</div>
			</div>
			<br><br>

			<div class="row">
				<label class="col-md-10 col-md-offset-2 control-label">Autor de la entrega</label>
				<div class="col-md-9 col-md-offset-4">
					<p><?= $autor->getNombreCompleto(); ?></p>
				</div>
			</div><br>
			<div class="row">
				<label class="col-md-10 col-md-offset-2 control-label">Titulo de la entrega</label>
				<div class="col-md-9 col-md-offset-4">
					<p><?= $entrega->getTitulo(); ?></p>
				</div>
			</div><br>
			
			<div class="row">
				<label class="col-md-10 col-md-offset-2 control-label">Descripción de la entrega</label>
			</div><br>
			<div class="row">
				<div class="col-md-8 col-md-offset-2 well">
					<p><?= $entrega->getDescripcion(); ?></p>
				</div>
			</div><br><br><br>
			<div class="row">
				<label class="col-md-2 col-md-offset-2 control-label">Archivo adjunto</label>
				<div class="col-md-6">
					<?php
						if($idArchivo != NULL){
							$_SESSION['idA'] = $idArchivo;
					?>
						<a href="../Funciones/descargarArchivo.php">
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
				</div>
			</div><br><br>

			<!-- Seccion para los comentarios con el profesor -->
			<div class="row">
		    	<div class="hueco"></div>
		        <div class="col-md-10 col-md-offset-1 col-xs-12">

		            <div class="panel panel-perso">

		            	<!--Header del chat-->
		                <div class="panel-heading labelPanel">
		                    <span class="glyphicon glyphicon-comment"></span>  Comentarios
		                </div>

		                <!--Body del chat-->
		                <div class="panel-body panel-body-perso">
		                    <ul class="chat" id="listaComentarios">
		                    	<!--Aqui iran los comentarios-->
		                    </ul>
		                </div>

		                <!--Footer del chat-->
		                <div class="panel-footer">
		                    <div class="input-group">
		                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Escriba aqui..." />
		                        <span class="input-group-btn">
		                            <button class="btn btn-success btn-sm" id="btn-chat">Enviar</button>
		                        </span>
		                    </div>
		                </div>

		            </div>
		        </div>
		    </div>

		</div>

		<!-- Modal para confirmar la eliminacion de la entrega -->
        <div class="modal fade" id="modalEliminarEntrega" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Eliminar entrega</h4>
		            </div>
		            <div class="modal-body">
		                <p>¿Desea realmente eliminar la entrega <?=$entrega->getTitulo();?>?</p>
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

	<script src="../../static/js/comentarios.js" type="text/javascript"></script>
	<script type="application/javascript">
		//Rellena los comentarios
		var list = <?= json_encode($comentarios); ?>;
		var rol = <?= json_encode($usuario->getRol());?>;

		if(rol === 'Alumno'){
			rol = 'Profesor';
		}else{
			rol = 'Alumno';
		}

		$(document).on('ready',function(){
			rellenaComentarios(list,$('#listaComentarios'),rol);
		});
		

		$('#btn-chat').on('click',function(){
			
			var com = new Object({
				COMENTARIO: $('#btn-input').val(),
				AUTOR: <?= json_encode($usuario->getDNI());?>,
				ID_ENTREGA: <?= json_encode($entrega->getID());?>,
				ID_PROYECTO: <?= json_encode($proyecto->getID());?>,
				NOMBRE_AUTOR:<?= json_encode($usuario->getNombreCompleto());?>,
				ROL_AUTOR:<?= json_encode($usuario->getRol());?>,
				FOTO: <?= json_encode($usuario->getFoto());?>,
				DESTINO:<?= json_encode($destino);?>
			});

			$.post("../Funciones/guardarComentario.php",com)
				.success(function(resp,estado,jqXHR){
					
					if(resp != 'Error'){
						//Si se guarda correctamente el mensaje en la bbdd lo mostramos
						
						for(var i=0;i<list.length;i++){
							$('li').remove('#elemento');
						}

						list.unshift(JSON.parse(resp));

						rellenaComentarios(list,$('#listaComentarios'),rol);

						$('#btn-input').val('');
					} else {
						//Mostrar algo diciendo error
						console.log("Error en el success");
					}

				})
				.error(function(){
					console.log("Error en la peticion");
				});


		});

		//Eliminar entrega
		$('#eliminarEntrega').on('click',function(){
			$('#modalEliminarEntrega').modal('show');
		});

		//Confirmar eliminar lectura
		$('#confirmarEliminacion').on('click',function(){
			var entrega = new Object({
				idEntrega: <?= json_encode($entrega->getID());?>,
				action: 'eliminar'
				});
			$('#modalEliminarEntrega').modal('hide');
			$.post("../Alumno/Entregas/ctrlEntregas.php",entrega)
				.success(function(resp,estado,jqXHR){
					if(resp){
						window.location = '../Comun/Headers/redireccion.php';
					} else {
						console.log(resp);
					}
				})
				.error(function(){
					console.log("Error en la peticion");
				});
		});

	</script>

</body>
</html>

<!-- Controlador de la vista -->

<?php
				}else{
					echo "Esa entrega no pertenece al proyecto";
				}

			}else{
				echo "No tiene acceso a ese proyecto";
			}

		}else{
			echo "Faltan parametros";
		}
	}else{
		echo "No ha iniciado sesion";
	}
?>