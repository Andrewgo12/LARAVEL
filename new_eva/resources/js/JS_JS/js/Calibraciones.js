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
		url: base_url + 'calibracion/Ccalibraciones/add',
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
		list_calibraciones(JSON.parse(data));
		list_calibraciones2(JSON.parse(data));
		$('#modal_add_calibracion .close').click();

		$('#btn_add_calibracion').removeAttr('disabled', 'disabled');
		$('#mensaje').html('');
		$('#mensaje').removeClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);

		datatable_destroy();
		list_data_table_server_side_filtros();
	});
});
function recover_modal_edit_calibracion(id) {
	//Coloca los datos en el formulario de actualizar
	$.ajax({
		url: base_url + 'calibracion/Ccalibraciones/getOne',
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
		url: base_url + 'calibracion/Ccalibraciones/update',
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
		list_calibraciones(JSON.parse(data));
		list_calibraciones2(JSON.parse(data));
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
			url: base_url + 'calibracion/Ccalibraciones/delete',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			list_calibraciones(equipo_id);
			list_calibraciones2(equipo_id);
			datatable_destroy();
			list_data_table_server_side_filtros();
		});
	} else {
		aler('Acción cancelada');
	}
}
function list_calibraciones(id) {
	var calibraciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'calibracion/Ccalibraciones/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		calibraciones = JSON.parse(data);
		$.each(calibraciones, function (i, item) {
			tmp +=
				'<tr height="27" style="mso-height-source:userset;height:20.25pt" >';
			tmp +=
				'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
				item.description +
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
					'<td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;width:263pt"></td><td class="xl1526419"></td>';
			}
			tmp += '</tr>';
		});
		$('#contenedor_detalle_equipo .apendice_calibracion').append(tmp);
	});
}
function list_calibraciones2(id) {
	var calibraciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'calibracion/Ccalibraciones/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		calibraciones = JSON.parse(data);
		$.each(calibraciones, function (i, item) {
			tmp += '<tr>';
			// tmp+="<td>"+item.id+"</td>";
			tmp += '<td>' + item.description + '</td>';
			tmp += '<td>' + item.fecha_calibracion + '</td>';
			tmp += '<td>' + item.fecha_programada + '</td>';
			if (item.file != null) {
				tmp +=
					"<td class='esconder'><a  target='_blank' href='" +
					base_url +
					'assets/upload_calibraciones/' +
					item.file +
					"' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></a></td>";
			} else {
				tmp += "<td class='esconder'></td>";
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
		$('#form_update_equipo .tblCalibraciones tbody').html(tmp);
	});
}
function funcion_modal_calibraciones(e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'calibracion/Ccalibraciones/show',
		type: 'post',
		data: { id: 1 },
	}).done(function (data) {
		$('#modal_calibraciones .modal-body').html(data);
		$('.datatable-calibraciones').dataTable();
	});
}
