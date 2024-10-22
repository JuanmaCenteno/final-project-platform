

<div class="modal fade" id="modalUsuarios" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalP-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmar generación de usuarios</h4>
            </div>
            <div class="modal-body">
                <p>Se crearán los siguientes usuarios: </p>
                <p><?=  $solicitud->getAlumno(); ?></p>
            </div>
            <div class="modal-footer modalP-footer">
            	<a type="button" class="btn btn-success" href="#" id="confirmarUsuarios">Aceptar</a>
                <a type="button" class="btn btn-danger" href="#" data-dismiss="modal" aria-label="Close">Cerrar</a>
            </div>
        </div>
    </div>
</div>