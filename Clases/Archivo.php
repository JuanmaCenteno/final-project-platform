

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";

class Archivo {

	private $id;
	private $nombre;
	private $ruta;
	private $tipo;
    private $peso;
	private $id_entrega;

	public function __construct($id,$nombre,$ruta,$tipo,$peso,$id_entrega){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->ruta = $ruta;
		$this->tipo = $tipo;
        $this->peso = $peso;
		$this->id_entrega = $id_entrega;
	}

	/* METODOS SET Y GET */

    public function getID(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getRuta(){
        return $this->ruta;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function getPeso(){
        return $this->peso;
    }
    public function getIDentrega(){
        return $this->id_entrega;
    }

    /* METODOS DE CLASE */


	/* METODOS STATIC */

    /* Devuelve el archivo perteneciente a una entrega */
    public static function getArchivo($id_entrega){
        $db = DB::getInstance();
        $query = "SELECT * FROM ARCHIVO WHERE (ID_ENTREGA = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id_entrega);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);
        $archivo = new Archivo($row['ID'],$row['NOMBRE'],$row['RUTA'],$row['TIPO'],$row['PESO'],$row['ID_ENTREGA']);
        return $archivo;
    }

    /* CRUD DE ARCHIVO */

	/* Crear */
	public static function crear($archivo,$id,$dir){

		$temp_name = $archivo['tmp_name'];
		$nombre = $archivo['name'];
		$tipo = $archivo['type'];
		$tamaño = $archivo['size'];

		//Guardamos el archivo en el servidor
        if(is_uploaded_file($temp_name)){
            //Formamos la ruta
            $ruta = $_SERVER['DOCUMENT_ROOT'] . '/tfg/Archivos/'.$dir.'/'.$id;
            //Creamos el directorio
            mkdir($ruta,0700);
            //Añadimos nuestro archivo
            $ruta = $ruta.'/'.$nombre;
            //Lo subimos
            if(move_uploaded_file($temp_name, $ruta)){

                $db = DB::getInstance();

                if(is_int($id)){
                    //Para entregas
                    $query = "INSERT INTO ARCHIVO(NOMBRE,RUTA,TIPO,PESO,ID_ENTREGA) VALUES(?,?,?,?,?)";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('sssii',$nombre,$ruta,$tipo,$tamaño,$id);
                }else{
                    //Para archivos asociados al dni
                    $query = "INSERT INTO ARCHIVO(NOMBRE,RUTA,TIPO,PESO) VALUES(?,?,?,?)";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('sssi',$nombre,$ruta,$tipo,$tamaño);
                }
                $stmt->execute();
                $id_archivo = $stmt->insert_id;

                if($id_archivo > 0){
                    return $id_archivo;
                }else{
                    return false;
                }

            }else{
                echo "Fichero no subido";
            }

        }else{
            echo "Error al subir el fichero";
        }

	}

    /* Obtener */
    public static function get($id){

        $db = DB::getInstance();
        $query = "SELECT * FROM ARCHIVO WHERE (ID = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);
        $archivo = new Archivo($row['ID'],$row['NOMBRE'],$row['RUTA'],$row['TIPO'],$row['PESO'],$row['ID_ENTREGA']);
        return $archivo;
    }

    /* Borrar */
    public static function borrar($archivo){

        $cont = 0;
        $file = $archivo->getRuta();
        if(is_file($file)){
            unlink ($file);
        }

        $fin = strlen($archivo->getRuta()) - strlen($archivo->getNombre());
        $dir = substr($file, 0, $fin);
        echo $dir;
        if(is_dir($dir)){ 
            rmdir ($dir);
        }
    }

    /* Borrar archivo por entrega */
    public static function borrarByEntrega($id_entrega){
        $archivo = Archivo::getArchivo($id_entrega);
        Archivo::borrar($archivo);
    }

    /* Borrar archivo por id */
    public static function borrarByID($id){
        $archivo = Archivo::get($id);
        //Lo borramos del sistema
        Archivo::borrar($archivo);

        $db = DB::getInstance();
        $query = "DELETE FROM ARCHIVO WHERE ID = ?";
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