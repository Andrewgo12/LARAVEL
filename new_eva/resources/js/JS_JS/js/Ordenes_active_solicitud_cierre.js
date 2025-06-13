list_cierres();
function list_cierres() {
	var select_cierres = '<option>---Seleccione-----</option>';
	$.ajax({
		// hago una llamada a los cierres codificados dentro de la base de datos
		url: base_url + 'orden/Cordenes/getCierres',
		type: 'post',
		data: {},
	}).done(function (data) {
		var cierres = JSON.parse(data);
		$.each(cierres, function (i, item) {
			select_cierres +=
				"<option value='" +
				item.id +
				"'>" +
				item.code +
				'-' +
				item.name +
				'</option>';
		});
		$('.cierre_id').html('');
		$('.cierre_id').html(select_cierres);
	});
}
function recover_modal_solicitud_cierre(id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/getOneWithRepuestos',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		respuesta = JSON.parse(data);
		orden = respuesta.orden;
		repuestos = respuesta.repuestos;

		$(
			'#modal_solcitud_cierre_orden .id,#modal_archivo_solicitud_cierre_orden .id'
		).val(orden.id);

		$('#modal_solcitud_cierre_orden .asunto').html('');
		$('#modal_solcitud_cierre_orden .asunto').html(orden.asunto);

		$('#modal_solcitud_cierre_orden .descripcion').html('');
		$('#modal_solcitud_cierre_orden .descripcion').html(orden.descripcion);

		$('#modal_solcitud_cierre_orden .prioridad').html('');
		$('#modal_solcitud_cierre_orden .prioridad').html(orden.prioridad);

		$('#modal_solcitud_cierre_orden .retro_diagnostico').html('');
		$('#modal_solcitud_cierre_orden .retro_diagnostico').html(
			orden.retro_diagnostico
		);

		$('#modal_solcitud_cierre_orden .diagnostico').html('');
		$('#modal_solcitud_cierre_orden .diagnostico').html(orden.diagnostico);

		$('#modal_solcitud_cierre_orden .fecha_diagnostico').html('');
		$('#modal_solcitud_cierre_orden .fecha_diagnostico').html(
			orden.fecha_diagnostico
		);

		$('#modal_solcitud_cierre_orden .contenedor_codigo_diagnostico').html('');
		$('#modal_solcitud_cierre_orden .contenedor_codigo_diagnostico').html(
			orden.codigo_diagnostico +
				`||&nbsp;<span class="text-muted">` +
				orden.descripcion_diagnostico +
				`</span>`
		);

		$('#modal_solcitud_cierre_orden .contenido_ubicacion').html('');
		var tmp_ubicacion =
			`
		<li class="list-inline-item"><h4>Ubicación de referencia</h4>
			<ul>
			<li>
			<strong>Servicio donde se encuentra actualmente</strong>
			<h5>` +
			orden.servicio +
			`</h5>
			</li>`;
		if (orden.area != undefined && orden.area != '') {
			tmp_ubicacion +=
				`
		    <li>
			<strong>Area donde se encuentra actualmente</strong>
			<h5>` +
				orden.area +
				`</h5>
		    </li>`;
			tmp_ubicacion += `</ul></li>`;
		}
		$('#modal_solcitud_cierre_orden .contenido_ubicacion').html(tmp_ubicacion);

		$('#modal_solcitud_cierre_orden .contenedor_repuestos_necesarios').html('');
		var tmp_repuestos = `
		<h3>Repuestos necesarios</h3>
		<ul class=''>`;
		$.each(repuestos, function (i, item) {
			tmp_repuestos +=
				`
				<li class="">` +
				item.name +
				`</li>
			`;
		});
		tmp_repuestos += `</ul>`;
		$('#modal_solcitud_cierre_orden .contenedor_repuestos_necesarios').html(
			tmp_repuestos
		);
		var tmp = '';
		if (orden.subproceso_id == 1) {
			//Equipos biomedicos
			if (orden.nombre_equipo == undefined || orden.nombre_equipo == '') {
				//si no se ingreso manual

				tmp +=
					`
			<h3>Información del equipo</h3>
				<ul class="list-inline">
					<li class="list-inline-item">
						<h4>Nombre</h4>
						<h5>` +
					orden.nombre_equipo_db +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Activo fijo</h4>
						<h5>` +
					orden.codigo_equipo_database +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Serie</h4>
						<h5>` +
					orden.serie_equipo_db +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Marca</h4>
						<h5>` +
					orden.marca_equipo_db +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Modelo</h4>
						<h5>` +
					orden.modelo_equipo_db +
					`</h5>
					</li>

				</ul>		
			`;
			} else {
				tmp +=
					`
			<h3>Información del equipo</h3>
				<ul class="list-inline">
					<li class="list-inline-item">
						<h4>Nombre</h4>
						<h5>` +
					orden.nombre_equipo +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Activo fijo</h4>
						<h5>` +
					orden.codigo_equipo +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Serie</h4>
						<h5>` +
					orden.serie_equipo +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Marca</h4>
						<h5>` +
					orden.marca_equipo +
					`</h5>
					</li>
					<li class="list-inline-item">
						<h4>Modelo</h4>
						<h5>` +
					orden.modelo_equipo +
					`</h5>
					</li>

				</ul>		
			`;
			}
			$('#modal_solcitud_cierre_orden .contenido_equipo').html('');
			$('#modal_solcitud_cierre_orden .contenido_equipo').html(tmp);

			tmp = '';
			if ($('.rol').val() <= 2) {
				$('#modal_solcitud_cierre_orden .contenendor_file').show();
				$('#modal_solcitud_cierre_orden .file').removeAttr(
					'disabled',
					'disabled'
				);

				tmp += `
					<div class="row">
						<div class="col-sm-12">
							<label for="fecha_asignacion_cierre">Fecha de solicitud de cierre  </label>
							<input required="" min="2015-01-01" type="date" name="fecha_asignacion_cierre" id="fecha_asignacion_cierre"  class="form-control"><input type="time" name="hora_solicitud_cierre" id="hora_solicitud_cierre" class="form-control">
							
						</div>
					</div><br>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<label for="tecnico_cierre_text">Relacione el nombre del tecnico que realizo el procedimiento correctivo</label>
							<input class="form-control" type="text" name="tecnico_cierre_text" id="tecnico_cierre_text">
						</div>
					</div>
				`;
			}

			$('#modal_solcitud_cierre_orden .contenido_administrador').html('');
			$('#modal_solcitud_cierre_orden .contenido_administrador').html(tmp);
			list_cierres();
		}
	});
}
/*solicitud de cierre de la orden*/
$('#modal_solcitud_cierre_orden .form_solicitar_cierre_orden').submit(function (
	e
) {
	e.preventDefault();
	$('#modal_solcitud_cierre_orden #btn_update').attr('disabled', 'disabled');

	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'orden/Cordenes/update_solicitar_cierre_orden',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			$('#modal_solcitud_cierre_orden form').trigger('reset');
			datatable_destroy_orden();
			list_data_table_orden();
			$('#modal_solcitud_cierre_orden .close').click();
			$('#modal_solcitud_cierre_orden #btn_update').removeAttr(
				'disabled',
				'disabled'
			);
			update_solicitar_cierre_orden_email(respuesta.contenido);

			// alert("La información ha sido actualizada exitosamente");
		} else {
			alert(respuesta.contenido);
		}
	});
});
function update_solicitar_cierre_orden_email(orden_id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/update_solicitar_cierre_orden_email',
		type: 'post',
		data: { id: orden_id },
	}).done(function (data) {
		alert('se envio un correo con la información del correctivo realizado');
	});
}
$('#modal_archivo_solicitud_cierre_orden .form_solicitar_cierre_orden').submit(
	function (e) {
		e.preventDefault();
		$('#modal_archivo_solicitud_cierre_orden #btn_update').attr(
			'disabled',
			'disabled'
		);
		var formulario = new FormData(this);
		$.ajax({
			url: base_url + 'orden/Cordenes/update_archivo_solicitar_cierre_orden',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			$('#modal_archivo_solicitud_cierre_orden form').trigger('reset');
			datatable_destroy_orden();
			list_data_table_orden();
			$('#modal_archivo_solicitud_cierre_orden .close').click();
			$('#modal_archivo_solicitud_cierre_orden #btn_update').removeAttr(
				'disabled',
				'disabled'
			);

			// alert("Se agrego correctamente la información del trabajo realizado");
			update_solicitar_cierre_orden_email(respuesta.orden_id);
		});
	}
);
