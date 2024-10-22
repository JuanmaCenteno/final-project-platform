
//Tribunal

//Variables
var idLectura = $('#idLectura').attr('value');
var idProyecto = $('#idProyecto').attr('value');
var idConvocatoria = $('#idConvocatoria').attr('value');

//Modal para eliminacion de tribunales
$('.eliminarTribunal').on('click',function(){
	dni = $(this).attr('value');

	$('#eliminar'+dni).modal('show');
});

//Eliminar tribunal
$('.confirmar').on('click',function(){
	dni = $(this).attr('value');
	var tribunal = new Object({
		idLectura: idLectura,
		dniTribunal: dni,
		action: 'eliminarTribunal'
		});
	$('#eliminar'+dni).modal('hide');
	$.post("ctrlLecturas.php",tribunal)
		.success(function(resp,estado,jqXHR){
			if(resp){
				console.log(resp);
				window.location.reload();
			} else {
				console.log(resp);
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});
});

var dni = '';

//Añadir tribunal
$('.addTribunal').on('click',function(){
	//Rellenar modal
	dni = $(this).attr('value');
	nombre = $(this).attr('name');
	$('#nombreProfesor').html('Se asignará como tribunal a '+nombre);
	$('#detallarTribunal').modal('show');
});

//Seleccionar un nuevo tribunal
$(document).on('click','#guardarTribunal',function(){

	var tribunal = new Object({
			dni: dni,
			idlectura: idLectura,
			rol: $('#inputRol').val(),
			action: 'addTribunal'
			});

		$.post("ctrlLecturas.php",tribunal)
			.success(function(resp,estado,jqXHR){
				if(resp == 1){
					window.location.reload();
				}else{
					console.log(resp);
				}
			})
			.error(function(){
				console.log("Error en la peticion");
			});

});

//Lectura

//Eliminar lectura
$('#eliminarLectura').on('click',function(){
	$('#modalEliminarLectura').modal('show');
});

//Confirmar eliminar lectura
$('#confirmarEliminacion').on('click',function(){
	var lectura = new Object({
		idLectura: idLectura,
		action: 'eliminarLectura'
		});
	$('#modalEliminarLectura').modal('hide');
	$.post("ctrlLecturas.php",lectura)
		.success(function(resp,estado,jqXHR){
			if(resp){
				console.log('Eliminacion correcta');
				window.location = '../detallarConvocatoria.php?id='+idConvocatoria;
			} else {
				console.log(resp);
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});
});
