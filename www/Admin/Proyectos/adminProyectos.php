
<?php
	//Comprobamos que la sesion iniciada es la correcta, y si lo es cargamos la pagina
	session_start();

	$server = $_SERVER['DOCUMENT_ROOT'] . "/tfg/";
	$server_name = 'http://'. $_SERVER['SERVER_NAME'] . '/tfg/';

	include_once $server . "Clases/Admin.php";
	include_once $server . "Clases/Proyecto.php";

	if(!empty($_SESSION['usuario'])){
		$admin = new Admin($_SESSION['usuario']);
		if($admin->getRol() == 'Admin'){
			$proyectos = Proyecto::getProyectos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<title>Gestion de usuarios</title>
	<?php include_once($server . "www/Comun/librerias.php") ?>
</head>
<body>

	<header>
		<?php include_once($server . "www/Comun/Headers/header_secundario.php") ?>
	</header>

	<!-- Seccion para mostrar la gestion de Proyectos-->
	<section>

		<div class="container">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-heading labelPanel">
		                <div class="modal-title row">
		                    <h4 class="col-md-8 col-xs-12">Proyectos abiertos</h4>
		                    <a href="addProyecto.php" type="button" class="btn btn-warning col-md-4 col-xs-12">
		                        <span class="glyphicon glyphicon-plus"></span> Añadir proyecto
		                    </a>
		                </div>
		            </div>
					<div class="panel-body">

						<!-- Buscador -->
						<div class="row">    
					        <div class="col-xs-12 col-md-10 col-md-offset-1">
							    <div class="input-group">
					                <div class="input-group-btn search-panel">
					                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					                    	<span id="search_concept">Nombre</span> <span class="caret"></span>
					                    </button>
					                    <ul class="dropdown-menu" role="menu">
											<li><a href="#">Descripción</a></li>
											<li><a href="#">Palabras clave</a></li>
											<li><a href="#">Nota</a></li>
					                    </ul>
					                </div>
					                <input type="hidden" name="search_param" value="all" id="search_param">         
					                <input type="text" class="form-control" id="inputBusqueda" placeholder="Buscar proyecto...">
					                <span class="input-group-btn">
					                    <button class="btn btn-success" type="button" id="buscar">
					                    	<span class="glyphicon glyphicon-search"></span>
					                    	Buscar
					                    </button>
					                </span>
					            </div>
					        </div>
						</div>

						<div id="listaBusqueda"></div>

						<!-- Lista de proyectos -->
						<div class="list-group" id="listaProyectos">
							<?php
									foreach ($proyectos as $proyecto) {
										$idproyecto = $proyecto->getID();
										$nombre = $proyecto->getNombre();
										$pc = $proyecto->getPalabrasClave();
								?>
									<a href="detallarProyecto.php?id=<?=$idproyecto;?>" class="cajaEntregas">
										<h4 class="list-group-item elemEntregas">
											<?=$nombre;?>
											<span class="badge">Palabras clave: <?=$pc;?></span>
										</h4>	
									</a>
								<?php
									}
								?>
						</div>
					</div>
					<div class="panel-footer" style="background-color:#D8D8D8;">
						<small>
							<span class="glyphicon glyphicon-info-sign"></span>
							Se muestran los 10 últimos proyectos abiertos, para acceder a otros, utilice el buscador.
						</small>
					</div>
				</div>
			</div>
		</div>
		
	</section>

	<footer>
		
	</footer>
 	<script type="text/javascript">

		$(document).ready(function(e){
	    	$('.search-panel .dropdown-menu').find('a').click(function(e) {
				e.preventDefault();
				var concept = $(this).text();
				$('.search-panel span#search_concept').text(concept);
			});

			$('#buscar').on('click',function(){
				busqueda = $('#inputBusqueda').val();
				tipo = $('.search-panel span#search_concept').text();

				console.log(busqueda);
				console.log(tipo);
				
				var proyecto = new Object({
					busqueda: busqueda,
					tipo: tipo,
					action: 'buscar'
					});

				$.post("ctrlProyectos.php",proyecto)
					.success(function(resp,estado,jqXHR){
						resp = JSON.parse(resp);
						if(resp['estado']=='ok'){
							rellenarLista(resp['proyectos'],$('#listaProyectos'));
						}else{
							console.log(resp);
						}
					})
					.error(function(){
						console.log("Error en la peticion");
					});
			});
	});

	function rellenarLista(lista,container){
		
		$.each(lista,function(lista,value){

		$('<a>')
			.attr('href','detallarProyecto.php?id='+value['id'])
			.addClass('cajaEntregas')
			.html(

				$('<h4>')
					.addClass('list-group-item elemEntregas')
					.html(value['nombre'])
					.append(

						$('<span>')
						.addClass('badge')
						.html('Palabras clave: '+value['palabras_clave'])
					)

			).appendTo(container);
	});
	}
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