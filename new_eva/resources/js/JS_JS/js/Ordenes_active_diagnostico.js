// list_diagnosticos();
// function list_diagnosticos(){
// 	var select_diagnosticos="<option value=''>---Seleccione-----</option>";
// 		$.ajax({ // hago una llamada a los diagnosticos codificados dentro de la base de datos
// 			url:base_url+"orden/Cordenes/getDiagnosticos",
// 			type:"post",
// 			data:{}
// 		}).done(function(data){
// 			var diagnosticos=JSON.parse(data);
// 			$.each(diagnosticos,function(i,item){
// 				select_diagnosticos+="<option value='"+item.id+"'>"+item.code+"-"+item.name+"</option>";
// 			});
// 			$(".diagnostico_id").html("");
// 			$(".diagnostico_id").html(select_diagnosticos);
// 		});
// }
function recover_modal_diagnose(id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		orden = JSON.parse(data);

		$('#modal_diagnose_orden .id,#modal_archivo_diagnose_orden .id').val(
			orden.id
		);

		$('#modal_diagnose_orden .asunto').html('');
		$('#modal_diagnose_orden .asunto').html(orden.asunto);

		$('#modal_diagnose_orden .descripcion').html('');
		$('#modal_diagnose_orden .descripcion').html(orden.descripcion);

		$('#modal_diagnose_orden .prioridad').html('');
		$('#modal_diagnose_orden .prioridad').html(orden.prioridad);

		$('#modal_diagnose_orden .contenido_ubicacion').html('');
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
		$('#modal_diagnose_orden .contenido_ubicacion').html(tmp_ubicacion);
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
			$('#modal_diagnose_orden .contenido_equipo').html('');
			$('#modal_diagnose_orden .contenido_equipo').html(tmp);

			tmp = '';
			if ($('.rol').val() <= 2) {
				$('#modal_diagnose_orden .contenendor_file').show();
				$('#modal_diagnose_orden .file').removeAttr('disabled', 'disabled');

				tmp += `
					<div class="row">
						<div class="col-sm-12">
							<label for="fecha_diagnostico">Fecha del diagnostico </label>
							<input required="" min="2015-01-01" type="date" name="fecha_diagnostico" id="fecha_diagnostico"  class="form-control"><input type="time" name="hora_diagnostico" id="hora_diagnostico" class="form-control">
							
						</div>
					</div><br>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<label for="tecnico_diagnostico_text">Relacione el nombre del tecnico que realiza el diagnostico</label>
							<input class="form-control" type="text" name="tecnico_diagnostico_text" id="tecnico_diagnostico_text">
						</div>
					</div>
				`;
			}

			$('#modal_diagnose_orden .contenido_administrador').html('');
			$('#modal_diagnose_orden .contenido_administrador').html(tmp);
			list_diagnosticos();
		}
	});
}
/*diagnostico de la orden*/
$('#modal_diagnose_orden .form_diagnosticar_orden').submit(function (e) {
	e.preventDefault();
	$('#modal_diagnose_orden #btn_update').attr('disabled', 'disabled');

	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'orden/Cordenes/update_diagnose_orden',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			$('#modal_diagnose_orden form').trigger('reset');
			datatable_destroy_orden();
			list_data_table_orden();
			$('#modal_diagnose_orden .close').click();
			$('#modal_diagnose_orden #btn_update').removeAttr('disabled', 'disabled');

			//alert("Se agrego correctamente la información del diagnostico");
			update_diagnose_orden_email(respuesta.contenido);
		} else {
			alert(respuesta.contenido);
		}
	});
});
function update_diagnose_orden_email(orden_id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/update_diagnose_orden_email',
		type: 'post',
		data: { id: orden_id },
	}).done(function (data) {
		alert('se envio un correo con la información del diagnostico realizado');
	});
}
$('#modal_archivo_diagnose_orden .form_diagnosticar_orden').submit(function (
	e
) {
	e.preventDefault();
	$('#modal_archivo_diagnose_orden #btn_update').attr('disabled', 'disabled');
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'orden/Cordenes/update_archivo_diagnose_orden',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		var respuesta = JSON.parse(data);

		$('#modal_archivo_diagnose_orden form').trigger('reset');
		datatable_destroy_orden();
		list_data_table_orden();
		$('#modal_archivo_diagnose_orden .close').click();
		$('#modal_archivo_diagnose_orden #btn_update').removeAttr(
			'disabled',
			'disabled'
		);

		//alert("Se agrego correctamente la información del diagnostico");
		update_diagnose_orden_email(respuesta.orden_id);
	});
});
