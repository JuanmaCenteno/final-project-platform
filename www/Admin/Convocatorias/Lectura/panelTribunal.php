

<?php
    $tribunales = $lectura->getTribunal();
?>

<div class="panel" style="background-color:#D8D8D8;">

    <div class="panel-heading labelPanel">
		<div class="modal-title row">
            <h5 class="col-md-10 col-xs-12">Tribunal asignado</h5>
        </div>
    </div>

    <div class="panel-body">
        <ul class="media-list">
            <?php
            	 
                foreach($tribunales as $tribunal){
                    $usuario = $tribunal->getProfesor();
                    $rol = $tribunal->getRol();
                    $dni = $usuario->getDNI();
                    $foto = $usuario->getFoto();
                    $nombre = $usuario->getNombreCompleto();
            ?>
                <li class="media" value="<?=$dni;?>">
                    <div class="list-group-item">
                        <div class="media-left pull-left img-user-admin">
                            <img src="<?=$foto;?>" class="img-responsive img-rounded" alt="Foto usuario">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?=$nombre;?></h4>
                            Asignado como: <?=$rol;?>
                            <div class="media-right pull-right">
                                <button type="button" class="btn btn-danger eliminarTribunal" value="<?=$dni;?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                    Quitar
                                </button>
                            </div>
                        </div>
                    </div>                          
                </li>

                <!-- Modal para confirmar la eliminacion -->
                <div class="modal fade" id="eliminar<?=$dni;?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modalP-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Eliminar tribunal</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Desea realmente eliminar a <?=$tribunal->getLinkNombre();?> como tribunal?</p>
                            </div>
                            <div class="modal-footer modalP-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger confirmar" value="<?=$dni;?>">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </ul>
    </div>

    <div class="panel-footer" style="background-color:#D8D8D8;">
		<small>
			<span class="glyphicon glyphicon-info-sign"></span> 
			Pulse en quitar si desea eliminar a un tribunal
		</small>
	</div>
</div>