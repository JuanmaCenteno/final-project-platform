

function rellenaComentarios(lista,container,autor){

	$.each(lista,function(key,value){

		//Diferenciamos entre autores
		if(value['ROL_AUTOR'] === autor){

			var itemLi = $('<li>',{
				id:"elemento",
				class: "left clearfix"
			}).appendTo(container);

			var itemFotoSpan = $('<span>',{
				class: "chat-img pull-left"
			}).appendTo(itemLi);

		} else {

			var itemLi = $('<li>',{
				id:"elemento",
				class: "right clearfix"
			}).appendTo(container);

			var itemFotoSpan = $('<span>',{
				class: "chat-img pull-right"
			}).appendTo(itemLi);

		}

		if(value['FOTO'] == null){
			var foto = "http://placehold.it/50/55C1E7/fff&text=U";
		}else{
			var foto = value['FOTO'];
		}

		var itemFoto = $('<img>',{
			src: foto,
			class: "img-responsive img-rounded",
			alt: "User Avatar"
		}).appendTo(itemFotoSpan);

		var itemChat = $('<div>',{
			class: "chat-body clearfix"
		}).appendTo(itemLi);

		var itemHeader = $('<div>',{
			class: "header"
		}).appendTo(itemChat);

		if(value['ROL_AUTOR'] === autor){
			//Nombre
			var itemNombre = $('<strong>',{
				class: "primary-font"
			})
			.html(value['NOMBRE_AUTOR'])
			.appendTo(itemHeader);

			//Fecha
			var itemSmall = $('<small>',{
				class: "pull-right text-muted"
			}).appendTo(itemHeader);

			var itemFecha = $('<span>',{
				class: "glyphicon glyphicon-time"
			}).appendTo(itemSmall);

			var itemFechaSmall = $('<span>')
			.html(value['FECHA'])
			.appendTo(itemSmall);
		}else{
			//Fecha
			var itemSmall = $('<small>',{
				class: "text-muted"
			}).appendTo(itemHeader);

			var itemFecha = $('<span>',{
				class: "glyphicon glyphicon-time"
			}).appendTo(itemSmall);

			var itemFechaSmall = $('<span>')
			.html(value['FECHA'])
			.appendTo(itemSmall);

			//Nombre
			var itemNombre = $('<strong>',{
				class: "pull-right primary-font"
			})
			.html(value['NOMBRE_AUTOR'])
			.appendTo(itemHeader);
		}

		//Comentario
		var itemComent = $('<p>')
		.html(value['COMENTARIO'])
		.appendTo(itemChat);

	});
}