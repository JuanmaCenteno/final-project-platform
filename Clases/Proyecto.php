
<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Entrega.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Alumno.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Profesor.php";

class Proyecto {

	private $id;
	private $nombre;
	private $descripcion;
	private $nota_final;
    private $palabras_clave;
    private $tutor;
    private $alumno;
    private $entregas;
    private $estado;
    private $convocatoria;

	public function __construct($id,$nombre,$descripcion,$nota_final,$palabras_clave,$estado,$convocatoria){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        if($nota_final == null){
            $this->nota_final = "Sin nota asignada";  
        }else{
            $this->nota_final = $nota_final;
        }
        $this->palabras_clave = $palabras_clave;
        $this->estado = $estado;
        $this->convocatoria = $convocatoria;
        $this->tutor = [];
        $this->alumno = [];
        $this->entregas = [];
    }

    /* METODOS SET Y GET */

    public function getID(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getNotaFinal(){
        return $this->nota_final;
    }
    public function getEntregas(){
        return Entrega::getEntregasByProyecto($this->id);
    }
    public function getPalabrasClave(){
        return $this->palabras_clave;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getConvocatoria(){
        return $this->convocatoria;
    }

    public function setEstado($estado){
        $db = DB::getInstance();
        $query = "UPDATE PROYECTO SET ESTADO = ? WHERE ID = '$this->id'";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$estado);
        $stmt->execute();
    }

    public function setConvocatoria($convocatoria){
        $db = DB::getInstance();
        $query = "UPDATE PROYECTO SET PETICION_CONVOCATORIA = ?, ESTADO = 'Pendiente lectura' WHERE ID = '$this->id'";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$convocatoria);
        $stmt->execute();
    }

    public function setLectura($lectura){
        $db = DB::getInstance();
        $query = "UPDATE PROYECTO SET PETICION_CONVOCATORIA = ?, ESTADO = 'Lectura' WHERE ID = '$this->id'";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$lectura);
        $stmt->execute();
    }

    /* METODOS DE CLASE */

    /* Devuelve el o los tutores asignados al proyecto */
    public function getTutor(){
        
        $db = DB::getInstance();
        $query = "SELECT DNI FROM PROFESOR WHERE PROYECTO = '$this->id'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $tutor = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $tutorAux = new Profesor($row['DNI']);
            array_push($tutor, $tutorAux);
        }
        $this->tutor = $tutor;
        return $tutor;
    }

    /* Devuelve el o los alumnos asignados al proyecto */
    public function getAlumno(){
        
        $db = DB::getInstance();
        $query = "SELECT DNI FROM ALUMNO WHERE PROYECTO = '$this->id'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $alumno = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $alumnoAux = new Alumno($row['DNI']);
            array_push($alumno, $alumnoAux);
        }
        $this->alumno = $alumno;
        return $alumno;
    }

    /* Devuelve los tutores de este proyecto */
    public function getLinkTutor(){
        $server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

        if(sizeof($this->tutor) == 0){
            $tutor = $this->getTutor();
        }else{
            $tutor = $this->tutor;
        }
        
        $aux = '';
        for($i=0;$i<sizeof($tutor);$i++){
            $aux = $aux . '<a href="'. $server_name.'www/Comun/perfil.php?id='. $tutor[$i]->getDNI() .'">' . $tutor[$i]->getNombreCompleto() . '</a>' .' - ';
        }
        return $aux;
    }

    /* Devuelve el nombre de los alumnos asignados al proyecto */
    public function getLinkAlumno(){
        $server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';
        
        if(sizeof($this->alumno) == 0){
            $alumno = $this->getAlumno();
        }else{
            $alumno = $this->alumno;
        }
        $aux = '';
        for($i=0;$i<sizeof($alumno);$i++){
            $aux = $aux . '<a href="'.$server_name.'www/Comun/perfil.php?id='. $alumno[$i]->getDNI() .'">' . $alumno[$i]->getNombreCompleto() . '</a>' .' - ';
        }
        return $aux;
    }

    /* Devuelve el DNI de los tutores */
    public function getDNITutor(){
        if(sizeof($this->tutor) == 0){
            $tutor = $this->getTutor();
        }else{
            $tutor = $this->tutor;
        }

        $aux = [];
        for($i=0;$i<sizeof($tutor);$i++){
            array_push($aux, $tutor[$i]->getDNI());
        }

        return $aux;
    }

    /* Devuelve el DNI de los alumnos */
    public function getDNIAlumno(){
        if(sizeof($this->alumno) == 0){
            $alumno = $this->getAlumno();
        }else{
            $alumno = $this->alumno;
        }

        $aux = [];
        for($i=0;$i<sizeof($alumno);$i++){
            array_push($aux, $alumno[$i]->getDNI());
        }

        return $aux;
    }

    /* Funcion que devuelve los dni de los tutores y alumnos */
    public function getUsuarios(){
        $alumnos = $this->getDNIAlumno();
        $tutores = $this->getDNITutor();
        return array_merge($alumnos,$tutores);
    }

    /* Funcion que devuelve todos los usuarios que estan en el proyecto menos el dni que le pasamos */
    public function getDestinos($dni){
        $destinos = $this->getUsuarios();
        unset($destinos[array_search($dni,$destinos)]);
        return $destinos;
    }

    /* Funcion que devuelve todos los usuarios profesores que podrian ir como tribunal */
    public function getProfesoresLectura(){

        $db = DB::getInstance();
        $query = "SELECT DNI FROM USUARIO WHERE ROL = 'Profesor' AND DNI NOT IN (SELECT DNI FROM PROFESOR WHERE PROYECTO = '$this->id')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();
        $usuarios = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            array_push($usuarios, $row['DNI']);
        }
        return $usuarios;
    }

    /* Devuelve la entrega si pertenece al proyecto*/
    public function getEntregaByID($id){
        $db = DB::getInstance();
        $query = "SELECT * FROM ENTREGA WHERE (ID = ?) AND ID_PROYECTO = '$this->id' LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $entrega = new Entrega($row['ID'],$row['TITULO'],$row['DESCRIPCION'],$row['FECHA'],$row['ID_PROYECTO'],$row['AUTOR']);
            return $entrega;  
        }
        return false;
    }

    /* Funcion que devuelve la lectura asignada al proyecto,si la tiene */
    public function getLectura(){
        $db = DB::getInstance();
        $query = "SELECT * FROM LECTURA WHERE (ID_PROYECTO = '$this->id') LIMIT 1";
        $stmt = $db->prepare($query);
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

    /* Devuelve el tipo de acceso que tiene el usuario indicado, o false sino tiene acceso */
    public function getAcceso($dni,$rol){

        $dni = $dni;

        switch ($rol) {
            case 'Alumno':
                $dnis = $this->getDNIAlumno();
                if(in_array($dni, $dnis)){
                    return 'Alumno';
                }
                break;
            case 'Profesor':
                $dnis = $this->getDNITutor();
                if(in_array($dni, $dnis)){
                    return 'Tutor';
                }else{
                    $dnis = Tribunal::getDNITribunal($this->convocatoria);
                    if(in_array($dni, $dnis)){
                        return 'Tribunal';
                    }
                }
                break;
            default:
                return false;
                break;
        }
        return false;
    }

    /* Funcion que devuelve el numero de valoraciones necesarias */
    public function getNumVal(){
        $t = $this->getDNITutor();
        $a = $this->getDNIAlumno();
        return sizeof($t)*sizeof($a);
    }

    /* Pasa un proyecto a JSON */
    public function toJSON(){
        return array(
            'id'=>$this->id,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'nota_final'=>$this->nota_final,
            'palabras_clave'=>$this->palabras_clave
            );
    }

    /* METODOS STATIC PARA PROYECTOS */

    /* Asigna la nota final */
    public static function setNota($proyecto,$nota){
        $db = DB::getInstance();
        $query = "UPDATE PROYECTO SET NOTA_FINAL = ? WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('di',$nota,$proyecto);
        $stmt->execute();
        return true;
    }

    /* Devuleve todos los proyectos */
    public static function getProyectos(){
        $db = DB::getInstance();
        $query = "SELECT * FROM PROYECTO ORDER BY ID DESC LIMIT 10";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        $proyectos = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $proyectoAux = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
            array_push($proyectos, $proyectoAux);
        }
        
        return $proyectos;
    }

    public static function getProyectosByNombre($nombre){

        $db = DB::getInstance();

        $nombre = '%'.$nombre.'%';
        $query = "SELECT * FROM PROYECTO WHERE NOMBRE LIKE ('$nombre') AND ESTADO = 'Pendiente lectura'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        //Rellenamos un array con los proyectos
        $proyectos = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $proyecto = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
            array_push($proyectos, $proyecto->toJSON());
        }
        return $proyectos;
    }

    /* Funcion que devuelve los proyectos segun la busqueda */
    public static function getByTipo($busqueda,$tipo){
        $parametro = '';

        switch ($tipo) {
            case 'Nombre':
                $parametro = 'NOMBRE';
                break;
            case 'Descripción':
                $parametro = 'DESCRIPCION';
                break;
            case 'Palabras clave':
                $parametro = 'PALABRAS_CLAVE';
                break;
            default:
                $parametro = 'NOTA_FINAL';
                break;
        }

        $db = DB::getInstance();
        $busqueda = '%'.$busqueda.'%';
        $query = "SELECT * FROM PROYECTO WHERE $parametro LIKE ('$busqueda')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        $proyectos = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $proyectoAux = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
            array_push($proyectos, $proyectoAux->toJSON());
        }
        return $proyectos;
    }

    /* CRUD DE PROYECTOS */

    /* Crear */
    public static function crear($nombre,$descripcion,$palabras_clave,$tutor,$alumno){

        $db = DB::getInstance();
        //Guardamos el proyecto
        $query = "INSERT INTO PROYECTO(NOMBRE,DESCRIPCION,PALABRAS_CLAVE) VALUES (?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss',$nombre,$descripcion,$palabras_clave);
        $stmt->execute();
        $id_proyecto = $stmt->insert_id;
  
        if($id_proyecto > 0){
            
            //Guardamos los profesores
            for ($i=0; $i < sizeof($tutor); $i++) {
                Profesor::crear($tutor[$i],$id_proyecto);
            }

            //Guardamos los alumnos asignados
            for ($i=0; $i < sizeof($alumno); $i++) { 
                Alumno::crear($alumno[$i],$id_proyecto);
            }

            return $id_proyecto;
        }else{
            return false;
        }
    }

    /* Obtener */
    public static function get($id){

        $db = DB::getInstance();
        $query = "SELECT * FROM PROYECTO WHERE (ID = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$id);
        if($stmt->execute()){
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $proyecto = new Proyecto($row['ID'],$row['NOMBRE'],$row['DESCRIPCION'],$row['NOTA_FINAL'],$row['PALABRAS_CLAVE'],$row['ESTADO'],$row['PETICION_CONVOCATORIA']);
            return $proyecto;  
        }
        return false; 
    }

    /* Actualizar */
    public static function actualizar($id,$nombre,$descripcion,$palabras_clave,$nota,$tutor,$alumno){

        $db = DB::getInstance();
        //Guardamos el proyecto
        $query = "UPDATE PROYECTO SET NOMBRE = ?, DESCRIPCION = ?, PALABRAS_CLAVE = ?, NOTA_FINAL = ? WHERE ID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssssi',$nombre,$descripcion,$palabras_clave,$nota,$id);
        $stmt->execute();

        Profesor::borrarAll($id);
        Alumno::borrarAll($id);

        //Guardamos los profesores
        for ($i=0; $i < sizeof($tutor); $i++) { 
            Profesor::crear($tutor[$i],$id);
        }

        //Guardamos los alumnos asignados
        for ($i=0; $i < sizeof($alumno); $i++) { 
            Alumno::crear($alumno[$i],$id);
        }
        return true;
    }

    /* borrar */
    public static function borrar($id){
        $db = DB::getInstance();
        $query = "DELETE FROM PROYECTO WHERE ID = ?";
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