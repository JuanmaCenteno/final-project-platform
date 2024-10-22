
<!-- El detalle de una lectura se presentara en un modal -->    
<div class="modal fade" id="detallarLectura<?=$idLectura;?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalP-header">
                <div class="modal-title row">
                    <h4 class="col-md-8 col-xs-12"><?=$proyecto->getNombre();?></h4>
                    <a type="button" href="Lectura/detallarLectura.php?idL=<?=$idLectura;?>" class="btn btn-warning col-md-4 col-xs-12">
                        <span class="glyphicon glyphicon-refresh"></span> Modificar
                    </a>
                </div>
            </div>
            <div class="modal-body">
                <p>Día de la lectura: <?= $dia[$i]; ?></p>
                <p>Hora: <?= $hora; ?></p>
                <p>Aula asignada: <?= $aula; ?></p>

                <div class="panel" style="background-color:#D8D8D8;">

                    <div class="panel-heading labelPanel">
                        <div class="modal-title">Tribunal asignado</div>
                    </div>

                    <div class="panel-body">
                        <?php 
                            foreach($tribunales as $tribunal){
                                if($tribunal->getAsistencia()=='si'){
                                    $style = 'background-color: rgba(0, 255, 0, 0.4)';
                                    $motivo = 'Asistencia confirmada';
                                    $icon = 'glyphicon-ok';
                                }else if($tribunal->getAsistencia()=='no'){
                                    $style = 'background-color: rgba(255, 0, 0, 0.4)';
                                    $motivo = 'Motivo: '.$tribunal->getMotivo();
                                    $icon = 'glyphicon-remove';
                                }else {
                                    $style = 'background-color: rgba(150, 150, 150, 0.4)';
                                    $motivo = 'Sin confirmar';
                                    $icon = 'glyphicon-minus';
                                }

                        ?>
                            <div class="list-group-item" style="<?=$style;?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5><?=$tribunal->getLinkNombre();?></h5>
                                    </div>
                                    <div class="col-md-7">
                                        <?=$motivo;?>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="glyphicon <?=$icon;?>"></span>
                                    </div>
                                </div>
                            </div>

                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalP-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cerrar</button>
            </div>
        </div>
    </div>
</div>