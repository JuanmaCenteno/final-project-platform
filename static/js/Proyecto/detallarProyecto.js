
//Cambiar datos
$(document).ready(function(){

	//Eliminacion del proyecto
	$('#confirmarEliminacion').on('click',function(){
		$('#modalEliminacion').modal('show');
	})

	$('#eliminarProyecto').on('click',function(){

		var proyecto = new Object({
			id: $('#idProyecto').attr('value'),
			action: 'eliminar'
			});

		$.post("ctrlProyectos.php",proyecto)
			.success(function(resp,estado,jqXHR){
				
				if(resp){
					console.log('Proyecto borrado correctamente');
					window.location = 'adminProyectos.php';
				} else {
					console.log(resp);
				}

			})
			.error(function(){
				console.log("Error en la peticion");
			});

	});

	//Actualizar proyecto
	$('#cambiarDatos').on('click',function(){
		$('#modalDatos').modal('show');
	});

	$('#confirmarDatos').on('click',function(){
		var profesores = [];

		$('#listaP li').each(function(i, e) {
	  		profesores.push($(e).attr('value'));
		});

		var alumnos = [];

		$('#listaA li').each(function(i, e) {
	  		alumnos.push($(e).attr('value'));
		});

		//Creamos el objeto para actualizar el proyecto

		var proyecto = new Object({
				nombre: $('#nuevoNombre').val(),
				descripcion: $('#nuevaDescripcion').val(),
				idProyecto: $('#idProyecto').attr('value'),
				profesores: profesores,
				alumnos: alumnos,
				nota_final:$('#nuevaNota').val(),
				palabras_clave:$('#nuevasPalabras').val(),
				action: 'actualizarProyecto'
				});
		
		$.post("ctrlProyectos.php",proyecto)
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

	//Busqueda de usuarios
	$('#buscarProfe').on('click',function(){
		busqueda = $('#busquedaProfe').val();
		Buscar(busqueda,'Profesor');
		
	});
	$('#buscarAlumno').on('click',function(){
		busqueda = $('#busquedaAlumno').val();
		Buscar(busqueda,'Alumno');
	});

	function Buscar(busqueda,rol){

		$('#lista'+rol).empty();

		if(busqueda.length > 0){

			var usuario = new Object({
				nombre: busqueda,
				idProyecto: $('#idProyecto').attr('value'),
				rol: rol,
				action: 'buscarUsuario'
				});

			$.post("ctrlProyectos.php",usuario)
				.success(function(resp,estado,jqXHR){

					resp = JSON.parse(resp);

					if(resp['estado']=='ok'){
						//Hay busqueda
						rellenarUsuarios(resp['usuarios'],$('#lista'+rol),'seleccionar'+rol);
					} else {
						//Muestro que no hay resultados
						$('<div>')
							.html('No hay resultados para esa busqueda')
							.appendTo($('#lista'+rol));
					}
				})
				.error(function(){
					console.log("Error en la peticion");
				});
		}
	}

	//Seleccion de usuarios
	$(document).on('click','li#seleccionarProfesor',function(){
		dni = $('#seleccionarProfesor').attr('value');
		boton = dni+'<div class="media-right pull-right"><button type="button" class="btn btn-danger eliminar" value="'+dni+'" name="Profesor"><span class="glyphicon glyphicon-remove"></span>Quitar</button></div>';

		var usuario = [{
			dni: $('#seleccionarProfesor').attr('value'),
			foto: $('#seleccionarProfesor a div div img').attr('src'),
			nombre: $('#seleccionarProfesor a div div h4').html(),
			apellidos: '',
			rol: boton
			}];
		rellenarUsuarios(usuario,$('#listaP'),'');
		$('#listaProfesor').empty();	
	});

	$(document).on('click','li#seleccionarAlumno',function(){
		dni = $('#seleccionarAlumno').attr('value');
		boton = dni+'<div class="media-right pull-right"><button type="button" class="btn btn-danger eliminar" value="'+dni+'" name="Alumno"><span class="glyphicon glyphicon-remove"></span>Quitar</button></div>';

		var usuario = [{
			dni: $('#seleccionarAlumno').attr('value'),
			foto: $('#seleccionarAlumno a div div img').attr('src'),
			nombre: $('#seleccionarAlumno a div div h4').html(),
			apellidos: '',
			rol: boton
			}];
		rellenarUsuarios(usuario,$('#listaA'),'');
		$('#listaAlumno').empty();
	});
		
	//Eliminar Usuario
	$(document).on('click','.eliminar',function(){
		dni = $(this).attr('value');
		$('li[value='+dni+']').remove();
	});

});
