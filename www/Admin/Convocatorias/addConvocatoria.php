
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Usuario.php";


	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol()=='Admin'){
		
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Nueva convocatoria</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
	<script type="text/javascript" src="<?=$server_name;?>static/js/datepicker.js"></script>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>


	<section>
		
		<div class="container containerEntregas">
			<form class="form-horizontal">

				<!-- Formulario para crear una nueva convocatoria -->

				<div class="form-group">
					<label for="inputNombre" class="col-md-2 control-label">Nombre</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="inputNombre" name="Nombre" placeholder="Nombre de la convocatoria" required>
					</div>
				</div>

				<div class="form-group">
					<label for="from" class="col-md-2 control-label">Fecha de inicio</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="from" name="from" required>
					</div>
				</div>

				<div class="form-group">
					<label for="to" class="col-md-2 control-label">Fecha de fin</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="to" name="to" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-8 col-md-offset-2 control-label">
						<button id="btn-add" class="col-xs-12 col-md-4 btn btn-success">Crear convocatoria</button>
						<button id="btn-next" class="col-xs-12 col-md-4 btn btn-primary">Añadir proyectos a la convocatoria</button>
						<a href="javascript:history.back()"><button type="button" class="col-xs-12 col-md-4 btn btn-danger">Cancelar</button></a>
					</div>
				</div>
				
			</form>
		</div>

		<!-- Modal para confirmacion de creacion -->
		<div class="modal fade modalOk" tabindex="-1" role="dialog">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content modalOk-content">
		            <div class="modal-header modalOk-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Confirmación</h4>
		            </div>
		            <div class="modal-body modalOk-body">
		                <p>La convocatoria ha quedado guardada correctamente</p>
		            </div>
		            <div class="modal-footer modalOk-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
		            </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</section>

	<footer>
		
	</footer>

	<script type="application/javascript">

		$('#btn-add').on('click',function(){
			resp = enviarInfo('close');
		});

		$('#btn-next').on('click',function(){
			resp = enviarInfo('next');
		});

		function enviarInfo(msj){
			var convocatoria = new Object({
				nombre: $('#inputNombre').val(),
				from: $('#from').val(),
				to: $('#to').val(),
				action: 'guardar'
				});

			//Crear convocatoria
			$.post("ctrlConvocatorias.php",convocatoria)
				.success(function(resp,estado,jqXHR){

					resp = JSON.parse(resp);
					
					if(resp['estado']){
						console.log('Convocatoria guardada correctamente');

						//$('.modalOk').modal('show');

						if(msj === 'close'){
							window.location="adminConvocatorias.php";
						}else if(msj === 'next'){
							window.location="Lectura/detallarConvocatoria.php?id="+resp['id'];
						}
					} else {
						console.log(resp);
						return false;
					}

				})
				.error(function(){
					console.log("Error en la peticion");
					return false;
				}); 
		}

		$(function(){
			var dateFormat = "yy/mm/dd",
				from = $( "#from" )
					.datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						numberOfMonths: 1
					})
					.on( "change", function() {
						to.datepicker( "option", "minDate", getDate( this ) );
					}),
				to = $( "#to" ).datepicker({
					defaultDate: "+1w",
					changeMonth: true,
					numberOfMonths: 1
				})
				.on( "change", function() {
					from.datepicker( "option", "maxDate", getDate( this ) );
				});

			function getDate( element ) {
				var date;
				try {
					date = $.datepicker.parseDate( dateFormat, element.value );
				} catch( error ) {
					date = null;
				}

				return date;
			}
		});
	</script>
</body>
</html>

<?php
		}else{
			echo "Sesion incorrecta";
		}
	}else{
		//Redireccion porque el usuario no ha sido logeado y no tiene acceso
		//header("Location: '../../index.php'");
		echo "No ha iniciado sesion";
	}
?>
