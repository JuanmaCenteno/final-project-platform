

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Lectura.php";

class Convocatoria {

	private $id;
	private $nombre;
	private $fecha_inicio;
	private $fecha_fin;

	public function __construct($id,$nombre,$fecha_inicio,$fecha_fin){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->fecha_inicio = $fecha_inicio;
		$this->fecha_fin = $fecha_fin;
	}

    /* SET y GET */

    public function getID(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getFechaInicio(){
        return date("d-m-Y", strtotime($this->fecha_inicio));
    }
    public function getFechaFin(){
        return date("d-m-Y", strtotime($this->fecha_fin));
    }


	/* Pasa una convocatoria a JSON */
    public function toJSON(){
        return array(
            'ID'=>$this->id,
            'NOMBRE'=>$this->nombre,
            'FECHA_INICIO'=>$this->fecha_inicio,
            'FECHA_FIN'=>$this->fecha_fin
            );
    }

    /* Funcion que devuelve un array de dias pertenecientes a la convocatoria */
    public function getDias(){
        $fechaInicio=strtotime($this->fecha_inicio);
        $fechaFin=strtotime($this->fecha_fin);

        $array = [];
        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            array_push($array, date("d-m-Y", $i));
        }

        return $array;

    }

    /* Funcion que devuelve un array de lecturas */
    public function getLecturasByDia($fecha){

        //Convertimos la fecha
        $fecha = date("Y-m-d",strtotime($fecha));
        //Obtenemos todas las lecturas de esta convocatoria y esa fecha
        $lecturas = Lectura::getLecturas($this->id,$fecha);

        return $lecturas;

    }

    /* METODOS STATIC */

    /* Devuleve todas las convocatorias */
    public static function getConvocatorias(){
        $db = DB::getInstance();
        $query = "SELECT * FROM CONVOCATORIA ORDER BY FECHA_INICIO ASC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $convocatorias = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $convocatoriaAux = new Convocatoria($row['ID'],$row['NOMBRE'],$row['FECHA_INICIO'],$row['FECHA_FIN']);
            array_push($convocatorias, $convocatoriaAux);
        }

        return $convocatorias;
    }

	/* CRUD DE CONVOCATORIA */

	/* Crear */
	public static function crear($nombre,$fecha_inicio,$fecha_fin){

		$id_convocatoria = 0;
        
        $db = DB::getInstance();
        $query = "INSERT INTO CONVOCATORIA(NOMBRE,FECHA_INICIO,FECHA_FIN) VALUES(?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss',$nombre,$fecha_inicio,$fecha_fin);
        $stmt->execute();
        $id_convocatoria = $stmt->insert_id;

        if($id_convocatoria != 0){
        	return $id_convocatoria;
        }else{
        	return 0;
        }
	}

	/* Obtener */
	public static function get($id){

		$db = DB::getInstance();
        $query = "SELECT * FROM CONVOCATORIA WHERE (ID = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $convocatoria = new Convocatoria($row['ID'],$row['NOMBRE'],$row['FECHA_INICIO'],$row['FECHA_FIN']);
            return $convocatoria;  
        }
        return false;
	}

	/* Eliminar*/
	public static function borrar($id){
		$db = DB::getInstance();
        $query = "DELETE FROM CONVOCATORIA WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
	}

	/* Actualizar */
	public static function actualizar(){
		
	}

} 

?>