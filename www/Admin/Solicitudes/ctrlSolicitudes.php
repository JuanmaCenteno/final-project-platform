

<?php
session_start(); 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Solicitud.php";

//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Admin'){

		switch ($_POST['action']) {

			case 'aceptar':
					
				if(!empty($_POST['id'])){
					Solicitud::actualizar($_POST['id'],'si');
					echo true;
				}else{
					echo "Faltan datos para guardar el proyecto";
				}
				break;

			case 'eliminar':
					
				if(!empty($_POST['id'])){
					Solicitud::borrar($_POST['id']);
					echo true;
				}else{
					echo "Faltan datos para guardar el proyecto";
				}
				break;
			
			default:
				echo "Ninguna accion especificada";
				break;
		}
	}else{
		echo "No es admin";
	}
}else{
	echo "No ha iniciado sesion";
}

?>