

<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php"; 

	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
			//Obtener los usuarios para mostrarlos
			$conjuntoUsuarios = $admin->getUsuariosByRol();

?>	

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Gestion de usuarios</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la gestion de usuarios-->
	<section>

	<div class="container">
		<div class="panel">
			<div class="panel-heading labelPanel">
                <div class="modal-title row">
                    <h4 class="col-md-8 col-xs-12">Gestión de usuarios</h4>
                    <a href="addUsuario.php" type="button" class="btn btn-warning col-md-4 col-xs-12">
                        <span class="glyphicon glyphicon-plus"></span> Añadir usuario
                    </a>
                </div>
            </div>
			<div class="panel-body" style="background-color:#D8D8D8;">

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

					<div class="panel">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							<div class="panel-heading labelPanel" role="tab" id="headingOne">
								<h4 class="panel-title">Profesores</h4>
							</div>
						</a>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<ul class="media-list">
									<!-- Todos los profesores -->
									<?php
										$usuarios = [];
										$usuarios = $conjuntoUsuarios[0];
										include('rellenarUsuarios.php');
									?>
								</ul>
							</div>
						</div>
					</div>

					<div class="panel">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							<div class="panel-heading labelPanel" role="tab" id="headingTwo">
								<h4 class="panel-title">Alumnos</h4>
							</div>
						</a>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							<div class="panel-body">
								<ul class="media-list">
									<!-- Todos los alumno -->
									<?php
										$usuarios = [];
										$usuarios = $conjuntoUsuarios[1];
										include('rellenarUsuarios.php');
									?>
								</ul>
							</div>
						</div>
					</div>

					<div class="panel">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							<div class="panel-heading labelPanel" role="tab" id="headingThree">
								<h4 class="panel-title">Administradores</h4>
							</div>
						</a>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">
								<ul class="media-list">
									<!-- Todos los administradores -->
									<?php
										$usuarios = [];
										$usuarios = $conjuntoUsuarios[2];
										include('rellenarUsuarios.php');
									?>
								</ul>
							</div>
						</div>
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
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>