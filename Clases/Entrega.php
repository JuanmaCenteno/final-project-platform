

<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Archivo.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Comentario.php";

class Entrega {

	private $id;
	private $titulo;
	private $descripcion;
	private $fecha;
	private $id_proyecto;
    private $archivo;
    private $comentarios;
    private $autor;

	public function __construct($id,$titulo,$descripcion,$fecha,$id_proyecto,$autor){
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->id_proyecto = $id_proyecto;
        $this->autor = $autor;
    }

    /* METODOS SET Y GET */

    public function getID(){
        return $this->id;
    }
    public function getTitulo(){
        return $this->titulo;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getFecha(){
        return date("d-m-Y H:m:s", strtotime($this->fecha));
    }
    public function getProyecto(){
        return Proyecto::get($this->id_proyecto);
    }
    public function getArchivo(){
        return Archivo::getArchivo($this->id);
    }
    public function getComentarios(){
        return Comentario::getComentarios($this->id);
    }
    public function getAutor(){
        return Usuario::get($this->autor);
    }

    /* METODOS DE CLASE */

    /* Devuelve las entregas del proyecto */
    public function getEntregasByProyecto($id_proyecto){

        $db = DB::getInstance();
        $query = "SELECT * FROM ENTREGA WHERE (ID_PROYECTO = '$id_proyecto') ORDER BY FECHA DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $entregas = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $entregaAux = new Entrega($row['ID'],$row['TITULO'],$row['DESCRIPCION'],$row['FECHA'],$row['ID_PROYECTO'],$row['AUTOR']);
            array_push($entregas, $entregaAux);
        }
        return $entregas;
    }

    /* Transforma la clase en JSON */
    public function toJSON(){
        return array(
            'ID'=>$this->id,
            'TITULO'=>$this->titulo,
            'DESCRIPCION'=>$this->descripcion,
            'FECHA'=>$this->fecha,
            'ID_PROYECTO'=>$this->id_proyecto
            );
    }

    /* Devuelve los comentarios en JSON */
    public function getComentariosJSON(){
        $arrayAux = [];
        $comentarios = $this->getComentarios();
        for($i=sizeof($comentarios)-1;$i>=0;$i--){
            array_push($arrayAux, $comentarios[$i]->toJSON());
        }
        return $arrayAux;
    }


    /* METODOS STATIC */


    /* CRUD DE CLASE */

    /* Crear */
    public static function crear($titulo,$descripcion,$id_proyecto,$autor){

        $db = DB::getInstance();
        $fecha = date("Y-m-d H:i:s");
        $query = "INSERT INTO ENTREGA(TITULO,DESCRIPCION,ID_PROYECTO,FECHA,AUTOR) VALUES(?,?,?,'$fecha',?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssis',$titulo,$descripcion,$id_proyecto,$autor);
        $stmt->execute();
        $id_entrega = $stmt->insert_id;

        if($id_entrega > 0){
            return $id_entrega;
        }else{
            return false;
        }
        
    }

    /* Borrar */
    public static function borrar($id){
        //Borramos el archivo adjunto si lo hay
        Archivo::borrarByEntrega($id);

        $db = DB::getInstance();
        $query = "DELETE FROM ENTREGA WHERE ID = ?";
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