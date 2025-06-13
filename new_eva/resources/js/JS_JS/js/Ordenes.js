if (controlador == 'Cordenes') {
	select_procesos();
	select_centros();
	list_data_table_orden();
	get_listado_industriales();
}
$('.imprimir-ticket').click(function () {
	$('.contenido-modal-timeline').print({
		title: 'Detalle del Ticket',
	});
});
$(document).on('hidden.bs.modal', '.modal', function () {
	$('.modal:visible').length && $(document.body).addClass('modal-open');
});
$('#servicio_id').select2({
	placeholder: 'Seleccione la ubicación del equipo',
});
$('#centro_costo').select2({
	placeholder: 'Seleccione el centro de costo del reportante',
});

$('.subproceso_1,.subproceso_2').hide();
$('.subproceso_1 select, .subproceso_1 input').attr('disabled', 'disabled');
$('.subproceso_2 select, .subproceso_2 input').attr('disabled', 'disabled');
function show_orden(id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/show',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		$('#modal_show_orden .modal-body').html(data);
	});
}
$('.abrir_modal_add_orden_biomedico').click(function () {
	$('.equipo_id').val();
	$('.resultado_seleccion_equipo').html('');
	$('.btn_add_orden').attr('disabled', 'disabled');
	$('.subproceso_id').val(1);
});
$('.abrir_modal_add_orden_industrial').click(function () {
	$('.equipo_id').val();
	$('.resultado_seleccion_equipo').html('');
	$('.btn_add_orden').attr('disabled', 'disabled');
	$('.subproceso_id').val(2);
});
$('.abrir_modal_add_orden_otros').click(function () {
	$('.btn_add_orden').attr('disabled', 'disabled');
	$('.subproceso_id').val(3);
});
$('.form_orden').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#modal_add_biomedicos .close').click();
	$('#modal_add_industriales .close').click();
	$('#modal_add_otros .close').click();
	$.blockUI({
		message:
			'<h1><div class="glyphicon glyphicon-refresh"></dv>Procesando</h1><br><p>Espere un momento mientras la información es procesada</p>',
		css: {
			width: '275px',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
		},
	});
	$.ajax({
		url: base_url + 'orden/Cordenes/add',
		type: 'POST',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		$.unblockUI();
		if (respuesta.respuesta == 1) {
			var id_orden = respuesta.valor;
			notify_orden('add');
			$('.contenedor-orden .resultado_seleccion_equipo input').val('');
			email_add_orden(id_orden);
		} else {
			contenido =
				'<div class=""><div class="panel panel-danger"><div class="panel-heading">Error</div><div class="panel-body">' +
				respuesta.valor +
				'</div></div></div>';
			$.blockUI({ message: contenido });
			if ($('.subproceso_id').val() == 1) {
				$('.contenedor-orden #btn_add_orden').removeAttr(
					'disabled',
					'disabled'
				);
				setTimeout(function () {
					$.unblockUI();
					$('.abrir_modal_add_orden_biomedico').click();
				}, 3000);
			}
			if ($('.subproceso_id').val() == 2) {
				setTimeout(function () {
					$.unblockUI();
					$('.abrir_modal_add_orden_industrial').click();
				}, 3000);
			}
			if ($('.subproceso_id').val() == 3) {
				setTimeout(function () {
					$.unblockUI();
					$('.abrir_modal_add_orden_otros').click();
				}, 3000);
			}
		}
	});
});
/**
 * It sends an AJAX request to a PHP function that sends an email.
 * @param id_orden - The id of the order
 */
function email_add_orden(id_orden) {
	$.ajax({
		url: base_url + 'orden/Cordenes/email_add_orden',
		type: 'post',
		data: { id: id_orden },
	}).done(function (data2) {
		datatable_destroy_orden();
		list_data_table_orden();
		$('#form_orden').trigger('reset');
		alert('Se ha enviado un correo electronico con la información del Ticket');
	});
}
/**
 * It creates a table with ajax data.
 * @returns The data is being returned correctly, but the table is not being updated.
 */
function list_data_table_orden() {
	var subproceso_id = $('.orden_creada .subproceso_id').val();
	var tabla = '';
	tabla = $('#tblOrdenes').DataTable({
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
			[5, 15, -1],
			[5, 15, 'todos'],
		],
		paging: true,
		info: true,
		filter: true,
		stateSave: true,
		dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
		bDestroy: true,
		ajax: {
			//
			url: base_url + 'orden/Cordenes/getOwn',
			type: 'POST',
			data: {
				subproceso_id: subproceso_id,
			},
			dataSrc: '',
		},
		columns: [
			{ data: 'id' },
			{ data: 'descripcion' },
			{ data: 'fecha_inicio' },
			{ data: 'estado_id' },
			{
				orderable: true,
				render: function (data, type, row) {
					var msj = '';
					msj += '&nbsp;';
					msj +=
						'<a href="" title="Seguimiento del Ticket" id="btn_upd" class="fa fa-folder-open-o" data-toggle="modal" data-target="#modal_timeline_orden" onClick="getTimeline(' +
						row.id +
						')" style="font-size:30px;color:#252525;" ></a>';
					return msj;
				},
			},
		],
		columnDefs: [
			{
				targets: [1],
				data: 'estado_id',
				render: function (data, type, row) {
					var tmp = '';
					tmp += `<strong>Origen</strong>:` + row.subproceso + '<br>';
					if (row.equipo_id != 0 && row.equipo_id != null) {
						tmp +=
							`
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Equipo:</strong></li>
								<li class="list-inline-item">` +
							row.name +
							`</li>
							</ul>
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Codigo:</strong></li>
								<li class="list-inline-item">` +
							row.code +
							`</li>
							</ul>
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Marca:</strong></li>
								<li class="list-inline-item">` +
							row.marca +
							`</li>
							</ul>
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Modelo:</strong></li>
								<li class="list-inline-item">` +
							row.modelo +
							`</li>
							</ul>
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Serie:</strong></li>
								<li class="list-inline-item">` +
							row.serial +
							`</li>
							</ul>
						`;
					} else {
						if (row.nombre_equipo) {
							tmp +=
								`
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Equipo:</strong></li>
								<li class="list-inline-item">` +
								row.nombre_equipdo +
								`</li>
							</ul>
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Codigo:</strong></li>
								<li class="list-inline-item">` +
								row.codigo_equipo +
								`</li>
							</ul>
							<ul class="list-inline" style="text-transform: uppercase;">
								<li class="list-inline-item"><strong>Serie:</strong></li>
								<li class="list-inline-item">` +
								row.serie_equipo +
								`</li>
							</ul>
						`;
						}
					}
					tmp +=
						`<div title="` +
						row.descripcion +
						`" class="text-muted">
						` +
						row.descripcion +
						`
					</div>`;
					return tmp;
				},
			},
			{
				targets: [3],
				data: 'estado_id',
				render: function (data, type, row) {
					if (data == 1) {
						return "<span class='label label-danger'>Abierto</span>";
					} else if (data == 2) {
						return "<span class='label label-warning'>Asignado</span>";
					} else if (data == 3) {
						return "<span class='label label-info'>Diagnosticado</span>";
					} else if (data == 4) {
						return "<span class='label label-success'>Cerrado</span>";
					} else if (data == 5) {
						return "<span class='label label-success'>Esperando cierre</span>";
					}
				},
			},
		],
	});
	tabla.column('0:visible').order('desc').draw();
}
function datatable_destroy_orden() {
	$('#tblOrdenes').dataTable().fnClearTable();
	$('#tblOrdenes').dataTable().fnDestroy();
}
function select_centros() {
	console.log('sss');
	var temporal = '';
	$.ajax({
		url: base_url + 'ubicacion/Cservicios/getCentros',
		type: 'POST',
		data: {},
		success: function (data) {
			valor = JSON.parse(data);
			temporal += '<option>--Seleccione--</option>';
			$.each(valor, function (i, item) {
				temporal +=
					'<option value=' +
					item.id +
					'>' +
					'item.code' +
					'-' +
					'item.name' +
					'</option>';
			});
			$('#centro_costo').append(temporal);
			temporal = '';
		},
	});
}
function notify_orden(action = '') {
	//mensajes de alerta
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'Orden de servicio Generada exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'Orden de servicio editada exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'Orden de servicio eliminada exitosamente';
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
function esconder() {
	$('.esconder').hide();
}
function mostrar() {
	$('.esconder').show();
}
function select_procesos() {
	$.ajax({
		url: base_url + 'orden/Cordenes/getProcesos',
		type: 'post',
		data: { dato: 1 },
	}).done(function (data) {
		procesos = JSON.parse(data);
		var tmp = '';
		$.each(procesos, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.nombre + '</option>';
		});
		$('#proceso').append(tmp);
		tmp = '';
	});
}
$('#proceso').on('change', function () {
	$.ajax({
		url: base_url + 'orden/Cordenes/getSubprocesos',
		type: 'post',
		data: { proceso_id: $('#proceso').val() },
	}).done(function (data) {
		subprocesos = JSON.parse(data);
		var tmp = '';
		tmp += "<option value=''>--Seleccione--</option>";

		$.each(subprocesos, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.nombre + '</option>';
		});
		$('#subproceso').html(tmp);
		tmp = '';
	});
});
$('#subproceso').change(function () {
	if ($('#subproceso').val() == 1) {
		$('#seleccionado').val(1);
		$('.subproceso_1').show();
		$('.subproceso_2').hide();
		$('.subproceso_1 select,.subproceso_1 input').attr('disabled', false);
		$('.subproceso_2 select,.subproceso_2 input').attr('disabled', true);
		select_servicios();
	} else if ($('#subproceso').val() == 2) {
		$('#seleccionado').val(2);
		$('.subproceso_1').hide();
		$('.subproceso_2').show();
		$('.subproceso_2 select,.subproceso_2 input').attr('disabled', false);
		$('.subproceso_1 select,.subproceso_1 input').attr('disabled', true);
		select_servicios2();
	}
});
$('#form_orden #codigo_equipo').on('keyup', function () {
	if ($('#modal_add_orden #form_orden #codigo_equipo').val().length > 2) {
		var respuesta_codigo = '';
		var tmp = '';
		$('#respuesta_codigo').dropdown('toggle');
		$.ajax({
			url: base_url + 'orden/Cordenes/getLikeCodigo',
			type: 'POST',
			data: { code: $('#form_orden #codigo_equipo').val() },
		}).done(function (data) {
			respuesta_codigo = JSON.parse(data);
			$('#form_orden #respuesta_codigo').empty();
			$('#form_orden #respuesta_codigo').show();
			$.each(respuesta_codigo, function (id, item) {
				tmp +=
					"<li class='list-group-item'><a href='#' onClick='seleccionado_codigo(" +
					item.id +
					")'>Codigo: " +
					item.code +
					'| Serie: ' +
					item.serial +
					' |Nombre: ' +
					item.name +
					'</a></li>';
			});
			$('#respuesta_codigo').append(tmp);
		});
	}
});
$('#form_orden #codigo_equipo_2').on('keyup', function () {
	if ($('#modal_add_orden #form_orden #codigo_equipo_2').val().length > 2) {
		var respuesta_codigo = '';
		var tmp = '';
		$('#respuesta_codigo_2').dropdown('toggle');
		$.ajax({
			url: base_url + 'equipos_ind/Cequipos_ind/getLikeCodigo',
			type: 'POST',
			data: { code: $('#form_orden #codigo_equipo_2').val() },
		}).done(function (data) {
			respuesta_codigo = JSON.parse(data);
			$('#form_orden #respuesta_codigo_2').empty();
			$('#form_orden #respuesta_codigo_2').show();
			$.each(respuesta_codigo, function (id, item) {
				tmp +=
					"<li class='list-group-item'><a href='#' onClick='seleccionado_codigo(" +
					item.id_equipos +
					")'>Codigo: " +
					item.codigo_inventario +
					'| Serie: ' +
					item.serial +
					' |Nombre: ' +
					item.nombre +
					'</a></li>';
			});
			$('#respuesta_codigo_2').append(tmp);
		});
	}
});
function seleccionado_codigo(id) {
	$('#form_orden #respuesta_codigo').hide();
	$('#form_orden #respuesta_codigo_2').hide();
	var respuesta_codigo = '';
	if ($('#subproceso').val() == 1) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/getOne',
			type: 'POST',
			data: { id: id },
		}).done(function (data) {
			respuesta_codigo = JSON.parse(data);
			$('#form_orden #serial').val(respuesta_codigo.serial);
			$('#form_orden #nombre_equipo').val(respuesta_codigo.name);
			$('#form_orden #codigo_equipo').val(respuesta_codigo.code);
			$('#form_orden #modelo_equipo').val(respuesta_codigo.modelo);
			$('#form_orden #marca_equipo').val(respuesta_codigo.marca);
			$('#form_orden #equipo_id').val(respuesta_codigo.id);
		});
	} else if ($('#subproceso').val() == 2) {
		$.ajax({
			url: base_url + 'equipos_ind/Cequipos_ind/getOne',
			type: 'POST',
			data: { id: id },
		}).done(function (data) {
			respuesta_serie = JSON.parse(data);
			$('#form_orden #serial_2').val(respuesta_serie.serial);
			$('#form_orden #nombre_equipo_2').val(respuesta_serie.nombre);
			$('#form_orden #codigo_equipo_2').val(respuesta_serie.codigo_inventario);
			$('#form_orden #modelo_equipo_2').val(respuesta_serie.modelo);
			$('#form_orden #marca_equipo_2').val(respuesta_serie.marca);
			$('#form_orden #equipo_id_2').val(respuesta_serie.id_equipos);
		});
	}
}
function validacionImagen() {
	var fileInput = document.getElementById('image');
	var filePath = fileInput.value;
	var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
	if (!allowedExtensions.exec(filePath)) {
		alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
		fileInput.value = '';
		return false;
	}
}
$('#modal_add_orden #form_orden').click(function (e) {
	$('#form_orden #respuesta_codigo').empty();
	$('#form_orden #respuesta_codigo').hide();
	$('#form_orden #respuesta_serie').empty();
	$('#form_orden #respuesta_serie').hide();
	$('#form_orden #respuesta_codigo_2').empty();
	$('#form_orden #respuesta_codigo_2').hide();
	$('#form_orden #respuesta_serie_2').empty();
	$('#form_orden #respuesta_serie_2').hide();
});
function desbloquear_add_orden() {
	$.unblockUI();
	abrir_modal_add_orden();
}
function abrir_modal_add_orden() {
	$('.abrir_modal_add_orden_biomedico').click();
}
$('.contenedor-orden .servicio_id').on('change', function () {
	var servicio_id = this.value;
	select_areas(servicio_id);
});
function funcion_seleccion_area_auxiliar() {
	$('.area_id_auxiliar').val(0);
	list_data_table_server_side_general();
	var servicio_id = $('.servicio_id_auxiliar').val();
	select_areas_auxiliar(servicio_id);
}
function funcion_get_equipos_biomedicos(param = '') {
	$.ajax({
		url: base_url + 'equipo/Cequipos/show_listado',
		type: 'post',
		data: {},
	}).done(function (data) {
		list_servicios_auxiliar();
		select_sedes_busqueda_equipos();
		$('#modal_consulta_equipos_biomedicos .modal-body').html(data);
		$('.tipo_id').val(param);
		list_data_table_server_side_general();
	});
}
function set_equipo_id(equipo_id) {
	$('.contenedor-orden #btn_add_orden').removeAttr('disabled', 'disabled');
	$('.boton-seleccion').attr('disabled', 'disabled');

	$('.contenedor-orden #equipo_id').val('');
	$('.contenedor-orden .resultado_seleccion_equipo').html('');
	tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getOne',
		type: 'post',
		data: { id: equipo_id },
	}).done(function (data) {
		var equipo = JSON.parse(data);
		tmp += '<blockquote>';
		tmp += '<ul>';
		tmp +=
			"<li><span style='font-weight:900;'>Nombre:</span><small class='text-muted'>" +
			equipo.name +
			'</small></li>';
		tmp +=
			"<li><span style='font-weight:900;'>Marca:</span><small class='text-muted'>" +
			equipo.marca +
			'</small></li>';
		tmp +=
			"<li><span style='font-weight:900;'>Modelo:</span><small class='text-muted'>" +
			equipo.modelo +
			'</small></li>';
		tmp +=
			"<li><span style='font-weight:900;'>Serie:</span><small class='text-muted'>" +
			equipo.serial +
			'</small></li>';
		tmp +=
			"<li><span style='font-weight:900;'>codigo:</span><small class='text-muted'>" +
			equipo.code +
			'</small></li>';
		tmp +=
			"<li><span style='font-weight:900;'>Servicio donde registra:</span><small class='text-muted'>" +
			equipo.servicios +
			'</small></li>';
		if (equipo.area != null && equipo.area != '') {
			tmp +=
				"<li><span style='font-weight:900;'>Area donde registra:</span><small class='text-muted'>" +
				equipo.area +
				'</small></li>';
		}
		tmp += '</ul>';
		tmp += '</blockquote>';

		$('.contenedor-orden #equipo_id').val(equipo_id);
		$('.contenedor-orden .resultado_seleccion_equipo').html(tmp);
		$('#modal_consulta_equipos_biomedicos .close').click();
		$('.boton-seleccion').removeAttr('disabled', 'disabled');
	});
}
function set_manual(e) {
	e.preventDefault();
	$('.contenedor-orden #btn_add_orden').removeAttr('disabled', 'disabled');
	$('.contenedor-orden .resultado_seleccion_equipo').html('');
	$('.contenedor-orden #equipo_id').val('');
	tmp = ` 
		<div class="panel panel-body">
			  <div class="form-group">
			    <label for="name">Nombre del equipo</label>
			    <input required="required" type="text" class="form-control" id="nombre_equipo" name="nombre_equipo" placeholder="Nombre equipo">
			  </div>
			  <div class="form-group">
			    <label for="marca">Marca</label>
			    <input required="required" type="text" class="form-control" id="marca_equipo" name="marca_equipo" placeholder="Marca">
			  </div>
			  <div class="form-group">
			    <label for="marca">Modelo</label>
			    <input required="required" type="text" class="form-control" id="modelo_equipo" name="modelo_equipo" placeholder="Modelo">
			  </div>
			  <div class="form-group">	
			    <label for="Serie">Serie</label>
			    <input required="required" type="text" class="form-control" id="serie_equipo" name="serie_equipo" placeholder="serial">
			  </div>
			  <div class="form-group">	
			    <label for="Serie">Activo fijo</label>
			    <input required="required" type="text" class="form-control" id="codigo_equipo" name="codigo_equipo" placeholder="Activo fijo">
			  </div>
		</div>

		`;
	$('.contenedor-orden .resultado_seleccion_equipo').html(tmp);
	$('.contenedor-orden .seleccion_manual').val(1);
}
function inicio_modal(param) {
	$('.contenedor-orden .contenedor_seleccion_reportante').html('');
	switch (param) {
		case 1:
			$('#modal_add_biomedicos .tipo_id').val(param);
			break;
		case 2:
			$('#modal_add_biomedicos .tipo_id').val(param);
			break;
	}
}
$('.seleccion_reportante_biomedicos').on('change', function () {
	var tmp = '';
	if (
		$(
			'#modal_add_biomedicos input[name="seleccion_reportante"]:checked'
		).val() == 'propio'
	) {
		$('.contenedor-orden .contenedor_seleccion_reportante').html('');
	} else if (
		$(
			'#modal_add_biomedicos input[name="seleccion_reportante"]:checked'
		).val() == 'otro'
	) {
		tmp += `
				<div class="row">
					<div class="col-sm-6">
						<label for="nombre_reportante">Nombre del reportante:</label><br>
						<input class="form-control informacion_otro_reportante" required="" type="text" name="nombre_reportante" id="nombre_reportante" placeholder="Nombre del reportante">
					</div>
					<div class="col-sm-6">
						<label for="servicio_reportante">Centro de costo del reportante:</label><br>
						<select style="width: 100%;" class="form-control informacion_otro_reportante centro" name="centro_costo" id="centro_costo" required=""></select>
					</div>
				</div>
			`;
		list_centros();
		$('.contenedor_seleccion_reportante').html(tmp);
	}
});
$('.seleccion_reportante_industriales').on('change', function () {
	var tmp = '';
	if (
		$(
			'#modal_add_industriales input[name="seleccion_reportante"]:checked'
		).val() == 'propio'
	) {
		$('.contenedor-orden .contenedor_seleccion_reportante').html('');
	} else if (
		$(
			'#modal_add_industriales input[name="seleccion_reportante"]:checked'
		).val() == 'otro'
	) {
		tmp += `
				<div class="row">
					<div class="col-sm-6">
						<label for="nombre_reportante">Nombre del reportante:</label><br>
						<input class="form-control informacion_otro_reportante" required="" type="text" name="nombre_reportante" id="nombre_reportante" placeholder="Nombre del reportante">
					</div>
					<div class="col-sm-6">
						<label for="servicio_reportante">Centro de costo del reportante:</label><br>
						<select style="width: 100%;" class="form-control informacion_otro_reportante centro" name="centro_costo" id="centro_costo" required=""></select>

					</div>
				</div>
			`;
		list_centros();
		$('.contenedor_seleccion_reportante').html(tmp);
	}
});
$('.seleccion_reportante_otros').on('change', function () {
	var tmp = '';
	if (
		$('#modal_add_otros input[name="seleccion_reportante"]:checked').val() ==
		'propio'
	) {
		$('.contenedor-orden .contenedor_seleccion_reportante').html('');
	} else if (
		$('#modal_add_otros input[name="seleccion_reportante"]:checked').val() ==
		'otro'
	) {
		tmp += `
					<div class="row">
						<div class="col-sm-6">
							<label for="nombre_reportante">Nombre del reportante:</label><br>
							<input class="form-control informacion_otro_reportante" required="" type="text" name="nombre_reportante" id="nombre_reportante" placeholder="Nombre del reportante">
						</div>
						<div class="col-sm-6">
							<label for="servicio_reportante">Centro de costo del reportante:</label><br>
							<select style="width: 100%;" class="form-control informacion_otro_reportante centro" name="centro_costo" id="centro_costo" required=""></select>

						</div>
					</div>
				`;
		list_centros();
		$('.contenedor_seleccion_reportante').html(tmp);
	}
});
$('.orden_creada .subproceso_id').on('change', function () {
	list_data_table_orden();
});
function get_listado_industriales() {
	var respuesta = ``;
	result = $.ajax({
		url: base_url + 'equipo/Cequipos/get_listado_industriales',
		type: 'post',
		data: {},
	}).done(function (data) {
		respuesta = JSON.parse(data);
		var tmp = `<option value="">------</option>`;
		$.each(respuesta, function (i, registro) {
			tmp += `
					<option value="${registro.id}">${registro.name}</option>
				`;
		});
		$(
			'#modal_add_industriales #form_orden_industriales .listado_industrial_id'
		).html(tmp);
	});
}
