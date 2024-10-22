

<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Convocatoria.php";


//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Admin'){

		switch ($_POST['action']) {

			case 'guardar':
					
				if(
					!empty($_POST['nombre']) &&
					!empty($_POST['from']) &&
					!empty($_POST['to'])
				){
					$nombre = $_POST['nombre'];
					$fecha_inicio =  $_POST['from'];
					$fecha_fin = $_POST['to'];

					//Guardamos la convocatoria
					$idConvocatoria = Convocatoria::crear($nombre,$fecha_inicio,$fecha_fin);

					if($idConvocatoria != 0){
						$res = array(
				            'estado' => true,
				            'id' => $idConvocatoria
				        );
						echo json_encode($res);
						
					}else{
						$res = array(
				            'estado' => false,
				            'id' => 0
				        );
						echo json_encode($res);
					}
				}else{
					echo "Faltan datos para guardar el proyecto";
				}
				break;

			case 'eliminar':

				if(!empty($_POST['idConvocatoria'])){
					$idConvocatoria =  $_POST['idConvocatoria'];
					//Eliminamos de la base de datos la lectura
					echo Convocatoria::borrar($idConvocatoria);
				}else{
					echo "Falta algun campo para la eliminacion de la lectura";
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