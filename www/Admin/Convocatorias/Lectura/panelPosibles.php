

<?php
    $tribunalPosible = $lectura->getPosibleTribunal();
?>

<div class="panel" style="background-color:#D8D8D8;">

    <div class="panel-heading labelPanel">
		<div class="modal-title row">
            <h5 class="col-md-10 col-xs-12">Posible tribunal</h5>
        </div>
    </div>

    <div class="panel-body">
        <?php
        	 
            foreach($tribunalPosible as $tribunal){

            	$asistencia = $tribunal->getAsistencia();

                if($asistencia == 'si'){
                    $style = 'background-color: rgba(0, 255, 0, 0.4)';
                    $motivo = 'Asistencia confirmada';
                }else{
                    $style = 'background-color: rgba(255, 0, 0, 0.4)';
                    $motivo = 'Motivo: '.$tribunal->getMotivo();
                }

        ?>
            <div class="list-group-item" style="<?=$style;?>">
                <div class="row">
                    <div class="col-md-4">
                        <h5><?=$tribunal->getLinkNombre();?></h5>
                    </div>
                    <div class="col-md-6">
                        <?=$motivo;?>
                    </div>
                    <div class="col-md-2">
						<button type="button" class="btn btn-primary addTribunal" value="<?=$tribunal->getDNI();?>" name="<?=$tribunal->getNombre();?>">
							<span class="glyphicon glyphicon-plus"></span>
							Añadir
						</button>
					</div>
                </div>
			</div>
        <?php
            }
        ?>
    </div>

    <div class="panel-footer" style="background-color:#D8D8D8;">
		<small>
			<span class="glyphicon glyphicon-info-sign"></span> 
			Pulse en añadir para asignar el profesor como tribunal
		</small>
	</div>
</div>

<!-- Modal para añadir tribunal -->
<div class="modal fade" id="detallarTribunal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalP-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo tribunal</h4>
            </div>
            <div class="modal-body">
            	<label id="nombreProfesor"></label>
				<div class="hueco"></div>

				<div class="row">
					<div class="col-md-5">Seleccione el rol del profesor</div>
					<div class="col-md-7">
						<select class="form-control" id="inputRol">
							<option>Presidente</option>
							<option>Vocal</option>
							<option>Secretario</option>
						</select>
					</div>
				</div>

				<div class="hueco"></div>
            </div>
            <div class="modal-footer modalP-footer">
            	<button type="button" class="btn btn-success" id="guardarTribunal">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>