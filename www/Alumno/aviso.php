<?php
	if($estado == 'Lectura'){
		$lectura = $proyecto->getLectura();
		$idLectura = $lectura->getID();
?>
	<div class="alert alert-success">
		<span class="glyphicon glyphicon-info-sign"></span> 
		Su lectura ha sido confirmada, pinche <a href="../Comun/detallarLectura.php?idL=<?=$idLectura;?>">aqui</a> para ver los detalles.
	</div>


<?php
	}else if($estado == 'Pendiente aceptar'){
?>

	<div class="alert alert-info">
		<span class="glyphicon glyphicon-info-sign"></span> 
		Su proyecto esta pendiente de ser aceptado por su/s tutor/es.
	</div>

<?php
	}else if($estado == 'Pendiente lectura'){
?>

	<div class="alert alert-info">
		<span class="glyphicon glyphicon-info-sign"></span>
		Su lectura esta pendiente de ser asignada.
	</div>

<?php
	}else{

	}
?>