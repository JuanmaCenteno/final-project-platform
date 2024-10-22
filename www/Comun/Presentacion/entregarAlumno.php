

<?php
$presentacion = Presentacion::getPresentacionDeAlumno($dni,$idProyecto);
if(!$presentacion){
?>

<div class="row">
	<h4 class="col-md-7 col-md-offset-2 col-xs-12">Sección de entrega final</h4>
</div>
<div class="hueco"></div>
<div class="hueco"></div>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Autor</label>
	<div class="col-md-6 col-xs-9">
		<p><?=$usuario->getNombreCompleto();?></p>
	</div>
</div>

<!-- seccion a rellenar por el autor -->
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Título</label>
	<div class="col-md-6 col-xs-9">
		<input type="text" id="inputTitulo" class="form-control" placeholder="Introduzca el título para la entrega final" required>
	</div>
</div>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Observaciones</label>
	<div class="col-md-6 col-xs-9">
		<textarea id="inputObservaciones" class="form-control" rows="8" placeholder="Escriba las observaciones acerca de su TFG para la presentación" required></textarea>
	</div>
</div>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Adjuntar archivo</label>
	<div class="col-md-6 col-xs-9">
		<input type="file" id="inputArchivo">
		<p class="help-block">Añada todos los archivos pertenecientes al TFG(Memoria, aplicación, etc.)</p>
	</div>
</div>
<div class="hueco"></div>
<div class="row">
	<button class="btn btn-success col-md-8 col-md-offset-2 col-xs-12" id="guardar">Guardar para presentación</button>
</div>

<!-- Modal para confirmar -->
<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalP-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmación de entrega</h4>
            </div>
            <div class="modal-body">
                <p>¿Desea realmente guardar los siguientes archivos para su presentación?</p>
            </div>
            <div class="modal-footer modalP-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmar" class="btn btn-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	
	$('#guardar').on('click',function(){
		$('#modalConfirmar').modal('show');
	});

	$('#confirmar').on('click',function(){
		var inputFileImage = document.getElementById("inputArchivo");
		var file = inputFileImage.files[0];
		var data = new FormData();

		data.append('archivo',file);
		data.append('autor',<?=json_encode($dni);?>);
		data.append('titulo', $('#inputTitulo').val() );
		data.append('observaciones', $('#inputObservaciones').val() );
		data.append('idProyecto', <?=$idProyecto;?>);
		data.append('action', 'guardarPresentacion');

		var url = 'ctrlPresentacion.php';
		$.ajax({
			url:url,
			type:'POST',
			contentType:false,
			data:data,
			processData:false,
			cache:false
		})
			.success(function(resp,estado,jqXHR){
				console.log(resp);
				if(resp){
					$('#modalConfirmar').modal('hide');
					window.location.reload();
				} else {
					console.log(resp);
				}
			})
			.error(function(){
				console.log("Error en la peticion");
			});
	});

</script>

<?php
}else{
?>
	<div class="alert alert-success col-md-8 col-md-offset-2 col-xs-12">
		<span class="glyphicon glyphicon-info-sign"></span>
		Usted ya realizó la entrega para su presentación
	</div>
<?php
}
?>

<?php
	$tipo = 'Tutor'; 
	$valoraciones = Valoracion::getByProyectoRol($idProyecto,$tipo);
	if(sizeof($valoraciones) > 0){
?>
<br><br><br><br><br><br>
<div class="row">
	<h4 class="col-md-7 col-md-offset-2 col-xs-12">Valoración del/los tutor/es</h4>
</div>
<div class="hueco"></div>
<?php
		include($server . "www/Comun/Presentacion/rellenarValoraciones.php");		
	}
?>

<?php
	$tipo = 'Tribunal';  
	$valoraciones = Valoracion::getByProyectoRol($idProyecto,$tipo);
	if(sizeof($valoraciones) > 0){
?>
<br>
<div class="row">
	<h4 class="col-md-7 col-md-offset-2 col-xs-12">Valoración del/los tribunal/es</h4>
</div>
<div class="hueco"></div>
<?php
		include($server . "www/Comun/Presentacion/rellenarValoraciones.php");	
	}
?>