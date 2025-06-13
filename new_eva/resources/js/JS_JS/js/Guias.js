sessionStorage.nombre = '';
$(document).ready(function () {
	$('#myInput').on('keyup', function () {
		let value = $(this).val().toLowerCase();
		$('.tabla_guias tr').filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
		});
	});
});
$('.nav-tabs a').click(function () {
	$(this).tab('show');
});
$('.filtro_grupos').on('keyup', function () {
	let value = $(this).val().toLowerCase();
	$('.tbl-indicador-por-guia tr').filter(function () {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
	});
});
if (controlador == 'Cguias') {
	tbl_indicador_por_guia();
	tbl_inclusion_riesgo();
	tbl_exclusion_estado();
	function ObtenerListadoNombreEquipos() {
		$.ajax({
			url: base_url + 'equipo/Cequipos/ObtenerListadoNombreEquipos',
			type: 'post',
			data: {},
		}).done(function (data) {
			let respuesta = JSON.parse(data);
			let tmp = '';
			$.each(respuesta, function (i, item) {
				tmp += `
				<option value="${item.name}">${item.name}</option>
				`;
			});
			$('.datalistNombreEquipos').html('');
			$('.datalistNombreEquipos').html(tmp);
		});
	}
	function ObtenerListadoModeloEquipos() {
		$.ajax({
			url: base_url + 'equipo/Cequipos/ObtenerListadoModeloEquipos',
			type: 'post',
			data: {},
		}).done(function (data) {
			let respuesta = JSON.parse(data);
			let tmp = '';
			$.each(respuesta, function (i, item) {
				tmp += `
				<option value="${item.modelo}">${item.modelo}</option>
				`;
			});
			$('.datalistModeloEquipos').html('');
			$('.datalistModeloEquipos').html(tmp);
		});
	}
	function ObtenerListadoMarcaEquipos() {
		$.ajax({
			url: base_url + 'equipo/Cequipos/ObtenerListadoMarcaEquipos',
			type: 'post',
			data: {},
		}).done(function (data) {
			let respuesta = JSON.parse(data);
			let tmp = '';
			$.each(respuesta, function (i, item) {
				tmp += `
				<option value="${item.marca}">${item.marca}</option>
				`;
			});
			$('.datalistMarcaEquipos').html('');
			$('.datalistMarcaEquipos').html(tmp);
		});
	}
	tabla_guias();
	ObtenerListadoNombreEquipos();
	ObtenerListadoMarcaEquipos();
	ObtenerListadoModeloEquipos();
}
function tabla_guias() {
	$.ajax({
		url: base_url + 'guia/Cguias/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		let guias = JSON.parse(data);
		let tmp = '';
		$.each(guias, function (i, guia) {
			tmp +=
				`
			<tr>
			<td>${guia.id}</td>
			<td>` +
				guia.name +
				`<a target="__blank" href="${base_url}assets/upload_guias/${guia.file}"><i style="font-size:20px;color:orange;fonte-weight:900;" class="fa fa-paperclip"></i></a></td>
			<td><div class="item-${guia.id}">${guia.nro_equipos}</div></td>			
			<td>`;
			if (guia.estado != 1) {
				tmp +=
					'<span><i class="glyphicon glyphicon-remove"></i>&nbsp;Inactivo</span>';
			} else {
				tmp +=
					'<span><i class="glyphicon glyphicon-ok"></i>&nbsp;Activo</span>';
			}
			tmp += `</td>
			<td>
			<ul class="list-inline">`;
			if (editar_guia == 1) {
				tmp += `
				<li class="list-inline-item">
				<a data-toggle="modal" data-target="#modal_update_guia" onclick="recover_modal_edit_guia(${guia.id})"  href="#" class="btn btn-info"><i class="fa fa-pencil"></i></a>
				</li>
				`;
			}
			if (guia.estado == 1) {
				if (editar_equipo == 1) {
					tmp += `
						<li class="list-inline-item">
						<a onclick="modal_show_relacionar_guia_equipos(${guia.id},event)" data-toggle="modal" data-target="#modal_show_relacionar_guia_equipos"  href="#" class="btn btn-primary"><i class="fa fa-random"></i></a>
						</li>`;
				}
				if (eliminar_guia1 == 1) {
					tmp += `
						<li class="list-inline-item">
						<a onclick="eliminar_guia(${guia.id})"  href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
						</li>
						`;
				}
			}
			tmp += `
				</ul>	
				</td>
				</tr>
				`;
		});
		$('.tblguias').dataTable().fnClearTable();
		$('.tblguias').dataTable().fnDestroy();
		$('.tblguias tbody').html(tmp);
		$('.tblguias').dataTable({
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
			stateSave: true,
			paging: true,
			dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
			lengthMenu: [
				[5, 10, 20],
				[5, 10, 20],
			],
		});
	});
}
$('.form_guia').submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);
	$.ajax({
		url: base_url + 'guia/Cguias/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			$('.close').click();
			$('.form_guia').trigger('reset');
			$('.mensaje-guia-exito')
				.html(
					`<span style="font-size:30px;color:green;font-weight:900;">Informacion ingresada exitosamente<i class="fa fa-refresh fa-spin"></i></span>`
				)
				.fadeIn()
				.delay(3000)
				.fadeOut('slow');
			tabla_guias();
		} else {
			$('.mensaje-guia-error')
				.html(
					`<span style="font-size:30px;color:red;font-weight:900;">${respuesta.informacion}<i class="fa fa-refresh fa-spin"></i></span>`
				)
				.fadeIn()
				.delay(3000)
				.fadeOut('slow');
		}
	});
});
function eliminar_guia(id) {
	$.ajax({
		url: base_url + 'guia/Cguias/delete',
		type: 'post',
		data: {
			id: id,
		},
	}).done(function () {
		tabla_guias();
		$('.mensaje-guia-exito')
			.html(
				`<span style="font-size:30px;color:red;font-weight:900;">El registro ha sido deshabilitado exitosamente exitosamente<i class="fa fa-refresh fa-spin"></i></span>`
			)
			.fadeIn()
			.delay(3000)
			.fadeOut('slow');
	});
}
function recover_modal_edit_guia(id) {
	$.ajax({
		url: base_url + 'guia/Cguias/getOne',
		type: 'post',
		data: {
			id: id,
		},
	}).done(function (data) {
		let guia = JSON.parse(data);
		$('.form_update_guia #id').val(guia.id);
		$('.form_update_guia #name').val(guia.name);
		$('.form_update_guia #estado').val(guia.estado);
	});
}
$('.form_update_guia').submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);
	$.ajax({
		url: base_url + 'guia/Cguias/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		contentType: false,
		cache: false,
		processData: false,
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			$('.close').click();
			$('.mensaje-guia-exito')
				.html(
					`<span style="font-size:30px;color:green;font-weight:900;">${respuesta.informacion}<i class="fa fa-refresh fa-spin"></i></span>`
				)
				.fadeIn()
				.delay(3000)
				.fadeOut('slow');
		} else {
			$('.mensaje-guia-error')
				.html(
					`<span style="font-size:30px;color:red;font-weight:900;">${respuesta.informacion}<i class="fa fa-refresh fa-spin"></i></span>`
				)
				.fadeIn()
				.delay(3000)
				.fadeOut('slow');
			$('.close').click();
		}
		tabla_guias();
	});
});
function detail_relacionar() {
	$.ajax({
		url: base_url + 'guia/Cguias/detail_relacionar',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_link .contenido').html(data);
		$('.tblRelacionGuias').dataTable({
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
			stateSave: true,
			dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
			lengthMenu: [
				[5, 10, 20],
				[5, 10, 20],
			],
		});
	});
}
function modal_show_relacionar_guia(id) {
	$('#modal_show_relacionar_guia .id').val(id);
}
function enviar_a_formulario(nombre, marca, modelo) {
	$('#modal_show_relacionar_guia #nombre').val(nombre);
	$('#modal_show_relacionar_guia #marca').val(marca);
	$('#modal_show_relacionar_guia #modelo').val(modelo);
}
$('#formulario_guia').submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);
	if ($('#modal_show_relacionar_guia #nombre').val() == '') {
		alert('No se ha ingresado información');
	} else {
		$.ajax({
			url: base_url + 'guia/Cguias/cantidad_relacionar_con_equipos',
			type: 'post',
			data: formulario,
			dataType: 'html',
			contentType: false,
			cache: false,
			processData: false,
		}).done(function (data) {
			let cantidad = JSON.parse(data);
			let confirmacion = confirm(
				`Por los parametros seleccionados se asociaran ${cantidad} equipos a la guia rapida. ¿desea continuar?`
			);
			if (confirmacion) {
				$.ajax({
					url: base_url + 'guia/Cguias/relacionar_con_equipos',
					type: 'post',
					data: formulario,
					dataType: 'html',
					contentType: false,
					cache: false,
					processData: false,
				}).done(function () {
					tabla_guias();
					$('#modal_show_relacionar_guia #formulario_guia').trigger('reset');
					$('#modal_show_relacionar_guia .close').click();
					actualizar_cobertura_biomedicos();
					actualizar_cobertura_industriales();
					alert('Información asociada correctamente');
				});
			} else {
				alert('Operción cancelada');
			}
		});
	}
});
function actualizar_cobertura_biomedicos() {
	$.ajax({
		url: base_url + 'guia/Cguias/getCoberturaBiomedicos',
		type: 'post',
		data: {},
	}).done(function (data) {
		let cobertura = JSON.parse(data);
		let tmp = '';
		tmp += `
		COBERTURA DE GUIAS RAPIDAS: <strong style="font-size: 20px;">${cobertura.cobertura}</strong>
		`;
		$('.cobertura_biomedicos').html(tmp);
	});
}
function actualizar_cobertura_industriales() {
	$.ajax({
		url: base_url + 'guia/Cguias/getCoberturaIndustriales',
		type: 'post',
		data: {},
	}).done(function (data) {
		let cobertura = JSON.parse(data);
		let tmp = '';
		tmp += `
		COBERTURA DE GUIAS RAPIDAS: <strong style="font-size: 20px;">${cobertura.cobertura}</strong>
		`;
		$('.cobertura_industriales').html(tmp);
	});
}
function show_consulta_guia() {
	$.ajax({
		url: base_url + 'guia/Cguias/show',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_consulta_guia .modal-body').html(data);
		$('.datatable-guias').dataTable({
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
			paging: true,
			filter: true,
			info: true,
			stateSave: true,
			dom: '<"top"ifp<"clear">>rlt<"bottom"ilp<"clear">>',
		});
	});
}
function asociar_guia_rapida(guia_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'guia/Cguias/getOne',
		type: 'post',
		data: { id: guia_id },
	}).done(function (data) {
		resultado = JSON.parse(data);
		$('#modal_update_equipo #form_update_equipo .guia_id').val(resultado.id);
		$('#modal_update_equipo #form_update_equipo .contenedor_name_guia').html(
			resultado.name
		);
		$('#modal_copy #form_equipo_copy .guia_id').val(resultado.id);
		$('#modal_copy #form_equipo_copy .contenedor_name_guia').html(
			resultado.name
		);
		if (
			resultado.file != null &&
			resultado.file != undefined &&
			resultado.file != ''
		) {
			let archivo =
				`
			<a target="__blank" href="` +
				base_url +
				`assets/upload_guias/${resultado.file}"><span class="fa fa-paperclip"></span></a>
			`;
			$('.contenedor_archivo_guia').html(archivo);
		}
		$('#modal_consulta_guia .close').click();
	});
}
function borrar_reacion_guia() {
	$('#modal_update_equipo #form_update_equipo .guia_id').val(0);
	$('#modal_update_equipo #form_update_equipo .contenedor_name_guia').html('');
	$('#modal_copy #form_equipo_copy .guia_id').val(0);
	$('#modal_copy #form_equipo_copy .contenedor_name_guia').html('');
	$('.contenedor_archivo_guia').html('');
}
function modal_show_relacionar_guia_equipos(id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'guia/Cguias/show_combinaciones',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		$('#modal_show_relacionar_guia_equipos .modal-body').html(data);
		$('#modal_show_relacionar_guia_equipos .tbl-combinaciones').dataTable({
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
			paging: true,
			filter: true,
			info: true,
			stateSave: true,
			dom: '<"top"ifp<"clear">>rlt<"bottom"ilp<"clear">>',
		});
	});
}
function relacionar_guia_con_equipos(id, name, marca, modelo, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'guia/Cguias/relacionar_guia_con_equipos',
		type: 'post',
		data: {
			id: id,
			nombre: name,
			marca: marca,
			modelo: modelo,
		},
	}).done(function (data) {
		$('#modal_show_relacionar_guia_equipos .close').click();
		$('.mensaje-guia-exito')
			.html(
				`<span style="font-size:30px;color:green;font-weight:900;">Se han asociado los equipos a la guia rapida<i class="fa fa-refresh fa-spin"></i></span>`
			)
			.fadeIn()
			.delay(2000)
			.fadeOut('slow');
		actualizar_cobertura_biomedicos();
		actualizar_cobertura_industriales();
		let cantidad = JSON.parse(data);
		$('.item-' + id).html(cantidad.cantidad);
		tbl_indicador_por_guia();
	});
}
function tbl_indicador_por_guia() {
	$.ajax({
		url: base_url + 'guia/Cguias/get_indicador_por_guia',
		type: 'post',
		data: {},
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		tmp = '';
		$.each(respuesta, function (i, registro) {
			tmp += `
			<tr>
			<td>${registro.nombre}<span class="glyphicon glyphicon-list" onclick="listado_detalle_indicador_por_guia('${registro.nombre}')"></span></td>
			<td>${registro.cantidad_individual}</td>
			<td>${registro.cantidad_total}</td>
			<td>${registro.porcentaje}</td>
			</tr>	
			`;
		});
		$('.tbl-indicador-por-guia tbody').html(tmp);
		if (sessionStorage.nombre != '') {
			listado_detalle_indicador_por_guia(sessionStorage.nombre);
		}
	});
}
function listado_detalle_indicador_por_guia(nombre) {
	sessionStorage.nombre = nombre;
	$(`.nav-tabs a[href="#detallados"`).tab('show');
	$.ajax({
		url: base_url + 'equipo/Cequipos/listado_detalle_por_nombre_equipo',
		type: 'post',
		data: { name: nombre },
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		tmp = '';
		$.each(respuesta, function (i, registro) {
			tmp += `
				<tr>
					<td>${registro.name}</td>
					<td>${registro.marca}</td>
					<td>${registro.modelo}</td>
					<td>${registro.cantidad_total}</td>
					<td>${registro.cantidad_con_guia}</td>
				</tr>	
			`;
		});
		$('.tbl-detallados tbody').html(tmp);
	});
}
function tbl_inclusion_riesgo() {
	$.ajax({
		url: base_url + 'guia/Cguias/getRiesgosIncluidos',
		type: 'post',
		data: {},
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		let tmp = '';
		$.each(respuesta, function (i, registro) {
			tmp += `
				<tr>
					<td>${registro.name}</td>
				</tr>	
			`;
		});
		$('.tbl-riesgos-incluidos tbody').html(tmp);
	});
}
function tbl_exclusion_estado() {
	$.ajax({
		url: base_url + 'guia/Cguias/getEstadosExcluidos',
		type: 'post',
		data: {},
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		let tmp = '';
		$.each(respuesta, function (i, registro) {
			tmp += `
				<tr>
					<td>${registro.name}</td>
				</tr>	
			`;
		});
		$('.tbl-estados-excluidos tbody').html(tmp);
	});
}
