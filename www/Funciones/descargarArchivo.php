
<?php
session_start();

$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
include_once $server . "Clases/Archivo.php";

//Si entramos significa que estamos logeados y que el id del archivo es correcto para esa sesion
if( !empty($_SESSION['usuario']) ){
	if ( !empty($_SESSION['idA']) ) {
		$archivo = Archivo::get($_SESSION['idA']);

		header('Content-type: '.$archivo->getTipo());
		header('Content-Disposition: attachment; filename= '.$archivo->getNombre());
		readfile($archivo->getRuta());

		$_SESSION['idA'] = 0;
	}else{
		echo "No tiene acceso al archivo";
	}
	
}else{
	echo "No ha iniciado sesion, no tiene acceso a esta seccion";
}

?>