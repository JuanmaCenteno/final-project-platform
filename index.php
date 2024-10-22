<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/bootstrap-theme.min.css">
    <link href="static/css/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="static/js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="static/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>
    <div class="container-full">
        <form class="form-signin" action="www/Comun/ctrlAcceso.php" method="post">
            <h2 class="form-signin-heading">Inicie Sesión: </h2>
            <br>
            <label for="inputEmail" class="sr-only">DNI</label>
            <input type="text" name="dni" id="inputText" class="form-control" placeholder="DNI" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Contraseña</label>
            <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Contraseña" required="">
            <br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            <a type="button" class="btn btn-lg btn-warning btn-block" href="www/Alumno/Solicitud/solicitar.php">Solicitar Proyecto</a>
        </form>      
    </div>


</body>
</html>