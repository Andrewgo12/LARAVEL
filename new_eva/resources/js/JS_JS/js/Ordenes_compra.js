if (controlador == 'Cordenes_compra') {
	/* select_secop(); */
	list_ordenes_compra();
}
function list_ordenes_compra() {
	let tmp = '';
	$.ajax({
		url: base_url + 'ordenes_compra/Cordenes_compra/getWithNumberDevices',
		type: 'post',
		data: {},
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		$.each(respuesta, function (i, item) {
			tmp += '<tr>';
			tmp += `<td>` + item.orden;
			if (item.url_secop != undefined) {
				tmp +=
					`<a style="font-size:20px;color:black;font-weight:900;" class="glyphicon glyphicon-link" target="__top" href="` +
					item.url_secop +
					`"></a>`;
			}
			tmp += '</td>';
			tmp += '<td>' + item.tipo_compra + '</td>';
			tmp += '<td>' + item.fecha + '</td>';
			if (item.file != null && item.file != '') {
				tmp +=
					"<td><a class='glyphicon glyphicon-file' target='__blank' href='" +
					base_url +
					'assets/upload_ordenes_compra/' +
					item.file +
					"'></a></td>";
			} else {
				tmp += '<td></td>';
			}
			tmp += '<td>' + item.proveedor + '</td>';

			tmp +=
				"<td><a data-toggle='modal' data-target='#modal_update_orden_compra' onclick='recover_modal_edit_orden_compra(" +
				item.id +
				")' style='font-size:12px;' class='btn btn-info glyphicon glyphicon-pencil'></a>";
			tmp +=
				"<a href='' data-toggle='modal' data-target='#modal_asociacion_orden_compra' class='orden_compra_multiple glyphicon glyphicon glyphicon-random' onclick='asociar_multiple_orden_compra(" +
				item.id +
				",event)'></a><hr> <span class='smallmsj'>Asociado a un total de <span style='font-size:20px;font-weight:900;color:green;'><a class='badge' onclick='consultar_equipos_orden_compra(" +
				item.id +
				",event)' data-toggle='modal' data-target='#modal_asociacion_orden_compra_especifico' href='' target='__blank'>" +
				item.cuenta +
				'</a></span> Equipos</span></td>';

			tmp += '</tr>';
		});
		$('.tabla_ordenes_compra').dataTable().fnClearTable();
		$('.tabla_ordenes_compra').dataTable().fnDestroy();
		$('.tabla_ordenes_compra tbody').html(tmp);
		$('.tabla_ordenes_compra').dataTable({
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
$('#modal_add_orden_compra .form_add_orden_compra').submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);
	$.ajax({
		url: base_url + 'ordenes_compra/Cordenes_compra/add',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			alert('Soporte de compra agregada exitosamente');
			$('#modal_add_orden_compra .close').click();

			list_ordenes_compra();
			list_data_table_server_side_filtros();
		} else {
			alert(respuesta.informacion_error);
		}
	});
});
$('#modal_update_orden_compra .form_update_orden_compra').submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);

	$.ajax({
		url: base_url + 'ordenes_compra/Cordenes_compra/update',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		if (respuesta.caso == 1) {
			alert('Informacion actualizada exitosamente');
			$('#modal_update_orden_compra .close').click();

			$('.secop_id').select2('destroy');
			select_secop();
			list_ordenes_compra();
		} else {
			alert(respuesta.informacion_error);
		}
	});
});
function recover_modal_edit_orden_compra(id) {
	$('.form_update_orden_compra').trigger('reset');

	$.ajax({
		url: base_url + 'ordenes_compra/Cordenes_compra/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		let orden_compra = JSON.parse(data);
		$('#modal_update_orden_compra #id').val(orden_compra.id);
		$('#modal_update_orden_compra #orden').val(orden_compra.orden);
		$('#modal_update_orden_compra #fecha').val(orden_compra.fecha);
		$('#modal_update_orden_compra #proveedor_id').val(
			orden_compra.proveedor_id
		);
		$('#modal_update_orden_compra #tipo_compra_id').val(
			orden_compra.tipo_compra_id
		);
		$('#modal_update_orden_compra #url_secop').val(orden_compra.url_secop);
	});
}
function show_consulta_orden_compra(e, tipo_compra) {
	e.preventDefault();
	if (tipo_compra == 1) {
		$.ajax({
			url: base_url + 'ordenes_compra/Cordenes_compra/show_ordenes_compra',
			type: 'post',
			data: {},
		}).done(function (data) {
			$('#modal_consulta_orden_compra .modal-body').html(data);
			$('.datatable-ordenes-compra').dataTable();
		});
	} else if (tipo_compra == 2) {
		$.ajax({
			url: base_url + 'ordenes_compra/Cordenes_compra/show_contratos',
			type: 'post',
			data: {},
		}).done(function (data) {
			$('#modal_consulta_orden_compra .modal-body').html(data);
			$('.datatable-ordenes-compra').dataTable();
		});
	} else if (tipo_compra == 3) {
		$.ajax({
			url: base_url + 'ordenes_compra/Cordenes_compra/show_cruces_cuentas',
			type: 'post',
			data: {},
		}).done(function (data) {
			$('#modal_consulta_orden_compra .modal-body').html(data);
			$('.datatable-ordenes-compra').dataTable();
		});
	} else if (tipo_compra == 4) {
		$.ajax({
			url: base_url + 'ordenes_compra/Cordenes_compra/show_comodatos',
			type: 'post',
			data: {},
		}).done(function (data) {
			$('#modal_consulta_orden_compra .modal-body').html(data);
			$('.datatable-ordenes-compra').dataTable();
		});
	}
}
function asociar_orden_compra(orden_compra_id) {
	$.ajax({
		url: base_url + 'ordenes_compra/Cordenes_compra/getOne',
		type: 'post',
		data: { id: orden_compra_id },
	}).done(function (data) {
		resultado = JSON.parse(data);

		$('#modal_update_equipo #form_update_equipo #orden_compra_id').val(
			resultado.id
		);
		$('#modal_update_equipo #form_update_equipo .orden_compra_orden').html(
			resultado.orden
		);

		$('#modal_copy #form_equipo_copy #orden_compra_id').val(resultado.id);
		$('#modal_copy #form_equipo_copy .orden_compra_orden').html(
			resultado.orden
		);

		if (resultado.file != null && resultado.file != '') {
			let anclor_orden_compra = '';
			anclor_orden_compra +=
				"<a title='" +
				resultado.file +
				"' class='glyphicon glyphicon-file' href='" +
				base_url +
				'assets/upload_ordenes_compra/' +
				resultado.file +
				"' target='__blank'></a>";
			$('#modal_update_equipo #form_update_equipo .file_orden_compra').html(
				anclor_orden_compra
			);
			$('#modal_copy #form_equipo_copy .file_orden_compra').html(
				anclor_orden_compra
			);
		} else {
			$('#modal_update_equipo #form_update_equipo .file_orden_compra').html('');
			$('#modal_copy #form_equipo_copy .file_orden_compra').html('');
		}

		$('#modal_consulta_orden_compra .close').click();
	});
}
function cancelar_seleccion_orden_compra() {
	$('#modal_update_equipo #form_update_equipo #orden_compra_id').val(null);
	$('#modal_update_equipo #form_update_equipo .orden_compra_orden').html('');
	$('#modal_update_equipo #form_update_equipo .file_orden_compra').html('');
}
function asociar_multiple_orden_compra(orden_compra_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cequipos/show_orden_compra_asociaciones',
		type: 'post',
		data: { orden_compra_id: orden_compra_id },
	}).done(function (data) {
		$('#modal_asociacion_orden_compra .modal-body').html(data);
		$('.orden-compra-asociacion').dataTable();
	});
}
$(
	'#modal_asociacion_orden_compra .form_asociacion_orden_compra_equipos'
).submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cequipos/update_multiples_ordenes_compra',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_asociacion_orden_compra .close').click();
		list_ordenes_compra();
		alert(data);
	});
});
$(
	'#modal_asociacion_orden_compra_especifico .form_asociacion_orden_compra_equipos_especifico'
).submit(function (e) {
	e.preventDefault();
	let formulario = new FormData(this);

	$.ajax({
		url: base_url + 'equipo/Cequipos/update_multiples_ordenes_compra_eliminar',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_asociacion_orden_compra_especifico .close').click();
		list_ordenes_compra();
		alert(data);
	});
});
function consultar_equipos_orden_compra(orden_compra_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'equipo/Cequipos/show_equipos_en_orden_compra',
		type: 'post',
		data: { orden_compra_id: orden_compra_id },
	}).done(function (data) {
		$('#modal_asociacion_orden_compra_especifico .modal-body').html(data);
		$('.orden-compra-asociacion-especifico').dataTable();
	});
}
function consultar_secop(e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'ordenes_compra/Cordenes_compra/consultar_secop',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_api .modal-body').html(data);
		$('.tabla_secop').dataTable({
			order: [[2, 'desc']],
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
// async function select_secop() {
//   const response = await $.ajax({
//     /* url: "https://www.datos.gov.co/resource/xvdy-vvsk.json", */
//     url: "https://www.datos.gov.co/resource/xvdy-vvsk.json?nombre_de_la_entidad=VALLE DEL CAUCA  ESE HOSPITAL UNIVERSITARIO DEL VALLE EVARISTO GARCÍA&$limit=10000",
//     type: "get",
//     data: {
//       /* "$limit" : 5000, */
//       "$$app_token": "0iTwkhcEox4XRHJKGZvx2Z64k"
//     }
//   }).done(function (data) {
//     let secop = data;
//     secop = data;
//     let tmp = "<option value=0>-----------</option>";
//     $.each(secop, function (i, registro) {
//       tmp += `
// 				<option value=${registro.ui}>${registro.ui}---(${registro.ui})</option>
// 			`;
//     });
//     $(".secop_id").html(tmp);
//     $(".secop_id").select2();

//   });
// }
// select_secop();
