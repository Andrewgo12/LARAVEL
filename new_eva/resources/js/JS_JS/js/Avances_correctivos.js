function funcion_recobrar_id_correctivo(e) {
	e.preventDefault();
	$('#ingresar_avance_correctivo').removeAttr('disabled', 'disabled');
	var correctivo_general_id = $(
		'#modal_update_correctivo_general #form_update_correctivo_general #id'
	).val();
	$('#modal_add_avance_correctivo #form_add_avance_correctivo').trigger(
		'reset'
	);
	$(
		'#modal_add_avance_correctivo #form_add_avance_correctivo #correctivo_general_id'
	).val(correctivo_general_id);
	$('#modal_add_avance_correctivo .origen').val('general');
}
function funcion_recobrar_id_orden(e) {
	e.preventDefault();
	var orden_id = $('#modal_timeline_orden #id').val();
	$('#modal_add_avance_correctivo #form_add_avance_correctivo').trigger(
		'reset'
	);
	$('#modal_add_avance_correctivo #form_add_avance_correctivo #orden_id').val(
		orden_id
	);
	$('#modal_add_avance_correctivo .origen').val('orden');
}
$('#modal_add_avance_correctivo #form_add_avance_correctivo').on(
	'submit',
	function (e) {
		e.preventDefault();

		$('#ingresar_avance_correctivo').attr('disabled', 'disabled');
		var origen = $('#modal_add_avance_correctivo .origen').val(); // El origen del avance si correctivo general o ticket
		var formulario = new FormData(this);
		var correctivo_general_id = $(
			'#modal_update_correctivo_general #form_update_correctivo_general #id'
		).val();
		var orden_id = $('#modal_timeline_orden #id').val();
		$.ajax({
			url: base_url + 'correctivo_general/Cavances_correctivos/add',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta == 0) {
				alert('No se pudo ingresar el avance');
			} else {
				if (origen == 'general') {
					list_avances_correctivos(correctivo_general_id);
				} else {
					list_avances_ordenes(orden_id);
				}
				$('#modal_add_avance_correctivo .close').click();
			}
		});
	}
);
function list_avances_correctivos(correctivo_id) {
	$.ajax({
		url: base_url + 'correctivo_general/Cavances_correctivos/GetByDevice',
		type: 'post',
		data: { correctivo_general_id: correctivo_id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = '';

		tmp += "<div class='panel panel-default'>";
		tmp += "<div class='panel-heading'> Notas de avance</div>";
		tmp += "<div class='panel-body'>";
		tmp += "<ul class='list-group'>";
		$.each(respuesta, function (i, item) {
			tmp +=
				`
							<li class="list-group-item">
								<div class="row">
									<div class="col-sm-8">
										<h5>
											<span class="glyphicon glyphicon-user"></span>
											` +
				item.usuario +
				`
										</h5>
										<p style="font-size: 10px;">` +
				item.description +
				`</p>

									</div>
									<div class="col-sm-1">
									`;
			if (item.file != null && item.file != '') {
				tmp +=
					`
										<span class="">
										<a href="` +
					base_url +
					`assets/upload_correctivos_generales/` +
					item.file +
					`" target="__blank" class="btn btn-dark glyphicon glyphicon-file"></a>
										</span>
										`;
			}
			tmp +=
				`
									</div>
									<div class="col-sm-3">
										<span class="badge">Fecha:</span>
										<footer class="blockquote-footer"><cite>` +
				item.date +
				`</cite></footer>
									</div>
								</div>
							</li>
			`;
		});
		tmp += '</ul>';
		tmp += '</div>';
		tmp += '</div>';
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general .listado-avances-correctivos'
		).html();
		$(
			'#modal_update_correctivo_general #form_update_correctivo_general .listado-avances-correctivos'
		).html(tmp);
		$('#ingresar_avance_correctivo').removeAttr('disabled', 'disabled');
	});
}
function list_avances_ordenes(orden_id) {
	$.ajax({
		url: base_url + 'correctivo_general/Cavances_correctivos/GetByOrden',
		type: 'post',
		data: { orden_id: orden_id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = '';

		$.each(respuesta, function (i, item) {
			tmp +=
				`
		<tr height=20 style='mso-height-source:userset;height:15.0pt'>
			<td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
			<td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;
				<div class="row">
					<div class="col-sm-4">
						` +
				item.description +
				`
					</div>
					<div class="col-sm-5">
					</div>
					<div class="col-sm-3">
						<span style="font-size: 10px;" class="text-muted">[` +
				item.date +
				`]</span>
						<span class="fa fa-user">` +
				item.usuario +
				`</span>`;
			if (item.file != null && item.file != undefined && item.file != '') {
				tmp +=
					`
							<span class="">
							<a href="` +
					base_url +
					`assets/upload_correctivos_generales/` +
					item.file +
					`" target="__blank" class="btn btn-dark fa fa-paperclip"></a>
							</span>
							`;
			}
			tmp += `</div>
				</div>
			</td>
			<td class=xl674158></td>
			<td class=xl754158>&nbsp;</td>
		</tr>
			`;
		});
		$('#modal_timeline_orden .listado-avances-ordenes').html('');
		$('#modal_timeline_orden .listado-avances-ordenes').append(tmp);
		$('#ingresar_avance_correctivo').removeAttr('disabled', 'disabled');
	});
}
function eliminar_avance_correctivo(id) {
	var correctivo_general_id = $(
		'#modal_update_correctivo_general #form_update_correctivo_general #id'
	).val();
	$.ajax({
		url: base_url + 'correctivo_general/Cavances_correctivos/delete',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		list_avances_correctivos(correctivo_general_id);
	});
}
