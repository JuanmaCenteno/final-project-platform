

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php"; 

class Admin extends Usuario {

	public function __construct($dni){
		//Rellena la clase Usuario
		parent::__construct($dni);
	}

	/* METODOS DE CLASE */

	/* Devuelve los usuarios diferenciados por su rol */
	public function getUsuariosByRol(){
		//Variables para devolver
		$alumnos=[];
		$profesores=[];
		$administradores=[];

		$db = DB::getInstance();
        $query = "SELECT DNI FROM USUARIO";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
        	$usu = new Usuario($row['DNI']);
        	switch ($usu->getRol()) {
        		case 'Alumno':
        			array_push($alumnos, $usu);
        			break;
    			case 'Profesor':
        			array_push($profesores, $usu);
        			break;
        		case 'Admin':
        			array_push($administradores, $usu);
        			break;

        	}
        }
        
        return [$profesores,$alumnos,$administradores];
	}
}

?>