
<?php
session_start();

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/';
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Tribunal.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";


//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Profesor'){

		switch ($_POST['action']) {

			case 'guardarRespuesta':

				if( !empty($_POST['dni']) && !empty($_POST['idLectura']) &&
					!empty($_POST['asistencia']) && !empty($_POST['motivo'])
					){

					$resp = Tribunal::crear($_POST['dni'],$_POST['idLectura'],$_POST['asistencia'],$_POST['motivo']);

					if($_POST['asistencia'] == 'si'){
						//Notificacion
						$badge = 'Lectura';
						$destino = Usuario::getDNIAdministradores();
						$mensaje = 'Un profesor pujo';
						$ruta = $server_name.'Admin/Convocatorias/Lectura/detallarLectura.php?idL='.$_POST['idLectura'];
						Notificacion::crear($badge,$destino,$mensaje,$ruta);
					}
					
					echo $resp; 

				}else{
					echo 'Faltan datos en la creacion';
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