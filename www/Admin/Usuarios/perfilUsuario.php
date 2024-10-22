
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Usuario.php";
	include_once $server . "Clases/Admin.php";


	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$rol = Usuario::getRolUsuario($_SESSION['usuario']);
		if($rol == 'Admin'){
			//Admin
			$usuario = new Admin($_GET['id']);
		
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Perfil</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2" >

					<div class="panel">

						<div class="panel-heading labelPanel">
							<h3 class="panel-title">Informacion personal</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<!-- Imagen -->
								<div class="col-md-3 col-lg-3" align="center">
									<img alt="Foto usuario" src="<?=$usuario->getFoto();?>" class="img-rounded img-responsive"> 
								</div>
								<div class=" col-md-9 col-lg-9"> 
									<table class="table table-user-information">
										<tbody>
											<tr>
												<td>Nombre</td>
												<td><?= $usuario->getNombre();?></td>
											</tr>
											<tr>
												<td>Apellidos</td>
												<td><?= $usuario->getApellidos();?></td>
											</tr>
											<tr>
												<td>DNI</td>
												<td><?= $usuario->getDNI();?></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><a href="mailto:<?= $usuario->getEmail();?>"><?= $usuario->getEmail();?></a></td>
											</tr>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="panel-heading labelPanel labelPanelSB">
							<h3 class="panel-title">Detalles del perfil</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3 col-lg-3" align="center"> 
								</div>
								<div class=" col-md-9 col-lg-9 "> 
									<table class="table table-user-information">
										<tbody id="detallePerfil">
											<!-- Detalles dependiendo del perfil -->
										</tbody>

									</table>
									<button type="button" class="col-xs-12 col-md-12 btn btn-danger" data-toggle="modal" data-target="#confirmarEliminacion">Eliminar usuario</button>


								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="confirmarEliminacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modalP-header">
						<h4 class="modal-title" id="myModalLabel">Eliminar usuario</h4>
					</div>
					<div class="modal-body">
						Desea realmente eliminar al usuario: <?= $usuario->getNombreCompleto(); ?>
					</div>
					<div class="modal-footer modalP-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="button" id="eliminarUsusuario" class="btn btn-success">Eliminar</button>
					</div>
				</div>
			</div>
		</div>

	</section>

	<footer>
		
	</footer>
	
	<script type="application/javascript">

		$('#eliminarUsusuario').on('click',function(){

			var user = new Object({
				dni: <?= json_encode($usuario->getDNI()); ?>,
				action: 'eliminar'
			});

			$.post('ctrlUsuarios.php',user)
				.success(function(resp,estado,jqXHR){
					
					if(resp === 'Usuario borrado'){
						console.log('Usuario borrado correctamente');
						window.location = 'adminUsuarios.php';
					} else {
						console.log(resp);
					}

				})
				.error(function(xhr, textStatus, error){
					    console.log(xhr.statusText);
      					console.log(textStatus);
      					console.log(error);
				});
		})

	</script>
</body>
</html>

<?php
		}else{
			$redir = $server . "index.php";
			//header("Location: '$redir'");
		}
	}else{
		$redir = $server . "index.php";
		//header("Location: '$redir'");
	}
?>
