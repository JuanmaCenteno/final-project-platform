

<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Proyecto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Tribunal.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Convocatoria.php";

class Lectura{
	
	private $id;
	private $id_proyecto;
	private $id_convocatoria;
	private $fecha_lectura;
	private $hora;
	private $aula;
	private $fecha_limite; //Para la confirmacion de los tribunales


	public function __construct($id,$id_proyecto,$id_convocatoria,$fecha_lectura,$hora,$aula,$fecha_limite){
		$this->id = $id;
		$this->id_proyecto = $id_proyecto;
		$this->id_convocatoria = $id_convocatoria;
		$this->fecha_lectura = $fecha_lectura;
		$this->hora = $hora;
		$this->aula = $aula;
		$this->fecha_limite = $fecha_limite;
	}

	public function getID(){
		return $this->id;
	}
	public function getIDProyecto(){
		return $this->id_proyecto;
	}
	public function getIDConvocatoria(){
		return $this->id_convocatoria;
	}
	public function getFechaLectura(){
		return date("d-m-Y", strtotime($this->fecha_lectura));
	}
	public function getHora(){
		$elimina_segundos=substr($this->hora, 0, -3);
		return $elimina_segundos;
	}
	public function getAula(){
		return $this->aula;
	}
	public function getFechaLimite(){
		return $this->fecha_limite;
	}

	/* METODOS DE CLASE */

	/* Funcion que devuelve el proyecto asignado a la lectura */
	public function getProyecto(){
		return Proyecto::get($this->id_proyecto);
	}

	/* Funcion que devuelve la convocatoria a la que esta asignada la lectura */
	public function getConvocatoria(){
		return Convocatoria::get($this->id_convocatoria);
	}

	/* Funcion que devuelve el tribunal asignado de una lectura */
	public function getTribunal(){
		return Tribunal::getTribunalConfirmado($this->id);
	}

	/* Funcion que devuelve el posible tribunal asignado de una lectura */
	public function getPosibleTribunal(){
		return Tribunal::getTribunalPendiente($this->id);
	}

	/* Funcion que devuelve el tribunal confirmado */
	public function getTribunalConfirmado($tribunal){
		$array = [];

		for($i=0;$i<sizeof($tribunal);$i++){
			if($tribunal[$i]->getAsistencia() == 'si'){
				array_push($array, $tribunal[$i]);
			}
		}
		return $array;
	}


	/* METODOS STATIC */

	/* Funcion que devuelve las lecturas por dias */
	public static function getLecturas($id_convocatoria,$fecha){
		$db = DB::getInstance();
        $query = "SELECT * FROM LECTURA WHERE (ID_CONVOCATORIA = ?) AND (FECHA_LECTURA = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('is',$id_convocatoria,$fecha);
        $stmt->execute();
        $res = $stmt->get_result();


        $lecturas = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $lecturaAux = new Lectura($row['ID'],$row['ID_PROYECTO'],$row['ID_CONVOCATORIA'],$row['FECHA_LECTURA'],$row['HORA'],$row['AULA'],$row['FECHA_LIMITE']);
            array_push($lecturas, $lecturaAux);
        }

        return $lecturas;
	}

	/* CRUD */

	public static function crear($id_proyecto,$id_convocatoria,$fecha_lectura,$hora,$aula){
		
		//Lo guardamos en la bbdd
        $db = DB::getInstance();
        $fecha_lectura = date("Y-m-d H:m:s", strtotime($fecha_lectura));
        //Creamos una fecha limite
        $fecha_limite = strtotime ( '-10 day' , strtotime ( $fecha_lectura ) ) ;
		$fecha_limite = date ( 'Y-m-d' , $fecha_limite );

        $query = "INSERT INTO LECTURA(ID_PROYECTO,ID_CONVOCATORIA,FECHA_LECTURA,FECHA_LIMITE,HORA,AULA) VALUES(?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iissss',$id_proyecto,$id_convocatoria,$fecha_lectura,$fecha_limite,$hora,$aula);
        $stmt->execute();
        $id_lectura = $stmt->insert_id;
        
        if($id_lectura > 0){
            return $id_lectura;
        }else{
            return false;
        }
        
	}

	public static function get($id){
		$db = DB::getInstance();
        $query = "SELECT * FROM LECTURA WHERE (ID = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $lectura = new Lectura($row['ID'],$row['ID_PROYECTO'],$row['ID_CONVOCATORIA'],$row['FECHA_LECTURA'],$row['HORA'],$row['AULA'],$row['FECHA_LIMITE']);
            if($lectura->getID()!=NULL){
            	return $lectura;
            }else{
            	return false;
        	}
        }
        
	}



	public static function borrar($idLectura){
 		$db = DB::getInstance();
        $query = "DELETE FROM LECTURA WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$idLectura);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
	}


}


 ?>
