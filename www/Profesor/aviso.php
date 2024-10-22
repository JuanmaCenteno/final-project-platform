

<?php
	$estado = $proyecto->getEstado();
	$idProyecto = $proyecto->getID();
	//Aceptar por el profesor
	if($estado == 'Pendiente aceptar'){
?>
	<div class="alert alert-warning">
		<span class="glyphicon glyphicon-info-sign"></span> 
		El/los alumno/s desean presentar el proyecto, a espera de la confirmación del/los tutor/es. Confirmar
		<a href="../Profesor/detallarProyecto.php?id=<?=$idProyecto;?>">aqui</a>
	</div>

<?php
	//Proyectos a espera de la lectura
	}else if($estado == 'Aceptado'){
?>
	<div class="alert alert-info">
		<span class="glyphicon glyphicon-info-sign"></span> 
		Este proyecto fue aceptado, a espera de la lectura.
	</div>

<?php
	//Proyectos con lectura
	}else if($estado == 'Lectura'){
		$lectura = $proyecto->getLectura();
		$idLectura = $lectura->getID();		
?>
	<div class="alert alert-success">
		<span class="glyphicon glyphicon-info-sign"></span> 
		La lectura de este Proyecto ha sido confirmada, pinche <a href="../Comun/detallarLectura.php?idL=<?=$idLectura;?>">aqui</a> para ver los detalles.
	</div>
<?php
	}
?>