

<?php
	if($proyecto!=null){
		$estado = $proyecto->getEstado();
		if($estado == 'Aceptado'){
?>

	<a href="../Alumno/Peticion/solicitarConvocatoria.php" type="button" class="btn btn-info col-md-3 col-xs-12">
	    <span class="glyphicon glyphicon-education"></span> Solicitar convocatoria
	</a>

<?php
		}else if($estado == null){
			$entregas = $proyecto->getEntregas();
			if(sizeof($entregas)>0){

?>

	<a href="../Alumno/Peticion/ctrlPeticion.php?action=peticion" type="button" class="btn btn-success col-md-3 col-xs-12">
	    <span class="glyphicon glyphicon-ok"></span> Pedir autorización
	</a>

<?php
			}
		}
	}
?>
