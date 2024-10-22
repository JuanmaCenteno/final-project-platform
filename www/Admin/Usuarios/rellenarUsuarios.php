

<?php
	foreach($usuarios as $usuario) {
		$dni = $usuario->getDNI();
		$foto = $usuario->getFoto();
		$nombre = $usuario->getNombreCompleto();
	
?>

<li class="media">
	<a href="<?=$server_name;?>www/Admin/Usuarios/perfilUsuario.php?id=<?=$dni;?>" class="cajaEntregas">
		<div class="list-group-item elemEntregas">
			<div class="media-left pull-left img-user-admin">
				<img src="<?=$foto;?>" class="img-responsive img-rounded" alt="Foto usuario">
			</div>
			<div class="media-body">
				<h4 class="media-heading"><?=$nombre;?></h4>
				<?=$dni;?>
			</div>
		</div>
	</a>							
</li>

<?php
	}
?>