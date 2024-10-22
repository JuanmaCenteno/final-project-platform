
<?php
	if(sizeof($valoraciones) > 0){
		foreach ($valoraciones as $valoracion) {
			$alumno = $valoracion->getAlumno();
			$autor = $valoracion->getAutor();
			if($alumno->getDNI() == $dni){
?>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label"><?=$tipo;?></label>
	<div class="col-md-6 col-xs-6">
		<p><?=$autor->getNombreCompleto();?></p>
	</div>
</div>
<div class="row">
	<label class="col-md-10 col-md-offset-2 control-label">Valoracion hecha por el <?=$tipo;?></label>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2 well">
		<p><?=$valoracion->getValoracion();?></p>
	</div>
</div>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Nota estimada</label>
	<div class="col-md-6 col-xs-6">
		<p class="badge"><?=$valoracion->getNota();?></p>
	</div>
</div><br>

<?php
			}
		}
	}else{
?>
<div class="alert alert-danger col-md-8 col-md-offset-2 col-xs-12">
	<span class="glyphicon glyphicon-info-sign"></span>
	El/los tutor/es no han realizado la valoración del/los alumno/s
</div>
<?php
	}
?>
