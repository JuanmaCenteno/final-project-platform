
<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";

class Notificacion {

	private $id;
	private $badge;
	private $destino;
	private $mensaje;
    private $ruta;

	function __construct($id,$badge,$destino,$mensaje,$ruta){
		$this->id = $id;
		$this->badge = $badge;
		$this->destino = $destino;
		$this->mensaje = $mensaje;
		$this->ruta = $ruta;
	}

	/* METODOS SET Y GET*/

	public function getID(){
        return $this->id;
    }
    public function getBadge(){
        return $this->badge;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getMensaje(){
        return $this->mensaje;
    }
    public function getRuta(){
        return $this->ruta;
    }

    /* METODOS DE CLASE */

	/* METODOS STATIC */

    /* CRUD */

	/* Crear */
	public static function crear($badge,$destino,$mensaje,$ruta){
		$db = DB::getInstance();
        //Creamos una notificacion por cada destino
        for($i=0;$i<sizeof($destino);$i++){
            $query = "INSERT INTO NOTIFICACIONES(BADGE,DESTINADO,MENSAJE,RUTA) VALUES (?,?,?,?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('ssss',$badge,$destino[$i],$mensaje,$ruta);
            $stmt->execute();
        }
	}

    /* Obtener */
    public static function get($id){

        $db = DB::getInstance();
        $query = "SELECT * FROM NOTIFICACIONES WHERE ID = '$id'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);
        $not = new Notificacion($row['ID'],$row['BADGE'],$row['DESTINADO'],$row['MENSAJE'],$row['RUTA']);
        return $not;
    }

    /* Borrar */
    public static function borrar($id){
        $db = DB::getInstance();
        $query = "DELETE FROM NOTIFICACIONES WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
    }
}
?>