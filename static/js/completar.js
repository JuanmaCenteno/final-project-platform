

/* Funcion que rellena las entregas de un proyecto */
function rellenarEntregas(listEnt,containerEnt){

	$.each(listEnt,function(key,value){

		$('<a>')
			.attr('href','../Comun/detallarEntrega.php?id='+value['ID'])
			.addClass('cajaEntregas')
			.html(

				$('<h4>')
					.addClass('list-group-item elemEntregas')
					.html(value['TITULO'])
					.append(

						$('<span>')
						.addClass('badge')
						.html(value['FECHA'])
					)

			).appendTo(containerEnt);

	});
}

/* Funcion que rellena los proyectos */
function rellenarProyectos(listProy,containerProy){
	
	$.each(listProy,function(key,value){

		$('<a>')
			.attr('id','seleccionarProyecto')
			.attr('value',value['id'])
			.addClass('cajaEntregas')
			.html(

				$('<h4>')
					.addClass('list-group-item elemEntregas')
					.attr('id',value['id'])
					.attr('name',value['nombre'])
					.html(value['nombre'])
					.append(

						$('<span>')
						.addClass('badge')
						.html('Palabras clave: '+value['palabras_clave'])
					)

			).appendTo(containerProy);
	});
}

/* Funcion que rellena las convocatorias */
function rellenarConvocatorias(listConv,containerConv){

	$.each(listConv,function(key,value){

		$('<a>')
			.attr('href','detallarConvocatoria.php?id='+value['ID'])
			.addClass('cajaEntregas')
			.html(

				$('<h4>')
					.addClass('list-group-item elemEntregas')
					.html(value['NOMBRE'])
					.append(

						$('<span>')
						.addClass('badge')
						.html(value['FECHA_INICIO']+' hasta '+value['FECHA_FIN'])
					)

			).appendTo(containerConv);
	});
}

/* Funcion que rellena los usuarios en el panel de admin */
function rellenarUsuarios(lista,container,id){
	
	$.each(lista,function(key,value){

		$('<li>')
			.addClass('media')
			.attr('value',value['dni'])
			.attr('id',id)
			.append(
				$('<a>')
					.addClass('cajaEntregas')
					.append(
						$('<div>')
							.addClass('list-group-item elemEntregas')
							.append(
									$('<div>')
										.addClass('media-left pull-left img-user-admin')
										.append(
												$('<img>')
													.addClass('img-responsive img-rounded')
													.attr('src',value['foto'])
													.attr('alt','Foto usuario')
											)
									)
							.append(
									$('<div>')
										.addClass('media-body')
										.append(
											$('<h4>')
												.addClass('media-heading')
												.html(value['nombre']+' '+value['apellidos'])
											)
										.append(value['rol'])
								)
						)
				).appendTo(container);

	});
}