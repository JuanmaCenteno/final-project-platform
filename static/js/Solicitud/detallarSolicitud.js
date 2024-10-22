var idProyecto = 0;

/* Genera los usuarios */
$('#btn-usuario').on('click',function(){
	$('#modalUsuarios').modal('show');
});

$('#confirmarUsuarios').on('click',function(){

	var user = new Object({
		alumno: $('#inputAlumno').html(),
		email: $('#inputEmail').html(),
		dni: $('#inputDNI').html(),
		rol: 'Alumno',
		action: 'guardarAlumnos'
		});

	//Crear usuarios
	$.post("../Usuarios/ctrlUsuarios.php",user)
		.success(function(resp,estado,jqXHR){
			console.log(resp);
			if(resp){
				window.location.reload();
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});

});

/* Valida y genera el proyecto */
$('#btn-validar').on('click',function(){
	$('#modalProyecto').modal('show');
});

$('#confirmarProyecto').on('click',function(){

	$('#modalProyecto').modal('hide');

	var proyecto = new Object({
		nombre: $('#inputProyecto').html(),
		descripcion: $('#inputDescripcion').html(),
		alumno: $('#inputDNIAlumno').html(),
		tutor: $('#inputDNITutores').html(),
		palabras_clave: $('#inputPalabrasClave').html(),
		action: 'guardar'
		});

	console.log(proyecto);

	$.post("../Proyectos/ctrlProyectos.php",proyecto)
		.success(function(resp,estado,jqXHR){
			console.log(resp);
			if(resp > 0){
				idProyecto = resp;
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});

	var solicitud = new Object({
		id: $('#inputID').attr('value'),
		action: 'aceptar'
	});

	$.post("ctrlSolicitudes.php",solicitud)
		.success(function(resp,estado,jqXHR){
			if(resp){
				window.location = '../Proyectos/detallarProyecto.php?id='+idProyecto;
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});
});

/* Eliminar una solicitud */
$('#btn-eliminar').on('click',function(){
	$('#modalEliminar').modal('show');
});

$('#confirmarEliminacion').on('click',function(){

	var solicitud = new Object({
		id: $('#inputID').attr('value'),
		action: 'eliminar'
	});

	$('#modalEliminar').modal('hide');

	$.post("ctrlSolicitudes.php",solicitud)
		.success(function(resp,estado,jqXHR){
			if(resp){
				window.location = 'adminSolicitudes.php';
			}
		})
		.error(function(){
			console.log("Error en la peticion");
		});
});

