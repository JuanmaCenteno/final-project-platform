

<?php  
    $server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de solicitud</title>
    <?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>
    <div class="hueco"></div>
    <div class="hueco"></div>
    <div class="container containerEntregas">
        <div class="hueco"></div>
        <div class="row">
            <h4 class="col-md-7 col-md-offset-2 col-xs-12">Detalles de la solicitud</h4>
        </div>
        <div class="hueco"></div>
        <div class="hueco"></div>
        <div class="hueco"></div>
        <div class="row">
            <label class="col-md-2 col-md-offset-2 col-xs-3 control-label">Mensaje</label>
            <div class="col-md-6 col-xs-6">
                <p><?=$_GET['msj'];?></p>
            </div>
        </div>
        <div class="hueco"></div>
        <div class="hueco"></div>
        <div class="hueco"></div>
        <div class="row">
            <a type="button" href="../../../index.php" class="btn btn-success col-md-3 col-md-offset-2 col-xs-12">Inicio</a>
            <a type="button" href="#" onclick="history.back(-1)" class="btn btn-warning col-md-3 col-md-offset-2 col-xs-12">Realizar de nuevo</a>
        </div>
    </div>
</body>
</html>