
//Gestion del panel de confirmacion de asistencia a tribunales del profesor

//Variables
var idLectura = '';
var opcion = 'si';
var motivo = 'x';

//Gestion del modal de asistencia
$('.sinConfirmar').on('click',function(){
	idLectura = $(this).attr('value');
	nombreProyecto = $('#inputProyecto'+idLectura).html();
	idProyecto = $('#inputIDProyecto'+idLectura).attr('value');
	$('#modalProyecto').html(nombreProyecto);
	$('a#detallarProyecto').attr('href','../Comun/detallarProyecto.php?id='+idProyecto);
	$('#gestionAsistencia').modal('show');
});

//Control de label opciones
$('#opcSi').on('click',function(){
	$('#panelMotivo').css('display','none');
	opcion = 'si';
	motivo = 'x';
});
$('#opcNo').on('click',function(){
	$('#panelMotivo').css('display','block');
	opcion = 'no';
});

//Guardar respuestas del profesor
$(document).on('click','#guardarRespuesta',function(){

	if(opcion == 'no'){
		motivo = $('#inputMotivo').val();
	}

	var tribunal = new Object({
			dni: $('#idUsuario').attr('value'),
			idLectura: idLectura,
			asistencia: opcion,
			motivo: motivo,
			action: 'guardarRespuesta'
			});

		$.post("ctrlTribunal.php",tribunal)
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