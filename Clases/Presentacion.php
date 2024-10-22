
<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Archivo.php";

class Presentacion{
	
	private $id;
	private $id_proyecto;
	private $autor;
	private $titulo;
	private $observaciones;
	private $archivo;


	public function __construct($id,$id_proyecto,$autor,$titulo,$observaciones,$archivo){
		$this->id = $id;
		$this->id_proyecto = $id_proyecto;
		$this->autor = $autor;
		$this->titulo = $titulo;
		$this->observaciones = $observaciones;
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
	public function getTitulo(){
		return $this->titulo;
	}
	public function getObservaciones(){
		return $this->observaciones;
	}
	public function getArchivo(){
		return $this->archivo;
	}

	/* METODOS DE CLASE */

	/* Funcion que devuelve la presentacion asignada a un alumno y su proyecto */
	public static function getPresentacionDeAlumno($dni,$proyecto){
		$db = DB::getInstance();
        $query = "SELECT * FROM PRESENTACION WHERE (AUTOR = ? AND ID_PROYECTO = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si',$dni,$proyecto);
        if($stmt->execute()){
            $res = $stmt->get_result();
            $row = $res->fetch_array(MYSQLI_ASSOC);
            $presentacion = new Presentacion($row['ID'],$row['ID_PROYECTO'],$row['AUTOR'],$row['TITULO'],$row['OBSERVACIONES'],$row['ARCHIVO']);
            if($presentacion->getID()!=NULL){
            	return $presentacion;
            }else{
            	return false;
        	}
        }
        
	}

	/* Funcion que devuelve las presentaciones asignadas a un proyecto */
	public static function getByProyecto($proyecto){
		$db = DB::getInstance();
        $query = "SELECT * FROM PRESENTACION WHERE ID_PROYECTO = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$proyecto);
        $stmt->execute();
        $res = $stmt->get_result();

        $presentaciones = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $presentacion = new Presentacion($row['ID'],$row['ID_PROYECTO'],$row['AUTOR'],$row['TITULO'],$row['OBSERVACIONES'],$row['ARCHIVO']);
            array_push($presentaciones, $presentacion);
        }
        return $presentaciones;
	}	

	/* CRUD */

	/* Crear */
	public static function crear($id_proyecto,$autor,$titulo,$observaciones,$archivo){

		$idArchivo = Archivo::crear($archivo,$autor,'Presentaciones');
		
		//Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "INSERT INTO PRESENTACION(ID_PROYECTO,AUTOR,TITULO,OBSERVACIONES,ARCHIVO) VALUES(?,?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('isssi',$id_proyecto,$autor,$titulo,$observaciones,$idArchivo);
        $stmt->execute();
        $id_presentacion = $stmt->insert_id;
        
        if($id_presentacion > 0){
            return $id_presentacion;
        }else{
            return false;
        }
        
	}

	/* Obtener */
	public static function get($id){
		$db = DB::getInstance();
        $query = "SELECT * FROM PRESENTACION WHERE (ID = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $presentacion = new Presentacion($row['ID'],$row['ID_PROYECTO'],$row['AUTOR'],$row['TITULO'],$row['OBSERVACIONES'],$row['ARCHIVO']);
            if($presentacion->getID()!=NULL){
            	return $presentacion;
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
