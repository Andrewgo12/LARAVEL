#!/usr/bin/node
if (controlador == 'Cinvimas') {
	list_invimas();
}
if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
	select_invimas();
}
function recover_modal_edit_invima(id) {
	$.ajax({
		url: base_url + 'equipo/Cinvimas/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		var registro_invima = JSON.parse(data);
		$('#modal_update_invima #id').val(registro_invima.id);
		$('#modal_update_invima #invima').val(registro_invima.invima);
		$('#modal_update_invima #description').val(registro_invima.description);
		$('#modal_update_invima #titulo').val(registro_invima.titulo);
		$('#modal_update_invima #marcas').val(registro_invima.marcas);
	});
}
$('#modal_update_invima .form_update_invima').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cinvimas/update',
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
			$('#modal_update_invima .close').click();

			list_invimas();
		} else {
			alert(respuesta.informacion_error);
		}
	});
});
$('#modal_add_invima .form_add_invima').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'equipo/Cinvimas/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			alert('Registro sanitario agregado exitosamente');
			$('#modal_add_invima .close').click();

			select_invimas();
			list_invimas();
		} else {
			alert(respuesta.informacion_error);
		}
	});
});
function list_invimas() {
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cinvimas/getWithNumberDevices',
		type: 'post',
		data: {},
	}).done(function (data) {
		var invimas = JSON.parse(data);
		$.each(invimas, function (i, item) {
			tmp += '<tr>';
			tmp +=
				"<td class='verde sangria800 centrar-horizontal'><span class='prueba'>" +
				item.invima +
				'</span></td>';
			tmp += "<td class='smallmsj'>" + item.description + '</td>';
			tmp += '<td>' + item.titulo + '</td>';
			tmp += '<td>' + item.marcas + '</td>';
			tmp += '<td>';
			if (item.file != '') {
				tmp +=
					'<a target="__blank" href="' +
					base_url +
					'assets/upload_registros_sanitarios/' +
					item.file +
					'" class="glyphicon glyphicon-file"></a>';
			} else {
				tmp +=
					'<span class="smallmsj sangria800">Sin archivo relacionado</span>';
			}
			tmp += '</td>';
			if (item.status != 1) {
				tmp += '<td><span class="sangria800 rojo">Inactivo</span></td>';
			} else {
				tmp += '<td><span class="sangria800 verde">Activo</span></td>';
			}
			tmp += '<td>';
			tmp +=
				'<a data-toggle="modal" data-target="#modal_update_invima"  class="glyphicon glyphicon-pencil item-edicion " onclick="recover_modal_edit_invima(' +
				item.id +
				')"></a>';
			if (item.status == 1) {
				tmp +=
					'<span class="glyphicon glyphicon-remove item-eliminacion" onclick="delete_invima(' +
					item.id +
					')"></span>';
			} else {
				tmp +=
					'<span class="glyphicon glyphicon-ok item-activacion" onclick="activate_invima(' +
					item.id +
					')"></span>';
			}
			tmp += '</td>';
			tmp +=
				"<td><a href='' data-toggle='modal' data-target='#modal_asociacion_invima' class='invima_multiple glyphicon glyphicon glyphicon-random' onclick='asociar_multiple_invima(" +
				item.id +
				",event)'></a><hr> <span class='smallmsj'>Asociado a un total de <a class='badge' onclick='consultar_equipos_invima(" +
				item.id +
				",event)' href='' data-toggle='modal' data-target='#modal_asociacion_invima_especifico'>" +
				item.cuenta +
				'</a> Equipos</span></td>';
			tmp += '</tr>';
		});
		$('.tabla_invimas').dataTable().fnClearTable();
		$('.tabla_invimas').dataTable().fnDestroy();
		$('.tabla_invimas tbody').html(tmp);
		$('.tabla_invimas').dataTable({
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
				[5, 10, 20],
				[5, 10, 20],
			],
		});
	});
}
function select_invimas() {
	$.ajax({
		url: base_url + 'equipo/Cinvimas/get',
		type: 'post',
		data: {},
	}).done(function (data) {
		var invimas = JSON.parse(data);
		var tmp = '';
		tmp += "<option title='' value=''>--------------</option>";
		$.each(invimas, function (i, item) {
			tmp +=
				`
				<option 

				title="` +
				item.description +
				`"
				value=` +
				item.id +
				`	
				>
				ID: ` +
				item.id +
				`_` +
				item.invima +
				`
				</option>
			`;

			//tmp+="<option title='"+item.description+"' value='"+item.id+"'>"+"ID:"+item.id+"|"+item.invima+"</option>";
		});
		// $("#modal_update_equipo #invima_id").html(tmp);
		$('#modal_copy #invima_id').html(tmp);
		$('#modal_add_equipo #invima_id').html(tmp);
		$('#modal_add_equipo #invima_id').select2();
		$('.invima_id').html(tmp);
	});
}
function delete_invima(id) {
	$.ajax({
		url: base_url + 'equipo/Cinvimas/delete',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		list_invimas();
	});
}
function activate_invima(id) {
	$.ajax({
		url: base_url + 'equipo/Cinvimas/activate',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		list_invimas();
	});
}
function funcion_cambio_select_update() {
	var invima_id = $('#modal_update_equipo #invima_id').val();
	$.ajax({
		url: base_url + 'equipo/Cinvimas/getOne',
		type: 'post',
		data: { id: invima_id },
	}).done(function (data) {
		var invima = JSON.parse(data);

		var anclor_file_registro_sanitario = '';
		anclor_file_registro_sanitario +=
			"<a class='glyphicon glyphicon-file' href='" +
			base_url +
			'assets/upload_registros_sanitarios/' +
			invima.file +
			"' target='__blank'></a>";
		$('#modal_update_equipo #form_update_equipo .file_registro_sanitario').html(
			anclor_file_registro_sanitario
		);
	});
}
function funcion_cambio_select_add() {
	var invima_id = $('#modal_add_equipo #invima_id').val();
	$.ajax({
		url: base_url + 'equipo/Cinvimas/getOne',
		type: 'post',
		data: { id: invima_id },
	}).done(function (data) {
		var invima = JSON.parse(data);

		var anclor_file_registro_sanitario = '';
		anclor_file_registro_sanitario +=
			"<a class='glyphicon glyphicon-file' href='" +
			base_url +
			'assets/upload_registros_sanitarios/' +
			invima.file +
			"' target='__blank'></a>";
		$('#modal_add_equipo .file_registro_sanitario').html(
			anclor_file_registro_sanitario
		);
	});
}
function funcion_cambio_select_copy() {
	var invima_id = $('#modal_copy #invima_id').val();
	$.ajax({
		url: base_url + 'equipo/Cinvimas/getOne',
		type: 'post',
		data: { id: invima_id },
	}).done(function (data) {
		var invima = JSON.parse(data);

		var anclor_file_registro_sanitario = '';
		anclor_file_registro_sanitario +=
			"<a class='glyphicon glyphicon-file' href='" +
			base_url +
			'assets/upload_registros_sanitarios/' +
			invima.file +
			"' target='__blank'></a>";
		$('#modal_copy .file_registro_sanitario').html(
			anclor_file_registro_sanitario
		);
	});
}
function show_consulta_invima(e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cinvimas/show',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_consulta_invima .modal-body').html(data);
		$('.datatable-invimas').dataTable();
	});
}
function asociar_registro(invima_id) {
	$.ajax({
		url: base_url + 'equipo/Cinvimas/getOne',
		type: 'post',
		data: { id: invima_id },
	}).done(function (data) {
		resultado = JSON.parse(data);

		var anclor_file_registro_sanitario = '';
		$('#modal_update_equipo #form_update_equipo #invima_id').val(resultado.id);
		$('#modal_update_equipo #form_update_equipo #invima_id').select2({
			placeholder: '' + resultado.invima + '',
		});
		if (resultado.file != null && resultado.file != '') {
			anclor_file_registro_sanitario = '';
			anclor_file_registro_sanitario +=
				"<a title='" +
				resultado.file +
				"' class='glyphicon glyphicon-file' href='" +
				base_url +
				'assets/upload_registros_sanitarios/' +
				resultado.file +
				"' target='__blank'></a>";
			$(
				'#modal_update_equipo #form_update_equipo .file_registro_sanitario'
			).html(anclor_file_registro_sanitario);
		} else {
			$(
				'#modal_update_equipo #form_update_equipo .file_registro_sanitario'
			).html('');
		}

		$('#modal_copy #invima_id').val(resultado.id);
		$('#modal_copy #invima_id').select2({
			placeholder: '' + resultado.invima + '',
		});
		if (resultado.file != null && resultado.file != '') {
			anclor_file_registro_sanitario = '';
			anclor_file_registro_sanitario +=
				"<a title='" +
				resultado.file +
				"' class='glyphicon glyphicon-file' href='" +
				base_url +
				'assets/upload_registros_sanitarios/' +
				resultado.file +
				"' target='__blank'></a>";
			$('#modal_copy .file_registro_sanitario').html(
				anclor_file_registro_sanitario
			);
		} else {
			$('#modal_copy .file_registro_sanitario').html('');
		}

		$('#modal_add_equipo #invima_id').val(resultado.id);
		$('#modal_add_equipo #invima_id').select2({
			placeholder: '' + resultado.invima + '',
		});
		if (resultado.file != null && resultado.file != '') {
			anclor_file_registro_sanitario = '';
			anclor_file_registro_sanitario +=
				"<a title='" +
				resultado.file +
				"' class='glyphicon glyphicon-file' href='" +
				base_url +
				'assets/upload_registros_sanitarios/' +
				resultado.file +
				"' target='__blank'></a>";
			$('#modal_add_equipo .file_registro_sanitario').html(
				anclor_file_registro_sanitario
			);
		} else {
			$('#modal_add_equipo .file_registro_sanitario').html('');
		}

		$('#modal_consulta_invima .close').click();
	});
}
function asociar_multiple_invima(invima_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cequipos/show_invima_asociaciones',
		type: 'post',
		data: { invima_id: invima_id },
	}).done(function (data) {
		$('#modal_asociacion_invima .modal-body').html(data);
		$('.invima-asociacion').dataTable();
	});
}
$('#modal_asociacion_invima .form_asociacion_invima_equipos').submit(function (
	e
) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cequipos/update_multiples_invimas',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_asociacion_invima .close').click();
		list_invimas();
		alert(data);
	});
});
$(
	'#modal_asociacion_invima_especifico .form_asociacion_invima_equipos_especifico'
).submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cequipos/update_multiples_invimas_eliminar',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_asociacion_invima_especifico .close').click();
		list_invimas();
		alert(data);
	});
});
function consultar_equipos_invima(invima_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cequipos/show_equipos_en_invima',
		type: 'post',
		data: { invima_id: invima_id },
	}).done(function (data) {
		$('#modal_asociacion_invima_especifico .modal-body').html(data);
		$('.invima-asociacion-especifico').dataTable();
	});
}
