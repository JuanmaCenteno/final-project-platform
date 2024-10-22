
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
		
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Crear proyecto</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>

		<div id="correcto" class="alert alert-success" role="alert" style="display:none;">Proyecto guardado</div>
		
		<div class="container containerEntregas">
			<form class="form-horizontal" enctype="multipart/form-data">
				<!-- Formulario para crear proyectos nuevos -->
				<div class="form-group">
					<label for="inputNombre" class="col-md-2 control-label">Nombre</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputNombre" name="Nombre" placeholder="Nombre del proyecto" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDescripcion" class="col-md-2 control-label">Descripción</label>
					<div class="col-md-8">
						<textarea class="form-control" rows="10" id="inputDescripcion" name="descripcion" placeholder="Descripcion del proyecto" required></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPalabras_clave" class="col-md-2 control-label">Palabras clave</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputPalabras_clave" name="palabras_clave" placeholder="Añada palabras que describan el proyecto" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5 col-xs-offset-2 control-label">
						<button type="button" class="btn btn-primary" id="btn-add">Añadir proyecto</button>
						<a href="javascript:history.back()"><button type="button" class="btn btn-danger">Cancelar</button></a>
					</div>
				</div>
				
			</form>
		</div>

		<!-- Modal para confirmar -->
        <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header modalP-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Creacion de proyectos</h4>
		            </div>
		            <div class="modal-body">
		                <p></p>
		            </div>
		            <div class="modal-footer modalP-footer">
		                <button type="button" id="btn-redir" class="btn btn-primary">Asignar usuarios</button>
		            </div>
		        </div>
		    </div>
		</div>

		

	</section>

	<footer>
		
	</footer>

	<script type="application/javascript" src="<?=$server_name;?>static/js/Proyecto/addProyecto.js"></script>
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