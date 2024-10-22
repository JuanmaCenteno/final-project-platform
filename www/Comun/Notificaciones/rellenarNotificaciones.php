

<?php
	foreach($notificaciones as $not){
		$id = $not->getID();
		$badge = $not->getBadge();
		$mensaje = $not->getMensaje();
		$href = $server_name.'www/Comun/Notificaciones/ctrlNotificaciones.php?action=eliminar&&id='.$id;
?>

	<a href="<?=$href;?>">
		<h5 class="list-group-item elemEntregas">
			<?=$mensaje;?>
			<span class="badge"><?=$badge;?></span>
		</h5>
	</a>

<?php
	}
?>