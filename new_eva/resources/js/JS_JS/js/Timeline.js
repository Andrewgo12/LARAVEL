function getTimeline(id) {
	$('#modal_timeline_orden  #id').val(id);
	$.ajax({
		url: `${base_url}orden/Cordenes/timeline`,
		type: 'post',
		data: { id },
	}).done(function (data) {
		$('#modal_timeline_orden .contenido-modal-timeline').html(data);
	});
}
function cerrar_ticket(e) {
	e.preventDefault();
	var orden_id = $('#modal_timeline_orden  #id').val();
	$.ajax({
		url: `${base_url}orden/Cordenes/archivar_orden`,
		type: 'post',
		data: { id: orden_id },
	}).done(function (data) {
		alert('orden cerrada exitosamente');
		getTimeline(orden_id);
		list_data_table_orden();
	});
}
function asignar_equipo_id(e, orden_id) {
	e.preventDefault();
	var equipo_id = $('.contenido-modal-timeline .equipo_id').val();
	if (equipo_id != '' && equipo_id >= 1) {
		$.ajax({
			url: `${base_url}orden/Cordenes/update_general`,
			type: 'post',
			data: {
				id: orden_id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			list_data_table_orden();
			getTimeline(orden_id);
			alert('Equipo asociado correctamente');
		});
	} else alert('El valor digitado no es valido');
}
function asignar(id) {
	$('#form_asignacion #id').val(id);
}
function asignar_otro(id) {
	$('#form_asignacion_otro #id').val(id);
	select_trabajos();
}
function select_trabajos() {
	$.ajax({
		url: `${base_url}orden/Ctrabajos/getAll`,
		type: 'post',
		data: {},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = `<option required="required" value="">---------</option>>`;
		$.each(respuesta, function (i, registro) {
			tmp +=
				`
				<option value="` +
				registro.id +
				`">` +
				registro.name +
				`</option>
			`;
		});
		$('#modal_asignar_orden_otro #form_asignacion_otro .trabajo_id').html(tmp);
	});
}
function seleccionar_tecnicos() {
	var entrada = '';
	if ($('.trabajo_id').val() == 7) {
		//Si se selecciona la opcion otros
		entrada = `<input class="form-control tecnico_otros" id="tecnico_otros" name="tecnico_otros" placeholder="Indique usuario y/o empresa al cual se asigna"></input>`;
		$('.contenedor_hijo_asignacion').html('');
		$('.contenedor_hijo_asignacion').html(entrada);
	} else {
		// Si no se selecciona la opcion otros
		entrada = `<select style="width: 80%;" name="tecnico_id" id="tecnico_id" class="form-control tecnico_id" style="width:60%" required=""></select>`;
		$('.contenedor_hijo_asignacion').html('');
		$('.contenedor_hijo_asignacion').html(entrada);
		var trabajo_id = $(
			'#modal_asignar_orden_otro #form_asignacion_otro .trabajo_id'
		).val();
		$.ajax({
			url: base_url + 'tecnico/Ctecnicos/getFromTrabajos',
			type: 'post',
			data: {
				trabajo_id: trabajo_id,
			},
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = `<option required value="">-------</option>`;
			$.each(respuesta, function (i, registro) {
				tmp +=
					`
				<option value="` +
					registro.id +
					`">` +
					registro.name +
					`</option>
			`;
			});
			$('#modal_asignar_orden_otro #form_asignacion_otro .tecnico_id').html(
				tmp
			);
		});
	}
}
//TODO
$('#form_asignacion').on('submit', function (e) {
	e.preventDefault();
	const form = new FormData(this);
	$('#modal_asignar_orden .close').click();
	$('#btn_asignar_orden').attr('disabled', 'disabled');
	$.blockUI({
		message:
			'<h1><div class="glyphicon glyphicon-pencil"></dv>Procesando</h1><br><p>Espere un momento mientras la información es procesada</p>',
		css: {
			width: '275px',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
		},
	});
	$.ajax({
		url: base_url + 'orden/Cordenes/asignar_empresa',
		type: 'POST',
		data: form,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		console.log({ data });
		var respuesta = JSON.parse(data);
		$.unblockUI();
		datatable_destroy_orden();
		list_data_table_orden();
		$('#form_asignacion').trigger('reset');
		notify('edit');
		funcion_email_asignar_empresa(respuesta.orden_id);
		getTimeline(respuesta.orden_id);
	});
});
$('#form_asignacion_otro').on('submit', function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#modal_asignar_orden_otro .close').click();
	$('#btn_asignar_orden').attr('disabled', 'disabled');
	$.blockUI({
		message:
			'<h1><div class="glyphicon glyphicon-pencil"></dv>Procesando</h1><br><p>Espere un momento mientras la información es procesada</p>',
		css: {
			width: '275px',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
		},
	});
	$.ajax({
		url: base_url + 'orden/Cordenes/asignar_trabajo',
		type: 'POST',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		$.unblockUI();
		datatable_destroy_orden();
		list_data_table_orden();
		$('#form_asignacion_otro').trigger('reset');
		notify('edit');
		funcion_email_asignar_trabajo(respuesta.orden_id);
		getTimeline(respuesta.orden_id);
	});
});
$('#form_add_diagnostico_orden').submit(function (e) {
	e.preventDefault();
	$('#btn_add_diagnostico_from_timeline').attr('disabled', 'disabled');
	var formulario = new FormData(this);
	$('#modal_add_diagnostico_from_timeline .close').click();
	$.ajax({
		url: base_url + 'orden/Cordenes/update_from_modal_diagnostico',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var orden_id = JSON.parse(data);
		datatable_destroy_orden();
		list_data_table_orden();
		getTimeline(orden_id);
		$('#form_add_diagnostico_orden').trigger('reset');
		alert('Se ha ingresado la información del diagnostico exitosamente');
		$('#btn_add_diagnostico_from_timeline').removeAttr('disabled', 'disabled');
		update_diagnose_orden_email(orden_id);
	});
});
function enviar_correo(orden_id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/enviar_correo',
		type: 'post',
		data: { orden_id: orden_id },
	}).done(function () {
		alert('Se ha enviado un correo con la información del ticket');
	});
}
$('#form_add_solicitud_cierre_orden').submit(function (e) {
	e.preventDefault();
	$('#btn_add_solicitud_cierre_from_timeline').attr('disabled', 'disabled');
	var formulario = new FormData(this);

	$('#modal_add_solicitud_cierre_from_timeline .close').click();
	$.ajax({
		url: base_url + 'orden/Cordenes/update_from_modal_solicitud_cierre',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		console.log(data);
		var orden_id = JSON.parse(data);
		datatable_destroy_orden();
		list_data_table_orden();
		getTimeline(orden_id);
		$('#form_add_solicitud_cierre_orden').trigger('reset');
		alert('Se ha ingresado la información del reporte exitosamente');
		$('#btn_add_solicitud_cierre_from_timeline').removeAttr(
			'disabled',
			'disabled'
		);
		update_solicitar_cierre_orden_email(orden_id);
	});
});
$('#modal_add_repuesto_pendiente_ticket form').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#modal_add_repuesto_pendiente_ticket .close').click();
	$('#ingresar_repuesto_pendiente').attr('disabled', 'disabled');
	let result = ``;
	try {
		result = $.ajax({
			url: base_url + 'orden/Cordenes/update_from_modal_repuesto_pendiente',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		});
		var orden_id = JSON.parse(result);
		if (orden_id != -1) {
			datatable_destroy_orden();
			list_data_table_orden();
			getTimeline(orden_id);
			alert('Se ha asociado el repuesto pendiente correctamente');
			$('#ingresar_repuesto_pendiente').removeAttr('disabled', 'disabled');
			$('#modal_add_repuesto_pendiente_ticket form').trigger('reset');
		} else {
			$('#ingresar_repuesto_pendiente').removeAttr('disabled', 'disabled');
			alert('La longitud del repuesto no es valida');
		}
	} catch (error) {
		console.log(error);
	}
});
function desvincluar_repuesto_pendiente(e) {
	e.preventDefault();
	let result = ``;
	try {
		result = $.ajax({
			url: `${base_url}orden/Cordenes/desvincular_repuesto_pendiente`,
			type: 'post',
			data: {},
		});
		var orden_id = JSON.parse(result);
		datatable_destroy_orden();
		list_data_table_orden();
		getTimeline(orden_id); // Modificacion del ticket
		alert('El repuesto asociado ya no esta pendiente');
		if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
			list_data_table_server_side_filtros();
		}
	} catch (error) {
		console.log(error);
	}
}
function addInstallationSpare() {
	console.log('hi');
}
