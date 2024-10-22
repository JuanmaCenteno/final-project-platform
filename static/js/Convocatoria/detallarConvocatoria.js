
//Variables
var idconvocatoria = $('#idConvocatoria').attr('value'); 

//Modal de detalle de una lectura
$(document).on('click','#listaLecturas',function(){
	//Obtenemos el id
	idLectura = $(this).attr('value');
	$('#detallarLectura'+idLectura).modal('show');
});

//Añadir nueva lectura
$(document).on('click','#addLectura',function(){
	dia = $(this).attr('value');
	window.location = 'Lectura/addLectura.php?dia='+dia+'&&idC='+idconvocatoria;
});

//Borrar convocatoria
//Eliminar convocatoria
$('#eliminarConvocatoria').on('click',function(){
	$('#modalEliminarConvocatoria').modal('show');
});

//Confirmar eliminar lectura
$('#confirmarEliminacion').on('click',function(){
	var lectura = new Object({
		idConvocatoria: idconvocatoria,
		action: 'eliminar'
		});
	$('#modalEliminarConvocatoria').modal('hide');
	$.post("ctrlConvocatorias.php",lectura)
		.success(function(resp,estado,jqXHR){
			if(resp){
				console.log('Eliminacion correcta');
				window.location = 'adminConvocatorias.php';
			} else {
				console.log(resp);
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});
});