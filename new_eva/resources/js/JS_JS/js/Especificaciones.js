if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
	list_especificaciones();
}
function list_especificaciones() {
	var especificaciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEspecificaciones',
		type: 'post',
		data: {},
	}).done(function (data) {
		especificaciones = JSON.parse(data);
		tmp = "<option value=''>---------</option>";
		$.each(especificaciones, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.name + '</option>';
		});
		$('#especificacion_id').html(tmp);
		$('.especificacion_id').html(tmp);
	});
}
function list_equipo_especificaciones(id) {
	var equipo_especificacion = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEquipoEspecificaciones',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		equipo_especificacion = JSON.parse(data);
		$.each(equipo_especificacion, function (i, item) {
			tmp += '<tr>';
			// tmp+="<td>"+item.id+"</td>";
			tmp += "<td style='width: 15%;'>" + item.especificacion + '</td>';
			tmp += '<td>' + item.valor + '</td>';
			tmp += '</tr>';
		});
		$('#contenedor_detalle_equipo .tblEquipo_especificaciones tbody').html(tmp);
	});
}
function list_equipo_especificaciones2(id) {
	var equipo_especificacion = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEquipoEspecificaciones',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		equipo_especificacion = JSON.parse(data);
		$.each(equipo_especificacion, function (i, item) {
			tmp += '<tr>';
			// tmp+="<td>"+item.id+"</td>";
			tmp += "<td style='width: 15%;'>" + item.especificacion + '</td>';
			if (item.especificacion_id == 12) {
				tmp +=
					`<td>
					<a class="fa fa-paperclip" style="color: #222d32;font-size:15px;font-weight:900;" onclick="window.open(this.href, 'mywin',
					'left=20,top=20,width=600,height=600,toolbar=1,resizable=0'); return false;" href="` +
					base_url +
					`assets/upload_archivos/` +
					item.file +
					`"></a>
				</td>`;
			} else {
				tmp += '<td>' + item.valor + '</td>';
			}
			tmp +=
				"<td style='width: 10%;' class='esconder'>" +
				"<a onClick='delete_equipo_especificacion(" +
				item.id +
				',' +
				item.equipo_id +
				")' class='btn btn-danger glyphicon glyphicon-minus' style='padding:5px;'></a>" +
				'</td>';
			tmp += '</tr>';
		});
		$('#form_update_equipo .tblEquipo_especificaciones tbody').html(tmp);
	});
}
$('#form_equipo_especificacion').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#btn_add_equipo_especificacion').attr('disabled', 'disabled');
	$('.mensaje').addClass(
		'glyphicon glyphicon-refresh glyphicon-refresh-animate'
	);
	$('.mensaje').html('Procesando..........');
	$.ajax({
		url: base_url + 'equipo/Cequipos/addEquipoEspecificacion',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		// $("#form_equipo_especificacion #equipo_id").val("");
		$('#form_equipo_especificacion #valor').val('');
		list_equipo_especificaciones(JSON.parse(data));
		list_equipo_especificaciones2(JSON.parse(data));
		$('#modal_add_equipo_especificacion .close').click();
		$('.mensaje').html('');
		$('.mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#btn_add_equipo_especificacion').removeAttr('disabled');
	});
});
function delete_equipo_especificacion(id, equipo_id) {
	$.ajax({
		url: base_url + 'equipo/Cequipos/deleteEquipoEspecificacion',
		type: 'post',
		data: {
			id: id,
			equipo_id: equipo_id,
		},
	}).done(function (data) {
		list_equipo_especificaciones(equipo_id);
		list_equipo_especificaciones2(equipo_id);
	});
}
$('#multiple_especificaciones').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'equipo/Cequipos/addMultipleEspecificaciones',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		datatable_destroy();
		//list_data_table_server_side();
		list_data_table_server_side_filtros();
		$('#modal_multiple .close').click();
		$('#modal_multiple input').html('');
		notify('add_especificacion');
	});
});
function funcion_modal_compartir_especificaciones(e) {
	e.preventDefault();

	$.ajax({
		url: base_url + 'equipo/Cequipos/show_compartir_especificaciones',
		type: 'post',
		data: { equipo_origen_id: $('#modal_update_equipo #id').val() }, //Se manda el ID del equipo origen
	}).done(function (data) {
		$('#modal_compartir_especificaciones .modal-body').html(data);
		$('#modal_compartir_especificaciones .tbl-listado-equipos').dataTable();
	});
}
$('#modal_compartir_especificaciones .form_compartir_especificaciones').submit(
	function (e) {
		e.preventDefault();
		var formulario = new FormData(this);

		$.ajax({
			url: base_url + 'equipo/Cequipos/update_especificaciones_tecnicas',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			/*
    $("#modal_compartir_especificaciones .close").click();	
    //list_invimas();
    alert(data);
    */

			alert(data);
		});
	}
);
function funcion_creacion_input_especificaciones_tecnicas(data) {
	var tmp = '';
	if (
		$(
			'.form_compartir_especificaciones .tbl-listado-equipos .registro_' + data
		).is(':checked')
	) {
		tmp +=
			`
				<input type="hidden" class="creado_` +
			data +
			`" name="creado[]" value="` +
			data +
			`">
			`;
		$('.form_compartir_especificaciones .contenedor_creado').append(tmp);
	} else {
		$('.form_compartir_especificaciones .creado_' + data + '').remove();
	}
}
