$('.formulario_plan_preventivo').submit(function (e) {
	e.preventDefault();

	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'mantenimiento/Cplanes/ImportFromExcel',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		alert('EL CRONOGRAMA FUE INSERTADO EXITOSAMENTE');
		list_datatable_server_side();
		$('.formulario_plan_preventivo').trigger('reset');
	});
});

list_datatable_server_side();

function list_datatable_server_side() {
	url = base_url + 'mantenimiento/Cplanes/get_server_side';

	$('.tabla_planes').dataTable({
		language: {
			lengthMenu: 'Mostrar _MENU_ registros por pagina',
			zeroRecords: 'No se encontraron resultados en su busqueda',
			searchPlaceholder: 'Buscar registros',
			info: 'Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros',
			infoEmpty: 'No existen registros',
			infoFiltered: '(filtrado de un total de _MAX_ registros)',
			search: 'Buscar:',
			paginate: {
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior',
			},
		},
		lengthMenu: [
			[5, 10, 20],
			[5, 10, 20],
		],
		paging: true,
		filter: true,
		info: true,
		stateSave: true,
		bDestroy: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: url,
			type: 'POST',
			data: {
				anio: $('.seleccion_anio').val(),
			},
		},
		columns: [
			{ data: 'equipo_id' },
			{ data: 'equipo_id' },
			{ data: 'equipo' },
			{ data: 'code' },
			{ data: 'serial' },
			{ data: 'marca' },
			{ data: 'modelo' },
			{ data: 'responsable' },
			{ data: 'last_day_m1' },
			{ data: 'last_day_m2' },
			{ data: 'last_day_m3' },
			{ data: 'equipo_id' },
			{ data: 'cantidad_programados' },
			{ data: 'cumplimiento_global' },
			{
				orderable: true,
				render: function (data, type, row) {
					return '';
				},
			},
		],
		columnDefs: [
			{
				targets: [0],
				data: 'equipo_id',
				render: function (data, type, row) {
					var tmp = '';
					tmp +=
						`
				<ul class="list-inline">
					<li class="list-inline-item">
						<a data-toggle="modal" data-target="#modal_update_plan_mantenimiento" onclick="recover_modal_edit_plan(event,` +
						row.id +
						`)" title="Editar" href="" class="glyphicon glyphicon-pencil" style="color:#444444;"></a>
					</li>
`;
					if (row.cuenta_cambios > 0) {
						tmp +=
							`

					<li class="list-inline-item">
						<a data-toggle="modal" data-target="#modal_cambios" onclick="funcion_cambios_cronograma(event,` +
							row.id +
							`)" style="color:#dff0d8;" href="" class="glyphicon glyphicon-book" title="control de cambios"></a>
					</li>

						`;
					}
					tmp += `</ul>
				`;
					return tmp;
				},
			},
			{
				targets: [1],
				data: 'equipo_id',
				render: function (data, type, row) {
					return row.equipo_id;
				},
			},
			{
				targets: [8],
				data: 'equipo_id',
				render: function (data, type, row) {
					return row.first_day_m1 + '<strong> | </strong>' + row.last_day_m1;
				},
			},
			{
				targets: [9],
				data: 'equipo_id',
				render: function (data, type, row) {
					if (row.first_day_m2 != null) {
						return row.first_day_m2 + '<strong> | </strong>' + row.last_day_m2;
					} else {
						return 'N/A';
					}
				},
			},
			{
				targets: [10],
				data: 'equipo_id',
				render: function (data, type, row) {
					if (row.first_day_m3 != null) {
						return row.first_day_m3 + '<strong> | </strong>' + row.last_day_m3;
					} else {
						return 'N/A';
					}
				},
			},
			{
				targets: [11],
				data: 'equipo_id',
				render: function (data, type, row) {
					return row.cantidad_ejecutados;
				},
			},
		],
	});
}

function recover_modal_edit_plan(e, id) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'mantenimiento/Cplanes/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		respuesta = respuesta[0];
		$('.form_update_plan_mantenimiento').trigger('reset');
		$('#modal_update_plan_mantenimiento .id').val(respuesta.id);
		$('#modal_update_plan_mantenimiento .mes1').val(respuesta.mes1);
		$('#modal_update_plan_mantenimiento .mes2').val(respuesta.mes2);
		$('#modal_update_plan_mantenimiento .mes3').val(respuesta.mes3);
		$('#modal_update_plan_mantenimiento .responsable').val(
			respuesta.responsable
		);
	});
}

$('.form_update_plan_mantenimiento').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('.btn_update_plan_mantenimiento').attr('disabled', 'disabled');
	$.ajax({
		url: base_url + 'mantenimiento/Cplanes/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_update_plan_mantenimiento .close').click();
		list_datatable_server_side();
		$('.btn_update_plan_mantenimiento').removeAttr('disabled', 'disabled');
		alert('Registro editado exitosamente');
	});
});

function funcion_cambios_cronograma(e, id) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'mantenimiento/Cplanes/getCambios',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = '';

		$.each(respuesta, function (i, item) {
			tmp +=
				`
				<tr>
					<td>` +
				item.usuario +
				`</td>
					<td>` +
				item.cambio +
				`</td>
					<td>` +
				item.created_at +
				`</td>
				</tr>

			`;
		});
		$('#modal_cambios .tabla_control_cambios_cronograma tbody').html('');
		$('#modal_cambios .tabla_control_cambios_cronograma tbody').html(tmp);
	});
}

$('.seleccion_anio').on('change', function (e) {
	e.preventDefault();
	list_datatable_server_side();
});

listado_responsables();
function listado_responsables() {
	$.ajax({
		url: base_url + 'mantenimiento/Cplanes/getListadoResponsables',
		type: 'post',
		data: {},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = '';
		$.each(respuesta, function (i, item) {
			tmp +=
				`
				<option value="` +
				item.responsable +
				`">` +
				item.responsable +
				`</option>;

			`;
		});
		$('#modal_update_plan_mantenimiento .responsables').html(tmp);
	});
}
