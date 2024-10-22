
<?php
session_start(); 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	switch ($_POST['action']) {

			case 'cambiarPass':

				if(!empty($_POST['dni']) && !empty($_POST['pass'])){

					$dni = $_POST['dni'];
					$newPass = $_POST['pass'];

					echo Usuario::cambiarPass($dni,$newPass);
					
				}else{
					echo "Faltan datos para borrar al usuario";
				}

				break;

			case 'cambiarDatos':

				if( !empty($_POST['nombre']) && 
					!empty($_POST['apellidos']) &&
					!empty($_POST['email']) &&
					!empty($_POST['dni'])
				){

					echo Usuario::actualizar($_POST['nombre'],$_POST['apellidos'],$_POST['email'],$_FILES['archivo'],$_POST['dni']);

				}else{
					echo 'Faltan datos';
				}
				break;
				
			default:
				echo "Ninguna accion especifica";
				break;
		}	
		
}else{
	echo "No ha iniciado sesion";
}

?>





				