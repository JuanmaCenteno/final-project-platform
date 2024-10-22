

<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";

class Valoracion{
	
	private $id;
	private $id_proyecto;
	private $autor;
	private $alumno;
	private $valoracion;
	private $nota;
    private $rol;
    private $archivo;


	public function __construct($id,$id_proyecto,$autor,$alumno,$valoracion,$nota,$rol,$archivo){
		$this->id = $id;
		$this->id_proyecto = $id_proyecto;
		$this->autor = $autor;
		$this->alumno = $alumno;
		$this->valoracion = $valoracion;
		$this->nota = $nota;
        $this->rol = $rol;
        $this->archivo = $archivo;
	}

	public function getID(){
		return $this->id;
	}
	public function getIDProyecto(){
		return $this->id_proyecto;
	}
	public function getAutor(){
		return Usuario::get($this->autor);
	}
	public function getAlumno(){
		return Usuario::get($this->alumno);
	}
	public function getValoracion(){
		return $this->valoracion;
	}
	public function getNota(){
		return $this->nota;
	}
    public function getRol(){
        return $this->rol;
    }
    public function getArchivo(){
        return $this->archivo;
    }

	/* METODOS DE CLASE */

	/* Funcion que devuelve la presentacion asignada a un alumno y su proyecto */
	public static function getValoracionDeAlumno($proyecto,$dni){
		$db = DB::getInstance();
        $query = "SELECT * FROM VALORACION WHERE (AUTOR = ? AND PROYECTO = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$proyecto);
        $stmt->execute();
        $res = $stmt->get_result();
        $valoraciones = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $valoracion = new Valoracion($row['ID'],$row['PROYECTO'],$row['AUTOR'],$row['ALUMNO'],$row['VALORACION'],$row['NOTA'],$row['ROL'],$row['ID_ARCHIVO']);
            array_push($valoraciones, $valoracion);
        }
        return $valoraciones;
	}

	/* Funcion que devuelve las presentaciones asignadas a un proyecto */
	public static function getByProyectoRol($proyecto,$rol){
		$db = DB::getInstance();
        $query = "SELECT * FROM VALORACION WHERE (ROL = ? AND PROYECTO = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$rol,$proyecto);
        $stmt->execute();
        $res = $stmt->get_result();
        $valoraciones = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $valoracion = new Valoracion($row['ID'],$row['PROYECTO'],$row['AUTOR'],$row['ALUMNO'],$row['VALORACION'],$row['NOTA'],$row['ROL'],$row['ID_ARCHIVO']);
            array_push($valoraciones, $valoracion);
        }
        return $valoraciones;
	}

    /* Funcion que devuelve las presentaciones asignadas a un proyecto */
    public static function getByProyecto($proyecto){
        $db = DB::getInstance();
        $query = "SELECT * FROM VALORACION WHERE PROYECTO = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$proyecto);
        $stmt->execute();
        $res = $stmt->get_result();

        $valoraciones = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $valoracion = new Valoracion($row['ID'],$row['PROYECTO'],$row['AUTOR'],$row['ALUMNO'],$row['VALORACION'],$row['NOTA'],$row['ROL'],$row['ID_ARCHIVO']);
            array_push($valoraciones, $valoracion);
        }
        return $valoraciones;
    }	

	/* CRUD */

	/* Crear */
	public static function crear($id_proyecto,$autor,$alumno,$valoracion,$nota,$rol,$archivo){

        //Creamos la ruta del proyecto sino aun no esta creada
        $ruta = $_SERVER['DOCUMENT_ROOT'] . '/tfg/Archivos/Valoraciones/'.$id_proyecto;
        if(!is_dir($ruta)){
            mkdir($ruta,0700);
        }

        $idArchivo = Archivo::crear($archivo,$autor,'Valoraciones/'.$id_proyecto);
		
		//Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "INSERT INTO VALORACION(PROYECTO,AUTOR,ALUMNO,VALORACION,NOTA,ROL,ID_ARCHIVO) VALUES(?,?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('isssdsi',$id_proyecto,$autor,$alumno,$valoracion,$nota,$rol,$idArchivo);
        $stmt->execute();
        $id_valoracion = $stmt->insert_id;
        
        if($id_valoracion > 0){
            return $id_valoracion;
        }else{
            return false;
        }
        
	}

	/* Obtener */
	public static function get($id){
		$db = DB::getInstance();
        $query = "SELECT * FROM VALORACION WHERE (ID = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $valoracion = new Valoracion($row['ID'],$row['PROYECTO'],$row['AUTOR'],$row['ALUMNO'],$row['VALORACION'],$row['NOTA'],$row['ROL'],$row['ID_ARCHIVO']);
            if($valoracion->getID()!=NULL){
            	return $valoracion;
            }else{
            	return false;
        	}
        }
        
	}

	/* Actualizar */
	public static function actualizar($dni,$idLectura,$asistencia,$motivo){
		/*$db = DB::getInstance();
        $query = "UPDATE TRIBUNAL SET ASISTENCIA = ?, MOTIVO = ? WHERE DNI = ? AND ID_LECTURA = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssi',$asistencia,$motivo,$dni,$idLectura);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }*/
	}

	/* Eliminar */
	public static function borrar($idLectura){
 		/*$db = DB::getInstance();
        $query = "DELETE FROM LECTURA WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$idLectura);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }*/
	}


}


 ?>
