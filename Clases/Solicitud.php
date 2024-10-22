

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Archivo.php";

class Solicitud {

	private $id;
	private $dni;
	private $alumno;
    private $email;
	private $proyecto;
    private $descripcion;
    private $tutor;
    private $palabras_clave;
    private $archivo;
    private $aceptado;

	public function __construct($id,$dni,$alumno,$email,$proyecto,$descripcion,$palabras_clave,$tutor,$archivo,$aceptado){
		$this->id = $id;
        $this->dni = $dni;
		$this->alumno = $alumno;
		$this->email = $email;
        $this->proyecto = $proyecto;
		$this->descripcion = $descripcion;
        $this->palabras_clave = $palabras_clave;
        $this->tutor = $tutor;
        $this->archivo = $archivo;
        $this->aceptado = $aceptado;
	}

	/* METODOS SET Y GET */

    public function getID(){
        return $this->id;
    }
    public function getDNI(){
        return $this->dni;
    }
    public function getAlumno(){
        return $this->alumno;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getProyecto(){
        return $this->proyecto;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getPalabrasClave(){
        return $this->palabras_clave;
    }
    public function getTutor(){
        return $this->tutor;
    }
    public function getArchivo(){
        return $this->archivo;
    }
    public function getAceptado(){
        return $this->aceptado;
    }

    /* METODOS DE CLASE */

	/* METODOS STATIC */

    /* Funcion que devuelve las solicitudes pendientes */
    public static function getPendientes(){
        $db = DB::getInstance();
        $query = "SELECT * FROM SOLICITUD WHERE ACEPTADO IS NULL";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        $solicitudes = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $solicitudAux = new Solicitud($row['ID'],$row['DNI'],$row['ALUMNO'],$row['EMAIL'],$row['PROYECTO'],$row['DESCRIPCION'],$row['PALABRAS_CLAVE'],$row['TUTOR'],$row['ARCHIVO'],$row['ACEPTADO']);
            array_push($solicitudes, $solicitudAux);
        }
        return $solicitudes;
    }

    /* Funcion que devuelve las solicitudes pendientes */
    public static function getAceptadas(){
        $db = DB::getInstance();
        $query = "SELECT * FROM SOLICITUD WHERE ACEPTADO = 'si'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        $solicitudes = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $solicitudAux = new Solicitud($row['ID'],$row['DNI'],$row['ALUMNO'],$row['EMAIL'],$row['PROYECTO'],$row['DESCRIPCION'],$row['PALABRAS_CLAVE'],$row['TUTOR'],$row['ARCHIVO'],$row['ACEPTADO']);
            array_push($solicitudes, $solicitudAux);
        }
        return $solicitudes;
    }

    /* CRUD DE ARCHIVO */

	/* Crear */
	public static function crear($dni,$alumno,$email,$proyecto,$descripcion,$palabras_clave,$tutor,$archivo){

        $idArchivo = Archivo::crear($archivo,$dni,'Solicitudes');

        $db = DB::getInstance();
        $query = "INSERT INTO SOLICITUD(DNI,ALUMNO,EMAIL,PROYECTO,DESCRIPCION,PALABRAS_CLAVE,TUTOR,ARCHIVO) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssssssi',$dni,$alumno,$email,$proyecto,$descripcion,$palabras_clave,$tutor,$idArchivo);
        $stmt->execute();

        $idSolicitud = $stmt->insert_id;

        if($idSolicitud > 0){
            return $idSolicitud;
        }else{
            return false;
        }
	}

    /* Obtener */
    public static function get($id){

        $db = DB::getInstance();
        $query = "SELECT * FROM SOLICITUD WHERE (ID = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);
        $solicitud = new Solicitud($row['ID'],$row['DNI'],$row['ALUMNO'],$row['EMAIL'],$row['PROYECTO'],$row['DESCRIPCION'],$row['PALABRAS_CLAVE'],$row['TUTOR'],$row['ARCHIVO'],$row['ACEPTADO']);
        return $solicitud;
    }

    /* actualizar */
    public static function actualizar($id,$msg){

        $db = DB::getInstance();
        $query = "UPDATE SOLICITUD SET ACEPTADO = '$msg' WHERE ID = '$id'";
        $stmt = $db->prepare($query);
        $stmt->execute();

    }

    /* Borrar */
    public static function borrar($id){
        //Borramos el archivo adjunto si lo hay
        $solicitud = Solicitud::get($id);
        Archivo::borrarByID($solicitud->getArchivo());

        $db = DB::getInstance();
        $query = "DELETE FROM SOLICITUD WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}

?>