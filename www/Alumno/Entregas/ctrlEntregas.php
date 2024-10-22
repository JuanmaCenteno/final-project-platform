

<?php  
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Alumno.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Entrega.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Archivo.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";
$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/';

session_start();

if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Alumno'){

		switch ($_POST['action']) {

			case 'guardar':
					
				if(
					!empty($_POST['titulo']) &&
					!empty($_POST['descripcion'])
				){
					$alumno = new Alumno($_SESSION['usuario']);
					$dni = $alumno->getDNI();
					$proyecto = $alumno->getProyecto($dni);
					$titulo = $_POST['titulo'];
					$descripcion = $_POST['descripcion'];
					$idProyecto = $proyecto->getID();

					$idEntrega = Entrega::crear($titulo,$descripcion,$idProyecto,$dni);

					if($idEntrega > 0){

						//Notificacion
						$badge = $alumno->getNombreCompleto();
						$destino = $proyecto->getDestinos($dni);
						$mensaje = 'Entrega realizada';
						$ruta = $server_name.'Comun/detallarEntrega.php?idE='.$idEntrega.'&&idP='.$idProyecto;
						Notificacion::crear($badge,$destino,$mensaje,$ruta);

						//Fichero
						//Hacer comprobaciones de tamaño y tipo
						if(!empty($_FILES['archivo'])){
							Archivo::crear($_FILES['archivo'],$idEntrega,'Proyectos/Entregas');
						}
						header('Location: ../../main/mainAlumno.php');
					}else{
						echo "No se pudo realizar la entrega correctamente";
					}
				}else{
					echo "Faltan datos, compruebe que relleno el campo titulo y descripcion";
				}

				break;

			case 'eliminar':
				if(!empty($_POST['idEntrega'])){
					$idEntrega =  $_POST['idEntrega'];
					//Eliminamos de la base de datos la lectura
					echo Entrega::borrar($idEntrega);
				}else{
					echo "Falta algun campo para la eliminacion de la entrega";
				}
				break;
			
			default:
				echo "Ninguna accion especificada";
				break;
		}
	}else{
		echo "Usted no es un Alumno";
	}
}else{
	echo "No ha iniciado sesion";
}	
?>
