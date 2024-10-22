
<?php
session_start(); 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

//Comprobamos que la peticion se haga desde un usuario correcto y admin
if(!empty($_SESSION['usuario'])){
	$usu = new Usuario($_SESSION['usuario']);

	if($usu->getRol()=='Admin'){

		switch ($_POST['action']) {
				case 'guardar':

					if(
						!empty($_POST['nombre']) &&
						!empty($_POST['apellidos']) &&
						!empty($_POST['email']) &&
						!empty($_POST['dni']) &&
						!empty($_POST['rol'])
					){
						$nombre = $_POST['nombre'];
						$apellidos = $_POST['apellidos'];
						$email = $_POST['email'];
						$dni = $_POST['dni'];
						$rol = $_POST['rol'];
						//Como password meteremos su DNI
						$password = $_POST['dni'];

						//Guardamos el usuario en la BBDD
						if(Usuario::crear($nombre,$apellidos,$email,$dni,$password,$rol)){
							echo "ok";
						}else{
							echo "error";
						}
						
					}else{
						echo "Faltan datos";
					}
					break;

				case 'guardarAlumnos':

					if(
						!empty($_POST['alumno']) &&
						!empty($_POST['email']) &&
						!empty($_POST['dni']) &&
						!empty($_POST['rol'])
					){	
						$alumno = explode(',', $_POST['alumno']);
						$email = explode(',', $_POST['email']);
						$dni = explode(',', $_POST['dni']);
						$rol = $_POST['rol'];

						for($i=0;$i<sizeof($alumno);$i++){
							//Como password meteremos su DNI
							$password = $dni[$i];
							//Separamos nombre y apellidos
							$datos = explode(' ', $alumno[$i]);
							$nombre = '';
							$apellidos = '';
							
							if(sizeof($datos) == 3){
								$nombre = $datos[0];
								$apellidos = $datos[1].' '.$datos[2];
							}else if(sizeof($datos) == 4){
								$nombre = $datos[0].' '.$datos[1];
								$apellidos = $datos[2].' '.$datos[3];
							}else if(sizeof($datos) == 5){
								$nombre = $datos[0].' '.$datos[1].' '.$datos[2];
								$apellidos = $datos[3].' '.$datos[4];
							}else{
								$nombre = $datos[0];
								$apellidos = $datos[1];
							}

							//Guardamos el usuario en la BBDD
							Usuario::crear($nombre,$apellidos,$email[$i],$dni[$i],$password,$rol);
						}
						echo true;
					}else{
						echo "Faltan datos";
					}
					break;

				case 'eliminar':

					if(!empty($_POST['dni'])){
						//Obtenemos el id del usuario que queremos eliminar
						$dni = $_POST['dni'];
						
						if(Usuario::borrar($dni)){
							echo "Usuario borrado";
						}else{
							echo "Problemas al borrar el usuario";
						}
						
					}else{
						echo "Faltan datos para borrar al usuario";
					}

					break;
					
				default:
					echo "Ninguna accion especifica";
					break;
			}	
		
	}else{
		echo "No es admin";
	}
}else{
	echo "No ha iniciado sesion";
}

?>