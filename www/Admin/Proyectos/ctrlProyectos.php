
<?php
session_start();

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/www/'; 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Alumno.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Profesor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";

//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Admin'){

		switch ($_POST['action']) {

			case 'guardar':
					
				if(
					!empty($_POST['nombre']) &&
					!empty($_POST['descripcion']) &&
					!empty($_POST['palabras_clave'])
				){
					$nombre = $_POST['nombre'];
					$descripcion = $_POST['descripcion'];
					$palabras_clave = $_POST['palabras_clave'];

					$tutor = [];
					if(!empty($_POST['tutor'])){
						$tutor = json_decode($_POST['tutor']);
					}

					$alumno = [];
					if(!empty($_POST['alumno'])){
						$alumno = json_decode($_POST['alumno']);
					}
					//Guardamos el pryecto en la BBDD
					$id_proyecto = Proyecto::crear($nombre,$descripcion,$palabras_clave,$tutor,$alumno);
					
					if($id_proyecto > 0){
						echo $id_proyecto;
					}else{
						echo "El proyecto no se ha podido guardar";
					}
				}else{
					echo "Faltan datos para guardar el proyecto";
				}
				break;

			case 'eliminar':
				
				if(!empty($_POST['id'])){
					$id = $_POST['id'];

					if(Proyecto::borrar($id)){
						echo true;
					}else{
						echo false;
					}
				}else{
					echo "Falta el id del proyecto para borrar";
				}

				break;

			case 'actualizarProyecto':
				if(
					!empty($_POST['nombre']) &&
					!empty($_POST['descripcion']) &&
					!empty($_POST['nota_final']) &&
					!empty($_POST['palabras_clave']) &&
					!empty($_POST['idProyecto'])
				){
					$idProyecto = $_POST['idProyecto'];
					$nombre = $_POST['nombre'];
					$descripcion = $_POST['descripcion'];
					$palabras_clave = $_POST['palabras_clave'];
					$nota_final = $_POST['nota_final'];
					//Creamos los arrays de alumnos y tutores
					$profesores = $_POST['profesores'];
					$alumnos = $_POST['alumnos'];
					//Guardamos el pryecto en la BBDD
					Proyecto::actualizar($idProyecto,$nombre,$descripcion,$palabras_clave,$nota_final,$profesores,$alumnos);

					//Notificacion
					$badge = 'Actualizacion';
					$destino = array_merge($profesores, $alumnos);
					$mensaje = 'Su proyecto ha sido actualizado';
					$ruta = $server_name.'Comun/detallarProyecto.php?id='.$idProyecto;
					Notificacion::crear($badge,$destino,$mensaje,$ruta);

					echo true;
				}else{
					echo "Faltan datos para actualizar el proyecto";
				}
				break;

			case 'buscar':
				
				if(!empty($_POST['busqueda']) && !empty($_POST['tipo'])){
					$busqueda = $_POST['busqueda'];
					$tipo = $_POST['tipo'];

					$proyectos = Proyecto::getByTipo($busqueda,$tipo);

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
				}else{
					echo "Falta el id del proyecto para borrar";
				}

				break;

			case 'buscarUsuario':

				if(!empty($_POST['nombre']) && !empty($_POST['idProyecto']) && !empty($_POST['rol'])){

					$usuarios = Usuario::getUsuarios($_POST['nombre'],$_POST['idProyecto'],$_POST['rol']);

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

			case 'addUsuario':

				if(!empty($_POST['dni']) && !empty($_POST['idProyecto']) && !empty($_POST['rol'])){

					if($_POST['rol'] == 'Alumno'){
						Alumno::crear($_POST['dni'],$_POST['idProyecto']);
					}else{
						Profesor::crear($_POST['dni'],$_POST['idProyecto']);
					}

					//Notificacion
					$badge = 'Proyecto';
					$destino = [];
					array_push($destino, $_POST['dni']);
					$mensaje = 'Asignado a un';
					$ruta = $server_name.'Comun/detallarProyecto.php?id='.$_POST['idProyecto'];
					Notificacion::crear($badge,$destino,$mensaje,$ruta);

					echo true;

				}

				break;

			case 'eliminarUsuario':

				if(!empty($_POST['dni']) && !empty($_POST['idProyecto']) && !empty($_POST['rol'])){

					if($_POST['rol'] == 'Alumno'){
						Alumno::borrar($_POST['dni'],$_POST['idProyecto']);
					}else{
						Profesor::borrar($_POST['dni'],$_POST['idProyecto']);
					}

					//Notificacion
					$badge = 'Proyecto';
					$destino = [];
					array_push($destino, $_POST['dni']);
					$mensaje = 'Fue eliminado de un';
					$ruta = $server_name.'Comun/detallarProyecto.php?id='.$_POST['idProyecto'];
					Notificacion::crear($badge,$destino,$mensaje,$ruta);

					echo true;

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