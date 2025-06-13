if (controlador == 'Ccontactos') {
	list_data_table_contacto();
	// $(".select2").select2();
	list_tcontactos();
}
if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
	list_contactos();
	list_contactos_proveedores();
}
if (controlador == 'Cordenes_compra') {
	list_contactos_proveedores();
}
if (controlador == 'Cordenes') {
	list_contactos();
}
function list_data_table_contacto() {
	var tabla = '';

	tabla = $('#tblContactos').DataTable({
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
			[5, 10, 20, 'Todo'],
		],
		paging: true,
		info: true,
		filter: true,
		stateSave: true,
		bDestroy: true,
		ajax: {
			url: base_url + 'contacto/Ccontactos/get_datatable',
			type: 'POST',
			dataSrc: '',
		},
		columns: [
			{ data: 'name' },
			{ data: 'email' },
			{ data: 'telefono' },
			{ data: 'tcontacto' },
			{
				orderable: true,
				render: function (data, type, row) {
					var tmp = '';
					tmp +=
						'&nbsp;<a style="padding:5px" href="#" class=" btn btn-primary glyphicon glyphicon-pencil"  onClick="recover_modal_edit_contacto(' +
						row.id +
						',event)" ></a>';
					tmp +=
						'&nbsp;<a style="padding:5px" href="#" class=" btn btn-danger fa fa-minus-circle"  onClick="delete_contacto(' +
						row.id +
						',event)" ></a>';

					return tmp;
				},
			},
		],
	});
}
function datatable_destroy_contacto() {

	$('#tblContactos').dataTable().fnClearTable();
	$('#tblContactos').dataTable().fnDestroy();
}
function list_contactos() {
	var contactos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'contacto/Ccontactos/get',
		type: 'post',
		data: {},
	}).done(function (data) {
		contactos = JSON.parse(data);
		tmp = "<option value=''>---------</option>";
		$.each(contactos, function (i, item) {
			tmp +=
				'<option value=' +
				item.id +
				'>' +
				item.name +
				'-' +
				item.tcontacto +
				'</option>';
		});
		$('#contacto_id').html(tmp);
	});
}
function list_contactos_proveedores() {
	var contactos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'contacto/Ccontactos/getProveedores',
		type: 'post',
		data: {},
	}).done(function (data) {
		contactos = JSON.parse(data);
		tmp = "<option value=''>---------</option>";
		$.each(contactos, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.name + '</option>';
		});
		$('#modal_add_orden_compra #proveedor_id').html(tmp);
		$('#modal_update_orden_compra #proveedor_id').html(tmp);
	});
}
function list_tcontactos() {
	$.ajax({
		url: base_url + 'contacto/Ccontactos/getTcontactos',
		type: 'POST',
		data: {},
	}).done(function (data) {
		var tcontactos = '';
		var tmp = '';
		tcontactos = JSON.parse(data);
		tmp += "<option value=''>-----------</option>";
		$.each(tcontactos, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.description + '</option>';
		});
		$('#form_contacto #tcontacto_id').html(tmp);
		$('.contenedor_formulario_contacto .auxiliar_tcontacto').html(tmp);
	});
}
function recover_modal_edit_contacto(id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'contacto/Ccontactos/getOne',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		$('#btn_update_contacto').removeAttr('disabled');
		var contacto = '';
		contacto = JSON.parse(data);
		$('#form_contacto #id').val(contacto.id);
		$('#form_contacto #name').val(contacto.name);
		$('#form_contacto #email').val(contacto.email);
		$('#form_contacto #telefono').val(contacto.telefono);
		$('#form_contacto #tcontacto_id').val(contacto.tcontacto_id);
	});
}
$('#form_contacto').submit(function (e) {
	e.preventDefault();
	var formulario = '';
	var respuesta = '';

	if ($('#condicion').val() == 1) {
		//Editar
		formulario = new FormData(this);

		$.ajax({
			url: base_url + 'contacto/Ccontactos/update',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			respuesta = JSON.parse(data);
			if (respuesta.respuesta == 1) {
				notify_contacto('edit');
				datatable_destroy_contacto();
				list_data_table_contacto();
			} else if (respuesta.respuesta == 2) {
				notify_contacto(respuesta.informacion);
			}
		});
	} else {
		//Agregar
		formulario = new FormData(this);

		$.ajax({
			url: base_url + 'contacto/Ccontactos/add',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			respuesta = JSON.parse(data);
			if (respuesta.respuesta == 1) {
				notify_contacto('add');
				datatable_destroy_contacto();
				list_data_table_contacto();
			} else if (respuesta.respuesta == 2) {
				notify_contacto(respuesta.informacion);
			}
		});
	}
});
function delete_contacto(id, e) {
	e.preventDefault();
	var confirmacion = confirm('¿Estas seguro de Eliminar este registro?');
	if (confirmacion) {
		$.ajax({
			url: base_url + 'contacto/Ccontactos/delete',
			type: 'POST',
			data: {
				id: id,
			},
			success: function (data) {
				datatable_destroy_contacto();
				list_data_table_contacto();
				notify_contacto('del');
			},
		});
	} else {
		alert('Eliminación cancelada');
	}
}
function notify_contacto(action = '') {
	//mensajes de alerta
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'Contacto Agregado exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'Contacto Editado exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'Contacto Eliminado exitosamente';
		tipo = 'danger';
	} else {
		msj = action;
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
function aplicar_condicion(valor = '') {
	if (valor == 1) {
		$('#condicion').val('1'); // Editar
	} else {
		$('#condicion').val('2'); // Agrear
	}
}
