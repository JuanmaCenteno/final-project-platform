
<?php

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/';

session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Tribunal.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Lectura.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";


//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Admin'){

		switch ($_POST['action']) {

			case 'addLectura':

				if( !empty($_POST['idProyecto']) && !empty($_POST['fechaLectura']) &&
					!empty($_POST['idConvocatoria']) && !empty($_POST['hora']) &&
					!empty($_POST['aula'])
					){

					$idLectura = Lectura::crear($_POST['idProyecto'],$_POST['idConvocatoria'],$_POST['fechaLectura'],$_POST['hora'],$_POST['aula']);
					$proyecto = Proyecto::get($_POST['idProyecto']);
					$proyecto->setLectura($idLectura);

					//Notificacion
					$badge = 'Fecha: '.$_POST['fechaLectura'];
					$destino = $proyecto->getUsuarios();
					$mensaje = 'Lectura concretada';
					$ruta = $server_name.'Comun/detallarLectura.php?idL='.$idLectura;
					Notificacion::crear($badge,$destino,$mensaje,$ruta);

					//Notificacion para los profesores
					$badge = 'Lectura';
					echo var_dump($destino = $proyecto->getProfesoresLectura());
					$mensaje = 'Nueva lectura para puja';
					$ruta = $server_name.'Profesor/pujarLecturas.php';
					Notificacion::crear($badge,$destino,$mensaje,$ruta);
					
					if($idLectura > 0){
			            echo true;
			        }else{
			            echo false;
			        }

				}else{
					echo 'Faltan datos en la creacion';
				}

				break;

			case 'eliminarLectura':

				if(!empty($_POST['idLectura'])){
					$idLectura =  $_POST['idLectura'];
					//Cambiamos le estado del proyecto
					$lectura = Lectura::get($_POST['idLectura']);
					$proyecto = $lectura->getProyecto();
					$proyecto->setEstado('Pendiente lectura');

					//Eliminamos de la base de datos la lectura
					echo Lectura::borrar($idLectura);
				}else{
					echo "Falta algun campo para la eliminacion de la lectura";
				}
				break;

			case 'eliminarTribunal':

				if(!empty($_POST['idLectura']) && !empty($_POST['dniTribunal'])){
					$idLectura =  $_POST['idLectura'];
					$dniTribunal = $_POST['dniTribunal'];
					//Eliminamos de la base de datos el tribunal asignado
					echo Tribunal::quitar($idLectura,$dniTribunal);
				}else{
					echo "Falta algun campo para la eliminacion del tribunal";
				}

				break;

			case 'buscarTribunal':

				if(!empty($_POST['nombre']) && !empty($_POST['idproyecto']) && !empty($_POST['idlectura'])){

					$usuarios = Usuario::getTribunalesPosibles($_POST['nombre'],$_POST['idproyecto'],$_POST['idlectura']);

					if($usuarios!=null){
						$arr = array(
							'estado'=>'ok',
							'usuarios'=>$usuarios
							);
						echo json_encode($arr);
					}else{
						$arr = array(
							'estado'=>'not',
							'usuarios'=> NULL
							);
						echo json_encode($arr);
					}
				}
				break;

			case 'addTribunal':

				if(!empty($_POST['dni']) && !empty($_POST['idlectura']) && !empty($_POST['rol'])){

					if(Tribunal::actualizar($_POST['dni'],$_POST['idlectura'],$_POST['rol'])){

						//Notificacion
						$badge = 'Lectura';
						$destino = [];
						array_push($destino, $_POST['dni']);
						$mensaje = 'Asignado como '. $_POST['rol'];
						$ruta = $server_name.'Comun/detallarLectura.php?idL='.$_POST['idlectura'];
						Notificacion::crear($badge,$destino,$mensaje,$ruta);

						echo true;
					}else{
						echo false;
					}
				}

				break;

			case 'buscarProyecto':

				if( !empty($_POST['nombre']) ){
					
					$proyectos = Proyecto::getProyectosByNombre($_POST['nombre']);

					if($proyectos!=null){
						$arr = array(
							'estado'=>'ok',
							'proyectos'=>$proyectos
							);
						echo json_encode($arr);
					}else{
						$arr = array(
							'estado'=>'not',
							'proyectos'=> NULL
							);
						echo json_encode($arr);
					}
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