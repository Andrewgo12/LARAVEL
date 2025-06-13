if (controlador == 'Ccontingencias') {
	list_contingencias_all();
	select_equipos_for_contingencia();
}
$('#modal_add_contingencia .form_add_contingencia').submit(function (e) {
	e.preventDefault();
	$('.btn-primary').attr('disabled', 'disabled');
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'equipo/Ccontingencias/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		if (data == 1) {
			alert('informacion agregada exitosamente');
		} else {
			alert('Ocurrio un error');
		}
		$('.btn-primary').removeAttr('disabled', 'disabled');
		$('#modal_add_contingencia .close').click();
		$('#modal_add_contingencia .form_add_contingencia').trigger('reset');
		if ($('#modal_add_contingencia .equipo_id').val() != '') {
			list_data_table_server_side_filtros();
		} else {
			list_contingencias_all();
		}
	});
});
function relacionar_equipo_id_contingencia(equipo_id) {
	$('#modal_add_contingencia .equipo_id').val(equipo_id);
}
function list_contingencias(id) {
	// El que aparece en el detalle de la hoja de vida
	var contingencias = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Ccontingencias/get',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		var contingencias = JSON.parse(data);
		$.each(contingencias, function (i, item) {
			tmp +=
				`<tr style='text-transform:uppercase'>
			<td  colspan="18.17" height="27" class="xl18926419" width="82" style="border-right:.5pt solid black;height:20.25pt;
			width:61pt">` +
				item.observacion +
				`</td>
			<td colspan="18.17" class="xl18526419" width="63" style="width:48pt">` +
				item.fecha +
				`</td>
			<td colspan="18.17" class="xl20126419" width="348" style="border-right:.5pt solid black;
			width:263pt">`;

			if (item.file != null && item.file != '') {
				tmp +=
					`
				<div class='esconder'>
					<a  target='_blank' href='` +
					base_url +
					`assets/upload_contingencias/` +
					item.file +
					`' class='btn bnt-info'>
						<span class='glyphicon glyphicon-file esconder'></span>
					</a>
				</div>
					`;
			}
			tmp += `</td>
			<td class="xl1526419"></td>
		`;
			tmp += '</tr>';
		});

		$('#contenedor_detalle_equipo .apendice_contingencia').append(tmp);
	});
}
function list_contingencias_all() {
	// El que aparece en el detalle de la hoja de vida
	var contingencias = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Ccontingencias/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var contingencias = JSON.parse(data);
		$.each(contingencias, function (i, item) {
			tmp +=
				`

				<tr>
					<td>
						` +
				item.observacion +
				`
					</td>
					<td>
						` +
				item.fecha +
				`
					</td>
					<td>`;

			if (item.fecha_cierre == null) {
				tmp += ``;
			} else {
				tmp += item.fecha_cierre;
			}
			tmp += `</td>
					<td>`;

			if (item.file != null && item.file != '') {
				tmp +=
					`
						<div class='esconder'>
							<a  target='_blank' href='` +
					base_url +
					`assets/upload_contingencias/` +
					item.file +
					`' class='btn bnt-info'>
								<span class='glyphicon glyphicon-file esconder'></span>
							</a>
						</div>
							`;
			}
			tmp +=
				`</td>
					<td>` +
				item.usuario +
				`</td>
					<td>`;

			if (item.equipo_id != 0) {
				tmp +=
					`

							<ul>
								<li>Nombre: ` +
					item.name +
					`</li>	
								<li>Codigo: ` +
					item.codigo +
					`</li>	
								<li>Serie: ` +
					item.serial +
					`</li>	
								<li>Marca: ` +
					item.marca +
					`</li>	
								<li>Modelo: ` +
					item.modelo +
					`</li>	
							</ul>
							`;
			} else {
				tmp += `No aplica`;
			}

			tmp += `</td>

					<td>`;
			tmp += item.estado;

			if (
				item.fecha_cierre != null &&
				item.fecha_cierre != '' &&
				item.fecha_cierre != undefined
			) {
				tmp +=
					`<br><span style="color:green;">` + item.fecha_cierre + `</span>`;
			}

			tmp += `</td>
					<td>`;
			if (item.tipo != null) {
				tmp += `Equipo ` + item.tipo;
			} else {
				tmp += `Otras contingencias`;
			}
			tmp += `</td>
					<td>`;
			tmp += `
					<ul class="list-inline">`;
			if (eliminar_contingencia == 1) {
				tmp +=
					`<li title="eliminar_contingencia" class="list-inline-item"><a onclick="delete_contingencia(` +
					item.id +
					`,event)" href="" class="btn btn-danger fa fa-trash-o"></a></li>`;
			}
			if (editar_contingencia == 1 && item.estado_id == 1) {
				tmp +=
					`<li title="Cerrar contingencia" class="list-inline-item"><a onclick="close_contingencia(` +
					item.id +
					`,event)" href="" class="btn btn-primary fa fa-power-off"></a></li>`;
			}
			if (editar_contingencia == 1) {
				tmp +=
					`<li title="Editar contingencia" class="list-inline-item"><a data-toggle="modal" data-target="#modal_update_contingencia" onclick="recover_modal_edit_contingencia(` +
					item.id +
					`,event)" href="" class="btn btn-info fa fa-pencil-square-o"></a></li>`;
			}

			tmp += `</ul>`;
			tmp += `</td>
				</tr>
			`;
		});
		$('.tblContingencias').dataTable().fnClearTable();
		$('.tblContingencias').dataTable().fnDestroy();
		$('.tblContingencias tbody').html(tmp);
		//$(".contenedor-contingencias .apendice-contingencia").html(tmp);
		$('.contenedor-contingencias .tblContingencias').dataTable({
			stateSave: true,
			language: {
				lengthMenu: 'Mostrar _MENU_ registros por pagina',
				zeroRecords: 'No se encontraron resultados en su busqueda',
				searchPlaceholder: 'Buscar registros',
				info: 'Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros',
				infoEmpty: 'No existen registros',
				infoFiltered: '',
				search: 'Buscar:',
				paginate: {
					first: 'Primero',
					last: 'Último',
					next: 'Siguiente',
					previous: 'Anterior',
				},
			},
			aaSorting: [[2, 'desc']],
		});
	});
}
function delete_contingencia(id, e) {
	e.preventDefault();
	var mensaje = confirm(
		'Esta seguro que desea eliminar la contingencia? Tenga en cuenta que esta acción sera permanente'
	);
	if (mensaje) {
		$.ajax({
			url: base_url + 'equipo/Ccontingencias/delete',
			type: 'post',
			data: { id: id },
		}).done(function () {
			list_contingencias_all();
		});
	} else {
		alert('Acción cancelada');
	}
}
function close_contingencia(id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Ccontingencias/close',
		type: 'post',
		data: { id: id },
	}).done(function () {
		list_contingencias_all();
	});
}
function recover_modal_edit_contingencia(id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Ccontingencias/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		console.log(respuesta);
		$('#modal_update_contingencia .id').val(id);
		$('#modal_update_contingencia .observacion').val(respuesta.observacion);
		$('#modal_update_contingencia .fecha').val(respuesta.fecha);
		$('#modal_update_contingencia .fecha_cierre').val(respuesta.fecha_cierre);
		$('#modal_update_contingencia .equipo_id').val(respuesta.equipo_id);
		$('#modal_update_contingencia .equipo_id').select2({
			searchPlaceholder: respuesta.id,
		});
	});
}
function select_equipos_for_contingencia() {
	$.ajax({
		url: base_url + 'equipo/Cequipos/getForCOntingencias',
		type: 'post',
		data: {},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = "<option value=''>----</option>";
		$.each(respuesta, function (i, registro) {
			tmp +=
				`
				<option value=` +
				registro.id +
				`>` +
				registro.id +
				`|` +
				registro.name +
				`|` +
				registro.marca +
				`|` +
				registro.modelo +
				`|` +
				registro.code +
				`|` +
				registro.serial +
				`</option>
			`;
		});
		$('#modal_update_contingencia .equipo_id').html(tmp);
		$('#modal_update_contingencia .equipo_id').select2();
	});
}
$('#modal_update_contingencia form').submit(function (e) {
	e.preventDefault();
	$('#modal_update_contingencia button').attr('disabled', 'disabled');
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'equipo/Ccontingencias/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		// alert(data);
		$('#modal_update_contingencia button').removeAttr('disabled', 'disabled');
		$('#modal_update_contingencia .close').click();
		$('#modal_update_contingencia form').trigger('reset');
		list_contingencias_all();
	});
});
