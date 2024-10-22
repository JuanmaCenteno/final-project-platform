

<!-- Modal para confirmar la creacion de un proyecto -->    
<div class="modal fade" id="modalProyecto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalP-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmar proyecto</h4>
                    </div>
            <div class="modal-body">
                <p>Proyecto: <?= $solicitud->getProyecto(); ?></p><br><br>

                <div class="panel" style="background-color:#D8D8D8;">
                    <div class="panel-heading labelPanel">
                        <div class="modal-title">Tutores asignados</div>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
                            <!-- Profesores asignados -->
                            <?php
                                $usuarios = [];
                                if($tutor[0]->getDNI() != null){
                                    $usuarios = $tutor;
                                    include('../Usuarios/rellenarUsuarios.php');
                                }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="panel" style="background-color:#D8D8D8;">
                    <div class="panel-heading labelPanel">
                        <div class="modal-title">Alumnos asignados</div>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
                            <!-- alumnos asignados -->
                            <?php
                                $usuarios = [];
                                if($alumno[0]->getDNI() != null){
                                    $usuarios = $alumno;
                                    include('../Usuarios/rellenarUsuarios.php');
                                }else{
                                    echo "No genero a los usuarios";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalP-footer">
                <button type="button" class="btn btn-success" id="confirmarProyecto">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cerrar</button>
            </div>
        </div>
    </div>
</div>