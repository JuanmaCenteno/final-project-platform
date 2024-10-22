
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Proyecto.php";

	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		$rol = $admin->getRol();
		if($rol == 'Admin'){
			$proyectos = Proyecto::getProyectos();
			$notificaciones = $admin->getNotificaciones();
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
		<?php include_once($server . "www/Comun/Headers/header_principal.php") ?>
	</header>

	<section>

		<div class="container-fluid">

			<div class="row">

				<!-- Panel izquierdo-->
				<div class="col-md-4">
					<!-- Panel de identificacion -->
					<div class="panel">
						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Identificación</h3>
						</div>
						<div class="panel-body">
					    	<p class="col-md-4 col-xs-4"><b>Usuario:</b></p> 
					    		<p class="col-md-8 col-xs-8"><?= $admin->getNombreCompleto(); ?></p>
					    	<p class="col-md-4 col-xs-4"><b>Rol:</b></p> 
					    		<p class="col-md-8 col-xs-8"><?= $admin->getRol(); ?></p>
					  	</div>
					</div>
					<!-- Panel de notificaciones -->
					<div class="panel">
						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Notificaciones</h3>
						</div>
						<div class="panel-body" id="listaNotificaciones">
						    <!-- Lista de notificaciones -->
						    <?php include_once($server . "www/Comun/Notificaciones/rellenarNotificaciones.php") ?>
					  	</div>
					</div>
				</div>

				<!-- Panel derecho -->
				<div class="col-md-8">
					<div class="panel">
						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Gestionar</h3>
						</div>
						<div class="panel-body">
						    <!-- Panel de herramientas -->
						    <a href="../Admin/Solicitudes/adminSolicitudes.php">
						    	<h4 class="list-group-item elemEntregas">Solicitudes</h4>
					    	</a>
						    <a href="../Admin/Usuarios/adminUsuarios.php">
						    	<h4 class="list-group-item elemEntregas">Usuarios</h4>
					    	</a>
						    <a href="../Admin/Proyectos/adminProyectos.php">
						    	<h4 class="list-group-item elemEntregas">Proyectos</h4>
					    	</a>
					    	<a href="../Admin/Convocatorias/adminConvocatorias.php">
						    	<h4 class="list-group-item elemEntregas">Convocatorias</h4>
					    	</a>
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
			echo "Sesion incorrecta";
		}
	}else{
		header("Location: '../../index.php'");
	}
?>