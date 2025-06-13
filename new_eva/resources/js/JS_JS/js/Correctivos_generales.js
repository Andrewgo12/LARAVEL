/*CRUD CORRECTIVOS GENERAL*/
$('#form_correctivo_general').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#btn_add_correctivo_general').attr('disabled', 'disabled');
	$('#mensaje').addClass(
		'glyphicon glyphicon-refresh glyphicon-refresh-animate'
	);
	$('#mensaje').html('Procesando..........');
	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		$('#form_correctivo_general').trigger('reset');
		$('#modal_add_correctivo_general .close').click();
		$('#btn_add_correctivo_general').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		list_correctivos_generales(respuesta.equipo_id);
		list_correctivos_generales2(respuesta.equipo_id);
		list_equipo_repuestos2(respuesta.equipo_id); //refresca la tabla de equipo repuestos
		list_data_table_server_side_filtros();
		if (respuesta.repuesto_pendiente != undefined) {
			// Si al agregar el correctivo general se relaciono un repuesto
			funcion_email_correctivo_general(
				respuesta.equipo_id,
				respuesta.correctivo_general_id
			);
		}
	});
});
function funcion_email_correctivo_general(equipo_id, correctivo_general_id) {
	$.ajax({
		url:
			base_url +
			'correctivo_general/Ccorrectivos_generales/send_email_correctivo_general',
		type: 'post',
		data: {
			equipo_id: equipo_id,
			correctivo_general_id: correctivo_general_id,
		},
	}).done(function (data) {
		alert(
			'Se ha enviado la información del repuesto pendiente a los correos correspondientes'
		);
	});
}
function recover_modal_edit_correctivo_general(id) {
	//Coloca los datos en el formulario de actualizar
	clear_repuestos_pendientes();
	$('#modal_correctivos .close').click();
	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/getOne',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		list_equipo_repuestos_correctivo_general(id);
		let correctivo_general = JSON.parse(data);
		set_repuestos_pendientes(correctivo_general.id);
		$('#form_repuesto_correctivo_general #correctivo_general_id').val(
			correctivo_general.id
		);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #id'
		).val(correctivo_general.id);
		list_avances_correctivos(
			$(
				'#modal_update_correctivo_general #form_update_correctivo_general #id'
			).val()
		);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #equipo_id'
		).val(correctivo_general.equipo_id);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #code'
		).val(correctivo_general.code);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #description'
		).val(correctivo_general.description);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #fecha_mantenimiento'
		).val(correctivo_general.fecha_mantenimiento_date);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #hora_mantenimiento'
		).val(correctivo_general.fecha_mantenimiento_hora);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #code_orden'
		).val(correctivo_general.code_orden);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #orden'
		).val(correctivo_general.orden);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #fecha_inicio'
		).val(correctivo_general.fecha_inicio_date);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #hora_orden'
		).val(correctivo_general.fecha_inicio_hora);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #cierre_id'
		).val(correctivo_general.cierre_id);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #tipo_falla_id'
		).val(correctivo_general.tipo_falla_id);
		if (correctivo_general.repuesto_pendiente == 'si') {
			$(
				'#modal_update_correctivo_general #form_update_correctivo_general #repuesto_pendiente'
			).removeAttr('disabled', 'disabled');
			$(
				'#modal_update_correctivo_general #form_update_correctivo_general #repuesto_pendiente'
			).prop('checked', true);
		} else {
			$(
				'#modal_update_correctivo_general #form_update_correctivo_general #repuesto_pendiente'
			).prop('checked', false);
		}
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #repuesto_id'
		).val(correctivo_general.repuesto_id); // repuesto pendiente
		var valor_codigo_cierre = $(
			'#modal_update_correctivo_general #form_update_correctivo_general #code'
		).val();
		var valor_descripcion_cierre = $(
			'#modal_update_correctivo_general #form_update_correctivo_general #description'
		).val();
	});
}
$('#form_update_correctivo_general').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#form_update_correctivo_general #btn_update_correctivo_general').attr(
		'disabled',
		'disabled'
	);

	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		$('#form_update_preventivo #fecha_mantenimiento').trigger('reset');
		$('.containerrep').html('');
		counter = 0;
		set_repuestos_pendientes(1);
		list_correctivos_generales(respuesta.equipo_id);
		list_correctivos_generales2(respuesta.equipo_id);
		list_cierres_from_correctivos_generales();
		list_data_table_server_side_filtros();
		$(
			'#form_update_correctivo_general #btn_update_correctivo_general'
		).removeAttr('disabled', 'disabled');
		if (respuesta.cambio == 'si') {
			funcion_email_correctivo_general(
				respuesta.equipo_id,
				respuesta.correctivo_general_id
			);
		}
		$('#modal_update_correctivo_general .close').click();
	});
});
function delete_correctivo_general(id, equipo_id) {
	var confirmacion = '';
	confirmacion = confirm(
		'Esta a punto de elminar el registro de Correctivo, Desea proceder?'
	);
	if (confirmacion) {
		$.ajax({
			url: base_url + 'correctivo_general/Ccorrectivos_generales/delete',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			list_correctivos_generales(equipo_id);
			list_correctivos_generales2(equipo_id);
			list_data_table_server_side_filtros();
		});
	}
}
/*Fin del CRUD*/
function reset_form_add_correctivos() {
	$('#modal_add_correctivo_general #form_correctivo_general').trigger('reset');
	$('.cierre_id').val(14);
}
function list_correctivos_generales(id) {
	//listado de correctivos en la hoja de vida

	var correctivos_generales = '';
	var correctivos_generales_archivos = '';
	var personalizado = '';
	var tmp = '';
	var tmp2 = '';
	var contador = 0;
	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		correctivos_generales = JSON.parse(data);
		$('.clarear_div').html('');

		$.each(correctivos_generales, function (i, item) {
			if (item.code_orden == null || item.code_orden == '') {
				item.code_orden = ' NO REGISTRA';
			}
			if (item.orden == null || item.orden == '') {
				item.orden = ' NO REGISTRA';
			}
			if (
				item.fecha_inicio == null ||
				item.fecha_inicio == '0000-00-00 00:00:00'
			) {
				item.fecha_inicio = ' NO REGISTRA';
			}
			if (item.code_diagnostico == null || item.code_diagnostico == '') {
				item.code_diagnostico = ' NO REGISTRA';
			}
			if (item.diagnostico == null || item.diagnostico == '') {
				item.diagnostico = ' NO REGISTRA';
			}
			if (
				item.fecha_diagnostico == null ||
				item.fecha_diagnostico == '0000-00-00 00:00:00'
			) {
				item.fecha_diagnostico = ' NO REGISTRA';
			}
			if (item.code == null || item.code == '') {
				item.code = ' NO REGISTRA';
			}
			if (item.description == null || item.description == '') {
				item.description = ' NO REGISTRA';
			}
			if (
				item.fecha_mantenimiento == null ||
				item.fecha_mantenimiento == '0000-00-00 00:00:00'
			) {
				item.fecha_mantenimiento = ' NO REGISTRA';
			}
			tmp +=
				`
						<tr height="27" style="mso-height-source:userset;height:20.25pt" >
							<td  colspan="18.17" height="27" class="xl18926419" width="82" style="border-right:.5pt solid black;height:20.25pt;
							width:61pt">
							<ul class="list-inline">
								<li class="list-inline-item">
									<span class='esconder'>
										<a style='font-size:15px;' data-target='#modal_show_single_correctivo' data-toggle='modal' onClick='funcion_detail_correctivo(` +
				item.id +
				`,event)' class='btn btn-primary glyphicon glyphicon-search' style='padding:5px;'></a>
									</span>
									<strong >Numero de Orden:</strong><span style='color:green;'>` +
				item.code_orden +
				`</span>
								</li>
								<li class="list-inline-item"></li>		
								<li class="list-inline-item">Fecha orden:<span style="font-size:15px;font-weight:900;" class="text-muted">` +
				item.fecha_inicio +
				`</span></li>		
							</ul>
							<blockquote>
								<strong>Descripción de la Orden</strong>
								<p>
									<div style="font-size:15px;" class="text-muted limitado1` +
				item.id +
				`">
										` +
				item.orden +
				`
									</div>	
								</p>
							</blockquote>	
							</td>
							<td colspan="18.17" class="xl18526419" width="63" style="width:48pt">
											`;
			if (item.notas_avance != 0) {
				tmp +=
					"Notas de avance <div class='badge'>" + item.notas_avance + '</div>';
			}
			if (item.repuesto_pendiente == 'si') {
				tmp +=
					`<span style="color:red;" class="glyphicon glyphicon-pencil" title="` +
					item.repuesto_id +
					`">RP</span><br />`;
			}
			switch (item.codigo_cierre) {
				case 'CI014':
					tmp += `<span style="color:red;font-size:30px;" title="Orden Abierta" class="glyphicon glyphicon-folder-open"></span>`;
					break;
				case 'CI015':
					tmp += `<span style="color:#a7d69e;font-size:30px;" title="Orden Cerrada" class="glyphicon glyphicon-thumbs-up"></span>`;
					tmp +=
						'<strong>Retro cierre</strong>:' +
						item.code +
						'<br><blockquote><strong>Descripción</strong>: <div style="font-size:15px;" class="text-muted limitado3' +
						item.id +
						'">' +
						item.description +
						'</div><br><footer class="footer-blockquote"><cite>' +
						item.fecha_mantenimiento +
						'</cite></footer></blockquote><strong><br><strong>Estado de la orden:</strong><span style="color:#a7d69e;font-weight:900;" title="' +
						item.descripcion_codigo +
						'">Cerrada</span>';
					break;
				case 'CI016':
					tmp += `<span style="color:#f48024;font-size:35px;" title="Orden Cerrada" class="fa fa-trash"></span>`;
					tmp +=
						'<strong>Retro cierre</strong>:' +
						item.code +
						'<br><blockquote><strong>Descripción</strong>: <div style="font-size:15px;" class="text-muted limitado3' +
						item.id +
						'">' +
						item.description +
						'</div><br><footer class="footer-blockquote"><cite>' +
						item.fecha_mantenimiento +
						'</cite></footer></blockquote><strong><br><strong>Estado de la orden:</strong><span style="color:#f48024;font-weight:900;" title="' +
						item.descripcion_codigo +
						'">Cerrada por baja</span>';

					break;
				case null:
					'NO REGISTRA';
					tmp += `<span style="color:#3e867c;font-size:30px;" title="Pendiente verificar la orden" class="fa fa-bullhorn"></span>`;
					break;
				case '':
					'NO REGISTRA';
				default:
					tmp +=
						'<strong>Retro cierre</strong>:' +
						item.code +
						'<br><blockquote><strong>Descripción</strong>: <div style="font-size:15px;" class="text-muted limitado3' +
						item.id +
						'">' +
						item.description +
						'</div><br><footer class="footer-blockquote"><cite>' +
						item.fecha_mantenimiento +
						'</cite></footer></blockquote><strong><br><strong>Estado de la orden:</strong><span style="color:blue;font-weight:900;" title="' +
						item.descripcion_codigo +
						'">' +
						item.codigo_cierre +
						'</span>';
			}
			tmp +=
				`
							</td>
							<td colspan="18.17" class="xl20126419 clarear_div tmp_` +
				item.id +
				`" width="348" style="border-right:.5pt solid black;
							width:263pt">
							 </td>
							<td class="xl1526419"></td>
						</tr>	
			`;
			$.ajax({
				url: base_url + 'equipo/Cequipos/getArchivosCorrectivosGenerales',
				type: 'post',
				data: { correctivo_general_id: item.id },
			}).done(function (data2) {
				correctivos_generales_archivos = JSON.parse(data2);
				$.each(correctivos_generales_archivos, function (j, resultado) {
					tmp2 +=
						"<a title='" +
						resultado.titulo +
						"' target='_blank' href='" +
						base_url +
						'assets/upload_correctivos_generales/' +
						resultado.file +
						"' class='btn bnt-info'><span class='glyphicon glyphicon-file esconder'></span></a>";
					contador = contador + 1;
					if (contador % 4 == 0) {
						tmp2 += '<br>';
					}
					personalizado = resultado.id_personalizado;
				});
				contador = 0;
				$(personalizado).html(tmp2);
				tmp2 = '';
			});
		});
		$('#contenedor_detalle_equipo .apendice_correctivo_general').append(tmp);
	});
}
function list_correctivos_generales2(id) {
	//listado de correctivos en la edición
	var correctivos_generales = '';
	var correctivos_generales_archivos = '';
	var personalizado = '';
	var tmp = '';
	var tmp2 = '';
	var contador = 0;
	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		correctivos_generales = JSON.parse(data);
		$('.clarear_div').html('');

		$.each(correctivos_generales, function (i, item) {
			if (item.code_orden == null || item.code_orden == '') {
				item.code_orden = ' NO REGISTRA';
			}
			if (item.orden == null || item.orden == '') {
				item.orden = ' NO REGISTRA';
			}
			if (
				item.fecha_inicio == null ||
				item.fecha_inicio == '0000-00-00 00:00:00'
			) {
				item.fecha_inicio = ' NO REGISTRA';
			}
			if (item.code_diagnostico == null || item.code_diagnostico == '') {
				item.code_diagnostico = ' NO REGISTRA';
			}
			if (item.diagnostico == null || item.diagnostico == '') {
				item.diagnostico = ' NO REGISTRA';
			}
			if (
				item.fecha_diagnostico == null ||
				item.fecha_diagnostico == '0000-00-00 00:00:00'
			) {
				item.fecha_diagnostico = ' NO REGISTRA';
			}
			if (item.code == null || item.code == '') {
				item.code = ' NO REGISTRA';
			}
			if (item.description == null || item.description == '') {
				item.description = ' NO REGISTRA';
			}
			if (
				item.fecha_mantenimiento == null ||
				item.fecha_mantenimiento == '0000-00-00 00:00:00'
			) {
				item.fecha_mantenimiento = ' NO REGISTRA';
			}
			tmp += '<tr>';
			tmp +=
				`
				<td>
				<span class="esconder">
					<a style='font-size:15px;' data-target='#modal_show_single_correctivo' data-toggle='modal' onClick='funcion_detail_correctivo(` +
				item.id +
				`,event)' class='btn btn-primary glyphicon glyphicon-search' style='padding:5px;'></a>
				</span>
					<strong>Numero de orden</strong>:` +
				item.code_orden +
				`<br>
					<blockquote>
						<strong>Descripción:</strong>
						<small><span style="font-size:15px;" class="text-muted"><div class="limitado1` +
				item.id +
				`">` +
				item.orden +
				`</div></span></small>
						<footer class="footer-blockquote"><cite>` +
				item.fecha_inicio +
				`</cite></footer>						
					</blockquote>
				</td>
			`;
			tmp += '<td>';
			if (item.notas_avance != 0) {
				tmp +=
					`Notas de avance <div class='badge'>` +
					item.notas_avance +
					`</div><br>
				<strong>Ultimo avance</strong>: ` +
					item.last_description;
			}
			switch (item.codigo_cierre) {
				case 'CI014':
					tmp += `<span style="color:red;font-size:30px;" title="Orden Abierta" class="glyphicon glyphicon-folder-open"></span>`;
					break;
				case 'CI015':
					tmp += `<span style="color:#a7d69e;font-size:30px;" title="Orden Cerrada" class="glyphicon glyphicon-thumbs-up"></span>`;
					tmp +=
						'<strong>Retro cierre</strong>:' +
						item.code +
						'<br><blockquote><strong>Descripción</strong>: <div style="font-size:15px;" title="' +
						item.description +
						'" class="text-muted limitado3' +
						item.id +
						'">' +
						item.description +
						'</div><br><footer class="footer-blockquote"><cite>' +
						item.fecha_mantenimiento +
						'</cite></footer></blockquote><strong><br><strong>Estado de la orden:</strong><span style="color:#a7d69e;font-weight:900;" title="' +
						item.descripcion_codigo +
						'">Cerrada</span>';
					break;
				case 'CI016':
					tmp += `<span style="color:#f48024;font-size:35px;" title="Orden Cerrada" class="fa fa-trash"></span>`;
					tmp +=
						'<strong>Retro cierre</strong>:' +
						item.code +
						'<br><blockquote><strong>Descripción</strong>: <div style="font-size:15px;" title="' +
						item.description +
						'" class="text-muted limitado3' +
						item.id +
						'">' +
						item.description +
						'</div><br><footer class="footer-blockquote"><cite>' +
						item.fecha_mantenimiento +
						'</cite></footer></blockquote><strong><br><strong>Estado de la orden:</strong><span style="color:#f48024;font-weight:900;" title="' +
						item.descripcion_codigo +
						'">Cerrada por baja</span>';
					break;
				case null:
					'NO REGISTRA';
					tmp += `<span style="color:#3e867c;font-size:30px;" title="Pendiente verificar la orden" class="fa fa-bullhorn"></span>`;
					break;
				case '':
					'NO REGISTRA';
				default:
					tmp +=
						'<strong>Retro cierre</strong>:' +
						item.code +
						'<br><blockquote><strong>Descripción</strong>: <div style="font-size:15px;" title="' +
						item.description +
						'" class="text-muted limitado3' +
						item.id +
						'">' +
						item.description +
						'</div><br><footer class="footer-blockquote"><cite>' +
						item.fecha_mantenimiento +
						'</cite></footer></blockquote><strong><br><strong>Estado de la orden:</strong><span style="color:blue;font-weight:900;" title="' +
						item.descripcion_codigo +
						'">' +
						item.codigo_cierre +
						'</span>';
			}
			tmp += '</td>';
			tmp +=
				"<td ><a data-toggle='modal' data-target='#modal_add_archivo_correctivo' onClick='modalArchivoCorrectivoGeneral(" +
				item.id +
				',' +
				item.equipo_id +
				")' class='btn btn-default'>Agregar Archivo</a><div class='clarear_div tmp_" +
				item.id +
				"'></div>";
			tmp += '</td>';
			$.ajax({
				url: base_url + 'equipo/Cequipos/getArchivosCorrectivosGenerales',
				type: 'post',
				data: { correctivo_general_id: item.id },
			}).done(function (data2) {
				correctivos_generales_archivos = JSON.parse(data2);
				$.each(correctivos_generales_archivos, function (j, resultado) {
					tmp2 +=
						"<a title='" +
						resultado.titulo +
						"' target='_blank' href='" +
						base_url +
						'assets/upload_correctivos_generales/' +
						resultado.file +
						"' class='btn bnt-info'><span class='glyphicon glyphicon-file esconder'></span></a><a href='#' onClick='delete_archivo_correctivo_general(" +
						resultado.id +
						',event,' +
						id +
						")'>(-)</a>";
					contador = contador + 1;
					if (contador % 4 == 0) {
						tmp2 += '<br>';
					}
					personalizado = resultado.id_personalizado;
				});
				contador = 0;
				$(personalizado).html(tmp2);
				tmp2 = '';
			});
			if (item.repuesto_pendiente == 'si') {
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_correctivo_general' onClick='recover_modal_edit_correctivo_general(" +
					item.id +
					")' class='btn btn-danger glyphicon glyphicon-pencil' style='padding:5px;'>rp</a>" +
					'</td>';
			} else {
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_correctivo_general' onClick='recover_modal_edit_correctivo_general(" +
					item.id +
					")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>" +
					'</td>';
			}
			tmp +=
				"<td class='esconder'>" +
				"<a onClick='delete_correctivo_general(" +
				item.id +
				',' +
				item.equipo_id +
				")' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>" +
				'</td>';
			tmp += '</tr>';
		});
		$('#form_update_equipo .tblCorrectivosGenerales tbody').html(tmp);
	});
}
$('#modal_add_correctivo_general #form_correctivo_general #code').on(
	'keyup',
	function () {
		var valor_codigo_cierre = $(
			'#modal_add_correctivo_general #form_correctivo_general #code'
		).val();
		var valor_descripcion_cierre = $(
			'#modal_add_correctivo_general #form_correctivo_general #description'
		).val();
		if (valor_codigo_cierre != '' && valor_descripcion_cierre != '') {
			$(
				'#modal_add_correctivo_general #form_correctivo_general #cierre_id'
			).removeAttr('disabled', 'disabled');
		} else {
			$(
				'#modal_add_correctivo_general #form_correctivo_general #cierre_id'
			).attr('disabled', 'disabled');
		}
	}
);
$('#modal_add_correctivo_general #form_correctivo_general #description').on(
	'keyup',
	function () {
		var valor_codigo_cierre = $(
			'#modal_add_correctivo_general #form_correctivo_general #code'
		).val();
		var valor_descripcion_cierre = $(
			'#modal_add_correctivo_general #form_correctivo_general #description'
		).val();
		if (valor_codigo_cierre != '' && valor_descripcion_cierre != '') {
			$(
				'#modal_add_correctivo_general #form_correctivo_general #cierre_id'
			).removeAttr('disabled', 'disabled');
		} else {
			$(
				'#modal_add_correctivo_general #form_correctivo_general #cierre_id'
			).attr('disabled', 'disabled');
		}
	}
);
function funcion_modal_correctivos(e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/show',
		type: 'post',
		data: { id: 1 },
	}).done(function (data) {
		$('#modal_correctivos .modal-body').html(data);
		$('.datatable-correctivos').dataTable();
	});
}
function funcion_detail_correctivo(correctivo_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'correctivo_general/Ccorrectivos_generales/show_one',
		type: 'post',
		data: { id: correctivo_id },
	}).done(function (data) {
		$('#modal_show_single_correctivo .modal-body').html(data);
	});
}
