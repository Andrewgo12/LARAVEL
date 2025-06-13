if (controlador == 'Crepuestos') {
	list_data_table_repuesto();
}
async function list_data_table_repuesto() {
	let tabla = '';

	tabla = await $('#tblRepuestos').DataTable({
		language: {
			lengthMenu: 'Mostrar _MENU_ registros por pagina',
			zeroRecords: 'No se encontraron resultados en su busqueda',
			searchPlaceholder: 'Buscar registros',
			info: 'Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros',
			infoEmpty: 'No existen registros',
			infoFiltered: '(filtrado de un total de _MAX_ registros)',
			search: 'Buscar:',
			paginate: {
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior',
			},
		},

		lengthMenu: [
			[5, 10, 20, -1],
			[5, 10, 20, 'Todo'],
		],
		paging: true,
		info: true,
		filter: true,
		stateSave: true,
		bDestroy: true,
		ajax: {
			url: base_url + 'repuesto/Crepuestos/get_datatable',
			type: 'POST',
			dataSrc: '',
		},
		columns: [
			{ data: 'code' },
			{ data: 'name' },
			{
				orderable: true,
				render: function (data, type, row) {
					var tmp =
						`<ul class='list-inline'>

					<li class="list-inline-item"><a style="font-size:15px;" href="#" class=" btn btn-primary glyphicon glyphicon-pencil"  onClick="recover_modal_edit_repuesto(` +
						row.id +
						`,event)" ></a></li>
					<li class="list-inline-item"><a style="font-size:15px;" href="#" class=" btn btn-danger fa fa-minus-circle"  onClick="delete_repuesto(` +
						row.id +
						`,event)" ></a></li>
					</ul>`;

					// <li class="list-inline-item"><a href="#" class="glyphicon glyphicon-play-circle btn btn-success" onClick="contenido(`+row.id+`,event)"></a></li>
					return tmp;
				},
			},
		],
		columnDefs: [
			{
				targets: [1],
				data: 'name',
				render: function (data, type, row) {
					var tmp = '';
					tmp += '<strong>' + data + '</strong>';
					//tmp+=" <a style='padding:3px;' data-toggle='modal' data-target='#modal_show_movimientos' href='' class='btn btn-info glyphicon glyphicon-eye-open' onClick='modal_show_repuesto("+row.id+",event)'></a>";
					return tmp;
				},
			},
		],
	});
	return tabla;
}
function datatable_destroy_repuesto() {
	// destruir data table
	$('#tblRepuestos').dataTable().fnClearTable();
	$('#tblRepuestos').dataTable().fnDestroy();
}
function recover_modal_edit_repuesto(id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/getOne',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		$('#btn_update_equipo').removeAttr('disabled');
		var repuesto = '';
		repuesto = JSON.parse(data);
		$('#form_repuesto #id').val(repuesto.id);
		$('#form_repuesto #name').val(repuesto.name);
		$('#form_repuesto #code').val(repuesto.code);
		$('#form_repuesto #precio').val(repuesto.precio);
		$('#form_repuesto #grupo').val(repuesto.grupo);
	});
}
$('#form_repuesto').submit(function (e) {
	e.preventDefault();
	var formulario = '';
	var respuesta = '';

	if ($('#condicion').val() == 1) {
		//Editar
		formulario = new FormData(this);

		$.ajax({
			url: base_url + 'repuesto/Crepuestos/update',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			respuesta = JSON.parse(data);
			if (respuesta.respuesta == 1) {
				notify_repuesto('edit');
				datatable_destroy_repuesto();
				list_data_table_repuesto();
				$('#btn_update_equipo').attr('disabled', true);
			} else if (respuesta.respuesta == 2) {
				notify_repuesto(respuesta.informacion);
			}
		});
	} else {
		//Agregar
		formulario = new FormData(this);

		$.ajax({
			url: base_url + 'repuesto/Crepuestos/add',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			respuesta = JSON.parse(data);
			if (respuesta.respuesta == 1) {
				notify_repuesto('add');
				datatable_destroy_repuesto();
				list_data_table_repuesto();
				$('#btn_update_equipo').attr('disabled', true);
			} else if (respuesta.respuesta == 2) {
				notify_repuesto(respuesta.informacion);
			}
		});
	}
});
function delete_repuesto(id, e) {
	e.preventDefault();
	var confirmacion = confirm('¿Estas seguro de Eliminar este registro?');
	if (confirmacion) {
		$.ajax({
			url: base_url + 'repuesto/Crepuestos/delete',
			type: 'POST',
			data: {
				id: id,
			},
			success: function (data) {
				datatable_destroy_repuesto();
				list_data_table_repuesto();
				notify_repuesto('del');
			},
		});
	} else {
		alert('Eliminación cancelada');
	}
}
function notify_repuesto(action = '') {
	//mensajes de alerta
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'repuesto Agregado exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'repuesto Editado exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'repuesto Eliminado exitosamente';
		tipo = 'danger';
	} else {
		msj = action;
		tipo = 'danger';
	}

	$.notify(
		{
			// icon: 'glyphicon glyphicon-user',
			title: '<strong>MSJ:</strong> ',
			message: msj,
		},
		{
			type: tipo,
			placement: {
				from: 'top',
				align: 'left',
			},
		}
	);
}
function notify_movimiento(action = '') {
	//mensajes de alerta
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'Se ha realizado el movimiento exitosamente';
		tipo = 'success';
	}

	$.notify(
		{
			// icon: 'glyphicon glyphicon-user',
			title: '<strong>MSJ:</strong> ',
			message: msj,
		},
		{
			type: tipo,
			placement: {
				from: 'top',
				align: 'left',
			},
		}
	);
}
function aplicar_condicion(valor = '') {
	if (valor == 1) {
		$('#condicion').val('1'); // Editar
	} else {
		$('#condicion').val('2'); // Agrear
	}
}
function contenido(id, e) {
	e.preventDefault();
	$('.contenido').show();
	$('#id').val(id);
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/getOne',
		type: 'post',
		data: { id: id },
	}).done(function (data) {
		var repuesto = JSON.parse(data);
		$('#stock').val(repuesto.cantidad);
		$('.contenido h3').html(repuesto.name);
		if (repuesto.cantidad == null) {
			$('.consulta').html('En Stock: <h2>0</h2>');
		} else {
			$('.consulta').html('En Stock: <h2>' + repuesto.cantidad + '</h2>');
		}
	});
}
function sumar() {
	var id = $('#id').val();
	var stock = $('#stock').val();
	var cantidad = $('#cantidad').val();
	var razon = $('#razon').val();
	if (parseInt(cantidad) <= 0) {
		alert('Solo son validos valores mayores  0');
	} else {
		$.ajax({
			url: base_url + 'repuesto/Crepuestos/sumar',
			type: 'post',
			data: { id: id, cantidad: cantidad, stock: stock, razon: razon },
		}).done(function (data) {
			notify_movimiento('add');
			datatable_destroy_repuesto();
			list_data_table_repuesto();
			$('td h2').html(data);
			$('#cantidad').val('');
			$('#razon').val('');
			$('#stock').val(data);
		});
	}
}
function restar() {
	var id = $('#id').val();
	var stock = $('#stock').val();
	var cantidad = $('#cantidad').val();
	var razon = $('#razon').val();
	if (parseInt(cantidad) > parseInt(stock)) {
		alert('La cantidad que pretende retirar excede el stock');
	} else if (parseInt(cantidad) == parseInt(stock)) {
		var mensaje = confirm('desea retirar todas las unidades existentes?');
		if (mensaje) {
			$.ajax({
				url: base_url + 'repuesto/Crepuestos/restar',
				type: 'post',
				data: { id: id, cantidad: cantidad, stock: stock, razon: razon },
			}).done(function (data) {
				datatable_destroy_repuesto();
				list_data_table_repuesto();
				$('td h2').html(data);
				$('#cantidad').val('');
				$('#stock').val(data);
			});
		} else {
			alert('Movimiento no realizado');
		}
	} else {
		$.ajax({
			url: base_url + 'repuesto/Crepuestos/restar',
			type: 'post',
			data: { id: id, cantidad: cantidad, stock: stock, razon: razon },
		}).done(function (data) {
			notify_movimiento('add');
			datatable_destroy_repuesto();
			list_data_table_repuesto();
			$('td h2').html(data);
			$('#cantidad').val('');
			$('#razon').val('');
			$('#stock').val(data);
		});
	}
}
function modal_show_repuesto(id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/show',
		type: 'post',
		data: { repuesto_id: id },
	}).done(function (data) {
		$('#modal_show_movimientos .modal-body').html(data);
	});
}
// Fecha para realizar el check de repuestos en la tabla de mantenimientos preventivos
$('#modal_update_preventivo .repuesto_pendiente').click(function (e) {
	//e.preventDefault();
	//var ele = document.getElementById("repuesto_pendiente");
	var ele = $('#modal_update_preventivo .repuesto_pendiente').is(':checked');
	var id = '';
	id = $('#modal_update_preventivo #id').val();
	var equipo_id = $('#modal_update_preventivo #equipo_id').val();
	if (ele == true) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/repuesto_pendiente_preventivo_true',
			type: 'POST',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			datatable_destroy();
			//list_data_table_server_side();
			list_data_table_server_side_filtros();
			list_preventivos2(equipo_id);

			//$("#modal_show_file .modal-body").html(data);
		});
	} else {
		$.ajax({
			url: base_url + 'equipo/Cequipos/repuesto_pendiente_preventivo_false',
			type: 'POST',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			datatable_destroy();
			//list_data_table_server_side();
			list_data_table_server_side_filtros();
			list_preventivos2(equipo_id);

			//$("#modal_show_file .modal-body").html(data);
		});
	}
});
$('#modal_update_correctivo_general .repuesto_pendiente').click(function (e) {
	//e.preventDefault();
	var ele = $('#modal_update_correctivo_general .repuesto_pendiente').is(
		':checked'
	);
	//var ele= $("#modal_update_correctivo_general .repuesto_pendiente").attr('checked');
	var id = '';
	id = $('#modal_update_correctivo_general #id').val();
	var equipo_id = $('#modal_update_correctivo_general #equipo_id').val();

	if (ele == true) {
		$.ajax({
			url:
				base_url + 'equipo/Cequipos/repuesto_pendiente_correctivo_general_true',
			type: 'POST',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			datatable_destroy();
			list_data_table_server_side_filtros();
			list_correctivos_generales2(equipo_id);
		});
	} else {
		$.ajax({
			url:
				base_url +
				'equipo/Cequipos/repuesto_pendiente_correctivo_general_false',
			type: 'POST',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			datatable_destroy();
			list_data_table_server_side_filtros();
			//list_data_table_server_side();
			list_correctivos_generales2(equipo_id);

			//$("#modal_show_file .modal-body").html(data);
		});
	}
});
$('#modal_update_observacion .repuesto_pendiente').click(function (e) {
	//e.preventDefault();
	var ele = $('#modal_update_observacion .repuesto_pendiente').is(':checked');
	//var ele= $("#modal_update_observacion .repuesto_pendiente").attr('checked');
	var id = '';
	id = $('#modal_update_observacion #id').val();
	var equipo_id = $('#modal_update_observacion #equipo_id').val();

	if (ele == true) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/repuesto_pendiente_observacion_true',
			type: 'POST',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			datatable_destroy();
			list_observaciones2(equipo_id);
			list_data_table_server_side_filtros();
		});
	} else {
		$.ajax({
			url: base_url + 'equipo/Cequipos/repuesto_pendiente_observacion_false',
			type: 'POST',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			datatable_destroy();
			list_observaciones2(equipo_id);
			list_data_table_server_side_filtros();

			//$("#modal_show_file .modal-body").html(data);
		});
	}
});
/*Logica para hacer un datatable con filtros por columna*/
var table = $('.datatable-repuesto-consolidado').DataTable({
	orderCellsTop: true,
	fixedHeader: true,
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
	dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
});
function show_repuestos_instalados() {
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/show_repuestos_instalados',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_show .modal-body').html(data);
		$('#modal_show .tbl_repuestos_instalados').dataTable({
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
function show_repuestos_pendientes() {
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/show_repuestos_pendientes',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_show .modal-body').html(data);

		$('.tbl_repuestos_pendientes thead tr')
			.clone(true)
			.appendTo('.tbl_repuestos_pendientes thead');
		$('.tbl_repuestos_pendientes thead tr:eq(1) th').each(function (i) {
			var title = $(this).text();
			if (title == 'Origen') {
				$(this).html(`
					<select name="" id="" class="form-control">
						<option value="">------</option>
						<option value="PREVENTIVOS">PREVENTIVOS</option>
						<option value="CORRECTIVOS">CORRECTIVOS</option>
						<option value="OBSERVACIONES">OBSERVACIONES</option>
					</select>

					`);
				$('select', this).on('change', function () {
					if (table.column(i).search() !== this.value) {
						table.column(i).search(this.value).draw();
					}
				});
			} else {
				$(this).html(
					'<input type="text" placeholder="Buscar ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table.column(i).search(this.value).draw();
					}
				});
			}
		});

		var table = $('#modal_show .tbl_repuestos_pendientes').DataTable({
			orderCellsTop: true,
			fixedHeader: true,
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
			dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
			lengthMenu: [
				[5, 10, 20],
				[5, 10, 20],
			],
		});
	});
}
function show_resumen_general() {
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/show_resumen_general',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_show .modal-body').html(data);
	});
}
function show_resumen_por_repuesto() {
	$.ajax({
		url: base_url + 'repuesto/Crepuestos/show_resumen_por_repuesto',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_show .modal-body').html(data);

		$('#tbl_resumen_por_repuesto thead tr')
			.clone(true)
			.appendTo('#tbl_resumen_por_repuesto thead');
		$('#tbl_resumen_por_repuesto thead tr:eq(1) th').each(function (i) {
			var title = $(this).text();
			if (title != 'Mes') {
				$(this).html(
					'<input type="text" placeholder="Buscar ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table.column(i).search(this.value).draw();
					}
				});
			} else {
				$(this).html(`
					<select name="" id="" class="form-control">
					<option value="">------</option>
					<option value="ENERO">ENERO</option>
					<option value="FEBRERO">FEBRERO</option>
					<option value="MARZO">MARZO</option>
					<option value="ABRIL">ABRIL</option>
					<option value="MAYO">MAYO</option>
					<option value="JUNIO">JUNIO</option>
					<option value="JULIO">JULIO</option>
					<option value="AGOSTO">AGOSTO</option>
					<option value="SEPTIEMBRE">SEPTIEMBRE</option>
					<option value="OCTUBRE">OCTUBRE</option>
					<option value="NOVIEMBRE">NOVIEMBRE</option>
					<option value="DICIEMBRE">DICIEMBRE</option>
					</select>

					`);
				$('select', this).on('change', function () {
					if (table.column(i).search() !== this.value) {
						table.column(i).search(this.value).draw();
					}
				});
			}
		});
		var table = $('#tbl_resumen_por_repuesto').DataTable({
			orderCellsTop: true,
			fixedHeader: true,
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
			dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
			lengthMenu: [
				[5, 10, 20],
				[5, 10, 20],
			],
		});
	});
}
function show_resumen_inversion_repuestos_equipo() {
	$.ajax({
		url:
			base_url + 'repuesto/Crepuestos/show_resumen_inversion_repuestos_equipo',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_show .modal-body').html(data);
	});
}
function show_resumen_inversion_repuestos_servicio() {
	$.ajax({
		url:
			base_url +
			'repuesto/Crepuestos/show_resumen_inversion_repuestos_servicio',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_show .modal-body').html(data);
	});
}
