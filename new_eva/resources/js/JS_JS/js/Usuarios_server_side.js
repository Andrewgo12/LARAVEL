list_data_table_server_side_usuarios();

function list_data_table_server_side_usuarios() {
	var tabla = '';

	tabla = $('#tblUsuarios').dataTable({
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
			url: base_url + 'administrador/Cusuarios/get_server_side',
			type: 'POST',
			data: {},
		},
		columns: [
			{ data: 'nombre' },
			{ data: 'centro' },
			{ data: 'username' },
			{ data: 'rol' },
			{
				orderable: true,

				render: function (data, type, row) {
					return (
						'<div class="btn-group">' +
						'<button type="button" class="btn btn-warning">Opciones</button>' +
						'<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">' +
						'<span class="caret"></span>' +
						'<span class="sr-only">Toggle Dropdown</span>' +
						'</button>' +
						'<ul class="dropdown-menu"  role="menu">' +
						' <li>' +
						'<a href="#" class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#modal_update_usuario" onClick="recover_modal_usuario(' +
						row.id +
						');"> Editar</a>' +
						'<a href="#" class="glyphicon glyphicon-remove-sign  " onClick="delete_usuario(' +
						row.id +
						');" > Eliminar </a>' +
						'<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#modal_show_usuario"   onClick="show_usuario(' +
						row.id +
						')" > Examinar</a>' +
						'</li>' +
						'</ul>' +
						' </div>'
					);
				},
			},
		],
		columnDefs: [
			{
				targets: [0],
				data: 'nombre',
				render: function (data, type, row) {
					return '<strong>' + data + '  ' + row.apellido + '</strong>';
				},
			},
		],
	});
}
