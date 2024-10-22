

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";

class Comentario {

	private $id;
	private $comentario;
	private $fecha;
	private $id_entrega;
	private $autor;

	public function __construct($id,$comentario,$fecha,$id_entrega,$autor){

		$this->id = $id;
		$this->comentario = $comentario;
		$this->fecha = $fecha;
		$this->autor = $autor;
		$this->id_entrega = $id_entrega;
	}

	/* METODOS SET Y GET */

    public function getID(){
        return $this->id;
    }
    public function getComentario(){
        return $this->comentario;
    }
    public function getFecha(){
        return date("d-m-Y H:m:s", strtotime($this->fecha));
    }
    public function getAutor(){
        return $this->autor;
    }
    public function getIDentrega(){
        return $this->id_entrega;
    }

    /* METODOS DE CLASE */

    /* Transforma en JSON el comentario */
    public function toJSON(){
    	return array(
            'ID'=>$this->id,
            'COMENTARIO'=>$this->comentario,
            'NOMBRE_AUTOR'=>Usuario::getNombreByDNI($this->autor),
            'ROL_AUTOR'=>Usuario::getRolUsuario($this->autor),
            'FECHA'=>date("H:m d-m-Y", strtotime($this->fecha)),
            'FOTO'=>Usuario::getFotoByDNI($this->autor),
            'ID_ENTREGA'=>$this->id_entrega
            );
    }
	/* METODOS STATIC */

    /* Funcion que devuelve los comentarios de una entrega */

    public static function getComentarios($id_entrega){
        $db = DB::getInstance();
        $query = "SELECT * FROM COMENTARIOS WHERE (ID_ENTREGA = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id_entrega);
        $stmt->execute();
        $res = $stmt->get_result();

        $comentarios = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $comentAux = new Comentario($row['ID'],$row['COMENTARIO'],$row['FECHA'],$row['ID_ENTREGA'],$row['AUTOR']);
            array_push($comentarios, $comentAux);
        }
        return $comentarios;
    }


    /* CRUD DE COMENTARIO */

    /* Crear */
    public static function crear($comentario,$autor,$id_entrega,$fecha){

        $db = DB::getInstance();
        $query = "INSERT INTO COMENTARIOS(COMENTARIO,AUTOR,ID_ENTREGA,FECHA) VALUES (?,?,?,'$fecha')";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssi',$comentario,$autor,$id_entrega);
        $stmt->execute();

    }

    /* Obtener */
    public static function get($id){

        $db = DB::getInstance();
        $query = "SELECT * FROM COMENTARIOS WHERE (ID = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $comentario = new Comentario($row['ID'],$row['COMENTARIO'],$row['FECHA'],$row['ID_ENTREGA'],$row['AUTOR']);
            return $comentario;  
        }
        return false;
    }

    /* Actualizar */
    public static function actualizar(){

    }

    /* borrar */
    public static function borrar($id){
        $db = DB::getInstance();
        $query = "DELETE FROM COMENTARIOS WHERE ID = ?";
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