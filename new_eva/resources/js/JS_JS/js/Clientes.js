list_data_table_server_side();

function show_cliente(id) {
	$.ajax({
		url: base_url + 'mantenimiento/Cclientes/show',
		type: 'POST',
		data: { id: id },
		success: function (data) {
			$('#modal_show_cliente .modal-body').html(data);
		},
	});
}
function delete_cliente(id) {
	var confirmacion = confirm('¿Estas seguro de Eliminar este registro?');
	if (confirmacion) {
		$.ajax({
			url: base_url + 'mantenimiento/Cclientes/delete',
			type: 'POST',
			data: {
				id: id,
			},
			success: function (data) {
				datatable_destroy();
				list_data_table_server_side();
				notify('del');
			},
		});
	} else {
		alert('Eliminación cancelada');
	}
}

function recover_modal_cliente(
	id,
	nombre,
	apellido,
	telefono,
	direccion,
	ruc,
	empresa
) {
	$('#update_id_cliente').val(id);
	$('#update_nombre_cliente').val(nombre);
	$('#update_apellido_cliente').val(apellido);
	$('#update_telefono_cliente').val(telefono);
	$('#update_direccion_cliente').val(direccion);
	$('#update_ruc_cliente').val(ruc);
	$('#update_empresa_cliente').val(empresa);
}
$('#btn_update_cliente').click(function () {
	var id = $('#update_id_cliente').val();
	var nombre = $('#update_nombre_cliente').val();
	var apellido = $('#update_apellido_cliente').val();
	var telefono = $('#update_telefono_cliente').val();
	var direccion = $('#update_direccion_cliente').val();
	var ruc = $('#update_ruc_cliente').val();
	var empresa = $('#update_empresa_cliente').val();
	$.ajax({
		url: base_url + 'mantenimiento/Cclientes/update',
		type: 'POST',
		data: {
			id: id,
			nombre: nombre,
			apellido: apellido,
			telefono: telefono,
			direccion: direccion,
			ruc: ruc,
			empresa: empresa,
		},
		success: function (data) {
			datatable_destroy();
			list_data_table_server_side();
			$('#modal_update_cliente .close').click();
			notify('edit');
			$('#add_id_cliente').val('');
			$('#add_nombre_cliente').val('');
			$('#add_apellido_cliente').val('');
			$('#add_telefono_cliente').val('');
			$('#add_direccion_cliente').val('');
			$('#add_ruc_cliente').val('');
			$('#add_empresa_cliente').val('');
		},
	});
});

$('#btn_add_cliente').click(function () {
	var validacion = '';
	if ($('#add_nombre_cliente').val() == '') {
		validacion = 1;
	}
	if (validacion == '') {
		$.ajax({
			url: base_url + 'mantenimiento/Cclientes/add',
			data: {
				nombre: $('#add_nombre_cliente').val(),
				apellido: $('#add_apellido_cliente').val(),
				telefono: $('#add_telefono_cliente').val(),
				direccion: $('#add_direccion_cliente').val(),
				ruc: $('#add_ruc_cliente').val(),
				empresa: $('#add_empresa_cliente').val(),
			},
			type: 'POST',
			success: function (data) {
				datatable_destroy();
				list_data_table_server_side();
				$('#modal_add_cliente .close').click();
				notify('add');
				$('#add_nombre_cliente').val('');
				$('#add_apellido_cliente').val('');
				$('#add_telefono_cliente').val('');
				$('#add_direccion_cliente').val('');
				$('#add_ruc_cliente').val('');
				$('#add_empresa_cliente').val('');
			},
		});
	}
});

function list_data_table_server_side() {
	var tabla = '';

	tabla = $('#tblClientes').dataTable({
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
			[5, 10, 20, -1],
			[5, 10, 20, 'todo'],
		],
		paging: true,
		filter: true,
		info: true,
		stateSave: true,
		bDestroy: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base_url + 'mantenimiento/Cclientes/get_server_side',
			type: 'POST',
			data: {},
		},
		columns: [
			{ data: 'id' },
			{ data: 'nombre' },
			{ data: 'telefono' },
			{ data: 'direccion' },
			{ data: 'ruc' },
			{ data: 'empresa' },
			{
				orderable: true,

				render: function (data, type, row) {
					return (
						'<div class="btn-group">' +
						'<button type="button" class="btn btn-default">Action</button>' +
						'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">' +
						'<span class="caret"></span>' +
						'<span class="sr-only">Toggle Dropdown</span>' +
						'</button>' +
						'<ul class="dropdown-menu"  role="menu">' +
						' <li>' +
						'<a href="#" class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#modal_update_cliente" onClick="recover_modal_cliente(' +
						row.id +
						",'" +
						row.nombre +
						"','" +
						row.apellido +
						"','" +
						row.telefono +
						"','" +
						row.direccion +
						"','" +
						row.ruc +
						"','" +
						row.empresa +
						'\');"> Editar</a>' +
						'<a href="#" class="glyphicon glyphicon-remove-sign  " onClick="delete_cliente(' +
						row.id +
						');" > Eliminar </a>' +
						'<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#modal_show_cliente"   onClick="show_cliente(' +
						row.id +
						')" > Examinar</a>' +
						'</li>' +
						' <li><a href="#">Something else here</a></li>' +
						'<li class="divider"></li>' +
						' <li><a href="#">Separated link</a></li>' +
						'</ul>' +
						' </div>'
					);
				},
			},
		],
		columnDefs: [
			{
				targets: [1],
				data: 'nombre',
				render: function (data, type, row) {
					return '<strong>' + data + '  ' + row.apellido + '</strong>';
				},
			},
		],
	});
}

function notify(action) {
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'Cliente agregado exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'Cliente editado exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'Cliente eliminado exitosamente';
		tipo = 'danger';
	}

	$.notify(
		{
			title: '<strong>MSJ:</strong> ',
			message: msj,
		},
		{
			type: tipo,
		}
	);
}
function datatable_destroy() {
	$('#tblClientes').dataTable().fnClearTable();
	$('#tblClientes').dataTable().fnDestroy();
}
