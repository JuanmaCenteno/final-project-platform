
<?php
session_start();
$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";

if(!empty($_POST['dni']) && !empty($_POST['pass'])){
    $dni = $_POST['dni'];
    $pass = $_POST['pass'];

    if(Usuario::validar($dni,$pass)){
        $_SESSION['usuario'] = $dni;
        header('Location: '.$server_name.'www/Comun/Headers/redireccion.php');
    }else{
        header('Location: '.$server_name.'index.php');
    }

}else if(!empty($_GET['action'])){

    if($_GET['action']=='out'){
        session_destroy();
        header('Location: '.$server_name.'index.php');
    }
}else{
    header('Location: '.$server_name.'index.php');
}
?>