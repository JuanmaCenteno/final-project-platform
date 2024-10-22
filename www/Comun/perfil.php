
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";

	include_once $server . "Clases/Usuario.php";


	if(!empty($_SESSION['usuario']) && !empty($_GET['id'])){
		$usuario = new Usuario($_GET['id']);
		
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
											<tr>
												<td>Rol</td>
												<td><?= $usuario->getRol();?></td>
											</tr>
											
										</tbody>
									</table>
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
		$redir = $server . "index.php";
		header("Location: '$redir'");
	}
?>
