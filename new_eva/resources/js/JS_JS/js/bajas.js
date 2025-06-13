list_bajas();

$('.form_baja').submit(function (e) {
	e.preventDefault();

	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'equipo/Cbajas/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		if (respuesta == 1) {
			$('#modal_add_baja .close').click();
			alert('El registro de baja ha sido registrado exitosamente');
			list_bajas();
		} else {
			alert('No se pudo completar el registro');
		}
	});
});

function list_bajas() {
	$.ajax({
		url: base_url + 'equipo/Cbajas/getWithNumberDevices',
		type: 'post',
		data: {},
	}).done(function (data) {
		bajas = JSON.parse(data);
		tmp = '';
		$.each(bajas, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.fecha_baja + '</td>';
			tmp += '<td>' + item.descripcion + '</td>';
			tmp +=
				"<td><a class='glyphicon glyphicon-file'  target='__blank' href='" +
				base_url +
				'assets/upload_bajas/' +
				item.archivo +
				"'></a></td>";
			tmp +=
				'<td><a data-toggle="modal" data-target="#modal_update_baja"  class="glyphicon glyphicon-pencil item-edicion " onclick="recover_modal_edit_baja(' +
				item.id +
				')"></a></td>';
			tmp +=
				"<td><a href='' data-toggle='modal' data-target='#modal_asociacion_baja' class='invima_multiple glyphicon glyphicon glyphicon-random' onclick='asociar_multiple_baja(" +
				item.id +
				",event)'></a><hr> <span class='smallmsj'>Asociado a un total de <a class='badge' onclick='consultar_equipos_baja(" +
				item.id +
				",event)' href='' data-toggle='modal' data-target='#modal_asociacion_baja_especifico'>" +
				item.cuenta +
				'</a> Equipos</span></td>';

			tmp += '</tr>';
		});
		$('.tabla-bajas').dataTable().fnClearTable();
		$('.tabla-bajas').dataTable().fnDestroy();
		$('.tabla-bajas tbody').html(tmp);
		$('.tabla-bajas').dataTable({
			language: {
				lengthMenu: 'Mostrar _MENU_ registros por pagina',
				zeroRecords: 'No se encontraron resultados en su busqueda',
				searchPlaceholder: 'Buscar registros',
				info: 'Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros',
				infoEmpty: 'No existen registros',
				infoFiltered: '',
				search: 'Buscar:',
				paginate: {
					first: 'Primero',
					last: 'Último',
					next: 'Siguiente',
					previous: 'Anterior',
				},
			},
			stateSave: true,
			dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
			lengthMenu: [
				[5, 10, -1],
				[5, 10, 'TODO'],
			],
		});
	});
}

function show_consulta_baja(e, equipo_id) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cbajas/show',
		type: 'post',
		data: { equipo_id: equipo_id },
	}).done(function (data) {
		$('#modal_consulta_baja .modal-body').html(data);
		$('.datatable-bajas').dataTable();
	});
}

function asociar_baja(baja_id, equipo_id) {
	var confirmar = confirm(
		'Desea vincular este registro de disposicion final al equipo?, tenga en cuenta que pasara a estado de baja'
	);
	if (confirmar) {
		$.ajax({
			url: base_url + 'equipo/Cbajas/asociar_baja',
			type: 'post',
			data: {
				equipo_id: equipo_id,
				baja_id: baja_id,
			},
		}).done(function (data) {
			$('#modal_consulta_baja .close').click();
			list_data_table_server_side_filtros();
		});
	}
}

function recover_modal_edit_baja(id) {
	$.ajax({
		url: base_url + 'equipo/Cbajas/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		var baja = JSON.parse(data);
		$('#modal_update_baja #id').val(baja.id);
		$('#modal_update_baja #fecha_baja').val(baja.fecha_baja);
		$('#modal_update_baja #descripcion').val(baja.descripcion);
	});
}

$('#modal_update_baja .form_update_baja').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cbajas/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			alert('Informacion actualizada exitosamente');
			$('#modal_update_baja .close').click();

			list_bajas();
		} else {
			alert(respuesta.informacion_error);
		}
	});
});

function asociar_multiple_baja(baja_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cbajas/show_baja_asociaciones',
		type: 'post',
		data: { baja_id: baja_id },
	}).done(function (data) {
		$('#modal_asociacion_baja .modal-body').html(data);
		$('.baja-asociacion').dataTable({
			lengthMenu: [
				[5, 10, -1],
				[5, 10, 'TODO'],
			],
		});
	});
}

$('#modal_asociacion_baja .form_asociacion_baja_equipos').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cbajas/update_multiples_bajas',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_asociacion_baja .close').click();
		list_bajas();
		alert(data);
	});
});

function consultar_equipos_baja(baja_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cbajas/show_equipos_en_baja',
		type: 'post',
		data: { baja_id: baja_id },
	}).done(function (data) {
		$('#modal_asociacion_baja_especifico .modal-body').html(data);
		$('.baja-asociacion-especifico').dataTable();
	});
}

$(
	'#modal_asociacion_baja_especifico .form_asociacion_baja_equipos_especifico'
).submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cbajas/update_multiples_bajas_eliminar',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_asociacion_baja_especifico .close').click();
		list_bajas();
		alert(data);
	});
});
