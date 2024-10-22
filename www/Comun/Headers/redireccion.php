<?php
session_start();

$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Usuario.php";

if(!empty($_SESSION['usuario'])){

    $rol = Usuario::getRolUsuario($_SESSION['usuario']);
    //Dependiendo del rol del usuario, creamos la clase que corresponda y la pasamos por la sesion
    switch ($rol) {
    	case 'Alumno':
    		header('Location: '.$server_name.'www/main/mainAlumno.php');
    		break;
    	case 'Profesor':
    		header('Location: '.$server_name.'www/main/mainProfesor.php');
    		break;
    	case 'Admin':
    		header('Location: '.$server_name.'www/main/mainAdmin.php');
    		break;
    	default:
    		header('Location: '.$server_name.'index.php');
    		break;
    }
}


?>