$('.imprimir-ticket').click(function () {
	$('.contenido-modal-timeline').print({
		title: 'Detalle del Ticket',
	});
});
var tabla = '';
tabla = list_data_table();

function list_data_table() {
	var sede_id = $('.orden_cerrada .sede_id').val();
	var url = base_url + 'orden/Cordenes/getClosed';
	var tabla = '';

	tabla = $('#tblOrdenes').DataTable({
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
			[5, 10, -1],
			[5, 10, 'Todo'],
		],
		paging: true,
		info: true,
		filter: true,
		stateSave: true,
		bDestroy: true,
		ajax: {
			//
			url: url,
			type: 'POST',
			data: { sede_id: sede_id },
			dataSrc: '',
		},
		dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
		columns: [
			{
				class: 'details-control',
				orderable: false,
				data: null,
				defaultContent: '',
			},
			{ data: 'id' },
			{ data: 'descripcion' },
			{ data: 'reparacion' },
			{ data: 'tiempo' },
			{
				orderable: true,
				render: function (data, type, row) {
					var msj = '';
					msj +=
						'<a href="" title="Seguimiento del Ticket" id="btn_upd" class="fa fa-folder-open-o" data-toggle="modal" data-target="#modal_timeline_orden" onClick="getTimeline(' +
						row.id +
						')" style="font-size:30px;color:#252525;" ></a>';

					return msj;
				},
			},
		],
		columnDefs: [
			{
				targets: [2],
				data: 'estado_id',
				render: function (data, type, row) {
					var tmp = '';
					tmp += `<strong>Origen</strong>:` + row.subproceso + '<br>';
					if (row.equipo_id) {
						tmp +=
							`
					<ul class="list-inline" style="text-transform: uppercase;">
						<li class="list-inline-item"><strong>Equipo:</strong></li>
						<li class="list-inline-item">` +
							row.equipo +
							`</li>
					</ul>
					<ul class="list-inline" style="text-transform: uppercase;">
						<li class="list-inline-item"><strong>Codigo:</strong></li>
						<li class="list-inline-item">` +
							row.codigo +
							`</li>
					</ul>
					<ul class="list-inline" style="text-transform: uppercase;">
						<li class="list-inline-item"><strong>Serie:</strong></li>
						<li class="list-inline-item">` +
							row.serial +
							`</li>
					</ul>
				`;
					} else {
						if (row.nombre_equipo) {
							tmp +=
								`
					<ul class="list-inline" style="text-transform: uppercase;">
						<li class="list-inline-item"><strong>Equipo:</strong></li>
						<li class="list-inline-item">` +
								row.nombre_equipo +
								`</li>
					</ul>
					<ul class="list-inline" style="text-transform: uppercase;">
						<li class="list-inline-item"><strong>Codigo:</strong></li>
						<li class="list-inline-item">` +
								row.codigo_equipo +
								`</li>
					</ul>
					<ul class="list-inline" style="text-transform: uppercase;">
						<li class="list-inline-item"><strong>Serie:</strong></li>
						<li class="list-inline-item">` +
								row.serie_equipo +
								`</li>
					</ul>
				`;
						}
					}
					tmp +=
						`<div title="` +
						row.descripcion +
						`" class="text-muted">
				` +
						row.descripcion +
						`
			</div>`;

					tmp += `<strong>Fecha inicio: </strong>` + row.fecha_inicio;
					return tmp;
				},
			},
			{
				targets: [3],
				data: 'estado_id',
				render: function (data, type, row) {
					var tmp = '';
					tmp += row.reparacion;
					tmp +=
						`
			<p></p>
				<strong>Fecha cierre: </strong>` +
						row.fecha_fin +
						`
			`;
					return tmp;
				},
			},
			{
				targets: [4],
				data: 'estado_id',
				render: function (data, type, row) {
					var tmp = '';

					tmp +=
						`
				<ul class="list-inline">
					<li style="text-transform:lowercase" class="list-inline-item">
						` +
						row.tiempo +
						` (h)
					</li>
					<li style="text-transform:lowercase" class="list-inline-item">
						` +
						row.tiempo_dia +
						` (d)
					</li>
					<li style="text-transform:lowercase" class="list-inline-item">
						` +
						row.tiempo_mes +
						` (m)
					</li>
				</ul>
			`;

					return tmp;
				},
			},
		],
	});
	tabla.column('1:visible').order('desc').draw();
	return tabla;
}

function show_orden(id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/show',
		type: 'POST',
		data: { id: id },
	}).done(function (data) {
		$('#modal_show_orden .modal-body').html(data);
	});
}

$('#tblOrdenes tbody').on('click', 'td.details-control', function () {
	var tr = $(this).closest('tr');
	var row = tabla.row(tr);
	if (row.child.isShown()) {
		row.child.hide();
		tr.removeClass('shown');
	} else {
		row.child(formato(row.data())).show();
		tr.addClass('shown');
	}
});

function formato(d) {
	return (
		'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
		'<tr>' +
		'<th>Realizo diagnostico: </th>' +
		'<td>' +
		d.diagnosticador +
		'</td>' +
		'</tr>' +
		'<tr>' +
		'<th>Cerro orden: </th>' +
		'<td>' +
		d.reparador +
		'</td>' +
		'</tr>' +
		'<tr>' +
		'<th>Tiempo de Cierre: </th>' +
		'<td>' +
		d.tiempo +
		' (h)</td>' +
		'</tr>' +
		'</table>'
	);
}

function entregar_id(id, e) {
	e.preventDefault();
	$('#form_retro #id').val(id);
}

$('#form_retro').submit(function (e) {
	e.preventDefault();
	var formulario = new FormData(this);
	$.ajax({
		url: base_url + 'orden/Cordenes/add_retro',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (data) {
		$('#modal_add_retro .close').click();
		$(data).html('');
	});
});

function getTimeline(id) {
	$.ajax({
		type: 'post',
		url: base_url + 'orden/Cordenes/timeline',
		data: { id: id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		respuesta = respuesta[0];

		//alert(respuesta);
		$('#modal_timeline_orden  #fecha_inicio').html(respuesta.fecha_inicio);
		$('#modal_timeline_orden  #asunto').html(respuesta.asunto);
		$('#modal_timeline_orden  #descripcion').html(respuesta.descripcion);
		$('#modal_timeline_orden  #nombre_equipo').html(respuesta.nombre_equipo);
		$('#modal_timeline_orden  #marca_equipo').html(respuesta.marca_equipo);
		$('#modal_timeline_orden  #modelo_equipo').html(respuesta.modelo_equipo);
		$('#modal_timeline_orden  #codigo_equipo').html(respuesta.codigo_equipo);
		$('#modal_timeline_orden  #serie_equipo').html(respuesta.serie_equipo);
		$('#modal_timeline_orden  #prioridad').html(respuesta.prioridad);

		if (
			respuesta.fecha_diagnostico != '' &&
			respuesta.fecha_diagnostico != null
		) {
			$('#modal_timeline_orden  #r_diag').show();
			$('#modal_timeline_orden  #p_diag').show();
			$('#modal_timeline_orden  #i_diag').show();
			$('#modal_timeline_orden  #fecha_diagnostico').html(
				respuesta.fecha_diagnostico
			);
			$('#modal_timeline_orden  #diagnostico').html(respuesta.diagnostico);
			$('#modal_timeline_orden  #diagnostico_id').html(
				respuesta.descripcion_diagnostico
			);
			if (
				respuesta.fecha_solicitud_repuesto != '' &&
				respuesta.fecha_solicitud_repuesto != null
			) {
				$('#modal_timeline_orden  #fecha_solicitud_repuesto').html(
					respuesta.fecha_solicitud_repuesto
				);
			} else {
				$('#modal_timeline_orden  #fecha_solicitud_repuesto').html(
					'No hay repuestos'
				);
			}
		} else {
			$('#modal_timeline_orden  #r_diag').hide();
			$('#modal_timeline_orden  #p_diag').hide();
			$('#modal_timeline_orden  #i_diag').hide();
		}
		if (
			respuesta.fecha_asignacion_cierre != '' &&
			respuesta.fecha_asignacion_cierre != null
		) {
			$('#modal_timeline_orden  #r_cierre').show();
			$('#modal_timeline_orden  #p_cierre').show();
			$('#modal_timeline_orden  #i_cierre').show();
			$('#modal_timeline_orden  #fecha_fin').html(
				respuesta.fecha_asignacion_cierre
			);
			$('#modal_timeline_orden  #reparacion').html(respuesta.reparacion);
			if (respuesta.cierre_id == 1) {
				$('#modal_timeline_orden  #cierre_id').html(
					'CI001-Instalación de nuevo repuesto/accesorio del equipo'
				);
			}
			if (respuesta.cierre_id == 2) {
				$('#modal_timeline_orden  #cierre_id').html(
					'CI002-Cerrado con repuestos faltantes'
				);
			}
			$('#modal_timeline_orden  #repuesto_usado').html(
				respuesta.repuesto_usado
			);
			$('#modal_timeline_orden  #fecha_recepcion_repuesto').html(
				respuesta.fecha_recepcion_repuesto
			);
			if (
				respuesta.cierre_active == 'false' &&
				respuesta.code != null &&
				respuesta.code != ''
			) {
				$('#modal_timeline_orden  #cerrar_orden').html(
					'<a href="' +
						base_url +
						'orden/Cordenes/activate/' +
						respuesta.id +
						'/' +
						respuesta.code +
						'">Cerrar Orden</a>'
				);
			} else {
				$('#modal_timeline_orden  #cerrar_orden').html('Orden cerrada');
			}
		} else {
			$('#modal_timeline_orden  #r_cierre').hide();
			$('#modal_timeline_orden  #p_cierre').hide();
			$('#modal_timeline_orden  #i_cierre').hide();
		}

		if (respuesta.file_cierre != '' && respuesta.file_cierre != null) {
			$('#modal_timeline_orden  #showimagen_orden_cierre').html(
				'Archivo cierre: <center><a target="__blank" style="padding:4px; margin-top:2px" href="' +
					base_url +
					'assets/upload_correctivos_generales/' +
					respuesta.file_cierre +
					'" class=" btn btn-success fa fa-file-o"></a></center>'
			);
		} else {
			$('#modal_timeline_orden  #showimagen_orden_cierre').html(
				'Archivo: No registra Archivo'
			);
		}

		if (
			respuesta.file_diagnostico != '' &&
			respuesta.file_diagnostico != null
		) {
			$('#modal_timeline_orden  #showimagen_orden_diag').html(
				'Archivo diagnostico: <center><a target="__blank" style="padding:4px; margin-top:2px" href="' +
					base_url +
					'assets/upload_correctivos_generales/' +
					respuesta.file_diagnostico +
					'" class=" btn btn-success fa fa-file-o"></a></center>'
			);
		} else {
			$('#modal_timeline_orden  #showimagen_orden_diag').html(
				'Archivo: No registra Archivo'
			);
		}

		if (respuesta.image != '' && respuesta.image != null) {
			$('#modal_timeline_orden  #showimagen_orden').html(
				'Archivo: <center><a target="__blank" style="padding:4px; margin-top:2px" href="' +
					base_url +
					'assets/upload_correctivos_generales/' +
					respuesta.image +
					'" class=" btn btn-success fa fa-file-o"></a></center>'
			);
		} else {
			$('#modal_timeline_orden  #showimagen_orden').html(
				'Archivo: No registra imagen'
			);
		}
		$('#modal_timeline_orden  #reportante').html(
			'Nombre: ' + respuesta.nombre + ' -Apellido: ' + respuesta.apellido
		);

		$('#modal_timeline_orden  #reportante_diag').html(
			'Username: ' + respuesta.asignado
		);
		$('#modal_timeline_orden  #reportante_cierre').html(
			'Nombre: ' + respuesta.nombre + ' -Email: ' + respuesta.email_empresa
		);
		// $("#modal_timeline_orden  #reportante_cierre").html("Nombre: "+respuesta[1][0].nombre+" -Email: "+respuesta[1][0].email_empresa);
	});
}
$('.orden_cerrada .sede_id').on('change', function () {
	list_data_table();
});
