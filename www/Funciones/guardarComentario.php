
<?php 
$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Comentario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/tfg/Clases/Notificacion.php";

if(
	!empty($_POST['COMENTARIO']) &&
	!empty($_POST['AUTOR']) &&
	!empty($_POST['ID_ENTREGA']) &&
	!empty($_POST['ID_PROYECTO']) &&
	!empty($_POST['NOMBRE_AUTOR']) &&
	!empty($_POST['ROL_AUTOR']) &&
	!empty($_POST['DESTINO']) &&
	!empty($_POST['FOTO'])
){
	//Me llega el mensaje
	$comentario = $_POST['COMENTARIO'];
	$autor = $_POST['AUTOR'];
	$id_entrega = $_POST['ID_ENTREGA'];
	$id_proyecto = $_POST['ID_PROYECTO'];
	$nombre_autor = $_POST['NOMBRE_AUTOR'];
	$rol_autor = $_POST['ROL_AUTOR'];
	$destino = $_POST['DESTINO'];
	$foto = $_POST['FOTO'];
	$fecha = date("Y-m-d H:i:s");

	//Guardo el comentario
	Comentario::crear($comentario,$autor,$id_entrega,$fecha);

	//Notificacion
	$badge = $nombre_autor;
	$destino = $destino;
	$mensaje = 'Comentario realizado';
	$ruta = $server_name.'www/Comun/detallarEntrega.php?idE='.$id_entrega.'&&idP='.$id_proyecto;
	Notificacion::crear($badge,$destino,$mensaje,$ruta);

	//Devuelvo un json como resultado para mostrarlo
	$res = array(
            'COMENTARIO'=>$comentario,
            'NOMBRE_AUTOR'=>$nombre_autor,
            'ROL_AUTOR'=>$rol_autor,
            'FECHA'=>$fecha,
            'ID_ENTREGA'=>$id_entrega,
            'FOTO'=>$foto
        );
	echo json_encode($res);

}else{
	echo "Error";
}


?>