
$(document).on('ready',function(){

	$('.seleccion').on('click',function(){
		id = $(this).attr('value');
		$('#modalSeleccion'+id).modal('show');
	});

	$('.confirmar').on('click',function(){
		id = $(this).attr('value');

		var peticion = new Object({
			idConvocatoria: id,
			action: 'solicitarConvocatoria'
			});

		$.post("ctrlPeticion.php",peticion)
			.success(function(resp,estado,jqXHR){
				
				if(resp){
					console.log(resp);
					window.location = '../../main/mainAlumno.php';
				} else {
					console.log(resp);
				}

			})
			.error(function(){
				console.log("Error en la peticion");
			});
	});

});