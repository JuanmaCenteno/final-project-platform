

<?php
session_start();

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/';

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php"; 
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Alumno.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Profesor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";


if(!empty($_SESSION['usuario'])){
	$dni = $_SESSION['usuario'];
	if(Usuario::getRolUsuario($dni)=='Alumno'){
		$alumno = new Alumno($dni);
		$proyecto = $alumno->getProyecto(1);
		$idProyecto = $proyecto->getID();

		if($idProyecto!=null){

			if(!empty($_GET['action'])){
				$action = $_GET['action'];
			}else if(!empty($_POST['action'])){
				$action = $_POST['action'];
			}else{
				$action = '';
			}

			switch ($action) {

				case 'peticion':
					$proyecto->setEstado('Pendiente aceptar');

					//Notificacion
					$badge = $alumno->getNombreCompleto();
					$destino = $proyecto->getDNITutor();
					$mensaje = 'Peticion de presentacion del proyecto';
					$ruta = $server_name.'Profesor/detallarProyecto.php?id='.$idProyecto;
					Notificacion::crear($badge,$destino,$mensaje,$ruta);

					header('Location: ../../main/mainAlumno.php');
					break;

				case 'solicitarConvocatoria':

					if(!empty($_POST['idConvocatoria'])){
						$proyecto->setConvocatoria($_POST['idConvocatoria']);

						//Notificacion
						$badge = $proyecto->getNombre();
						$destino = Usuario::getDNIAdministradores();
						$mensaje = 'Peticion de convocatoria';
						$ruta = $server_name.'Admin/Convocatorias/detallarConvocatoria.php?id='.$_POST['idConvocatoria'];
						Notificacion::crear($badge,$destino,$mensaje,$ruta);

						echo true;
					}else{
						echo "Faltan parametros";
					}

					break;
				
				default:
					echo "Ninguna accion especificada";
					break;
			}

		}else{
			echo "No existe el proyecto";
		}	
	}else if(Usuario::getRolUsuario($dni)=='Profesor'){

		if(!empty($_GET['idP'])){
			$profesor = new Profesor($dni);
			$proyecto = $profesor->getProyecto($_GET['idP']);
			$idProyecto = $proyecto->getID();
			if($idProyecto!=null){
				switch ($_GET['action']) {
					case 'aceptar':
						$proyecto->setEstado('Aceptado');

						//Notificacion
						$badge = $profesor->getNombreCompleto();
						$destino = $proyecto->getDestinos($dni);
						$mensaje = 'Proyecto aceptado para lectura';
						$ruta = $server_name.'Alumno/Peticion/solicitarConvocatoria.php';
						Notificacion::crear($badge,$destino,$mensaje,$ruta);

						header('Location: ../../main/mainProfesor.php');
						break;
					
					default:
						echo "Ninguna accion especificada";
						break;
				}	
			}else{
				echo "No tiene acceso a ese proyecto";
			}
		}else{
			echo "Faltan parametros para aceptar el proyecto";
		}

	}else{
		echo "Usted no es un Alumno";
	}
}else{
	echo "No ha iniciado sesion";
}	
?>
