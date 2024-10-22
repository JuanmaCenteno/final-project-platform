
<?php
	foreach($usuarios as $usuario) {
		$dni = $usuario->getDNI();
		$rol = $usuario->getRol();
		$foto = $usuario->getFoto();
		$nombre = $usuario->getNombreCompleto();
	
?>

<li class="media" value="<?=$dni;?>">
	<a class="cajaEntregas">
		<div class="list-group-item elemEntregas">
			<div class="media-left pull-left img-user-admin">
				<img src="<?=$foto;?>" class="img-responsive img-rounded" alt="Foto usuario">
			</div>
			<div class="media-body">
				<h4 class="media-heading"><?=$nombre;?></h4>
				<?=$dni;?>
				<div class="media-right pull-right">
					<button type="button" class="btn btn-danger eliminar" value="<?=$dni;?>">
						<span class="glyphicon glyphicon-remove"></span>
						Quitar
					</button>
				</div>
			</div>
		</div>
	</a>							
</li>

<?php
	}
?>