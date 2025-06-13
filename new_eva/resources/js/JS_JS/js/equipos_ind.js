$(function () {
	tablaequipos();
	buscadores();
	botones_modales();
	insertar();
	update();
});

/*CRUD PREVENTIVOS*/
$('#form_preventivo_ind').submit(function (e) {
	e.preventDefault();
	var tmp = '';
	var formulario = new FormData(this);
	$('#btn_add_preventivo').attr('disabled', 'disabled');
	$('#mensaje').addClass(
		'glyphicon glyphicon-refresh glyphicon-refresh-animate'
	);
	$('#mensaje').html('Procesando..........');

	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/addPreventivo',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		preventivos = JSON.parse(data);
		$('#form_preventivo_ind #fecha_mantenimiento').val('');
		$('#form_preventivo_ind #fecha_programada').val('');
		$('#form_preventivo_ind #description').val('');
		$('#modal_add_preventivo_ind .close').click();
		$('#btn_add_preventivo_ind').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#form_preventivo_ind').modal('hide');
		$('#formulario_update').modal('hide');
		$('#tbpreventivo tbody').html('');
		list_preventivos(JSON.parse(data));
	});
});

function list_preventivos(id) {
	var preventivos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getPreventivos',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		preventivos = JSON.parse(data);
		if (preventivos == 2) {
			$('#text_p').html('No se registran preventivos');
			$('#tbpreventivo  tbody').html('');
		} else {
			$.each(preventivos, function (i, item) {
				tmp +=
					'<tr height="27" style="mso-height-source:userset;height:20.25pt" >';
				tmp +=
					'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
					item.id +
					'</td>';
				tmp +=
					'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
					item.description +
					'</td>';
				tmp +=
					'<td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;width:200pt">' +
					item.fecha_mantenimiento +
					'</td>';
				tmp +=
					'<td colspan="13" class="xl18526419" width="63" style="width:48pt">' +
					item.fecha_programada +
					'</td>';
				if (item.file != null && item.file != '') {
					tmp +=
						"<td colspan='10' class='xl20126419' width='348' style='border-right:.5pt solid black;width:263pt'><div class='esconder'><a  target='_blank' href='" +
						base_url +
						'assets/upload_preventivos/' +
						item.file +
						"' class='btn bnt-info'><span class='glyphicon glyphicon-file esconder'></span></div></a></td><td class='xl1526419'></td>";
				} else {
					tmp +=
						'<td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;width:263pt">No Registra</td><td class="xl1526419"></td>';
				}
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_preventivo' onClick='recover_modal_edit_preventivo(" +
					item.id +
					")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>" +
					'</td>';
				tmp +=
					"<td class='esconder'>" +
					"<a onClick='delete_preventivo(" +
					item.id +
					',' +
					item.equipo_id +
					",event)' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>" +
					'</td>';
				tmp += '</tr>';
			});
			$('#text_p').html('');
			$('#tbpreventivo tbody').html('');
			$('#tbpreventivo tbody').append(tmp);
		}
	});
}

function recover_modal_edit_preventivo(id) {
	//Coloca los datos en el formulario de actualizar
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getOnePreventivo',
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
		$('#modal_update_preventivo #form_update_preventivo #fecha_programada').val(
			preventivo.fecha_programada
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
		url: base_url + 'equipos_ind/Cequipos_ind/updatePreventivo',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var equipo_id = JSON.parse(data);
		$('#form_update_preventivo #fecha_mantenimiento').val('');
		$('#form_update_preventivo #fecha_programada').val('');
		$('#form_update_preventivo #description').val('');

		$.ajax({
			url: base_url + 'equipos_ind/Cequipos_ind/getLastPreventivo',
			type: 'post',
			data: { equipo_id: equipo_id },
		}).done(function (data2) {
			var resultado2 = JSON.parse(data2);
			var contenedor_fecha_preventivo = '.contenedor_preventivo_' + equipo_id;
			var contenedor_archivo_preventivo =
				'.contenedor_archivo_preventivo_' + equipo_id;

			$(contenedor_fecha_preventivo).html(resultado2.fecha_mantenimiento);
			$(contenedor_archivo_preventivo).html(
				"<a target='__blank' href='" +
					base_url +
					'assets/upload_preventivos/' +
					resultado2.file +
					"' class='tamanio btn btn-warning glyphicon glyphicon-file' ></a>"
			);
		});
		list_preventivos(JSON.parse(data));

		$('#modal_update_preventivo #btn_update_preventivo').removeAttr(
			'disabled',
			'disabled'
		);
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
		$.ajax({
			url: base_url + 'equipos_ind/Cequipos_ind/deletePreventivo',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			$('#tbpreventivo tbody').html('');

			$.ajax({
				url: base_url + 'equipos_ind/Cequipos_ind/getLastPreventivo',
				type: 'post',
				data: { equipo_id: equipo_id },
			}).done(function (data2) {
				var resultado2 = JSON.parse(data2);
				var contenedor_fecha_preventivo = '.contenedor_preventivo_' + equipo_id;
				var contenedor_archivo_preventivo =
					'.contenedor_archivo_preventivo_' + equipo_id;

				alert(contenedor_fecha_preventivo);
				if (resultado2.fecha_mantenimiento != null) {
					$(contenedor_fecha_preventivo).html(resultado2.fecha_mantenimiento);
				} else {
					$(contenedor_fecha_preventivo).html('');
				}
				if (resultado2.file != null) {
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
			});
			list_preventivos(equipo_id);
		});
	} else {
		alert('Acción cancelada');
	}
}

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
		url: base_url + 'equipos_ind/Cequipos_ind/addCorrectivoGeneral',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#form_correctivo_general #fecha_mantenimiento').val('');
		$('#form_correctivo_general #description').val('');
		$('#form_correctivo_general #code').val('');
		$('#modal_add_correctivo_general .close').click();
		$('#btn_add_correctivo_general').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		list_correctivos(JSON.parse(data));
	});
});

function recover_modal_edit_correctivo_general(id) {
	//Coloca los datos en el formulario de actualizar
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getOneCorrectivoGeneral',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		var correctivo_general = JSON.parse(data);

		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #id'
		).val(correctivo_general.id);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #equipo_id'
		).val(correctivo_general.equipo_id);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #description'
		).val(correctivo_general.description);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #fecha_mantenimiento'
		).val(correctivo_general.fecha_mantenimiento);
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general #code'
		).val(correctivo_general.code);
	});
}

$('#form_update_correctivo_general').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/updateCorrectivoGeneral',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#form_update_correctivo_general #fecha_mantenimiento').val('');
		$('#form_update_correctivo_general #description').val('');
		$('#form_update_correctivo_general #code').val('');
		//var equipo_id = $("#modal_update_correctivo_general #form_update_correctivo_general #equipo_id").val();
		$('#tbcorrectivo  tbody').html('');
		list_correctivos(JSON.parse(data));
		$('#modal_update_correctivo_general').modal('hide');

		$('#modal_update_correctivo_general #btn_update_preventivo').removeAttr(
			'disabled',
			'disabled'
		);
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
			url: base_url + 'equipos_ind/Cequipos_ind/deleteCorrectivoGeneral',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			$('#tbcorrectivo  tbody').html('');
			list_correctivos(equipo_id);
		});
	}
}
function list_correctivos(id) {
	var correctivos = '';
	var tmp = '';
	var id_equipos = id;
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getCorrectivos',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		correctivos = JSON.parse(data);
		if (correctivos == 2) {
			$('#text_co').html('No se registran correctivos por orden');
			$('#tbcorrectivo  tbody').html('');
			list_correctivos_generales(id_equipos);
		} else {
			$.each(correctivos, function (i, item) {
				tmp +=
					'<tr height="27" style="mso-height-source:userset;height:20.25pt" >'; //
				tmp +=
					'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
					item.id +
					'</td>'; //
				tmp +=
					"<td colspan='18' class='xl20126419' width='200' style='border-right:.5pt solid black;width:200pt'>Reporte:&nbsp;(" +
					item.fecha_inicio +
					')<br>' +
					item.descripcion +
					'<br>';
				if (item.diagnostico != null && item.diagnostico != '') {
					tmp +=
						'Diagnostico:&nbsp;(' +
						item.fecha_diagnostico +
						')<br>' +
						item.diagnostico +
						'<br>';
				}
				if (item.reparacion != null && item.reparacion != '') {
					tmp +=
						'Reparacion:&nbsp;(' +
						item.fecha_fin +
						')<br>' +
						item.reparacion +
						'<br>';
				}
				tmp += '</td>'; //
				tmp +=
					'<td colspan="13" class="xl20126419" width="63" style="width:48pt">' +
					item.estado +
					'</td>'; //

				tmp +=
					"<td colspan='10' class='xl20126419' width='348' style='border-right:.5pt solid black;width:263pt'>";
				if (item.image != null && item.image != '') {
					tmp +=
						"<a class='esconder' href='" +
						base_url +
						'assets/upload_correctivos_generales/' +
						item.image +
						"' target='_blank'><label class='badge'>Reporte</label><br>";
				} else {
				}
				if (item.file_diagnostico != null && item.file_diagnostico != '') {
					tmp +=
						"<a class='esconder' href='" +
						base_url +
						'assets/upload_correctivos_generales/' +
						item.file_diagnostico +
						"' target='_blank'><label class='badge'>Diagnostico</label><br>";
				} else {
				}
				if (item.file_cierre != null && item.file_cierre != '') {
					tmp +=
						"<a class='esconder' href='" +
						base_url +
						'assets/upload_correctivos_generales/' +
						item.file_cierre +
						"' target='_blank'><label class='badge'>Cierre</label>";
				} else {
				}
				tmp += '</td></tr>';
			});

			$('#text_co').html('');
			$('#tbcorrectivo tbody').html('');
			$('#tbcorrectivo tbody').append(tmp);
			list_correctivos_generales(id_equipos);
		}
	});
}

function list_correctivos_generales(id) {
	var correctivos_generales = '';
	var correctivos_generales_archivos = '';
	var personalizado = '';
	var tmp = '';
	var tmp2 = '';
	var contador = 0;
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getCorrectivosGenerales',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		correctivos_generales = JSON.parse(data);
		$('.clarear_div').html('');
		if (correctivos_generales == 2) {
			$('#text_co').html('No se registran correctivos generales');
			//$("#tbcorrectivo  tbody").html("");
		} else {
			$.each(correctivos_generales, function (i, item) {
				tmp +=
					'<tr height="27" style="mso-height-source:userset;height:20.25pt" >';
				tmp +=
					'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
					item.code +
					'</td>';
				tmp +=
					'<td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;width:200pt">' +
					item.description +
					'</td>';
				tmp +=
					'<td colspan="13" class="xl18526419" width="63" style="width:48pt">fecha mantenimiento: ' +
					item.fecha_mantenimiento +
					'</td>';
				if (item.file != null && item.file != '') {
					tmp +=
						"<td colspan='10' class='xl20126419' width='348' style='border-right:.5pt solid black;width:263pt'><div class='esconder'><a  target='_blank' href='" +
						base_url +
						'assets/upload_correctivos_generales/' +
						item.file +
						"' class='btn bnt-info'><span class='glyphicon glyphicon-file esconder'></span></div></a></td><td class='xl1526419'></td>";
				} else {
					tmp +=
						'<td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;width:263pt">No Registra</td><td class="xl1526419"></td>';
				}
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_correctivo_general' onClick='recover_modal_edit_correctivo_general(" +
					item.id +
					")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>" +
					'</td>';
				tmp +=
					"<td class='esconder'>" +
					"<a onClick='delete_correctivo_general(" +
					item.id +
					',' +
					item.equipo_id +
					")' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>" +
					'</td>';
			});

			$('#text_co').html('');
			//$("#tbcorrectivo tbody").html("");
			$('#tbcorrectivo tbody').append(tmp);
		}
	});
}

/*CRUD CALIBRACIONES*/
$('#form_calibracion').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#btn_add_calibracion').attr('disabled', 'disabled');
	$('#mensaje').addClass(
		'glyphicon glyphicon-refresh glyphicon-refresh-animate'
	);
	$('#mensaje').html('Procesando..........');
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/addCalibracion',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#form_calibracion #fecha_calibracion').val('');
		$('#form_calibracion #fecha_programada').val('');
		$('#form_calibracion #description').val('');
		$('#modal_add_calibracion .close').click();

		$('#btn_add_calibracion').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		list_calibraciones(JSON.parse(data));
	});
});

function list_calibraciones(id) {
	var calibraciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getCalibraciones',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		calibraciones = JSON.parse(data);
		if (calibraciones == 2) {
			$('#text_ca').html('No se registran calibraciones');
			$('#tbcalibraciones  tbody').html('');
		} else {
			$.each(calibraciones, function (i, item) {
				tmp +=
					'<tr height="27" style="mso-height-source:userset;height:20.25pt" >';
				tmp +=
					'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
					item.id +
					'</td>';
				tmp +=
					'<td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;width:200pt">' +
					item.fecha_calibracion +
					'</td>';
				tmp +=
					'<td colspan="13" class="xl18526419" width="63" style="width:48pt">' +
					item.fecha_programada +
					'</td>';
				if (item.file != null && item.file != '') {
					tmp +=
						"<td colspan='10' class='xl20126419' width='348' style='border-right:.5pt solid black;width:263pt'><div class='esconder'><a  target='_blank' href='" +
						base_url +
						'assets/upload_calibraciones/' +
						item.file +
						"' class='btn bnt-info'><span class='glyphicon glyphicon-file esconder'></span></div></a></td><td class='xl1526419'></td>";
				} else {
					tmp +=
						'<td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;width:263pt">No Registra</td><td class="xl1526419"></td>';
				}
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_calibracion' onClick='recover_modal_edit_calibracion(" +
					item.id +
					")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>" +
					'</td>';
				tmp +=
					"<td class='esconder'>" +
					"<a onClick='delete_calibracion(" +
					item.id +
					',' +
					item.equipo_id +
					",event)' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>" +
					'</td>';
				tmp += '</tr>';
			});
			$('#text_ca').html('');
			$('#tbcalibraciones tbody').html('');
			$('#tbcalibraciones tbody').append(tmp);
		}
	});
}

function recover_modal_edit_calibracion(id) {
	//Coloca los datos en el formulario de actualizar
	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/getOneCalibracion',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		var calibracion = JSON.parse(data);

		$('#modal_update_calibracion #form_update_calibracion #id').val(
			calibracion.id
		);
		$('#modal_update_calibracion #form_update_calibracion #equipo_id').val(
			calibracion.equipo_id
		);
		$('#modal_update_calibracion #form_update_calibracion #description').val(
			calibracion.description
		);
		$(
			'#modal_update_calibracion #form_update_calibracion #fecha_calibracion'
		).val(calibracion.fecha_calibracion);
		$(
			'#modal_update_calibracion #form_update_calibracion #fecha_programada'
		).val(calibracion.fecha_programada);
	});
}

$('#form_update_calibracion').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$('#modal_update_calibracion #btn_update_calibracion').attr(
		'disabled',
		'disabled'
	);

	$.ajax({
		url: base_url + 'equipos_ind/Cequipos_ind/updateCalibracion',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#form_update_calibracion #fecha_mantenimiento').val('');
		$('#form_update_calibracion #fecha_programada').val('');
		$('#form_update_calibracion #description').val('');
		$('#modal_update_calibracion #btn_update_calibracion').removeAttr(
			'disabled',
			'disabled'
		);
		$('#modal_update_calibracion .close').click();
	});
});

function delete_calibracion(id, equipo_id, e) {
	e.preventDefault();
	var confirmacion = '';
	confirmacion = confirm(
		'Esta a punto de eliminar el registro de calibración, desea proceder?'
	);
	if (confirmacion) {
		$.ajax({
			url: base_url + 'equipos_ind/Cequipos_ind/deleteCalibracion',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			list_calibraciones(equipo_id);
		});
	} else {
		aler('Acción cancelada');
	}
}

//////////////////////////////////////////////////////////////////

function insertar() {
	$('#guardar').click(function (e) {
		e.preventDefault();
		var form = $('#form_add')[0];
		var formulario = new FormData(form);
		//formulario.append(form);
		$.ajax({
			type: 'post',
			url: base_url + 'equipos_ind/Cequipos_ind/add',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				var data = JSON.parse(response);
				if (data.success) {
					$('#form_add')[0].reset();
					$('#formulario_add').modal('hide');
					var type = 'guardado';
					$('.alert-success')
						.html('Equipo ' + type + ' con exito')
						.fadeIn()
						.delay(4000)
						.fadeOut('slow');
					tablaequipos();
				} else {
					$('.alert-error')
						.html('Errores ' + data.error + 'No se agrego equipo')
						.fadeIn()
						.delay(4000)
						.fadeOut('slow');
				}
			},
		});
	});
}

function update() {
	$('#formulario_update #actualizar').click(function (e) {
		e.preventDefault();

		var form = $('#form_update')[0];
		var formulario = new FormData(form);

		$.ajax({
			type: 'post',
			url: base_url + 'equipos_ind/Cequipos_ind/update',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
			success: function (response, type, row) {
				//alert(response);
				var dat = JSON.parse(response);

				if (dat.success) {
					$('#formulario_update').modal('hide');
					if (dat.type == 'upd') {
						var type = 'actualizado';
						$('.alert-success')
							.html('Equipo ' + type + ' con exito')
							.fadeIn()
							.delay(4000)
							.fadeOut('slow');
					}
					tablaequipos();
				} else {
					$('.alert-error')
						.html('Errores ' + dat.error + 'No se actualizo equipo')
						.fadeIn()
						.delay(4000)
						.fadeOut('slow');
				}
			},
		});
	});
}

function editar(rownum) {
	$.ajax({
		type: 'post',
		url: base_url + 'equipos_ind/Cequipos_ind/upd',
		data: { rownum: rownum },
		cache: false,
		success: function (response) {
			var dataObj = JSON.parse(response);

			var id_equipos = dataObj[0].id_equipos;
			var piso = dataObj[0].piso_id;
			var servicio = dataObj[0].servicio_id;
			var periodicidad = dataObj[0].periodicidad_id;
			var ubicacion = dataObj[0].ubicacion;
			var mantenimiento = dataObj[0].mantenimiento;
			var id_piso = dataObj[0].id_piso;

			list_correctivos(id_equipos);
			list_preventivos(id_equipos);
			list_calibraciones(id_equipos);

			$('#formulario_update #form_update #id_equipos').val(
				dataObj[0].id_equipos
			);
			$('#form_preventivo_ind #id_equipos').val(dataObj[0].id_equipos);
			$('#form_correctivo_general #id_equipos').val(dataObj[0].id_equipos);
			$('#form_calibracion #id_equipos').val(dataObj[0].id_equipos);

			$('#formulario_update #form_update #nombre').val(dataObj[0].nombre);
			$('#formulario_update #form_update #marca').val(dataObj[0].marca);
			$('#formulario_update #form_update #serial').val(dataObj[0].serial);
			$('#formulario_update #form_update #modelo').val(dataObj[0].modelo);
			$('#formulario_update #form_update #codigo_inventario').val(
				dataObj[0].codigo_inventario
			);

			$.ajax({
				url: base_url + 'equipos_ind/Cequipos_ind/getServicios',
				type: 'post',
				data: { name: servicio },
				// data:{id:id}
			}).done(function (data) {
				var datos = JSON.parse(data);
				var tmp =
					"<option value='" + servicio + "'>--" + ubicacion + '--</option>';
				$.each(datos, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.text + '</option>';
				});
				$('#formulario_update #form_update #servicio_id').html(tmp);
			});

			$.ajax({
				url: base_url + 'equipos_ind/Cequipos_ind/getMantenimiento',
				type: 'post',
				data: { name: periodicidad },
			}).done(function (data) {
				var datos = JSON.parse(data);
				var tmp =
					"<option value='" +
					periodicidad +
					"'>--" +
					mantenimiento +
					'--</option>';
				$.each(datos, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.text + '</option>';
				});
				$('#formulario_update #form_update #periodicidad_id').html(tmp);
			});

			$.ajax({
				url: base_url + 'equipos_ind/Cequipos_ind/getPiso',
				type: 'post',
				data: { name: piso },
			}).done(function (data) {
				var datos = JSON.parse(data);
				var tmp = "<option value='" + id_piso + "'>--" + piso + '--</option>';
				$.each(datos, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.text + '</option>';
				});
				$('#formulario_update #form_update #piso_id').html(tmp);
			});

			$('#formulario_update #form_update #Corriente').val(dataObj[0].corriente);
			$('#formulario_update #form_update #Tension').val(dataObj[0].tension);
			$('#formulario_update #form_update #Potencia').val(dataObj[0].potencia);
			$('#formulario_update #form_update #Temperatura').val(
				dataObj[0].temperatura
			);
			$('#formulario_update #form_update #fecha_mantenimiento').val(
				dataObj[0].fecha_mantenimiento
			);

			if (dataObj[0].imagen != '' && dataObj[0].imagen != null) {
				$('#formulario_update #form_update #showimagen').html(
					'<left><img src="' +
						base_url +
						'style/imagenes/' +
						dataObj[0].imagen +
						'"style="width:150px;height:150px;"/></left>'
				);
			} else {
				$('#formulario_update #form_update #texto').html(
					'No registra imagen' + dataObj[0].imagen
				);
			}
			if (dataObj[0].archivo != '' && dataObj[0].archivo != null) {
				$('#formulario_update #form_update #text').html(dataObj[0].archivo);
				$('#formulario_update #form_update #link').html(
					'<a class="glyphicon glyphicon-save-file" href="' +
						base_url +
						'equipos_ind/Cequipos_ind/downloads/' +
						dataObj[0].archivo +
						'"style="height: 20px; width: 20px;"></a>'
				);
			} else {
				$('#formulario_update #form_update #text').html(
					'No registra archivo' + dataObj[0].archivo
				);
			}
		},
	});
}

function botones_modales(data) {
	$('#btn_upd').click(function (e) {
		e.preventDefault();
		$('#formulario_update').modal('show');
	});

	$('#btn_excel').click(function (e) {
		e.preventDefault();
		$('#tablaexcel').modal('show');
	});
	$('#btn_orden').click(function (e) {
		e.preventDefault();
		$('#reporte').modal('show');
	});
}

function buscadores() {
	$('#servicio_idd').select2({
		ajax: {
			url: base_url + 'equipos_ind/Cequipos_ind/getServicios',
			dataType: 'json',

			data: function (params) {
				return {
					q: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
		},
	});

	$('#periodicidad_idd').select2({
		ajax: {
			url: base_url + 'equipos_ind/Cequipos_ind/getMantenimiento',
			dataType: 'json',

			data: function (params) {
				return {
					r: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
				alert(results);
			},
		},
	});
	$('#servicio_id').select2({
		ajax: {
			url: base_url + 'equipos_ind/Cequipos_ind/getServicios',
			dataType: 'json',

			data: function (params) {
				return {
					q: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
		},
	});

	$('#periodicidad_id').select2({
		ajax: {
			url: base_url + 'equipos_ind/Cequipos_ind/getMantenimiento',
			dataType: 'json',

			data: function (params) {
				return {
					r: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
		},
	});

	$('#piso_id').select2({
		ajax: {
			url: base_url + 'equipos_ind/Cequipos_ind/getPiso',
			dataType: 'json',

			data: function (params) {
				return {
					r: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
		},
	});
}

function tablaequipos() {
	var table = $('#tablaequipos').DataTable({
		destroy: true,
		paging: true,
		lengthMenu: [
			[5, 10, 15, 20],
			[5, 10, 15, 20],
		],
		searching: true,
		info: true,
		filter: true,
		//'responsive': true,
		stateSave: true,
		processing: true,
		serverSide: true,

		//orderable:true,
		ajax: {
			url: base_url + 'equipos_ind/Cequipos_ind/getEquipo',
			type: 'POST',
		},
		cache: false,

		columns: [
			{ data: 'nombre' },
			{ data: 'serial' },
			{ data: 'servicios' },
			{ data: 'fecha_mantenimiento' },
			{
				orderable: true,
				render: function (data, type, row) {
					// return '<button type="button" id="btn_upd" class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#formulario_update"style="width:50px; margin-top:10px;" onClick="editar('+row.rownum+')"></button>  <button type="button" id="btn_excel" class="btn btn-success glyphicon glyphicon-file" data-toggle="modal" data-target="#tablaexcel"  onClick="excel('+row.rownum+')" style="width:50px;margin-top:10px;"></button> <button type="button" id= "btn_orden" class="btn btn-info glyphicon glyphicon-wrench" data-toggle="modal" data-target="#reporte" onClick="reporte('+row.rownum+')" style="width:50px;margin-top:10px;"></button> <button type="button" class="btn btn-danger glyphicon glyphicon-trash" id="btn_dlt" data-toggle="modal" style="width:50px;margin-top:10px;" onClick="borrar('+row.rownum+')"></button>'
					// return'<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>Opciones</button><ul class="dropdown-menu" role="menu"> <li><button type="button" id="btn_upd" class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#formulario_update"style="width:50px; margin-top:10px;" onClick="editar('+row.rownum+')"></button> <button type="button" id="btn_excel" class="btn btn-success glyphicon glyphicon-file" data-toggle="modal" data-target="#tablaexcel"  onClick="excel('+row.rownum+')" style="width:50px;margin-top:10px;"></button> <button type="button" id= "btn_orden" class="btn btn-info glyphicon glyphicon-wrench" data-toggle="modal" data-target="#reporte" onClick="reporte('+row.rownum+')" style="width:50px;margin-top:10px;"></button> <button type="button" class="btn btn-danger glyphicon glyphicon-trash" id="btn_dlt" data-toggle="modal" style="width:50px;margin-top:10px;" onClick="borrar('+row.rownum+')"></button></li></ul></div>';
					return (
						'<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>Opciones</button><ul class="dropdown-menu" role="menu"> <li><button type="button" id="btn_upd" class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#formulario_update"style="width:50px; margin-top:10px;" onClick="editar(' +
						row.rownum +
						')"></button> <button type="button" id="btn_excel" class="btn btn-success glyphicon glyphicon-file" data-toggle="modal" data-target="#tablaexcel"  onClick="excel(' +
						row.rownum +
						')" style="width:50px;margin-top:10px;"></button> <button type="button" class="btn btn-danger glyphicon glyphicon-trash" id="btn_dlt" data-toggle="modal" style="width:50px;margin-top:10px;" onClick="borrar(' +
						row.rownum +
						')"></button></li></ul></div>'
					);
				},
			},
		],
		columnDefs: [
			{
				targets: [0],
				data: 'nombre',
				render: function (data, type, row) {
					var tmp = '';
					tmp += '<strong>' + row.nombre + '</strong>';
					tmp += ' ';
					if (row.archivo != null && row.archivo != '') {
						tmp +=
							'<right><a target="__blank" style="padding:4px; margin-top:2px" href="' +
							base_url +
							'style/archivos/HV/' +
							row.archivo +
							'" class=" btn btn-success fa fa-file-excel-o"> HV</a></right>';
						tmp += '&nbsp';
					}

					if (row.imagen != '') {
						tmp +=
							"<br><a data-lightbox='equipos' href='" +
							base_url +
							'style/imagenes/' +
							row.imagen +
							"' target='__blank'><img width='160px' height='160px'  src='" +
							base_url +
							'style/imagenes/' +
							row.imagen +
							"'>";
					}
					return tmp;
				},
			},
			{
				targets: [1],
				data: 'serial',
				render: function (data, type, row) {
					var tmp = '';
					tmp += '<strong>ID:</strong>' + row.rownum;
					tmp += '<br><strong>Codigo Inv:</strong>' + row.codigo_inventario;
					tmp += '<br><strong>Marca:</strong>' + row.marca;
					tmp += '<br><strong>Modelo:</strong>' + row.modelo;
					tmp += '<br><strong>Serie:</strong>' + row.serial;
					return tmp;
				},
			},
			{
				targets: [2],
				data: 'servicios',
				render: function (data, type, row) {
					var tmp = '';
					tmp += '<strong>Ubicación:</strong>' + row.name;
					tmp += '<br><strong>Piso:</strong>' + row.piso;
					tmp += '<br>';

					if (
						row.tension != null &&
						row.tension != '' &&
						row.tension != 'N.I'
					) {
						tmp += '<br><strong>Tension [V]:</strong>' + row.tension;
					}
					if (
						row.corriente != null &&
						row.corriente != '' &&
						row.corriente != 'N.I'
					) {
						tmp += '<br><strong>Corriente [A]:</strong>' + row.corriente;
					}
					if (
						row.temperatura != null &&
						row.temperatura != '' &&
						row.temperatura != 'N.I'
					) {
						tmp += '<br><strong>Temp[C]:</strong>' + row.temperatura;
					}
					if (
						row.potencia != null &&
						row.potencia != '' &&
						row.potencia != 'N.I'
					) {
						tmp += '<br><strong>Power:</strong>' + row.potencia;
					}
					return tmp;
				},
			},
			{
				targets: [3],
				data: 'fecha_mantenimiento',
				render: function (data, type, row) {
					var tmp = '';
					tmp +=
						'<strong>Frecuencia de mantenimiento:</strong>' +
						row.namem +
						'<br><br>';

					if (
						row.fecha_mantenimiento != null &&
						row.fecha_mantenimiento != '' &&
						row.fecha_mantenimiento != '0000-00-00'
					) {
						tmp +=
							"<span class='fa fa-calendar'> <strong>Ultimo mantenimiento<strong><br>" +
							row.fecha_mantenimiento +
							'</span><br>';
						row.estado_mantenimiento == 2;
					} else {
						tmp +=
							"<span class='fa fa-calendar'> <strong>Fecha incicial programada<strong><br>" +
							row.fecha_mantenimiento +
							'</span><br>';
					}

					if (row.estado == '1') {
						tmp +=
							"<br><br><strong>Estado del equipo:<br></strong>&nbsp;<span style='color:green; font-size:25px;'>Activo</span>";
					} else if (row.estado == '0') {
						tmp +=
							"<br><br><strong>Estado del equipo:<br></strong>&nbsp;<span style='color:green; font-size:25px;'>Activo</span>";
					} else if (row.estado == '2') {
						tmp +=
							"<br><br><strong>Estado del equipo:<br></strong>&nbsp;<span style='color:red; font-size:30px;'>No Activo</span>";
					} else {
						tmp +=
							"<br><br><strong>Estado del equipo:<br></strong>&nbsp;<span style='color:red; font-size:30px;'>No Activo</span>";
					}
					return tmp;
				},
			},
		],
	});
}

function borrar(rownum) {
	$.ajax({
		type: 'post',
		url: base_url + 'equipos_ind/Cequipos_ind/borrar',
		data: { rownum: rownum },
		success: function (response, type, row) {
			var data = JSON.parse(response);
			if (data.success) {
				if (data.type == 'delete') {
					var type = 'desactivado';
					$('.alert-success')
						.html('Equipo ' + type + ' con exito')
						.fadeIn()
						.delay(4000)
						.fadeOut('slow');
					tablaequipos();
				} else {
					$('.alert-success')
						.html('Errores = No se borro equipo')
						.fadeIn()
						.delay(4000)
						.fadeOut('slow');
					tablaequipos();
				}
			}
		},
	});
}

function excel(rownum) {
	$.ajax({
		type: 'post',
		url: base_url + 'equipos_ind/Cequipos_ind/upd',
		data: { rownum: rownum },
		cache: false,
		success: function (response, type, row) {
			var dataObj = JSON.parse(response);

			$('#tablaexcel  #tbexcel #nombre').html(dataObj[0].nombre);
			$('#tablaexcel  #marca').html(dataObj[0].marca);
			$('#tablaexcel  #serial').html(dataObj[0].serial);
			$('#tablaexcel  #modelo').html(dataObj[0].modelo);
			$('#tablaexcel  #codigo_inventario').html(dataObj[0].codigo_inventario);
			$('#tablaexcel  #servicio_id').html(dataObj[0].ubicacion);
			$('#tablaexcel  #periodicidad_id').html(dataObj[0].mantenimiento);

			if (dataObj[0].imagen != '' && dataObj[0].imagen != null) {
				$('#tablaexcel  #imagen').html(
					'<center><img src="' +
						base_url +
						'style/imagenes/' +
						dataObj[0].imagen +
						'"style="width:150px;height:150px;"/></center>'
				);
			} else {
				$('#tablaexcel  #imagen').html(
					'No registra imagen' + dataObj[0].imagen
				);
			}

			$('#tablaexcel  #piso_id').html(dataObj[0].piso_id);
			$('#tablaexcel  #tension').html(dataObj[0].tension);
			$('#tablaexcel  #corriente').html(dataObj[0].corriente);
			$('#tablaexcel  #potencia').html(dataObj[0].potencia);
			$('#tablaexcel  #temperatura').html(dataObj[0].temperatura);
		},
	});
}

function reporte(rownum) {
	$.ajax({
		type: 'post',
		url: base_url + 'equipos_ind/Cequipos_ind/upd',
		data: { rownum: rownum },
		cache: false,
		success: function (response, type, row) {
			var dataObj = JSON.parse(response);
			var f = new Date();

			if (dataObj[0].nombre == 'AUTOCLAVE') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('Revision de la tuberia de vapor');
				$('#reporte  #text2').html('Revision del control electrico');
				$('#reporte  #text3').html('Revision de las valvulas de vapor');
				$('#reporte  #text4').html('Revision del nivel');
				$('#reporte  #text5').html('Revision de los sellos de puerta');
				$('#reporte  #text6').html('Revision del estado del equipo');
				$('#reporte  #text7').html('Revision de valvulas de purga');
				$('#reporte  #text8').html('Revision de los manometros');
				$('#reporte  #text9').html('Revision de los termometros');
				$('#reporte  #text10').html(
					'Revision y verificacion de funcionamiento'
				);
			} else if (dataObj[0].nombre == 'MARMITA') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('Revision de las lineas de vapor');
				$('#reporte  #text2').html(
					'Revision del estado de la soldadura de la marmita'
				);
				$('#reporte  #text3').html(
					'Revision de la valvula de cierre de vapor de la marmita'
				);
				$('#reporte  #text4').html('Revision de manometros de la marmita');
				$('#reporte  #text5').html('Revision del regulador de la marmita');
				$('#reporte  #text6').html('N.I');
				$('#reporte  #text7').html('N.I');
				$('#reporte  #text8').html('N.I');
				$('#reporte  #text9').html('N.I');
				$('#reporte  #text10').html('N.I');
			} else if (dataObj[0].nombre == 'CAMILLA DE TRANSPORTE') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('Revision de los movimientos cabecera');
				$('#reporte  #text2').html('Revision de las barandas');
				$('#reporte  #text3').html('Revision de las ruedas y frenos');
				$('#reporte  #text4').html('Revision de los cilindros neumaticos');
				$('#reporte  #text5').html('N.I');
				$('#reporte  #text6').html('N.I');
				$('#reporte  #text7').html('N.I');
				$('#reporte  #text8').html('N.I');
				$('#reporte  #text9').html('N.I');
				$('#reporte  #text10').html('N.I');
			} else if (dataObj[0].nombre == 'CAMA ELECTRICA') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html(
					'Revision de los movimientos cabecera Y elevacion'
				);
				$('#reporte  #text2').html('Revision del control electrico');
				$('#reporte  #text3').html('Revision de los cables electricos');
				$('#reporte  #text4').html('Revision de las barandas');
				$('#reporte  #text5').html('Revision de las ruedas y frenos');
				$('#reporte  #text6').html('Revision de motor electrico');
				$('#reporte  #text7').html('Revision de los cilindros neumaticos');
				$('#reporte  #text8').html(
					'Revision y verificacion de su funcionamiento'
				);
				$('#reporte  #text9').html('N.I');
				$('#reporte  #text10').html('N.I');
			} else if (dataObj[0].nombre == 'CUARTO FRIO') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('Se lavan manejadoras y condensadora');
				$('#reporte  #text2').html(
					'Se revisa parte del control de temperatura'
				);
				$('#reporte  #text3').html('Se verifican presiones del refrigerante');
				$('#reporte  #text4').html('Se sopletea parte electrica');
				$('#reporte  #text5').html('Revision de motor electrico');
				$('#reporte  #text6').html(
					'Revision y verificacion de su funcionamiento'
				);
				$('#reporte  #text7').html('N.I');
				$('#reporte  #text8').html('N.I');
				$('#reporte  #text9').html('N.I');
				$('#reporte  #text10').html('N.I');
			} else if (dataObj[0].nombre == 'AIRE ACONDICIONADO CENTRAL') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('Se lavan manejadoras y condensadora');
				$('#reporte  #text2').html(
					'Se revisa parte del control de temperatura'
				);
				$('#reporte  #text3').html('Se verifican presiones del refrigerante');
				$('#reporte  #text4').html('Se sopletea parte electrica');
				$('#reporte  #text5').html('Se lavan filtros');
				$('#reporte  #text6').html('Revision de bombas de agua');
				$('#reporte  #text7').html('Revision de contactores y reletermico');
				$('#reporte  #text8').html('Revision de correas');
				$('#reporte  #text9').html('Se engrasan chumaceras de blower');
				$('#reporte  #text10').html('N.I');
			} else if (dataObj[0].nombre == 'MESA QUIRURGICA') {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('Sistema hidraulico elevacion y descenso');
				$('#reporte  #text2').html('Revision de pedales mecanicos');
				$('#reporte  #text3').html('Revision de palancas mecanicas');
				$('#reporte  #text4').html('Revision de brazos mecanicos');
				$('#reporte  #text5').html('Limpieza general');
				$('#reporte  #text6').html('Revision sistema electrico');
				$('#reporte  #text7').html('Lubricacion de partes moviles rodantes');
				$('#reporte  #text8').html('Revision de correas');
				$('#reporte  #text9').html(
					'Revision y verificacion de su funcionamiento'
				);
				$('#reporte  #text10').html('N.I');
			} else {
				$('#reporte  #fecha').html(
					f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear()
				);
				$('#reporte  #nombre').html(dataObj[0].nombre);
				$('#reporte  #marca').html(dataObj[0].marca);
				$('#reporte  #serial').html(dataObj[0].serial);
				$('#reporte  #modelo').html(dataObj[0].modelo);
				//$("#reporte  #codigo_inventario").html(dataObj[0].codigo_inventario);
				$('#reporte  #servicio_id').html(dataObj[0].ubicacion);
				$('#reporte  #text1').html('N.I');
				$('#reporte  #text2').html('N.I');
				$('#reporte  #text3').html('N.I');
				$('#reporte  #text4').html('N.I');
				$('#reporte  #text5').html('N.I');
				$('#reporte  #text6').html('N.I');
				$('#reporte  #text7').html('N.I');
				$('#reporte  #text8').html('N.I');
				$('#reporte  #text9').html('N.I');
				$('#reporte  #text10').html('N.I');
			}
		},
	});
}

function expand(rownum) {
	$.ajax({
		type: 'post',
		url: base_url + 'equipos_ind/Cequipos_ind/upd',
		data: { rownum: rownum },
		cache: false,
		success: function (response, type, row) {
			var dataObj = JSON.parse(response);
			if (dataObj[0].imagen != '' && dataObj[0].imagen != null) {
				$('#imagenmodal #expandimagen').html(
					'<center><img src="' +
						base_url +
						'style/imagenes/' +
						dataObj[0].imagen +
						'"style="width:257px; height:196px;"/></center>'
				);
			} else {
				$('#imagenmodal #expandimagen').html('No se registra imagen');
			}
		},
	});
}

function datatable_destroy() {
	// destruir data table
	$('#tblEquipos').dataTable().fnClearTable();
	$('#tblEquipos').dataTable().fnDestroy();
}
$('.errores').on('click', function () {
	$('.errores').hide();
});

$('.file').fileinput({
	language: 'es',
});

/*==========================================*/
// Logica para setear fecha programada al agregar preventivo
function set_fecha_programada_add() {
	var fecha = $('#modal_add_preventivo_ind #fecha_mantenimiento').val();
	var separado = fecha.split('-');
	var anio = separado[0];
	var mes = separado[1];
	var dia = separado[2];
	var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
	$('#modal_add_preventivo_ind #fecha_programada').val(fecha_programada);
}
// Logica para setear fecha programada al editar preventivo
function set_fecha_programada_edit() {
	var fecha = $('#modal_update_preventivo #fecha_mantenimiento').val();
	var separado = fecha.split('-');
	var anio = separado[0];
	var mes = separado[1];
	var dia = separado[2];
	var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
	$('#modal_update_preventivo #fecha_programada').val(fecha_programada);
}
// Logica para setear fecha programada al agregar calibracion
function set_fecha_programada_add_calibracion() {
	var fecha = $('#modal_add_calibracion #fecha_calibracion').val();
	var separado = fecha.split('-');
	var anio = separado[0];
	var mes = separado[1];
	var dia = separado[2];
	var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
	$('#modal_add_calibracion #fecha_programada').val(fecha_programada);
}
// Logica para setear fecha programada al editar calibracion
function set_fecha_programada_edit_calibracion() {
	var fecha = $('#modal_update_calibracion #fecha_calibracion').val();
	var separado = fecha.split('-');
	var anio = separado[0];
	var mes = separado[1];
	var dia = separado[2];
	var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
	$('#modal_update_calibracion #fecha_programada').val(fecha_programada);
}
function lastday(y, m) {
	return new Date(y, m, 0).getDate();
}

$(document).on('hidden.bs.modal', '.modal', function () {
	$('.modal:visible').length && $(document.body).addClass('modal-open');
});
