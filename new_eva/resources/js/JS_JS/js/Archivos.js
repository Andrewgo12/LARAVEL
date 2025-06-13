function funcion_modal_compartir_archivos(
	e,
	equipo_archivo_origen_id,
	equipo_origen_id
) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cequipos/show_compartir_archivos',
		type: 'post',
		data: {
			equipo_archivo_origen_id: equipo_archivo_origen_id,
			equipo_origen_id: equipo_origen_id,
		},
	}).done(function (data) {
		$('#modal_compartir_archivos .modal-body').html(data);
		$('#modal_compartir_archivos .tbl-listado-equipos').dataTable({
			lengthMenu: [
				[2, 5, 10, 20, -1],
				[2, 5, 10, 20, 'TODOS'],
			],
		});
	});
}
$('#modal_compartir_archivos .form_compartir_archivos').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cequipos/update_archivos',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_compartir_archivos .close').click();
		list_data_table_server_side_filtros();
	});
});
function funcion_creacion_input_archivos(data) {
	var tmp = '';
	if (
		$('.form_compartir_archivos .tbl-listado-equipos .registro_' + data).is(
			':checked'
		)
	) {
		tmp +=
			`
				<input type="hidden" class="creado_` +
			data +
			`" name="creado[]" value="` +
			data +
			`">
			`;
		$('.form_compartir_archivos .contenedor_creado').append(tmp);
	} else {
		$('.form_compartir_archivos .creado_' + data + '').remove();
	}
}
function seleccionar_todos() {
	if ($('.control').val() == 0) {
		$('.control').val(1);
		// $(':checkbox').attr('checked',true);
		$(':checkbox').prop('checked', true);
	} else {
		$('.control').val(0);
		// $(':checkbox').attr('checked',false);
		// $(':checkbox').attr('checked',false);
		$(':checkbox').prop('checked', false);

		$('.contenedor_creado').html('');
	}
}

function modalArchivoObservacion(e, id) {
	e.preventDefault();
	$(
		'#modal_add_archivo_observacion #form_archivo_observacion #observacion_id'
	).val(id);
}

$('#modal_add_archivo_observacion #form_archivo_observacion').submit(function (
	e
) {
	e.preventDefault();
	var formulario = new FormData(this);
	console.log(formulario);

	$.ajax({
		url: base_url + 'equipo/Cequipos/addArchivoObservcion',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_add_archivo_observacion #form_archivo_observacion').trigger(
			'reset'
		);
		$('#modal_add_archivo_observacion .close').click();
		list_data_table_server_side_filtros();
		list_observaciones2(JSON.parse(data));
	});
});
