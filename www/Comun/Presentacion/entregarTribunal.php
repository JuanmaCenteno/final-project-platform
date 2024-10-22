

<div class="row">
	<h4 class="col-md-7 col-md-offset-2 col-xs-12">Sección de presentación del/los alumno/s</h4>
</div>
<div class="hueco"></div>

<?php 
	$alumnos = $proyecto->getAlumno();
	include($server . "www/Comun/Presentacion/rellenarPresentaciones.php"); 
?>

<div class="row">
	<h4 class="col-md-7 col-md-offset-2 col-xs-12">Sección de valoración del/los tutor/es</h4>
</div>
<div class="hueco"></div>
<?php
	$tipo = 'Tutor'; 
	$valoraciones = Valoracion::getByProyectoRol($idProyecto,$tipo);
	include($server . "www/Comun/Presentacion/rellenarValTutor.php");
?>


<div class="hueco"></div>
<div class="row">
	<h4 class="col-md-7 col-md-offset-2 col-xs-12">Sección de evaluación del tribunal</h4>
</div>
<div class="hueco"></div>

<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Tribunal</label>
	<div class="col-md-6 col-xs-6">
		<p><?= $usuario->getNombreCompleto(); ?></p>
	</div>
</div><br>

<?php
	$acceso = Tribunal::get($dni,$idLectura);
	if($acceso->getRol() == 'Presidente'){

		$valoraciones = Valoracion::getValoracionDeAlumno($idProyecto,$dni);

		if(sizeof($valoraciones)<=0){
			$dnis = [];
			foreach ($alumnos as $alumno) {
				$dniA = $alumno->getDNI();
				array_push($dnis, $dniA);	
?>

<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Alumno</label>
	<div class="col-md-6 col-xs-6">
		<p><?= $alumno->getNombreCompleto(); ?></p>
	</div>
</div>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Valoración</label>
	<div class="col-md-6 col-xs-9">
		<textarea class="form-control" id="inputValoracion<?=$dniA;?>" rows="8" placeholder="Escriba la valoración acerca de la presentación realizada por el alumno" required></textarea>
	</div>
</div>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Nota</label>
	<div class="col-md-6 col-xs-9">
		<input type="text" class="form-control" id="inputNota<?=$dniA;?>" placeholder="Introduzca la nota" required>
	</div>
</div>

<?php
			}
?>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Adjuntar archivo</label>
	<div class="col-md-6 col-xs-9">
		<input type="file" id="inputArchivo">
		<p class="help-block">Añada los ficheros para la valoración del alumno</p>
	</div>
</div><br><br>

<div class="row">
	<button class="btn btn-success col-md-8 col-md-offset-2 col-xs-12" id="guardar">Guardar valoración</button>
</div>

<!-- Modal para confirmar -->
<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalP-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmación de la valoración</h4>
            </div>
            <div class="modal-body">
                <p>¿Desea realmente guardar la valoración de los alumnos como nota final?</p>
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
		alumnos = <?=json_encode($dnis);?>;
		valoraciones = [];
		$.each(alumnos,function(k,v){
			var valoracion = new Object({
				alumno: v,
				val: $('#inputValoracion'+v).val(),
				nota: $('#inputNota'+v).val()
				});
			valoraciones.push(valoracion);
		});

		var inputFileImage = document.getElementById("inputArchivo");
		var file = inputFileImage.files[0];
		var data = new FormData();

		data.append('archivo',file);
		data.append('autor',<?=json_encode($dni);?>);
		data.append('rol', <?=json_encode($tipoAcceso);?> );
		data.append('valoraciones', JSON.stringify(valoraciones) );
		data.append('proyecto', <?=$idProyecto;?>);
		data.append('action', 'guardarValoracion');
		
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

</script>

<?php
	}else{
?>
<div class="alert alert-success col-md-8 col-md-offset-2 col-xs-12">
	<span class="glyphicon glyphicon-info-sign"></span>
	Usted ya realizó la valoración de los alumnos
</div>
<?php
	}
}else{
?>
<div class="alert alert-info col-md-8 col-md-offset-2 col-xs-12">
	<span class="glyphicon glyphicon-info-sign"></span>
	Usted es vocal, contacte con el presidente de la lectura para hacer la valoración del/los alumno/s
</div>
<?php
	}
?>