
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Lectura.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Tribunal.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";

//Clase para los usuarios

class Profesor extends Usuario {

	public function __construct($dni){
		parent::__construct($dni);
	}

	/* METODOS DE CLASE */

    /* Devuelve el proyecto si pertenece a ese profesor */
    public function getProyecto($id){
        
        $db = DB::getInstance();
        $dni = parent::getDNI();
        $query = "SELECT PROYECTO FROM PROFESOR WHERE PROYECTO = ? AND DNI = '$dni' LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_array(MYSQLI_ASSOC);

        if($row['PROYECTO']!=''){
            $query = "SELECT * FROM PROYECTO WHERE ID = ? LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i',$id);
            $stmt->execute();
            if($res = $stmt->get_result()){
                $row = $res->fetch_array(MYSQLI_ASSOC);
                $proyecto = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
                return $proyecto;
            }
        }
        return null; 

    }
     
	/* Devuelve los proyectos que tutoriza el profesor */
	public function getProyectos(){

		$db = DB::getInstance();

        //Recuperamos las ID de los proyectos donde el profesor esta incluido
        $dni = parent::getDNI();

        //Ahora recuperamos los proyectos completos
        $query = "SELECT * FROM PROYECTO WHERE ID IN (SELECT PROYECTO FROM PROFESOR WHERE DNI = '$dni')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $proyectos = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $proyectoAux = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
            array_push($proyectos, $proyectoAux);
        }

        return $proyectos;
	}

    /* Devuelve las repuestas a las lecturas */
    public function getRespuesta($idLecturas){
        $db = DB::getInstance();
        $dni = parent::getDNI();
        $query = "SELECT * FROM TRIBUNAL WHERE DNI = '$dni' AND ID_LECTURA = '$idLecturas' LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_array(MYSQLI_ASSOC);
        $respuesta = new Tribunal($row['DNI'],$row['ID_LECTURA'],$row['ASISTENCIA'],$row['MOTIVO'],$row['ROL']);
        return $respuesta;
    }

    /* Devuelve las lecturas a las que el profesor podria asistir como tribunal */
    public function getLecturas(){

        $db = DB::getInstance();
        $dni = parent::getDNI();
        $query = "SELECT * FROM LECTURA WHERE ID_PROYECTO NOT IN (SELECT PROYECTO FROM PROFESOR WHERE DNI = '$dni') ORDER BY FECHA_LECTURA ASC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        //Rellenamos un array con las lecturas a las que asistira el profesor
        $lecturas = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $lectura = new Lectura($row['ID'],$row['ID_PROYECTO'],$row['ID_CONVOCATORIA'],$row['FECHA_LECTURA'],$row['HORA'],$row['AULA'],$row['FECHA_LIMITE']);
            array_push($lecturas, $lectura);
        }
        return $lecturas;
    }

    /* Devuelve las lecturas que has sido confirmadas por el profesor */
    public function getLecturasAsignadas(){

        $db = DB::getInstance();
        $dni = parent::getDNI();
        $query = "SELECT * FROM LECTURA WHERE ID IN (SELECT ID_LECTURA FROM TRIBUNAL WHERE DNI = '$dni' AND ASISTENCIA = 'si' AND ROL IS NOT NULL)";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        //Rellenamos un array con las lecturas a las que asistira el profesor
        $lecturas = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $lectura = new Lectura($row['ID'],$row['ID_PROYECTO'],$row['ID_CONVOCATORIA'],$row['FECHA_LECTURA'],$row['HORA'],$row['AULA'],$row['FECHA_LIMITE']);
            array_push($lecturas, $lectura);
        }
        return $lecturas;

    }

    /* CRUD */

    /* Crear */
    public static function crear($dni,$proyecto){

        //Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "INSERT INTO PROFESOR(DNI,PROYECTO) VALUES(?,?)";
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
        $query = "DELETE FROM PROFESOR WHERE DNI = ? AND PROYECTO = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$proyecto);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
        
    }

    /* borrar todos los profesores de un proyecto */
    public static function borrarAll($proyecto){
        $db = DB::getInstance();
        $query = "DELETE FROM PROFESOR WHERE PROYECTO = ?";
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