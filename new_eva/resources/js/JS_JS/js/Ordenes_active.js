var $buttonToPrint = document.getElementById('imprimir-ticket');

$buttonToPrint.addEventListener('click', () => {
	const toPrint = {
		title: 'Detalle del Ticket',
	};
	const $elementsToHide = document.getElementsByClassName('to-hide');
	const $listOfElementsToHide = Array.from($elementsToHide);
	$listOfElementsToHide.map(($row) => ($row.style.display = 'none'));
	$('.contenido-modal-timeline').print(toPrint);
	setTimeout(
		() => $listOfElementsToHide.map(($row) => ($row.style.display = 'block')),
		1000
	);
});

function show_orden(id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/show',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		$('#modal_show_orden .modal-body').html(data);
	});
}
$('#cierre_id').on('change', function () {
	if ($('#cierre_id').val() == '2') {
		$('.repuestos_en_cierre').removeAttr('required', 'required');
	} else {
		$('.repuestos_en_cierre').attr('required', 'required');
	}
});
list_data_table_orden();
async function list_data_table_orden() {
	const language = {
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
	};
	const sede_id = $('.orden_activa .sede_id').val();
	const estado_id = $('.orden_activa .estado_id').val();
	var rango_fechas = $('.orden_activa .rango-fechas').val();
	let condicion = !$('.orden_activa .condicion').is(':checked') ? 0 : 1;
	const user_id = $('.usuario_id').val();
	const dataToStore = {
		user_id,
		sede_id,
		estado_id,
		rango_fechas,
		condicion,
	};

	let tabla = ``;
	const url =
		$('.rol').val() <= 2
			? `${base_url}orden/Cordenes/getActive`
			: `${base_url}orden/Cordenes/getAsignadas`;

	try {
		tabla = await $('#tblOrdenes').DataTable({
			language,
			lengthMenu: [
				[5, 10, -1],
				[5, 10, 'Todo'],
			],
			paging: true,
			info: true,
			filter: true,
			stateSave: true,
			bDestroy: true,
			dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
			ajax: {
				url,
				type: 'POST',
				data: dataToStore,
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
						/*
            Estados
            -1.Abierto
            -2.Asignado
            -3.Diagnosticado
            -4.Cerrado
            -5.Esperando cierre
            */
						var msj = '';
						msj += `<ul class="list-inline">`;
						if (
							$('.rol').val() <= 2 &&
							(row.file_diagnostico == undefined ||
								row.file_diagnostico == '') &&
							row.estado_id > 2
						) {
							//Se habilita la opcion deagregar archivos de diagnostico posteriormente
							msj +=
								`<li class="list-inline-item"><a onClick="recover_modal_diagnose(` +
								row.id +
								`)" data-toggle="modal" data-target="#modal_archivo_diagnose_orden" style="color:#337ab7;" title="Agregar archivo diagnostico" href="" class="glyphicon glyphicon-paperclip"></a></li>`;
						}
						if (
							$('.rol').val() <= 2 &&
							(row.file_cierre == undefined || row.file_cierre == '') &&
							row.estado_id >= 4
						) {
							//Se habilita la opcion deagregar archivos de diagnostico posteriormente
							msj +=
								`<li class="list-inline-item"><a onClick="recover_modal_solicitud_cierre(` +
								row.id +
								`)" data-toggle="modal" data-target="#modal_archivo_solicitud_cierre_orden" style="color:#f2dede;" title="Agregar archivo cierre" href="" class="glyphicon glyphicon-paperclip"></a></li>`;
						}

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
						if (row.equipo_id) {
							if (row.area == null) {
								row.area = 'No registra';
							}
							if (row.localizacion_actual == null) {
								row.localizacion_actual = 'No registra';
							}
							tmp +=
								`
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>ID:</strong></li>
									<li class="list-inline-item"><a data-toggle="modal" data-target="#modal_show_equipo" href="#" onClick=show_equipo(` +
								row.equipo_id +
								`)>` +
								row.equipo_id +
								`</a></li>
									`;
							if (row.repuesto_pendiente_equipo == 'si') {
								tmp += `<li class="list-inline-item"><div style='color: red;' class='glyphicon glyphicon-wrench'>RP</div></li>`;
							}
							tmp +=
								`
								</ul>
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>Equipo:</strong></li>
									<li class="list-inline-item">` +
								row.equipo +
								`</li>
									`;
							if (row.responsable_mantenimiento != null) {
								tmp +=
									`
									<li class="list-inline-item"><strong>Responsable del mantenimiento:</strong></li>
									<li class="list-inline-item"><spa style="color:#75654B;font-weight:800;">` +
									row.responsable_mantenimiento +
									`</span></li>`;
							}
							tmp +=
								`</ul>
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>Codigo:</strong></li>
									<li class="list-inline-item">` +
								row.codigo +
								`</li>
								</ul>
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>Serie:</strong></li>
									<li class="list-inline-item">` +
								row.serial +
								`</li>
									<li class="list-inline-item"><strong>Sede:</strong></li>
									<li class="list-inline-item">` +
								row.sede +
								`</li>
									<li class="list-inline-item"><strong>Servicio:</strong></li>
									<li class="list-inline-item">` +
								row.servicio +
								`</li>
									<li class="list-inline-item"><strong>Area:</strong></li>
									<li class="list-inline-item">` +
								row.area +
								`</li>
									<li class="list-inline-item"><strong>Marca:</strong></li>
									<li class="list-inline-item">` +
								row.marca +
								`</li>
									<li class="list-inline-item"><strong>Modelo:</strong></li>
									<li class="list-inline-item">` +
								row.modelo +
								`</li>
								</ul>
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>Ultima localización registrada:</strong></li>
									<li class="list-inline-item">` +
								row.localizacion_actual +
								`</li>
									<li class="list-inline-item"><strong>Estado actual del equipo:</strong></li>
									<li class="list-inline-item"><span style="color:` +
								row.color_estado_equipo +
								`">` +
								row.estado_equipo +
								`</span></li>
								</ul>
							`;
						} else {
							if (row.nombre_equipo) {
								tmp +=
									`
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>Equipo:</strong></li>
									<li class="list-inline-item">` +
									row.nombre_equipo +
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
								<ul class="list-inline" style="text-transform: uppercase;">
									<li class="list-inline-item"><strong>Ubicación:</strong></li>
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
					render: function estado_id(data, type, row) {
						var id_usuario = $('.usuario_id').val();
						var tmp = '';
						if (data == 1) {
							tmp += "<span class='label label-danger'>Abierto</span>";
						} else if (data == 2) {
							tmp +=
								"<span class='label label-warning'>Asignado a:</span><br />";
							if (
								row.empresa != '' &&
								row.empresa != null &&
								row.empresa != undefined
							) {
								tmp +=
									`<p><span style="font-size:15px;text-transform:capitalize;color:green;">` +
									row.empresa +
									`</span></p>`;
							}
							if (
								row.tecnico_otros != null &&
								row.tecnico_otros != undefined &&
								row.tecnico_otros != ''
							) {
								tmp +=
									`<span style="font-size:13px;color:#153A6B;">` +
									row.tecnico_otros +
									`</span><br>`;
							}
							if (
								row.tecnico_asignado != '' &&
								row.tecnico_asignado != null &&
								row.tecnico_asignado != undefined
							) {
								tmp +=
									`<span style="font-size:13px;color:#153A6B;">` +
									row.tecnico_asignado +
									`</span><br>`;
							}

							if (row.asignador_id != 0) {
								tmp +=
									"<span class='label label-warning'>Asignado por:</span><br />";
								tmp +=
									`<p><span style="font-size:15px;text-transform:capitalize;color:#153A6B;">` +
									row.usuario_asignador +
									`
							 (` +
									row.nombre_usuario_asignador +
									`&nbsp;` +
									row.apellido_usuario_asignador +
									`)
							</span></p>`;
							}

							if (row.asignado_id != id_usuario && row.asignado_id != null) {
								tmp += '<br><br><strong>Responsable: </strong>' + row.usuario;
							} else if (
								row.asignado_id != id_usuario ||
								row.asignado_id == null
							) {
								tmp += '&nbsp;';
								tmp +=
									`<input type="checkbox" id="checkbox_` +
									row.id +
									`" name="checkbox_` +
									row.id +
									`" class="checkbox_` +
									row.id +
									`" onClick="ch(` +
									row.id +
									`)">`;
								tmp += '<br><br><strong>No hay responsable</strong>';
							} else if (
								row.asignado_id == id_usuario &&
								row.asignado_id != null
							) {
								tmp += '<br><br><strong>Responsable: </strong>' + row.usuario;
							}
						} else if (data == 3) {
							tmp += "<span class='label label-info'>Diagnosticado</span>";
							tmp += '&nbsp;';
							tmp += '<br><br><strong>Responsable: </strong>' + row.usuario;
						} else if (data == 4) {
							tmp += "<span class='label label-success'>Cerrado</span>";
							tmp += '&nbsp;';
							tmp += '<br><br><strong>Responsable: </strong>' + row.usuario;
						} else if (data == 5) {
							tmp +=
								"<span class='label label-success'>Esperando cierre</span>";
							tmp += '&nbsp;';
							tmp += '<br><br><strong>Responsable: </strong>' + row.usuario;
						}
						return tmp;
					},
				},
			],
		});
		tabla.column('0:visible').order('desc').draw();
		return tabla;
	} catch (error) {
		console.log(error);
	}
}
//--------------------------Recuperando la información y visualizandola al actualizar-----------------------------------------------//
function recover_modal_orden_1(id) {
	// subproceso 1 (mantenimiento biomedico)
	var orden = '';
	$.ajax({
		url: base_url + 'orden/Cordenes/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		orden = JSON.parse(data);

		// $(".subproceso_diagnostico").hide();
		$('.subproceso_reparacion').hide();
		$('.subproceso_1').show();
		$('.subproceso_2').hide();

		$('.subproceso_0 input,.subproceso_0 select,.subproceso_0 textarea').attr(
			'disabled',
			'disabled'
		);
		// $(".subproceso_1 input,.subproceso_1 select").attr("disabled",'disabled');
		$('.subproceso_2 input,.subproceso_2 select').attr('disabled', 'disabled');

		$('#form_orden #prioridad').removeAttr('disabled');
		$('.habilitar_input_repuestos').html('');

		$('#equipo_id').val(orden.equipo_id); // orden
		$('#equipo_id').removeAttr('disabled', 'disabled');
		$('#id').val(orden.id); // orden
		$('#nombre_equipo').val(orden.nombre_equipo);
		$('#modelo_equipo').val(orden.modelo_equipo);
		$('#marca_equipo').val(orden.marca_equipo);
		$('#serie_equipo').val(orden.serie_equipo);
		$('#codigo_equipo').val(orden.codigo_equipo);
		$('#servicio_id').val(orden.servicio_id);
		$('#descripcion').val(orden.descripcion);
		$('#asunto').val(orden.asunto);
		$('#prioridad').val(orden.prioridad);

		$('.contenedor_input_diagnostico').show();
		/*
  - Estado_id=Abierto
  - Estado_id=Asignado
  - Estado_id=Diagnosticado
  - Estado_id=Cerrado
  */
		if (orden.estado_id <= 2) {
			// Estado abierto o asignado, se procede a diagnosticar
			$('.contenedor_input_cierre').hide();
			$(
				'.contenedor_input_cierre input,.contenedor_input_cierre textarea,.contenedor_input_cierre select'
			).attr('disabled', 'disabled');

			$(
				'.contenedor_input_diagnostico input,.contenedor_input_diagnostico textarea,.contenedor_input_diagnostico select'
			).removeAttr('disabled');
			$('#fecha_solicitud_repuesto').attr('disabled', 'disabled');
			$('.contenedor_input_diagnostico #diagnostico').val(''); // reset
			$('.contenedor_input_diagnostico #diagnostico_id').val(''); // reset
		} else if (orden.estado_id == 3) {
			// Estado diagnosticado, se procede a cerrar

			$('.control_repuestos').hide();

			$('.contenedor_input_diagnostico #diagnostico').val(''); // reset
			$('.contenedor_input_diagnostico #diagnostico_id').val(''); // reset
			$('.contenedor_input_diagnostico #diagnostico').val(orden.diagnostico); // recover
			$('.contenedor_input_diagnostico #diagnostico_id').val(
				orden.diagnostico_id
			); // recover
			$(
				'.contenedor_input_diagnostico input,.contenedor_input_diagnostico textarea,.contenedor_input_diagnostico select'
			).attr('disabled', 'disabled');

			$('.contenedor_input_cierre').show();
			$(
				'.contenedor_input_cierre input,.contenedor_input_cierre textarea,.contenedor_input_cierre select'
			).removeAttr('disabled');

			$.ajax({
				url: base_url + 'orden/Cordenes/getRepuestos',
				type: 'post',
				data: { id: orden.id },
			}).done(function (data) {
				$repuestos_solicitados = JSON.parse(data);
				var tmp = '';
				tmp +=
					`
						<input class='form-control ' type='hidden' name='id_repuesto[]' id='id_repuesto' value='` +
					item.id +
					`'>
						<table class="table table-sm table-condensed table-hover table-bordered">

						<thead>
							<tr>
								<th>Solicitado</th>
								<th>Fecha solicitud</th>
								<th>Usado</th>
								<th>Fecha de recepción</th>
							</tr>
						</thead>
						<tbody style="text-transform:lowercase;">
						`;

				$.each($repuestos_solicitados, function (i, item) {
					tmp +=
						`
							<tr>

								<td>` +
						item.name +
						`</td>
								<td>` +
						item.fecha_solicitud_repuesto +
						`</td>
								<td><input placeholder=". ` +
						item.name +
						`" class='form-control repuestos_en_cierre' required type='text' name='repuesto_usado[]' id='repuesto_usado'></td>
								<td><input class='form-control repuestos_en_cierre' required type='date' name='fecha_recepcion_repuesto[]' id='fecha_recepcion_repuesto'></td> `;
				});
				tmp += `
						</tbody>
						</table>`;
				$('.repuestos_usados').html('');
				$('.repuestos_usados').html(tmp);
			});
		}
	});
}
function recover_modal_orden_2(id) {
	// subproceso 2 (Mantenimiento Industrial)

	var orden = '';
	$.ajax({
		url: base_url + 'orden/Cordenes/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		orden = JSON.parse(data);

		// $(".subproceso_diagnostico").hide();
		$('.subproceso_reparacion').hide();
		$('.subproceso_1').show();
		$('.subproceso_2').hide();

		$('.subproceso_0 input,.subproceso_0 select,.subproceso_0 textarea').attr(
			'disabled',
			'disabled'
		);
		// $(".subproceso_1 input,.subproceso_1 select").attr("disabled",'disabled');
		$('.subproceso_2 input,.subproceso_2 select').attr('disabled', 'disabled');

		$('#form_orden #prioridad').removeAttr('disabled');
		$('.habilitar_input_repuestos').html('');

		$('#equipo_id').val(orden.equipo_id); // orden
		$('#equipo_id').removeAttr('disabled', 'disabled');
		$('#id').val(orden.id); // orden
		$('#nombre_equipo').val(orden.nombre_equipo);
		$('#modelo_equipo').val(orden.modelo_equipo);
		$('#marca_equipo').val(orden.marca_equipo);
		$('#serie_equipo').val(orden.serie_equipo);
		$('#codigo_equipo').val(orden.codigo_equipo);
		$('#servicio_id').val(orden.servicio_id);
		$('#descripcion').val(orden.descripcion);
		$('#asunto').val(orden.asunto);
		$('#prioridad').val(orden.prioridad);

		$('.contenedor_input_diagnostico').show();
		/*
      - Estado_id=Abierto
      - Estado_id=Asignado
      - Estado_id=Diagnosticado
      - Estado_id=Cerrado
      */
		if (orden.estado_id <= 2) {
			// Estado abierto o asignado, se procede a diagnosticar
			$('.contenedor_input_cierre').hide();
			$(
				'.contenedor_input_cierre input,.contenedor_input_cierre textarea,.contenedor_input_cierre select'
			).attr('disabled', 'disabled');

			$(
				'.contenedor_input_diagnostico input,.contenedor_input_diagnostico textarea,.contenedor_input_diagnostico select'
			).removeAttr('disabled');
			$('#fecha_solicitud_repuesto').attr('disabled', 'disabled');
			$('.contenedor_input_diagnostico #diagnostico').val(''); // reset
			$('.contenedor_input_diagnostico #diagnostico_id').val(''); // reset
		} else if (orden.estado_id == 3) {
			// Estado diagnosticado, se procede a cerrar

			$('.control_repuestos').hide();

			$('.contenedor_input_diagnostico #diagnostico').val(''); // reset
			$('.contenedor_input_diagnostico #diagnostico_id').val(''); // reset
			$('.contenedor_input_diagnostico #diagnostico').val(orden.diagnostico); // recover
			$('.contenedor_input_diagnostico #diagnostico_id').val(
				orden.diagnostico_id
			); // recover
			$(
				'.contenedor_input_diagnostico input,.contenedor_input_diagnostico textarea,.contenedor_input_diagnostico select'
			).attr('disabled', 'disabled');

			$('.contenedor_input_cierre').show();
			$(
				'.contenedor_input_cierre input,.contenedor_input_cierre textarea,.contenedor_input_cierre select'
			).removeAttr('disabled');

			$.ajax({
				url: base_url + 'orden/Cordenes/getRepuestos',
				type: 'post',
				data: { id: orden.id },
			}).done(function (data) {
				$repuestos_solicitados = JSON.parse(data);
				$('.repuestos_usados').html('');
				$('.repuestos_usados').append('<ul>');
				$.each($repuestos_solicitados, function (i, item) {
					$('.repuestos_usados').append(
						'<li>Solicitado: ' +
							item.name +
							' / <strong>Fecha solicitud</strong>: ' +
							item.fecha_solicitud_repuesto
					);
					$('.repuestos_usados').append(
						"<label for='repuesto_usado'>Usado: <label><input class='form-control repuestos_en_cierre' required type='text' name='repuesto_usado[]' id='repuesto_usado'>"
					);
					$('.repuestos_usados').append(
						"<label for='fecha_recepcion_repuesto'>Fecha de recepción: <label><input class='form-control repuestos_en_cierre' required type='date' name='fecha_recepcion_repuesto[]' id='fecha_recepcion_repuesto'>"
					);
					$('.repuestos_usados').append(
						"<input class='form-control ' type='hidden' name='id_repuesto[]' id='id_repuesto' value='" +
							item.id +
							"'>"
					);
					$('.repuestos_usados').append('</li>');
				});
				$('.repuestos_usados').append('</ul>');
			});
		}
	});
}
//--------------------------Actualizando la información al enviar el formulario por ajax-----------------------------------------------//

$('#form_orden').submit(function (e) {
	// Evento para la actualizacion de la orden
	e.preventDefault();
	var formulario = new FormData(this);

	$('#btn_update').attr('disabled', 'disabled');
	$('#mensaje').addClass(
		'glyphicon glyphicon-pencil glyphicon-refresh-animate'
	);
	$('#mensaje').html('Procesando..........');
	$('#modal_edit_orden .close').click();

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
		url: base_url + 'orden/Cordenes/update',
		type: 'POST',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#btn_update').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-pencil glyphicon-refresh-animate'
		);
		if (data == 1) {
			datatable_destroy_orden();
			list_data_table_orden();
			document.getElementById('form_orden').reset();
			$('.errores').html('');
			$.unblockUI();
			notify('edit');
		} else {
			var respuesta = JSON.parse(data);
			var contenido = '';
			contenido =
				'<div class=""><div class="panel panel-danger"><div class="panel-heading">Error</div><div class="panel-body">' +
				respuesta +
				'</div></div></div>';
			// $("#errores").html(respuesta);
			$.unblockUI();
			$.blockUI({ message: contenido });
			setTimeout(function () {
				desbloquear();
			}, 4000);
		}
	});
});
//--------------------------Seleccion entre diagnostico y cierre-----------------------------------------------//
$('input:radio').on('click', function () {
	$('#btn_update').removeAttr('disabled');
	var diagnostico_db = '';
	diagnostico_db = $('#diagnostico_db').val();

	if (this.value == 0) {
		// Realizar diagnostico
		$('.subproceso_diagnostico').show();
		$('.subproceso_reparacion').hide();
		$(
			'.subproceso_diagnostico input,.subproceso_diagnostico select,.subproceso_diagnostico textarea'
		).attr('disabled', false);
		$(
			'.subproceso_reparacion input,.subproceso_reparacion select,.subproceso_reparacion textarea'
		).attr('disabled', 'disabled');

		if ($('#diagnostico').val() == '') {
			$(
				'.subproceso_diagnostico input,.subproceso_diagnostico select,.subproceso_diagnostico textarea'
			).removeAttr('disabled');
		} else {
			// sigue mirar si hay un diagnostico realizado en la base de datos
			if (diagnostico_db == 'null') {
				$(
					'.subproceso_diagnostico input,.subproceso_diagnostico select,.subproceso_diagnostico textarea'
				).attr('disabled', 'disabled');
			}
		}
	} else if (this.value == 1) {
		// Realizar diagnostico y reparación
		if ($('#diagnostico').val() == '') {
			$(
				'.subproceso_diagnostico input,.subproceso_diagnostico select,.subproceso_diagnostico textarea'
			).attr('disabled', false);
		} else {
			$(
				'.subproceso_diagnostico input,.subproceso_diagnostico select,.subproceso_diagnostico textarea'
			).attr('disabled', 'disabled');
		}
		$('.subproceso_diagnostico').show();
		$('.subproceso_reparacion').show();
		$(
			'.subproceso_reparacion input,.subproceso_reparacion select,.subproceso_reparacion textarea'
		).attr('disabled', false);
	}
});
//-------------------------- Asignación de ordenes a responsables-------------------------------------------------//
function ch(id) {
	var confirmacion = confirm(
		'Esta acción asignara la responsabilidad de gestion de la orden a esta cuenta, ¿desea continuar?'
	);

	if (confirmacion == true) {
		var id_orden = id;
		var usuario_id = $('.usuario_id').val();
		$.ajax({
			url: base_url + 'orden/Cordenes/revisar_orden',
			type: 'post',
			data: { id: id_orden },
			cache: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.respuesta == 2) {
				// No hay nadie asignado y se asigna la orden a quien la elija
				asignar_orden_usuario(id, usuario_id);
			} else if (
				respuesta.respuesta == 1 &&
				respuesta.asignado_id != id_usuario
			) {
				notify('usu1');
				$('#tblOrdenes').DataTable().ajax.reload();
			} else if (
				respuesta.respuesta == 1 &&
				respuesta.asignado_id == id_usuario
			) {
				notify('usu2');
				$('#checkbox').prop('checked', true);
			}
		});
	} else {
		alert('no confirmado');
	}
}
function asignar_orden_usuario(id, usuario_id) {
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
		url: base_url + 'orden/Cordenes/asignar_usuario',
		type: 'post',
		data: {
			id: id,
			asignado_id: usuario_id,
		},
	}).done(function (data) {
		var respuesta = JSON.parse(data);

		$.unblockUI();
		if (respuesta.respuesta == 1) {
			// Si se ejecuta la aignacion de usuario exitosmente
			// var id=respuesta.valor1;//id orden
			// var asignado_id=respuesta.valor2;//id del usuario asignado
			datatable_destroy_orden();
			list_data_table_orden();
			notify('edit');
			$.ajax({
				url: base_url + 'orden/Cordenes/email_asignar_usuario',
				type: 'post',
				data: {
					id: id, // Id de la orden para procesar toda la informacion asicada en el correo que se envia
				},
			}).done(function (data2) {
				alert(
					'Se ha enviado un correo electronico con la información del Ticket'
				);
				//$("#checkbox").prop("checked",true);
			});
		} else {
			contenido =
				'<div class=""><div class="panel panel-danger"><div class="panel-heading">Error</div><div class="panel-body">' +
				respuesta.valor +
				'</div></div></div>';
			$.blockUI({ message: contenido });
			setTimeout(function () {
				desbloquear_add_orden();
			}, 3000);
		}
	});
}
//----------------------------------Otros------------------------------------------------------------------//
function datatable_destroy_orden() {
	// destruir data table
	$('#tblOrdenes').dataTable().fnClearTable();
	$('#tblOrdenes').dataTable().fnDestroy();
}
function notify(action = '') {
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
	} else if (action == 'usu1') {
		msj = 'Orden ya seleccionada por otro usuario';
		tipo = 'info';
	} else if (action == 'usu2') {
		msj = 'La orden ya la tienes asignada';
		tipo = 'info';
	}

	$.notify(
		{
			// icon: 'glyphicon glyphicon-user',
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
// $("#add_servicio_id").select2();
function esconder() {
	// esconde icono de imagen cuando se valla a imprimir

	$('.esconder').hide();
}
function mostrar() {
	//muestra icono de imagen nuevamente

	$('.esconder').show();
}
function actualizar_fecha_solicitud(id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/update_fecha_solicitud',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		$('#modal_edit_orden .close').click();
		notify('edit');
	});
}
$('.solicitar_repuestos').on('click', function () {
	$('#fecha_solicitud_repuesto').removeAttr('disabled', 'disabled');
	var tmp = '';
	tmp += `

		<tr>
			<td>
			<ul class="list-inline">
				<li class="list-inline-item">
					<input required='' class='form-control' name='repuestos[]' placeholder='Indique cual es el repuesto a solicitar'>
				</li>
				<li class="list-inline-item">
					<!--<a href="" class="glyphicon glyphicon-remove" ></a>-->
				</li>
			</ul>
			</td>
		</tr>
	`;

	$('.contenedor_repuestos table tbody').append(tmp);
});
$('.eliminar_repuestos').on('click', function () {
	$('.contenedor_repuestos tbody').html('');
});
$('.contenedor_repuestos table tbody a').on('click', function (e) {
	e.preventDefault();
	$(this).remove();
});
function eliminar_uno(e) {
	e.preventDefault();
	$(this).remove();
}
function abrir_modal_edit_orden() {
	$('.abrir_modal_edit_orden').click();
}
function desbloquear() {
	$.unblockUI();
	abrir_modal_edit_orden();
}
function get_id_for_update(param) {
	$('.id').val(param);
}
$('.orden_activa .sede_id,.orden_activa .estado_id').on('change', function () {
	list_data_table_orden();
});

$('.orden_activa .condicion').on('click', function () {
	list_data_table_orden();
});
$('.orden_activa .rango-fechas').on('change', function () {
	if ($('.orden_activa .condicion').is(':checked')) {
		list_data_table_orden();
	}
});
