

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";

class Tribunal{

	private $dni;
	private $id_lectura;
	private $asistencia;
	private $motivo;
	private $rol;
	
	public function __construct($dni,$id_lectura,$asistencia,$motivo,$rol){
		$this->dni = $dni;
		$this->id_lectura = $id_lectura;
		$this->asistencia = $asistencia;
		$this->motivo = $motivo;
		$this->rol = $rol;
	}

	public function getProfesor(){
		return Usuario::get($this->dni);
	}
	public function getLectura(){
		return Lectura::get($this->id_lectura);
	}
	public function getAsistencia(){
		return $this->asistencia;
	}
	public function getMotivo(){
		return $this->motivo;
	}
	public function getRol(){
		return $this->rol;
	}
	public function getDNI(){
		return $this->dni;
	}
	public function getIDLectura(){
		return $this->id_lectura;
	}
	public function getNombre(){
		return Usuario::getNombreByDNI($this->dni);
	}
	public function getLinkNombre(){
		return Usuario::getLinkNombre($this->dni);
	}

	/* METODOS STATIC */

	/* Funcion que devuelve el tribunal que podria ser asignado a una lectura */
	public static function getTribunalPendiente($id_lectura){
		$db = DB::getInstance();
        $query = "SELECT * FROM TRIBUNAL WHERE (ID_LECTURA = ?) AND ROL IS NULL ORDER BY ASISTENCIA DESC";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id_lectura);
        $stmt->execute();
        $res = $stmt->get_result();


        $tribunal = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $tribunalAux = new Tribunal($row['DNI'],$row['ID_LECTURA'],$row['ASISTENCIA'],$row['MOTIVO'],$row['ROL']);
            array_push($tribunal, $tribunalAux);
        }

        return $tribunal;
	}

    /* Funcion que devuelve el tribunal asignado a una lectura */
    public static function getTribunalConfirmado($id_lectura){
        $db = DB::getInstance();
        $query = "SELECT * FROM TRIBUNAL WHERE (ID_LECTURA = ?) AND ROL IS NOT NULL ORDER BY ASISTENCIA DESC";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id_lectura);
        $stmt->execute();
        $res = $stmt->get_result();


        $tribunal = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $tribunalAux = new Tribunal($row['DNI'],$row['ID_LECTURA'],$row['ASISTENCIA'],$row['MOTIVO'],$row['ROL']);
            array_push($tribunal, $tribunalAux);
        }

        return $tribunal;
    }

    /* Funcion que devuelve el DNI del tribunal asignado a una lectura */
    public static function getDNITribunal($id_lectura){
        $db = DB::getInstance();
        $query = "SELECT DNI FROM TRIBUNAL WHERE (ID_LECTURA = ? AND ASISTENCIA = 'si')";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id_lectura);
        $stmt->execute();
        $res = $stmt->get_result();

        $tribunal = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            array_push($tribunal, $row['DNI']);
        }

        return $tribunal;
    }

	/* CRUD DE TRIBUNALES */

	/* Crear */
    public static function crear($dni,$idLectura,$asistencia,$motivo){

        //Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "INSERT INTO TRIBUNAL(DNI,ID_LECTURA,ASISTENCIA,MOTIVO) VALUES(?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('siss',$dni,$idLectura,$asistencia,$motivo);
        if($stmt->execute()){
        	return true;
        }else{
        	return false;
        }
        
    }

    /* Obtener */
    public static function get($dni,$lectura){
        //Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "SELECT * FROM TRIBUNAL WHERE DNI = ? AND ID_LECTURA = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$lectura);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $tribunal = new Tribunal($row['DNI'],$row['ID_LECTURA'],$row['ASISTENCIA'],$row['MOTIVO'],$row['ROL']);
            return $tribunal;  
        }
        return false;
    }

    /* Actualizar */
    public static function actualizar($dni,$idLectura,$rol){
        $db = DB::getInstance();
        $query = "UPDATE TRIBUNAL SET ROL = ? WHERE DNI = ? AND ID_LECTURA = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssi',$rol,$dni,$idLectura);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
    }

    /* Quitar */
    public static function quitar($idLectura,$dni){
        $db = DB::getInstance();
        $query = "UPDATE TRIBUNAL SET ROL = NULL WHERE DNI = ? AND ID_LECTURA = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$idLectura);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
    }

    /* borrar */
    public static function borrar($idLectura,$dniTribunal){
        $db = DB::getInstance();
        $query = "DELETE FROM TRIBUNAL WHERE DNI = ? AND ID_LECTURA = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dniTribunal,$idLectura);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
        
    }
}

 ?>