
<?php
set_error_handler(function ($errno, $errstr) {
    return strpos($errstr, 'Declaration of') === 0;
}, E_WARNING);
//Clase Usuario
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/conexDB.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";


class Usuario {

    private $dni = "";
    private $nombre = "";
    private $apellidos ="";
    private $email = "";
    private $rol = "";
    private $foto = "";

    public function __construct($dni){
        $this->cargarUsuario($dni);
    }

    private function cargarUsuario($dni){

        $db = DB::getInstance();
        $query = "SELECT * FROM USUARIO WHERE (DNI = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_array(MYSQLI_ASSOC);

        $this->dni = $row['DNI'];
        $this->nombre = $row['NOMBRE'];
        $this->apellidos = $row['APELLIDOS'];
        $this->email = $row['EMAIL'];
        $this->rol = $row['ROL'];
        $this->foto = $row['FOTO'];
        
    }

    /* METODOS GET */

    public function getDNI(){
        return $this->dni;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getFoto(){
        return $this->foto;
    }

    /* METODOS DE CLASE */

    /* Carga las notificaciones */
    public function getNotificaciones(){

        $db = DB::getInstance();
        $query = "SELECT * FROM NOTIFICACIONES WHERE (DESTINADO = '$this->dni')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $notificaciones = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $notificacionAux = new Notificacion($row['ID'],$row['BADGE'],$row['DESTINADO'],$row['MENSAJE'],$row['RUTA']);
            array_push($notificaciones, $notificacionAux);
        }
        return $notificaciones;
    }

    /* Devuelve el nombre completo del usuario */
    public function getNombreCompleto(){
        return $this->nombre." ".$this->apellidos;
    }

    /* Devuelve el nombre completo del usuario en un link */
    public function getNombreCompletoLink(){
        $server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';
        $aux = '<a href="'.$server_name.'www/Comun/perfil.php?id='.$this->dni.'">' .$this->nombre." ".$this->apellidos. '</a>';
        return $aux;
    }

    /* Pasa un usuario a JSON */
    public function toJSON(){
        return array(
            'dni'=>$this->dni,
            'nombre'=>$this->nombre,
            'apellidos'=>$this->apellidos,
            'rol'=>$this->rol,
            'foto'=>$this->foto,
            'email'=>$this->email
            );
    }

    /* METODOS STATIC PARA USUARIOS */


    /* Valida un usuario mediante su DNI y PASS */
    public static function validar($dni,$pass){
        
        $db = DB::getInstance();
        $query = "SELECT PASSWORD FROM USUARIO WHERE (DNI = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_array(MYSQLI_ASSOC);

        if(password_verify($pass,$row['PASSWORD'])){
            return true;
        }else{
            return false;
        }
    }

    /* Devuelve el Rol de un usuario mediante su DNI */
    public static function getRolUsuario($dni){

        $db = DB::getInstance();
        $query = "SELECT ROL FROM USUARIO WHERE (DNI = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);
        return $row['ROL'];
        
    }

    /* Devuelve el nombre del Usuario mediante su DNI */
    public static function getNombreByDNI($dni){

        $db = DB::getInstance();
        $query = "SELECT NOMBRE,APELLIDOS FROM USUARIO WHERE (DNI = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);

        return $row['NOMBRE']." ".$row['APELLIDOS'];
    }

    /* Devuelve el/los usuarios por nombre */
    public static function getUsuarioByNombre($nombre){
        $arr = explode(", ", $nombre);
        $usuarios = [];

        for($i=0;$i<sizeof($arr);$i++){

            $db = DB::getInstance();
            $nombre = '%'.$arr[$i].'%';
            $query = "SELECT DNI FROM USUARIO WHERE CONCAT_WS(' ',NOMBRE,APELLIDOS) LIKE ('$nombre') LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $usuario = new Usuario($row['DNI']);
            array_push($usuarios, $usuario);

        }
        return $usuarios;
    }

    public static function getLinkNombre($dni){
        $nombre = Usuario::getNombreByDNI($dni);
        $aux = '<a href="http://localhost/tfg/www/Comun/perfil.php?id='.$dni.'">' .$nombre. '</a>';
        return $aux;
    }

    /* Devuelve la foto del usuario */
    public static function getFotoByDNI($dni){
        
        $db = DB::getInstance();
        $query = "SELECT FOTO FROM USUARIO WHERE (DNI = ?) LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);

        return $row['FOTO'];
    }

    /* Funcion que devuelve un array de posibles tribunales */
    public static function getTribunalesPosibles($nombre,$idProyecto,$idLectura){

        $db = DB::getInstance();
        $nombre = '%'.$nombre.'%';
        $query = "SELECT DNI FROM USUARIO WHERE CONCAT_WS(' ',NOMBRE,APELLIDOS) LIKE ('$nombre') AND DNI NOT IN (SELECT DNI FROM PROFESOR WHERE PROYECTO = '$idProyecto') AND DNI NOT IN (SELECT DNI FROM TRIBUNAL WHERE ID_LECTURA = '$idLectura') AND ROL = 'Profesor'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        //Rellenamos un array con los dni de todos los posibles candidatos a ser tribunal
        $usuarios = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $usuario = new Usuario($row['DNI']);
            array_push($usuarios, $usuario->toJSON());
        }
        return $usuarios;
    }

    /* Funcion que nos indica si un usuario tiene acceso a la lectura indicada */
    public static function acessoLectura($dni,$idLectura){
        $rolUsuario = Usuario::getRolUsuario($dni);

        if($rolUsuario == 'Alumno'){
            $db = DB::getInstance();
            $query = "SELECT PROYECTO FROM ALUMNO WHERE DNI = '$dni'";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            $idProyecto = $row['PROYECTO'];

            $query = "SELECT ID FROM LECTURA WHERE ID_PROYECTO = '$idProyecto' AND ID = '$idLectura'";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);

            if($row['ID']!=NULL){
                return true;
            }else{
                return false;
            }
        }else if($rolUsuario == 'Profesor'){
            $db = DB::getInstance();
            $query = "SELECT DNI FROM TRIBUNAL WHERE ID_LECTURA = '$idLectura' AND DNI = '$dni'";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();

            $row = $res->fetch_array(MYSQLI_ASSOC);
            if($row['DNI']!=NULL){
                return true;
            }else{
                //Miramos que sea el tutor
                $db = DB::getInstance();
                $query = "SELECT ID FROM LECTURA WHERE ID_PROYECTO IN (SELECT PROYECTO FROM PROFESOR WHERE DNI = '$dni') AND ID = '$idLectura'";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $res = $stmt->get_result();

                $row = $res->fetch_array(MYSQLI_ASSOC);

                if($row['ID']!=NULL){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    /* Devuelve posibles usuarios por rol para el proyecto dado */
    public static function getUsuarios($nombre,$idProyecto,$rol){
        $db = DB::getInstance();
        $nombre = '%'.$nombre.'%';
        $query = "SELECT DNI FROM USUARIO WHERE CONCAT_WS(' ',NOMBRE,APELLIDOS) LIKE ('$nombre') AND ROL = '$rol'";
        if($rol=='Alumno'){
            $query = $query . "AND DNI NOT IN (SELECT DNI FROM ALUMNO)";
        }else{
            $query = $query . "AND DNI NOT IN (SELECT DNI FROM PROFESOR WHERE PROYECTO = '$idProyecto')";
        }
         

        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();


        //Rellenamos un array con los dni de todos los posibles candidatos a ser tribunal
        $usuarios = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            $usuario = new Usuario($row['DNI']);
            array_push($usuarios, $usuario->toJSON());
        }
        return $usuarios;
    }

    /* Devuelve un array de DNI con los administradores */
    public static function getDNIAdministradores(){

        $db = DB::getInstance();
        $query = "SELECT DNI FROM USUARIO WHERE ROL = 'Admin'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        $admin = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
           array_push($admin, $row['DNI']);
        }
        
        return $admin;
    }

    /* CRUD DE USUARIOS */

    /* Crear */
    public static function crear($nombre,$apellidos,$email,$password,$dni,$rol){

        //Encriptamos la contraseña para guardarla en la bbdd
        $passE = crypt($password,DB::$salt);
        
        //Foto
        $rutaFoto = Usuario::rutaFoto($dni);

        //Lo guardamos en la bbdd
        $db = DB::getInstance();
        $query = "INSERT INTO USUARIO(NOMBRE,APELLIDOS,EMAIL,PASSWORD,DNI,ROL,FOTO) VALUES(?,?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssssss',$nombre,$apellidos,$email,$passE,$dni,$rol,$rutaFoto);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
        
    }

    /* Obtener */
    public static function get($dni){
        $usuario = new Usuario($dni);
        return $usuario;
    }

    /* Actualizar */
    public static function actualizar($nombre,$apellidos,$email,$foto,$dni){

        if(!empty($foto)){
            Usuario::borrarDirectorio($dni);
            $rutaFoto = Usuario::guardarFoto($dni,$foto);
            $query = "UPDATE USUARIO SET NOMBRE = ?, APELLIDOS = ?, EMAIL = ?,FOTO = '$rutaFoto' WHERE DNI = ?";
        }else{
            $query = "UPDATE USUARIO SET NOMBRE = ?, APELLIDOS = ?, EMAIL = ? WHERE DNI = ?";
        }
        
        //Lo guardamos en la bbdd
        $db = DB::getInstance();
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssss',$nombre,$apellidos,$email,$dni);
        if($stmt->execute()){
            return true;  
        }else{
            return false;
        }
    }

    /* borrar */
    public static function borrar($dni){
        $db = DB::getInstance();
        $query = "DELETE FROM USUARIO WHERE DNI = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        if($stmt->execute()){
            //Borramos su perfil
            Usuario::borrarDirectorio($dni);
            return true;  
        }else{
            return false;
        }
        
    }

    /* Cambiar contraseña */
    public static function cambiarPass($dni,$password){
        //Encriptamos la contraseña para guardarla en la bbdd
        $passE = crypt($password,DB::$salt);
        $db = DB::getInstance();
        $query = "UPDATE USUARIO SET PASSWORD = '$passE' WHERE DNI = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$dni);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /* Funciones para el CRUD de usuarios */

    public static function rutaFoto($dni){
        //Ponemos una foto default
        //Formamos la ruta
        $ruta = $_SERVER['DOCUMENT_ROOT'] . '/tfg/Archivos/Perfiles/'.$dni;
        //Creamos el directorio
        mkdir($ruta,0755);
        //Nuevo nombre
        $ruta = $ruta .'/'.$dni;       
        //Cogemos la foto
        $foto = $_SERVER['DOCUMENT_ROOT'] . '/tfg/static/images/user.png';
        //Lo subimos
        copy($foto, $ruta);
        //Generamos la ruta para la web
        return $rutaFoto = $server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/Archivos/Perfiles/'.$dni.'/'.$dni;
    }

    public static function guardarFoto($dni,$foto){
        $temp_name = $foto['tmp_name'];
        $nombre = $foto['name'];
        $tipo = $foto['type'];
        $tamaño = $foto['size'];

        //Guardamos el archivo en el servidor
        if(is_uploaded_file($temp_name)){

            //Formamos la ruta
            $ruta = $_SERVER['DOCUMENT_ROOT'] . '/tfg/Archivos/Perfiles/'.$dni;
            //Creamos el directorio
            mkdir($ruta,0755);
            //Añadimos nuestro archivo
            $ruta = $ruta.'/'.$dni;
            //Lo subimos
            if(move_uploaded_file($temp_name, $ruta)){
                return 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/Archivos/Perfiles/'.$dni.'/'.$dni;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public static function borrarDirectorio($dni){
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/tfg/Archivos/Perfiles/'.$dni;
        if(is_dir($dir)){
            $archivo = $dir . '/'.$dni;
            unlink ($archivo); 
            rmdir ($dir);
        }
    }
}
?>