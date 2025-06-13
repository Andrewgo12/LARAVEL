list_data_table_server_side();

function show_categoria(id) {
	$.ajax({
		url: base_url + 'mantenimiento/Ccategorias/show',
		type: 'POST',
		data: { id: id },
		success: function (data) {
			$('#modal_show_categoria .modal-body').html(data);
		},
	});
}

$('#btn_add_categoria').click(function () {
	$.ajax({
		url: base_url + 'mantenimiento/Ccategorias/add',
		data: {
			nombre: $('#add_nombre_categoria').val(),
			descripcion: $('#add_descripcion_categoria').val(),
		},
		type: 'POST',
		success: function (data) {
			if (data == 1) {
				datatable_destroy();
				list_data_table_server_side();
				$('#modal_add_categoria .close').click();
				notify('add');
				$('#add_id_categoria').val('');
				$('#add_nombre_categoria').val('');
				$('#add_descripcion_categoria').val('');
				$('#modal_add_categoria .errores').html('');
			} else {
				var valor = JSON.parse(data);
				$('#modal_add_categoria .errores').html('');

				$.each(valor, function (i, item) {
					$('#modal_add_categoria .errores').append(item + '<br>');
				});
			}
		},
	});
});

function recover_modal_categoria(id, nombre, descripcion) {
	$('#update_id_categoria').val(id);
	$('#update_nombre_categoria').val(nombre);
	$('#update_descripcion_categoria').val(descripcion);
}
$('#btn_update_categoria').click(function () {
	$.ajax({
		url: base_url + 'mantenimiento/Ccategorias/update',
		type: 'POST',
		data: {
			id: $('#update_id_categoria').val(),
			nombre: $('#update_nombre_categoria').val(),
			descripcion: $('#update_descripcion_categoria').val(),
		},
		success: function (data) {
			if (data == 1) {
				datatable_destroy();
				list_data_table_server_side();
				$('#modal_update_categoria .close').click();
				notify('edit');
				$('#add_id_categoria').val('');
				$('#add_nombre_categoria').val('');
				$('#add_descripcion_categoria').val('');
			} else {
				var valor = JSON.parse(data);
				$('#modal_update_categoria .errores').html('');

				$.each(valor, function (i, item) {
					$('#modal_update_categoria .errores').append(item + '<br>');
				});
			}
		},
	});
});

function delete_categoria(id) {
	var confirmacion = confirm('¿Estas seguro de Eliminar este registro?');
	if (confirmacion) {
		$.ajax({
			url: base_url + 'mantenimiento/Ccategorias/delete',
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

function list() {
	$.ajax({
		url: base_url + 'mantenimiento/Ccategorias/get',
		type: 'POST',
		data: { valor: 1 },
		success: function (data) {
			var categorias = JSON.parse(data);
			$.each(categorias, function (i, item) {
				$('#tblCategorias').append(
					'<tr>' +
						'<td>' +
						item.id +
						'</td>' +
						'<td>' +
						item.nombre +
						'</td>' +
						'<td>' +
						item.descripcion +
						'</td>' +
						'<td>' +
						"<div class='btn-group'>" +
						"<a href='#' class='btn btn-info fa fa-eye'></a>" +
						"<a href='#' class='btn btn-warning fa fa-pencil'></a>" +
						"<a href='#' class='btn btn-danger fa fa-remove'></a>" +
						'</div>' +
						'</td>' +
						'</tr>'
				);
			});
		},
	});
}

function list_data_table() {
	var tabla = '';

	tabla = $('#tblCategorias').DataTable({
		lengthMenu: [
			[5, 10, 20, -1],
			[5, 10, 20, 'Todo'],
		],
		paging: true,
		info: true,
		filter: true,
		stateSave: true,
		bDestroy: true,
		ajax: {
			url: base_url + 'mantenimiento/Ccategorias/get',
			type: 'POST',
			dataSrc: '',
		},
		columns: [
			{ data: 'id' },
			{ data: 'nombre' },
			{ data: 'descripcion' },
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
						' <li><a href="#" class="glyphicon glyphicon-edit btn btn-lg" > Editar</a></li>' +
						' <li><a href="#" class="glyphicon glyphicon-remove-sign btn btn-lg"> Eliminar</a></li>' +
						' <li><a href="#">Something else here</a></li>' +
						'<li class="divider"></li>' +
						' <li><a href="#">Separated link</a></li>' +
						'</ul>' +
						' </div>'
					);
				},
			},
		],
	});
}

function list_data_table_server_side() {
	var tabla = '';
	var leer = $('#test').val();
	tabla = $('#tblCategorias').dataTable({
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
			url: base_url + 'mantenimiento/Ccategorias/get_server_side',
			type: 'POST',
			data: { Snombre: $('#Snombre').val() },
		},
		columns: [
			{ data: 'id' },
			{ data: 'nombre' },
			{ data: 'descripcion' },
			{
				orderable: true,

				render: function (data, type, row) {
					var mensaje = '';

					mensaje += '<div class="btn-group">';

					mensaje +=
						'<button type="button" class="btn btn-default">Action</button>';
					mensaje +=
						'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">';
					mensaje += '<span class="caret"></span>';
					mensaje += '<span class="sr-only">Toggle Dropdown</span>';
					mensaje += '</button>';
					mensaje += '<ul class="dropdown-menu"  role="menu">';
					mensaje += ' <li>';
					if (!($('#permiso_update').val() == 0)) {
						mensaje +=
							'<a href="#" class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#modal_update_categoria" onClick="recover_modal_categoria(' +
							row.id +
							",'" +
							row.nombre +
							"','" +
							row.descripcion +
							'\');"> Editar</a>';
					}
					if (!($('#permiso_delete').val() == 0)) {
						mensaje +=
							'<a href="#" class="glyphicon glyphicon-remove-sign  " onClick="delete_categoria(' +
							row.id +
							');" > Eliminar </a>';
					}
					mensaje +=
						'<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#modal_show_categoria"   onClick="show_categoria(' +
						row.id +
						')" > Examinar</a>';
					mensaje += '</li>';
					mensaje += ' <li><a href="#">Something else here</a></li>';
					mensaje += '<li class="divider"></li>';
					mensaje += ' <li><a href="#">Separated link</a></li>';
					mensaje += '</ul>';
					mensaje += ' </div>';
					return mensaje;
				},
			},
		],
	});
}

function datatable_destroy() {
	$('#tblCategorias').dataTable().fnClearTable();
	$('#tblCategorias').dataTable().fnDestroy();
}

function Snombre() {
	datatable_destroy();
	list_data_table_server_side($('Snombre').val());
}

function notify(action = '') {
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'Categoria agregada exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'Categoria editada exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'Categoria eliminada exitosamente';
		tipo = 'danger';
	}

	$.notify(
		{
			title: '<strong>MSJ:</strong> ',
			message: msj,
		},
		{
			type: tipo,
			placement: {
				from: 'top',
				align: 'left',
			},
		}
	);
}

$('.btn-print').click(function () {
	$('.impresion').print({
		title: 'Categorias',
	});
});
