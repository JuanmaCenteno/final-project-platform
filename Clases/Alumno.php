
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";

//Clase para los usuarios

class Alumno extends Usuario {

	private $dni;

	public function __construct($dni){
		$this->dni = $dni;
		parent::__construct($dni);
	}

	/* Devuelve el proyecto si pertenece al alumno */
	public function getProyecto($idP){

		$db = DB::getInstance();
        $query = "SELECT * FROM PROYECTO WHERE ID = (SELECT PROYECTO FROM ALUMNO WHERE DNI = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$this->dni);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_array(MYSQLI_ASSOC);
        $proyecto = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
        return $proyecto;
	}

    /* CRUD */

    /* Crear */
    public static function crear($dni,$proyecto){

        //Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "INSERT INTO ALUMNO(DNI,PROYECTO) VALUES (?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$proyecto);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        
    }

    /* Obtener */
    public static function get($dni){
        
    }

    /* Actualizar */
    public static function actualizar(){

    }

    /* borrar */
    public static function borrar($dni,$proyecto){
        $db = DB::getInstance();
        $query = "DELETE FROM ALUMNO WHERE DNI = ? AND PROYECTO = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$proyecto);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
        
    }

    /* borrar todos los alumnos de un proyecto */
    public static function borrarAll($proyecto){
        $db = DB::getInstance();
        $query = "DELETE FROM ALUMNO WHERE PROYECTO = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$proyecto);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
        
    }
} 

?>