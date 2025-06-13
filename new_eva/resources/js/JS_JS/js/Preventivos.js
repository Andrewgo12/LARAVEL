/*CRUD PREVENTIVOS*/

$('#form_preventivo').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#btn_add_preventivo').attr('disabled', 'disabled');
	$('#mensaje').addClass(
		'glyphicon glyphicon-refresh glyphicon-refresh-animate'
	);
	$('#mensaje').html('Procesando..........');
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		$('#form_preventivo').trigger('reset');
		$('#modal_add_preventivo .close').click();
		$('#btn_add_preventivo').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);

		funcion_edicion_estado_mantenimiento(respuesta.equipo_id);

		list_preventivos2(respuesta.equipo_id);
		datatable_destroy();
		list_data_table_server_side_filtros();

		if (respuesta.repuesto_pendiente != undefined) {
			// Si al agregar el preventivo se relaciono un repuesto
			funcion_email_preventivo(respuesta.equipo_id, respuesta.preventivo_id);
		}
	});
});
function funcion_edicion_estado_mantenimiento(equipo_id) {
	$.ajax({
		url: base_url + 'equipo/Cequipos/VerificarEstadoMantenimiento',
		type: 'post',
		data: {
			equipo_id: equipo_id,
		},
	}).done(function (data) {
		//alert(data);
	});
}

function funcion_edicion_estado_mantenimiento2(equipo_id) {
	$.ajax({
		url: base_url + 'equipo/Cequipos/VerificarEstadoMantenimiento2',
		type: 'post',
		data: {
			equipo_id: equipo_id,
		},
	}).done(function (data) {
		//alert(data);
	});
}
function funcion_email_preventivo(equipo_id, preventivo_id) {
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/send_email_preventivo',
		type: 'post',
		data: {
			equipo_id: equipo_id,
			preventivo_id: preventivo_id,
		},
	}).done(function (data) {
		alert(
			'Se ha enviado la información del repuesto pendiente a los correos correspondientes'
		);
	});
}
function recover_modal_edit_preventivo(id) {
	//Coloca los datos en el formulario de actualizar

	list_notas_from_preventivo(id);

	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/getOne',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		var preventivo = JSON.parse(data);

		$('#modal_update_preventivo #form_update_preventivo #id').val(
			preventivo.id
		);
		$('#modal_update_preventivo #form_update_preventivo #equipo_id').val(
			preventivo.equipo_id
		);
		$('#modal_update_preventivo #form_update_preventivo #description').val(
			preventivo.description
		);
		$(
			'#modal_update_preventivo #form_update_preventivo #fecha_mantenimiento'
		).val(preventivo.fecha_mantenimiento);
		$(
			'#modal_update_preventivo #form_update_preventivo #proveedor_mantenimiento_id'
		).val(preventivo.proveedor_mantenimiento_id);
		//$("#modal_update_preventivo #form_update_preventivo #fecha_programada").val(preventivo.fecha_programada);
		$('#modal_update_preventivo #form_update_preventivo #observacion').val(
			preventivo.observacion
		);
		if (preventivo.repuesto_pendiente == 'si') {
			$(
				'#modal_update_preventivo #form_update_preventivo #repuesto_pendiente'
			).prop('checked', true);
		} else {
			$(
				'#modal_update_preventivo #form_update_preventivo #repuesto_pendiente'
			).prop('checked', false);
		}
		$('#modal_update_preventivo #form_update_preventivo #repuesto_id').val(
			preventivo.repuesto_id
		);

		// Asocio el id del preventivo en el frmulario de la nota
		$('#modal_add_nota #form_preventivo_nota #preventivo_id').val(
			preventivo.id
		);
	});
}
$('#form_update_preventivo').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#modal_update_preventivo #btn_update_preventivo').attr(
		'disabled',
		'disabled'
	);

	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var equipo_id = respuesta.equipo_id;
		$('#form_update_preventivo').trigger('reset');

		funcion_edicion_estado_mantenimiento(respuesta.equipo_id);
		funcion_edicion_estado_mantenimiento2(respuesta.equipo_id);

		list_preventivos2(equipo_id);
		list_data_table_server_side_filtros();

		$('#modal_update_preventivo #btn_update_preventivo').removeAttr(
			'disabled',
			'disabled'
		);

		if (respuesta.cambio == 'si') {
			funcion_email_preventivo(respuesta.equipo_id, respuesta.preventivo_id);
		}

		$('#modal_update_preventivo .close').click();
	});
});
function delete_preventivo(id, equipo_id, e) {
	e.preventDefault();
	var confirmacion = '';
	confirmacion = confirm(
		'Esta a punto de elemininar el preventivo referenciado, desea proceder?'
	);
	if (confirmacion) {
		// $.blockUI({message:"Procesando"});

		$.ajax({
			url: base_url + 'preventivo/Cpreventivos/delete',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			$('#modal_update_equipo .tblPreventivos tbody').html('');

			$.ajax({
				url: base_url + 'preventivo/Cpreventivos/getLast',
				type: 'post',
				data: { equipo_id: equipo_id },
			}).done(function (data2) {
				var resultado2 = JSON.parse(data2);
				var contenedor_fecha_preventivo = '.contenedor_preventivo_' + equipo_id;
				var contenedor_archivo_preventivo =
					'.contenedor_archivo_preventivo_' + equipo_id;

				if (resultado2 != null && resultado2.fecha_mantenimiento != null) {
					$(contenedor_fecha_preventivo).html(resultado2.fecha_mantenimiento);
				} else {
					$(contenedor_fecha_preventivo).html('');
				}
				if (resultado2 != null && resultado2.file != null) {
					$(contenedor_archivo_preventivo).html(
						"<a target='__blank' href='" +
							base_url +
							'assets/upload_preventivos/' +
							resultado2.file +
							"' class='tamanio btn btn-warning glyphicon glyphicon-file' ></a>"
					);
				} else {
					$(contenedor_archivo_preventivo).html('');
				}

				funcion_edicion_estado_mantenimiento(equipo_id);
				funcion_edicion_estado_mantenimiento2(equipo_id);
				list_preventivos2(equipo_id);
				list_data_table_server_side_filtros();
			});
		});
	} else {
		alert('Acción cancelada');
	}
}
function list_preventivos(id) {
	// El que aparece en el detalle de la hoja de vida
	var preventivos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		preventivos = JSON.parse(data);
		$.each(preventivos, function (i, item) {
			tmp +=
				`<tr style='text-transform:uppercase'>
			<td  colspan="18.17" height="27" class="xl18926419" width="82" style="border-right:.5pt solid black;height:20.25pt;
			width:61pt">` +
				item.description +
				`</td>
			<td colspan="18.17" class="xl18526419" width="63" style="width:48pt">` +
				item.fecha_mantenimiento +
				` <span title='Numero de notas asociadas al preventivo' class="badge nro_notas">` +
				item.nro_notas +
				`</span> </td>
			<td colspan="18.17" class="xl20126419" width="348" style="border-right:.5pt solid black;
			width:263pt">`;
			if (item.repuesto_pendiente == 'si') {
				tmp +=
					`<span style="color:red;" class="glyphicon glyphicon-pencil" title="` +
					item.repuesto_id +
					`">RP</span>`;
			}
			if (item.file != null && item.file != '') {
				tmp +=
					`
				<div class='esconder'>
					<a  target='_blank' href='` +
					base_url +
					`assets/upload_preventivos/` +
					item.file +
					`' class='btn bnt-info'>
						<span class='glyphicon glyphicon-file esconder'></span>
					</a>`;
				if (item.observacion != null && item.observacion != '') {
					tmp +=
						`
					<blockquote>
						<ul class="list-inline">
							<li class="list-inline-item">
								<strong>Observación:</strong>		
							</li>	
							<li class="list-inline-item">
								<span class="text-muted" style="font-size:15px;">` +
						item.observacion +
						`</span>
							</li>	
						</ul>
					</blockquote>`;
				}
				tmp += `		
				</div>	
				`;
			} else {
				if (item.observacion != null && item.observacion != '') {
					tmp +=
						`
					<blockquote>
						<ul class="list-inline">
							<li class="list-inline-item">
								<strong>Observación:</strong>		
							</li>	
							<li class="list-inline-item">
								<span class="text-muted" style="font-size:15px;">` +
						item.observacion +
						`</span>
							</li>	
						</ul>
					</blockquote>`;
				}
			}
			tmp += `</td>
			<td class="xl1526419"></td>
		`;
			tmp += '</tr>';
		});

		$('#contenedor_detalle_equipo .apendice_preventivo').append(tmp);
	});
}
function list_preventivos2(id) {
	var preventivos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		preventivos = JSON.parse(data);
		$.each(preventivos, function (i, item) {
			tmp += "<tr style='text-transform:uppercase'>";
			// tmp+="<td>"+item.id+"</td>";
			tmp += '<td>' + item.description + '</td>';
			tmp +=
				'<td>' +
				item.fecha_mantenimiento +
				"<span title='Numero de notas asociadas al preventivo' class='badge nro_notas'>" +
				item.nro_notas +
				'</span></td>';
			// tmp+="<td>"+item.fecha_programada+"</td>";
			if (item.file != null) {
				tmp +=
					"<td class='esconder'><a  target='_blank' href='" +
					base_url +
					'assets/upload_preventivos/' +
					item.file +
					"' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></a>";
				if (item.observacion != null && item.observacion != '') {
					tmp +=
						"<br><span style='font-size:15px;font-weight:800;'>" +
						item.observacion +
						'</span>';
				}
				tmp += '</td>';
			} else {
				tmp += "<td class='esconder'>";
				if (item.observacion != null && item.observacion != '') {
					tmp +=
						"<br><span style='font-size:15px;font-weight:800;'>" +
						item.observacion +
						'</span>';
				}

				tmp += '</td>';
			}
			if (item.repuesto_pendiente == 'si') {
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_preventivo' onClick='recover_modal_edit_preventivo(" +
					item.id +
					")' class='btn btn-danger glyphicon glyphicon-pencil' style='font-size:15px;padding:5px;'>rp</a>" +
					'</td>';
			} else {
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_preventivo' onClick='recover_modal_edit_preventivo(" +
					item.id +
					")' class='btn btn-success glyphicon glyphicon-pencil' style='font-size:15px;padding:5px;'></a>" +
					'</td>';
			}
			tmp +=
				"<td class='esconder'>" +
				"<a onClick='delete_preventivo(" +
				item.id +
				',' +
				item.equipo_id +
				",event)' class='btn btn-warning glyphicon glyphicon-minus' style='font-size:15px;padding:5px;'></a>" +
				'</td>';
			tmp += '</tr>';
		});
		$('#modal_update_equipo .tblPreventivos tbody').html(tmp);
	});
}
function funcion_modal_preventivos(e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/show',
		type: 'post',
		data: { id: 1 },
	}).done(function (data) {
		$('#modal_preventivos .modal-body').html(data);
		$('.datatable-preventivos').dataTable();
		$('.nav-tabs a').click(function () {
			$(this).tab('show');
		});
		get_fechas_validas_ejecucion();
	});
}
function get_fechas_validas_ejecucion() {
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/get_fechas_validas_ejecucion',
		type: 'post',
		data: {},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = "<option value=''>------</option>";
		$.each(respuesta, function (i, registro) {
			tmp +=
				`
				<option>` +
				registro.fecha_efectiva +
				`</option>
			`;
		});
		$('#modal_preventivos #exportar .fecha_preventivos').html(tmp);
	});
}
$('#modal_add_nota #form_preventivo_nota').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/add_nota',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var preventivo_id = JSON.parse(data);
		list_notas_from_preventivo(preventivo_id);
	});
});
function crear_tabla_notas() {
	$('#modal_update_preventivo .notas').html();
	var tabla_notas = `
			<table class='tabla_notas table table-bordered'>
				<thead>
					<tr>
						<th>Nota</th>
						<th>Quien registra</th>
						<th>Fecha</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			<table>
		`;
	$('#modal_update_preventivo .notas').html(tabla_notas);
}
function list_notas_from_preventivo(preventivo_id) {
	$.ajax({
		url: base_url + 'preventivo/Cpreventivos/get_notas_from_preventivo',
		type: 'post',
		data: { preventivo_id: preventivo_id },
	}).done(function (data) {
		var notas = JSON.parse(data);
		var tmp = '';
		if (notas != '') {
			crear_tabla_notas();
			$.each(notas, function (i, nota) {
				tmp += `<tr>`;
				tmp += `<td>` + nota.description + `</td>`;
				tmp += `<td>` + nota.nombre_usuario + `(` + nota.alias + `)</td>`;
				tmp += `<td>` + nota.fecha_nota + `</td>`;
				tmp += `</tr>`;
			});
			$('#modal_update_preventivo .tabla_notas tbody').html(tmp);
			$('#modal_add_nota #form_preventivo_nota').trigger('reset');
			$('#modal_add_nota .close').click();
		}
	});
}
