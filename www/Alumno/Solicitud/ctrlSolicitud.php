

<?php  
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Solicitud.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";
$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/';

if(!empty($_POST['clave'])){
	$clave = $_POST['clave'];
	if($clave == 'proyecto123'){
		//Posee clave, creamos la solicitud
		if(
			!empty($_POST['dni']) &&
			!empty($_POST['alumno']) &&
			!empty($_POST['email']) &&
			!empty($_POST['proyecto']) &&
			!empty($_POST['descripcion']) &&
			!empty($_POST['palabras_clave']) &&
			!empty($_POST['tutor']) &&
			!empty($_FILES['archivo'])
		){

			$dni = $_POST['dni'];
			$alumno = $_POST['alumno'];
			$email = $_POST['email'];
			$proyecto = $_POST['proyecto'];
			$descripcion = $_POST['descripcion'];
			$palabras_clave = $_POST['palabras_clave'];
			$tutor = $_POST['tutor'];
			$archivo = $_FILES['archivo'];

			//Comprobar tamaño del fichero

			$idSolicitud = Solicitud::crear($dni,$alumno,$email,$proyecto,$descripcion,$palabras_clave,$tutor,$archivo);

			if($idSolicitud > 0){

				//Notificacion
				$badge = $alumno;
				$destino = Usuario::getDNIAdministradores();
				$mensaje = 'Nueva solicitud';
				$ruta = $server_name.'Admin/Solicitudes/detallarSolicitud.php?id='.$idSolicitud;
				Notificacion::crear($badge,$destino,$mensaje,$ruta);


				$msj = 'Solicitud enviada';
			}else{
				$msj = 'Falta adjuntar su Anteproyecto';
			}


		}else{
			$msj = 'Faltan datos para procesar la solicitud';
		}
	}else{
		$msj = 'Clave incorrecta';
	}
}else{
	$msj = 'No posee clave';
}

header('Location: infoSolicitud.php?msj='.$msj);	
?>
