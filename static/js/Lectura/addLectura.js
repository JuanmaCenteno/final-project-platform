
var idProyecto = '';
var nombreProyecto = '';

//Busqueda de proyectos
$('#buscarProyecto').on('keydown',function(){

	//Dejar en blanco
	$('#listaProyectos').empty();

	busqueda = $('#buscarProyecto').val();

	if(busqueda.length > 1){

		var proyecto = new Object({
			nombre: busqueda,
			action: 'buscarProyecto'
			});

		$.post("ctrlLecturas.php",proyecto)
			.success(function(resp,estado,jqXHR){

				resp = JSON.parse(resp);

				if(resp['estado']=='ok'){
					//Hay busqueda
					rellenarProyectos(resp['proyectos'],$('#listaProyectos'));
				} else {
					//Muestro que no hay resultados
					$('<div>')
						.html('No hay resultados para esa busqueda')
						.appendTo($('#listaProyectos'));
				}
			})
			.error(function(){
				console.log("Error en la peticion");
			});
	}
});

//Seleccionar el proyecto
$(document).on('click','a#seleccionarProyecto',function(){

	proyecto = $('a#seleccionarProyecto').attr('value');
	nombre = $('#'+proyecto).attr('name');
	$('#inputProyecto').remove();
	$('<div>')
		.addClass('well well-sm')
		.attr('id','seleccionado')
		.attr('value',proyecto)
		.html(nombre)
		.appendTo($('#proyectoSeleccionado'));

});

$('#btn-add').on('click',function(){

	var lectura = new Object({
		idProyecto: $('#seleccionado').attr('value'),
		fechaLectura: $('#inputFecha').attr('value'),
		idConvocatoria: $('#inputConvocatoria').attr('value'),
		hora: $('#inputHora').val(),
		aula: $('#inputAula').val(),
		action: 'addLectura'
		});

	//Crear lectura
	$.post("ctrlLecturas.php",lectura)
		.success(function(resp,estado,jqXHR){
			
			if(resp){
				console.log('resp');
				window.location='../detallarConvocatoria.php?id='+$('#inputConvocatoria').attr('value');
				
			} else {
				console.log(resp);
				window.location.reload();
			}

		})
		.error(function(){
			console.log("Error en la peticion");
		});

});