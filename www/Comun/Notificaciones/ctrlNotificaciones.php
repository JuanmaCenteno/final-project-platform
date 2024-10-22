

<?php
session_start();

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";

if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);
	if(!empty($_GET['id'])){

		$not = Notificacion::get($_GET['id']);

		switch ($_GET['action']) {

			case 'eliminar':

				$ruta = $not->getRuta();
				echo $ruta;
				Notificacion::borrar($not->getID());
				header('Location: '.$ruta);

				break;
			
			default:
				echo "Ninguna accion especificada";
				break;
		}

	}else{
		echo "Faltan parametros";
	}

	
}else{
	echo "No ha iniciado sesion";
}

?>