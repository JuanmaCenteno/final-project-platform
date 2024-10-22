

<?php
session_start();

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/';

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Presentacion.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Valoracion.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";


if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	switch ($_POST['action']) {

		case 'guardarPresentacion':
				
			if(
				!empty($_POST['titulo']) &&
				!empty($_POST['observaciones']) &&
				!empty($_POST['autor']) &&
				!empty($_POST['idProyecto']) &&
				!empty($_FILES['archivo'])
			){
				$idPresentacion = Presentacion::crear($_POST['idProyecto'],$_POST['autor'],$_POST['titulo'],$_POST['observaciones'],$_FILES['archivo']);
				if($idPresentacion > 0){
					echo true;
				}else{
					echo false;
				}
			}else{
				echo "Faltan datos";
			}

			break;

		case 'guardarValoracion':
			
			if(
				!empty($_POST['autor']) &&
				!empty($_POST['proyecto']) &&
				!empty($_POST['rol']) &&
				!empty($_POST['valoraciones']) && 
				!empty($_FILES['archivo'])
			){
				$autor = $_POST['autor'];
				$proyecto = $_POST['proyecto'];
				$rol = $_POST['rol'];
				$valoraciones = json_decode($_POST['valoraciones'], true);
				
				foreach ($valoraciones as $val) {
					Valoracion::crear($proyecto,$autor,$val['alumno'],$val['val'],$val['nota'],$rol,$_FILES['archivo']);

					//Notificacion
					$badge = $rol;
					$destino = [$val['alumno']];
					$mensaje = 'Valoración realizada';
					$ruta = $server_name.'Comun/Presentacion/detallarPresentacion.php?id='.$proyecto;
					Notificacion::crear($badge,$destino,$mensaje,$ruta);
				}

				if($rol == 'Tribunal'){
					//Asignamos la nota final al proyecto
					$valoraciones = Valoracion::getByProyecto($proyecto);
					$tutores = 0;
					$notaTutor = 0;
					foreach($valoraciones as $val){
						if($val->getRol()=='Tutor'){
							$notaTutor = $notaTutor + $val->getNota();
							$tutores++;
						}else{
							$notaTribunal = $val->getNota();
						}
					}

					$notaTutor = $notaTutor / $tutores;
					$notaFinal = ($notaTutor * 0.5) + ($notaTribunal * 0.5);
					Proyecto::setNota($proyecto,$notaFinal);

					//Notificacion
					$badge = 'Proyecto';
					$destino = Usuario::getDNIAdministradores();
					$mensaje = 'Nota final asignada';
					$ruta = $server_name.'Admin/Proyectos/detallarProyecto.php?id='.$proyecto;
					Notificacion::crear($badge,$destino,$mensaje,$ruta);
				}

				echo true;
			}else{
				echo "Faltan datos";
			}
			break;
		
		default:
			echo "Ninguna accion especificada";
			break;
	}
}else{
	echo "No ha iniciado sesion";
}	
?>
