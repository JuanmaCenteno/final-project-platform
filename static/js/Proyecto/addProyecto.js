
var idProyecto = 0;

//Guardar un proyecto
$(document).on('click','#btn-add',function(){

	var proyecto = new Object({
		nombre: $('#inputNombre').val(),
		descripcion: $('#inputDescripcion').val(),
		palabras_clave: $('#inputPalabras_clave').val(),
		action: 'guardar'
		});

	//Crear Proyectos
	$.post("ctrlProyectos.php",proyecto)
		.success(function(resp,estado,jqXHR){
			console.log(resp);
			if(resp > 0){
				idProyecto = resp;
				$('#modalInfo .modal-body p').text('Proyecto creado correctamente');
			} else {
				$('#modalInfo .modal-body p').text('No se pudo crear el proyecto: ',resp);
			}
			$('#modalInfo').modal('show');
		})
		.error(function(){
			console.log("Error en la peticion");
		});

});

$(document).on('click','#btn-redir',function(){
	if(idProyecto > 0){
		window.location = 'detallarProyecto.php?id='+idProyecto;
	}else{
		$('#modalInfo .modal-body p').text('Su proyecto no fue creado');
		$('#modalInfo').modal('show');
	}
})