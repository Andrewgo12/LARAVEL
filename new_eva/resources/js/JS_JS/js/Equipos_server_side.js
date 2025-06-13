var tabla = '';
tabla = list_data_table_server_side_filtros();
function list_data_table_server_side_filtros() {
	const PLAN_YEAR = 2023;
	const URL = `${base_url}equipo/Cequipos/get_server_side_filtros`;
	const language = {
		lengthMenu: 'Mostrar _MENU_ registros por pagina',
		zeroRecords: 'No se encontraron resultados en su busqueda',
		searchPlaceholder: 'Buscar registros',
		info: 'Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros',
		infoEmpty: 'No existen registros',
		infoFiltered: '',
		search: 'Busqueda Global:',
		paginate: {
			first: 'Primero',
			last: 'Último',
			next: 'Siguiente',
			previous: 'Anterior',
		},
	};
	const filterParams = {
		filtro_name: $('#filtro_name').val(),
		filtro_zona: $('#filtro_zona').val(),
		filtro_estadom: $('#filtro_estadom').val(),
		filtro_code: $('#filtro_code').val(),
		filtro_serial: $('#filtro_serial').val(),
		filtro_marca: $('#filtro_marca').val(),
		filtro_modelo: $('#filtro_modelo').val(),
		filtro_estadoequipo_id: $('#filtro_estadoequipo_id').val(),
		sede_id: $('.control_sede').val(),
		servicio_id: $('.servicio_id_auxiliar').val(),
		area_id: $('.area_id_auxiliar').val(),
		anio_plan: PLAN_YEAR,
		tipo_id: $('.tipo_id').val(),
		estado_id: $('.contenedor_estados_from_equipos .estado_id').val(),
		cierre_id: $('.contenedor_estados_from_equipos .estado_id_cg').val(),
		consulta_id: $('.consulta_id').val(),
		filtro_tadquisicion_id: $('#filtro_tadquisicion_id').val(),
		proveedor_mantenimiento: $('#proveedor_mantenimiento').val(),
	};
	const ajax = {
		url: URL,
		type: 'POST',
		data: filterParams,
	};
	try {
		$('#tblEquipos')
			.dataTable({
				language,
				lengthMenu: [
					[2, 5, 10, 20],
					[2, 5, 10, 20],
				],
				paging: true,
				filter: true,
				info: true,
				stateSave: true,
				bDestroy: true,
				processing: true,
				serverSide: true,
				displayStart: 0,
				dom: '<"top"ifp<"clear">>rlt<"bottom"ilp<"clear">>',
				ajax,
				columns: [
					{ data: 'name' },
					{ data: 'serial' },
					{ data: 'servicios' },
					{ data: 'fecha_mantenimiento' },
					{
						orderable: true,
						render: function (_, _, row) {
							let tmp = `<ul class="list-inline">`;
							tmp += `<li class="list-inline-item">
                <a title="Visualizar hoja de vida"
                   href="#"
                   class="btn btn-info glyphicon glyphicon-search"
                   data-toggle="modal"
                   data-target="#modal_show_equipo"
                   onClick="show_equipo(${row.id},${row.v1},${row.v2},${row.v3})">
                </a>
              </li>`;

							if (editar_equipo == 1) {
								if (editar_equipo == 1) {
									tmp += `<li class="list-inline-item">
                    <a title="Editar la información del equipo"
                       class="btn btn-primary glyphicon glyphicon-pencil"
                       onClick="recover_modal_edit(${row.id},event,function(){abrir_modal_update_equipo();})">
                    </a>
                  </li>`;
								}
								if (insertar_equipo_archivo == 1) {
									tmp += `<li class="list-inline-item">
                    <a title="Adicionar archivos"
                       href="#"
                       class="btn btn-warning glyphicon glyphicon-paperclip"
                       data-toggle="modal"
                       data-target="#modal_add_archivo"
                       onClick="show_equipo_archivos(${row.id})">
                    </a>
                  </li>`;
								}
								if (leer_equipo_archivo == 1) {
									if (row.cuenta_archivos > 0) {
										tmp += `<li class="list-inline-item">
                      <a title="Consolidado de archivos"
                         href="#"
                         class="btn btn-default glyphicon glyphicon-file"
                         data-toggle="modal"
                         data-target="#modal_show_archivos"
                         onClick="show_archivos(${row.id})">
                      </a>
                    </li>`;
									}
									if (row.cuenta_archivos_capacitaciones > 0) {
										tmp += `<li class="list-inline-item">
                      <a title="Consolidado de capacitaciones"
                         href="#"
                         class="btn btn-success glyphicon glyphicon-list-alt"
                         data-toggle="modal"
                         data-target="#modal_show_archivos"
                         onClick="show_capacitaciones(${row.id})">
                      </a>
                    </li>`;
									}
								}
								if (row.estadoequipo != 'Equipo dado de baja') {
									if (insertar_baja == 1) {
										tmp += `<li class="list-inline-item">
                      <a title="Asociar baja del equipo"
                         href="#"
                         class="btn btn-danger glyphicon glyphicon-remove-sign"
                         data-toggle="modal"
                         data-target="#modal_consulta_baja"
                         onClick="show_consulta_baja(event,${row.id})">
                      </a>
                    </li>`;
									}
								}
							}
							tmp += '<ul>';
							switch (row.verificacion_inventario) {
								case 'SI':
									tmp += `<li><span class="glyphicon glyphicon-ok"></span></li>`;
									break;
								case 'NUEVO':
									tmp += `<li><span style="font-size: 15px;" class="label label-default">New</span></li>`;
									break;
								case 'NOENCONTRA':
									tmp += `<li><span class="glyphicon glyphicon-remove" style="color: red;"></span></li>`;
									break;
							}
							tmp += `</ul></ul>`;
							return tmp;
						},
					},
				],
				columnDefs: [
					{
						targets: [0],
						data: 'name',
						render: function (_, _, row) {
							let tmp = '';
							if (row.repuesto_pendiente == 'si')
								tmp +=
									"<span class='glyphicon glyphicon-wrench text-danger'></span><br>";
							if (row.anios_transcurridos >= 5 && row.anios_transcurridos < 10)
								tmp += `<span title='${row.descripcion}' class='glyphicon glyphicon-exclamation-sign text-warning'>${row.name}</span>`;
							else if (row.anios_transcurridos >= 10) {
								tmp +=
									"<strong title='" +
									row.descripcion +
									"' class='fa fa-exclamation-triangle text-danger'>&nbsp;" +
									row.name +
									'</strong>';
							} else if (
								(row.anios_transcurridos < 5) &
								(row.anios_transcurridos != null)
							) {
								tmp +=
									"<span title='" +
									row.descripcion +
									"' class='fa fa-check text-success'>&nbsp;" +
									row.name +
									'</span>';
							} else {
								tmp +=
									"<strong title='" +
									row.descripcion +
									"'>" +
									row.name +
									'</strong>';
							}
							if (row.descripcion != undefined) {
								tmp += `(` + row.descripcion + `)<br>`;
							}
							if (row.file != null && row.file != '') {
								tmp +=
									'<a target="__blank" style="padding:4px" href="' +
									base_url +
									'assets/upload_archivos/' +
									row.file +
									'" class=" btn btn-success fa fa-file-excel-o"></a>';
							}
							if (row.anio != null) tmp += '(' + row.anio + ')';

							if (row.image != '') {
								tmp +=
									"<br><a data-lightbox='equipos' href='" +
									base_url +
									'assets/upload_imagenes/' +
									row.image +
									"' target='__blank'><img class='zoom-imagen' width='150px' height='150px' src=" +
									base_url +
									'assets/upload_imagenes/' +
									row.image +
									'></a>';
							}
							if (
								row.invima_id != null &&
								row.invima_id != 1 &&
								row.invima_id != 0
							) {
								tmp +=
									`
									<blockquote style="font-size:10px;">
										<strong>Registro sanitario:</strong>
										<p>
											<span><i class="glyphicon glyphicon-ok" style='color:green;font-weight:800;'></i>
												<smal>	<a target="__blank" href="${base_url}assets/upload_registros_sanitarios/` +
									row.archivo_registro_sanitario +
									`" class="text-muted">` +
									row.registro_sanitario +
									`</a></smal>
											</span>
										</p>
									</blockquote>
								`;
							}
							if (row.guia_id != 0) {
								tmp +=
									`
									<blockquote style="font-size:10px;">
										<strong>Guia rapida:</strong>
										<p>
											<span><i class="glyphicon glyphicon-ok" style='color:green;font-weight:800;'></i>
												<smal>	<a target="__blank" href="${base_url}assets/upload_guias/` +
									row.guia_file +
									`" class="text-muted">` +
									row.guia_nombre +
									`<span class="fa fa-paperclip"></span></a></smal>
											</span>
										</p>
									</blockquote>
								`;
							}
							if (row.manual_id != 0) {
								tmp +=
									`
									<blockquote style="font-size:10px;">
										<strong>Manual:</strong>
										<p>
											<span><i class="glyphicon glyphicon-ok" style='color:green;font-weight:800;'></i>
												<smal>	<a target="__blank" href="` +
									row.manual_url +
									`" class="text-muted">` +
									row.manual_descripcion +
									`<span class="fa fa-external-link-square btn btn-link"></span></a></smal>
											</span>
										</p>
									</blockquote>
								`;
							}
							if (insertar_contingencia == 1) {
								tmp +=
									`
								<br />
								<p></p>
								<div data-toggle="tooltip"><a onclick="relacionar_equipo_id_contingencia(` +
									row.id +
									`)" href="" data-toggle="modal" data-target="#modal_add_contingencia"><span class="fa fa-clipboard"></span></a> Contingencias</div><span class="badge">` +
									row.cantidad_contingencias +
									`</span>
							`;
							}
							return tmp;
						},
					},
					{
						targets: [1],
						data: 'serial',
						render: function (_, _, row) {
							var tmp = '';
							var tmp_observacion = '';
							if (insertar_equipo == 1)
								tmp +=
									'<strong>ID:</strong>' +
									row.id +
									"<a data-toggle='modal' data-target='#modal_copy' onclick='recover_modal_copy(" +
									row.id +
									")' title='Copiar equipo' href='' target='__blank' class='glyphicon glyphicon-duplicate' style='color:orange;font-size:15px;'></a>";
							else tmp += '<strong>ID:</strong>' + row.id;
							tmp += "<ol class='breadcrumb'>";
							tmp += '<li>Observaciones</li>';
							if (insertar_observacion == 1) {
								tmp +=
									'<li><a href="#" class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_observacion" onClick="pasar_equipo_id(' +
									row.id +
									')"></a></li>';
							}
							if (row.observacion != null && row.observacion != '') {
								tmp_observacion += row.observacion;
							}
							if (
								row.ultima_observacion != null &&
								row.ultima_observacion != ''
							) {
								tmp_observacion += '(' + row.fecha_ultima_observacion + ')';
								tmp_observacion += row.ultima_observacion;
							}
							if (tmp_observacion != null && tmp_observacion != '') {
								tmp +=
									"<li><div class='glyphicon glyphicon-info-sign' title='" +
									tmp_observacion +
									"'></div></li>";
							}
							tmp += '</ol>';
							tmp += '<br><strong>Codigo:</strong>' + row.code;
							tmp += '<br><strong>Marca:</strong>' + row.marca;
							tmp += '<br><strong>Modelo:</strong>' + row.modelo;
							tmp += `<br><strong>Serie:</strong> ${
								row.serial ? row.serial : 'No registra'
							}`;
							tmp +=
								"<br><strong>Preventivos</strong><span class='badge'>" +
								row.cuenta +
								'</span>';
							tmp +=
								"<br><strong>Calibraciones</strong><span class='badge'>" +
								row.cuenta_calibracion +
								'</span>';
							if (
								row.codigos_correctivos != '' &&
								row.codigos_correctivos != null
							)
								tmp +=
									"<br><strong>Correctivos</strong><span class='badge'>" +
									row.codigos_correctivos +
									'</span>';
							if (
								row.orden_compra_id != '' &&
								row.orden_compra_id != null &&
								row.orden_compra_id != 0
							) {
								tmp +=
									'<br><strong>Soporte de compra: </strong>' +
									row.orden_compra +
									'';
								if (
									row.orden_compra_file != null &&
									row.orden_compra_file != ''
								)
									tmp +=
										"&nbsp;<a href='" +
										base_url +
										'assets/upload_ordenes_compra/' +
										row.orden_compra_file +
										"' target='__blank' class='glyphicon glyphicon-file'> </a><span style='font-size:10px;'>(" +
										row.tipo_compra +
										')</span>';
							}
							if (
								row.url_secop != undefined &&
								row.url_secop != null &&
								row.url_secop != ''
							)
								tmp +=
									`<br><a style="font-size:20px;color:black;font-weight:900;" class="glyphicon glyphicon-link" target="__top" href="` +
									row.url_secop +
									`"></a>`;
							return tmp;
						},
					},
					{
						targets: [2],
						data: 'servicios',
						render: function (data, type, row) {
							var tmp = '';
							tmp += '<strong>Servicio:&nbsp;</strong>' + row.servicios;
							if (row.movimiento > 0)
								tmp += `<a onClick="funcion_show_cambios_ubicaciones(${row.id})" style="color:#2E4053;" title="Historial de cambios" href="" class="glyphicon glyphicon-book" data-toggle="modal" data-target="#modal_show_cambios_ubicaciones"></a>`;
							if (row.area != null && row.area != '')
								tmp +=
									"<br><div style='font-size:14px;'><strong>Area:&nbsp;</strong><span class=''>" +
									row.area +
									'</span></div>';
							if (
								row.pisos_areas == null ||
								row.pisos_areas == '' ||
								row.pisos_areas == 'undefined'
							)
								tmp += '<br><strong>Piso del servicio:</strong>' + row.pisos;
							else
								tmp += '<br><strong>Piso del area:</strong>' + row.pisos_areas;
							if (row.tipo_id == 1)
								tmp += `<br><strong>Zona:</strong> ${row.zona}`;
							tmp += `<br><strong>Sede:</strong>` + row.sede;
							tmp +=
								`<br><strong> Estado del equipo:<br><span style="font-weight:800;font-size:20px; color:` +
								row.color_estado +
								`">${row.estadoequipo}</span><br>`;
							if (
								row.localizacion_actual != null &&
								row.localizacion_actual != '' &&
								row.localizacion_actual != undefined
							) {
								tmp +=
									`<strong>Localización actual:</strong>&nbsp` +
									row.localizacion_actual;
								tmp += `<br>`;
							}
							if (
								row.disponibilidad != null &&
								row.disponibilidad != '' &&
								row.disponibilidad != undefined
							) {
								tmp +=
									`<strong>Disponibilidad:</strong>&nbsp` + row.disponibilidad;
								tmp += `<br>`;
							}
							if (
								row.baja_id != null &&
								row.baja_id != '' &&
								row.baja_id != 0
							) {
								tmp +=
									"<br><a target='__blank' href='" +
									base_url +
									'assets/upload_bajas/' +
									row.file_baja +
									"' class='glyphicon glyphicon-file'></a>";
								tmp +=
									"<br><span class='glyphicon glyphicon-trash'>" +
									row.fecha_baja +
									'</span>';
							}
							if (row.repuesto_pendiente == 'si') {
								tmp +=
									"<strong></strong>&nbsp<br><span style='color:red; font-size:25px;'>Repuesto pendiente</span>";
							}
							if (row.propietario_id != 0) {
								tmp +=
									`<br> <strong>Propietario:</strong><br>` + row.propietario;
								tmp +=
									`<div class="contenedor_logo" style="width:100 px;height="100 px;"><img  class="img-responsive" src="${base_url}assets/upload_imagenes/` +
									row.propietario_logo +
									`" /></div>`;
							}
							return tmp;
						},
					},
					{
						targets: [3],
						data: 'fecha_mantenimiento',
						render: function (_, _, row) {
							var tmp = '';
							tmp += `
						<div>Inclusion plan ${anio_plan}`;
							if (row.cuenta_planes_mantenimientos > 0) {
								tmp += `<span class="glyphicon glyphicon-ok"></span>`;
								tmp += `
						<span>
						<br />
						<span class="text-muted table-card-content">
						<strong>Frecuencia de mantenimiento preventivo:</strong>
								${compute_frecuency(row.preventivo_mes1, row.preventivo_mes2)}
							</span>
						</span>
						<div class="schedule-mantendance">
							<h5>Meses Programados</h5>
								<ul class="">
									<li class="">
										<strong>m1:</strong>
										<span class="text-muted">${row.preventivo_mes1}</span>
									</li>
									<li class="">
										<strong>m2:</strong>
										<span class="text-muted">${row.preventivo_mes2}</span>
									</li>
									<li class="">
										<strong>m3:</strong>
										<span class="text-muted">${row.preventivo_mes3}</span>
									</li>
									<li class="">
										<strong>Contratista mantenimiento:</strong>
										<span class="text-muted">${row.preventivo_responsable}</span>
									</li>
								</ul>
						  </div>`;
							} else {
								tmp += `<span class="glyphicon glyphicon-remove"></span>
						<span>
						<br />
							<strong>Frecuencia de mantenimiento preventivo:</strong>
							<span class="text-muted">${compute_frecuency(
								row.mes_programado1,
								row.mes_programado2
							)}</span>
						</span>
							`;
							}
							tmp += `</div>`;
							tmp += `<ul>`;
							if (
								row.ultimo_mantenimiento != null &&
								row.ultimo_mantenimiento != '' &&
								row.ultimo_mantenimiento != '0000-00-00'
							) {
								tmp += `
							<span class='fa fa-calendar table-card-content'><strong>Ultimo preventivo<strong><br>
								<div class='text-muted contenedor_preventivo_${row.id}'>${row.ultimo_mantenimiento}</div>`;
								if (
									row.archivo_ultimo_mantenimiento !== null &&
									row.archivo_ultimo_mantenimiento !== ''
								) {
									tmp += `
								<div class='contenedor_archivo_preventivo_${row.id}'>
									<a target='__blank' href='${base_url}assets/upload_preventivos/${row.archivo_ultimo_mantenimiento}' class='glyphicon glyphicon-paperclip' ></a>
								</div><br>`;
								} else
									tmp += `
							</span>
							`;
							}
							tmp += '';
							if (
								row.fecha_inicio_correctivo_general !== null &&
								row.fecha_inicio_correctivo_general !== undefined &&
								row.fecha_inicio_correctivo_general !== ''
							) {
								tmp +=
									`<li>
							<span class='table-card-content'>
								<strong>Ultima correctivo general generado:</strong>
								<span class="text-muted">` +
									row.fecha_inicio_correctivo_general +
									`</span>
								<span title="` +
									row.orden +
									`" style="color:#c33a31;" class="glyphicon glyphicon-time"></span>
							</span></li>`;
							}
							if (
								row.fecha_ultimo_correctivo != null &&
								row.fecha_ultimo_correctivo != undefined &&
								row.fecha_ultimo_correctivo != ''
							) {
								tmp +=
									`<li>
								<span class='table-card-content'>
									<strong>ultimo procedimiento correctivo realizado:</strong>
									<span class="text-muted">` +
									row.fecha_ultimo_correctivo +
									`</span>
									<span title="` +
									row.descripcion_ultimo_correctivo_general +
									`" style="color:#72a836;" class="glyphicon glyphicon-ok"></span>
								</span>
							</li>`;
							}
							if (
								row.fecha_inicio_ultimo_ticket != null &&
								row.fecha_inicio_ultimo_ticket != undefined &&
								row.fecha_inicio_ultimo_ticket != ''
							) {
								tmp +=
									`<li>
							<span class='table-card-content'>
								<strong>Fecha de creación del ultimo ticket:</strong>
								<span class="text-muted">` +
									row.fecha_inicio_ultimo_ticket +
									`</span>
								<span title="` +
									row.descripcion_ultimo_ticket +
									`" style="color:#c33a31;" class="glyphicon glyphicon-time"></span>
							</span></li>`;
							}
							if (
								row.fecha_fin_ultimo_ticket != null &&
								row.fecha_fin_ultimo_ticket != undefined &&
								row.fecha_fin_ultimo_ticket != ''
							) {
								tmp +=
									`<li>
							<span class='table-card-content'>
								<strong>Fecha de ultimo cierre de tickets:</strong>
								<span class="text-muted">` +
									row.fecha_fin_ultimo_ticket +
									`</span>
								<span title="` +
									row.descripcion_cierre_ultimo_ticket +
									`" style="color:#72a836;" class="glyphicon glyphicon-ok"></span>
							</span></li>`;
							}
							if (
								row.ultima_calibracion != null &&
								row.ultima_calibracion != '' &&
								row.ultima_calibracion != '0000-00-00'
							) {
								tmp +=
									"<br><br><span class='fa fa-calendar'> <strong>ultima calibracion<strong><br>" +
									row.ultima_calibracion +
									'</span>';
								if (
									row.archivo_ultima_calibracion != null &&
									row.archivo_ultima_calibracion != ''
								) {
									tmp +=
										"<a target='__blank' href='" +
										base_url +
										'assets/upload_calibraciones/' +
										row.archivo_ultima_calibracion +
										"' class='tamanio btn btn-warning glyphicon glyphicon-file' ></a><br>";
								} else tmp += '';
							}
							tmp += `</ul>`;
							return tmp;
						},
					},
				],
			})
			.fnSetFilteringDelay(900);
	} catch (error) {
		console.log(error);
	}
}
function list_data_table_server_side_general($sede_id_auxiliar = '') {
	$('.tbl-listado-equipos').dataTable({
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
			[5, 10, 20],
			[5, 10, 20],
		],
		paging: true,
		filter: true,
		info: true,
		stateSave: true,
		bDestroy: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: `${base_url}equipo/Cequipos/get_general_server_side`,
			type: 'POST',
			data: {
				sede_id: $sede_id_auxiliar,
				servicio_id: $(
					'#modal_consulta_equipos_biomedicos .servicio_id_auxiliar'
				).val(),
				area_id: $(
					'#modal_consulta_equipos_biomedicos .area_id_auxiliar'
				).val(),
				tipo_id: $('.tipo_id').val(),
			},
		},
		columns: [
			{ data: 'name' },
			{ data: 'marca' },
			{ data: 'modelo' },
			{ data: 'serial' },
			{ data: 'code' },
			{ data: 'servicio' },
			{ data: 'area' },
			{
				orderable: true,
				render: function (_, _, row) {
					return (tmp =
						"<span onClick='set_equipo_id(" +
						row.id +
						",event)' title='Seleccionar este equipo' class='fa fa-check btn bnt-sm btn-success boton-seleccion'></span>");
				},
			},
		],
	});
}
function list_datatable_server_side_compartir_especificaciones() {
	$('.tbl-listado-equipos').dataTable({
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
			[5, 10, 20],
			[5, 10, 20],
		],
		paging: true,
		filter: true,
		info: true,
		stateSave: true,
		bDestroy: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: `${base_url}equipo/Cequipos/get_general_server_side`,
			type: 'POST',
			data: {},
		},
		columns: [
			{ data: 'name' },
			{ data: 'marca' },
			{ data: 'modelo' },
			{ data: 'serial' },
			{ data: 'code' },
			{ data: 'servicio' },
			{ data: 'area' },
			{
				orderable: true,
				render: function (_, _, row) {
					return (tmp =
						"<span onClick='set_equipo_id(" +
						row.id +
						",event)' title='Seleccionar este equipo' class='fa fa-check btn bnt-sm btn-success'></span>");
				},
			},
		],
	});
}

function compute_frecuency(month1 = '', month2 = '') {
	const convertion = {
		enero: 1,
		febrero: 2,
		marzo: 3,
		abril: 4,
		mayo: 5,
		junio: 6,
		julio: 7,
		agosto: 8,
		septiembre: 9,
		octubre: 10,
		noviembre: 11,
		diciembre: 12,
	};
	month1 = convertion[month1];
	month2 = convertion[month2];
	if (month1 !== undefined && month2 === undefined) return 'Anual';
	if (month1 === undefined && month2 === undefined) return 'No definida';
	if (month1 !== undefined && month2 !== undefined)
		return `${month2 - month1} meses`;
	return 'Anual';
}
