select_rol();
select_centros();
tabla_usuarios_zonas();
function tabla_usuarios_zonas() {
	$.ajax({
		url: base_url + 'administrador/Cusuarios/getUsuarios_zonas',
		type: 'post',
		data: {},
	}).done(function (data) {
		var usuarioszonas = JSON.parse(data);
		var tmp = '';

		$.each(usuarioszonas, function (i, item) {
			tmp +=
				`
				<tr>
					<td>` +
				item.zona +
				`</td>
					<td>` +
				item.usuario +
				`</td>
					<td>` +
				item.email +
				`</td>
					<td><a onClick="eliminar_usuario_zona(event,` +
				item.id +
				`)" href="" style="color:red;" class="glyphicon glyphicon-remove" title="eliminar relación"></a></td>
				</tr>

			`;
		});
		$('.tblusuarioszonas tbody').html(tmp);
	});
}
function eliminar_usuario_zona(e, id) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'administrador/Cusuarios/delete_usuario_zona',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		tabla_usuarios_zonas();
	});
}
function funcion_modal_add_usuario_zona(e) {
	e.preventDefault();
	select_zonas();
	select_usuarios();
}
$('#modal_add_usuario_zona #form_usuario_zona').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('.btn-add-usuario-zona').attr('disabled', 'disabled');
	$.ajax({
		url: base_url + 'administrador/Cusuarios/add_usuario_zona',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		tabla_usuarios_zonas();
		$('.btn-add-usuario-zona').removeAttr('disabled', 'disabled');
		$('#modal_add_usuario_zona .close').click();
	});
});
function select_usuarios() {
	$.ajax({
		url: base_url + 'administrador/Cusuarios/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var usuarios = JSON.parse(data);
		var tmp = "<option value=''>----Seleccione----</option>";

		$.each(usuarios, function (i, item) {
			tmp +=
				`
				<option value="` +
				item.id +
				`">` +
				item.nombre +
				`|` +
				item.username +
				`|` +
				item.email +
				`</option>
			`;
		});
		$('.usuario_id').html(tmp);
		$('.usuario_id').select2();
	});
}
function show_usuario(id) {
	//Mostrar información detallada
	$.ajax({
		url: base_url + 'administrador/Cusuarios/show',
		type: 'POST',
		data: { id: id },
		success: function (data) {
			$('#modal_show_usuario .modal-body').html(data);
		},
	});
}
function delete_usuario(id) {
	// Pasar a estado 0
	var confirmacion = confirm('¿Estas seguro de Eliminar este registro?');
	if (confirmacion) {
		$.ajax({
			url: base_url + 'administrador/Cusuarios/delete',
			type: 'POST',
			data: {
				id: id,
			},
			success: function (data) {
				datatable_destroy();
				list_data_table_server_side_usuarios();
				notify('del');
			},
		});
	} else {
		alert('Eliminación cancelada');
	}
}
function recover_modal_usuario(id) {
	// Recuperar informacion del registro
	$('#form_usuario #id').val(id);
	$.ajax({
		url: base_url + 'administrador/Cusuarios/getOneWithActions',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		respuesta = JSON.parse(data);
		var usuario = respuesta.usuario;
		var acciones = respuesta.acciones;
		// acciones=acciones[0];

		$('.form_usuario').trigger('reset');
		$('#form_usuario #id').val(usuario.id);
		$('#form_usuario #nombre').val(usuario.nombre);
		$('#form_usuario #apellido').val(usuario.apellido);
		$('#form_usuario #telefono').val(usuario.telefono);
		$('#form_usuario #email').val(usuario.email);
		$('#form_usuario #username').val(usuario.username);
		$('#form_usuario #rol_id').val(usuario.rol_id);
		$('#form_usuario #rol_id').select2({
			placeholder: '' + usuario.rol_id + '',
		});
		$('#form_usuario #centro_id').val(usuario.centro_id);
		$('#form_usuario #centro_id').select2({
			placeholder: '' + usuario.centro_id + '',
		});
		$('#form_usuario .empresa_id').val(usuario.id_empresa);
		//$("#form_usuario .empresa_id").select2({placeholder:""+usuario.empesa+""});
		var tmp = '';
		$.each(acciones, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.modulo + '&nbsp;</td>';
			if (item.leer == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",1)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",1)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			if (item.insertar == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",2)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",2)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			if (item.editar == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",3)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",3)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			if (item.eliminar == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",4)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",4)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			tmp += '</tr>';
		});
		$('#modal_update_usuario .tbl_acciones tbody').html(tmp);
	});
}
$('#form_usuario').submit(function (e) {
	// Actualizar
	e.preventDefault();
	var formulario = new FormData(this);
	$('#btn_update_usuario').attr('disabled', 'disabled');
	$.ajax({
		url: base_url + 'administrador/Cusuarios/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_update_usuario .errores').html('');
		var valor = JSON.parse(data);
		if (valor == 1) {
			datatable_destroy();
			list_data_table_server_side_usuarios();
			tblEmpresas();
			$('#btn_update_usuario').removeAttr('disabled', 'disabled');
			$('#modal_update_usuario .close').click();
			notify('edit');
			// $(".hidden-xs").html(nombre);
			document.getElementById('form_usuario').reset();
		} else {
			$.each(valor, function (i, item) {
				$('#modal_update_usuario .errores').append(item + '<br>');
			});
		}
	});
});

$('#btn_add_usuario').click(function () {
	// Agregar
	// $("#modal_add_usuario .errores").html('');
	$('#modal_add_usuario .close').click();
	$('#modal_reg_usuario .close').click();
	$.blockUI({
		message:
			'<h1><div class="glyphicon glyphicon-refresh"></dv>Procesando</h1><br><p>Espere un momento mientras la información es verificada</p>',
		css: {
			width: '275px',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
		},
	});
	$.ajax({
		url: base_url + 'administrador/Cusuarios/add',
		data: {
			nombre: $('#add_nombre_usuario').val(),
			apellido: $('#add_apellido_usuario').val(),
			telefono: $('#add_telefono_usuario').val(),
			email: $('#add_email_usuario').val(),
			username: $('#add_username_usuario').val(),
			password: $('#add_password_usuario').val(),
			rol_id: $('#add_rol_id_usuario').val(),
			centro_id: $('#add_centro_id_usuario').val(),
			id_empresa: $('#add_id_empresa').val(),
		},
		type: 'POST',
		success: function (data) {
			var respuesta = JSON.parse(data);
			$.unblockUI();
			if (respuesta.respuesta == 1) {
				datatable_destroy();
				list_data_table_server_side_usuarios();
				notify('add');
				$('#add_nombre_usuario').val('');
				$('#add_apellido_usuario').val('');
				$('#add_telefono_usuario').val('');
				$('#add_email_usuario').val('');
				$('#add_username_usuario').val('');
				$('#add_password_usuario').val('');
				$('#add_rol_id_usuario').val('');
				$('#add_centro_id_usuario').val('');

				$.ajax({
					url: base_url + 'Cauth/email_registro',
					type: 'post',
					data: {
						password: respuesta.password,
						id: respuesta.valor,
					},
				}).done(function (data2) {
					alert('Usuario registrado exitosamente');
				});
			} else {
				contenido =
					'<div class=""><div class="panel panel-danger"><div class="panel-heading">Error</div><div class="panel-body">' +
					respuesta.valor +
					'</div></div></div>';
				$.blockUI({ message: contenido });
				setTimeout(function () {
					desbloquear_reg_usuario();
				}, 3000);
			}
		},
	});
});
function notify(action) {
	//mensajes de alerta
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'usuario agregado exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'usuario editado exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'usuario eliminado exitosamente';
		tipo = 'danger';
	}

	$.notify(
		{
			// icon: 'glyphicon glyphicon-user',
			title: '<strong>MSJ:</strong> ',
			message: msj,
		},
		{
			type: tipo,
		}
	);
}

function datatable_destroy() {
	// destruir data table
	$('#tblUsuarios').dataTable().fnClearTable();
	$('#tblUsuarios').dataTable().fnDestroy();
}
function select_rol() {
	$.ajax({
		url: base_url + 'administrador/Cusuarios/getRoles',
		type: 'POST',
		data: { valor: 1 },
		success: function (data) {
			var datos = JSON.parse(data);
			var html = "<option value=''>---------</option>";
			$.each(datos, function (i, item) {
				html += '<option value=' + item.id + '>' + item.nombre + '</option>';
			});
			$('#modal_add_usuario #add_rol_id_usuario').append(html);
			// $('#modal_add_usuario #add_rol_id_usuario').select2();

			$('#modal_update_usuario #rol_id').append(html);
			// $('#modal_update_usuario #rol_id').select2();
		},
	});
}
function select_centros() {
	const centros = new centroObj().ServiceGetAll();
	let print = '';
	centros.then((data) => {
		data.map((centro) => {
			console.log(centro);
			print += `<option value='${centro.id}'> ${centro.code} - ${centro.name} </option>`;
		});
		console.log(`Impresion: ${print}`);
		$('#modal_update_usuario #centro_id').html(print);
	});
}
function desbloquear_reg_usuario() {
	$.unblockUI();
	abrir_modal_reg_usuario();
}
function abrir_modal_reg_usuario() {
	$('.abrir_modal_reg_usuario').click();
}
