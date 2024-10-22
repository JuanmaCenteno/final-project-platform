
<?php
	$presentaciones = Presentacion::getByProyecto($idProyecto);
	if(sizeof($presentaciones) > 0){
		foreach ($presentaciones as $presentacion) {
			$autor = $presentacion->getAutor();
			$idArchivo = $presentacion->getArchivo();
?>

<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Autor</label>
	<div class="col-md-6 col-xs-6">
		<p><?=$autor->getNombreCompleto();?></p>
	</div>
</div><br>
<div class="row">
	<label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Titulo de la entrega</label>
	<div class="col-md-6 col-xs-6">
		<p><?=$presentacion->getTitulo();?></p>
	</div>
</div>

<div class="row">
	<label class="col-md-10 col-md-offset-2 control-label">Observaciones</label>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2 well">
		<p><?= $presentacion->getObservaciones(); ?></p>
	</div>
</div>

<div class="row">
	<label class="col-md-2 col-md-offset-2 control-label">Archivo adjunto</label>
	<div class="col-md-6">
		<?php
			if($idArchivo != NULL){
				$_SESSION['idA'] = $idArchivo;
		?>
			<a href="../../Funciones/descargarArchivo.php">
				<span class="glyphicon glyphicon-download-alt"></span> 
				Descargar archivo 
			</a>
		<?php
			}else{
		?>
			<span class="glyphicon glyphicon-remove"></span> 
			No hay archivos
		<?php
			}
		?>
	</div>
</div><br><br>


<?php
		}
		if(sizeof($alumnos) != sizeof($presentaciones)){
?>
<div class="alert alert-warning col-md-8 col-md-offset-2 col-xs-12">
	<span class="glyphicon glyphicon-info-sign"></span>
	Uno de los alumnos no ha realizado la entrega de presentación
</div>

<?php
		}
	}else{
?>
<div class="alert alert-danger col-md-8 col-md-offset-2 col-xs-12">
	<span class="glyphicon glyphicon-info-sign"></span>
	El/los alumno/s no han realizado aun la entrega de presentación
</div>
<?php
	}
?>
