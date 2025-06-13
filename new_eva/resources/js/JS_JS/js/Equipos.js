if (controlador === 'Cequipos' || controlador === 'Cequipos_ind') {
  //TODO
  if (parseInt(globalThis?.role?.replace(/"/g, '')) === 4) {
    globalThis.location.href = globalThis.base_url
  }
	const selectAreasByService = () => {
		const servicio_id = $('.servicio_id_auxiliar').val();
		new areaObj().PrintSelectByService('.area_id_auxiliar', servicio_id);
	};
	function selectServicesBySede() {
		const sede_id = $('.sede_id_auxiliar').val();
		const services = new serviceObj();
		if (sede_id == '') return services.PrintSelect('.servicio_id_auxiliar');
		services.PrintSelectBySede('.servicio_id_auxiliar', sede_id);
	}
	function funcion_seleccion_area_desde_equipos() {
		var servicio_id = $('.servicio_id_auxiliar').val();
		select_areas_auxiliar(servicio_id);
		$('.area_id_auxiliar').val(0);
		list_data_table_server_side_filtros();
	}
	$('.nav-tabs a').click(function () {
		$(this).tab('show');
	});

	$('#form_equipo').submit(function (e) {
		e.preventDefault();
		const form = new FormData(this);
		$('#btn_add_equipo').attr('disabled', 'disabled');
		$('#mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#mensaje').html('Procesando..........');
		$('#modal_add_equipo .close').click();
		const message = `
			<h1>
				<div class="glyphicon glyphicon-refresh">
					Procesando
				</div>
			</h1>
			<br>
			<h2>Por favor espere</h2>
		`;
		$.blockUI({
			message,
			css: {
				width: '275px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
			},
		});
		const url = `${base_url}equipo/Cequipos/add`;
		$.ajax({
			url,
			type: 'POST',
			data: form,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done((data) => {
			if (data === 1) {
				datatable_destroy();
				list_data_table_server_side_filtros();
				$.unblockUI();
				notify('add');
				if (!$('#check').is(':checked'))
					document.getElementById('form_equipo').reset();
			} else {
				const response = JSON.parse(data);
				message = `
					<div class="">
						<div class="panel panel-danger">
							<div class="panel-heading">Error</div>
							<div class="panel-body"> ${response}</div>
						</div>
					</div>
				`;
				$.unblockUI(); // Del mensaje de procesando
				$.blockUI({ message }); // Muestro un mensaje con los errores
				setTimeout(function () {
					desbloquear_add_equipo();
				}, 4000);
			}
			$('#btn_add_equipo').removeAttr('disabled', 'disabled');
			$('#mensaje').html('');
			const classToRemove =
				'glyphicon glyphicon-refresh glyphicon-refresh-animate';
			$('#mensaje').removeClass(classToRemove);
		});
	});
	$('#form_equipo_archivo').submit(function (e) {
		$('#form_equipo_archivo #btn_add_archivo').attr('disabled', 'disabled');
		const classToAdd = 'glyphicon glyphicon-refresh glyphicon-refresh-animate';
		const objective = '#form_equipo_archivo .mensaje';
		$(objective).addClass(classToAdd);
		$(objective).html('Procesando..........');
		e.preventDefault();
		const form = new FormData(this);
		const url = `${base_url}equipo/Cequipos/add_equipo_archivo`;
		$.ajax({
			url,
			type: 'post',
			data: form,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			$('#form_equipo_archivo #btn_add_archivo').removeAttr(
				'disabled',
				'disabled'
			);
			$('#form_equipo_archivo .mensaje').html('');
			$('#form_equipo_archivo .mensaje').removeClass(
				'glyphicon glyphicon-refresh glyphicon-refresh-animate'
			);
			$('#modal_add_archivo .close').click();
			datatable_destroy();
			list_data_table_server_side_filtros();
			notify('add_archivo');
		});
	});

	$('#form_update_equipo').submit(function (e) {
		e.preventDefault();
		const form = new FormData(this);
		const message =
			'<h1><div class="glyphicon glyphicon-refresh"></dv>Procesando</h1><br><h2>Por favor espere</h2>';
		$.blockUI({
			message,
			css: {
				width: '275px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
			},
		});
		$('#modal_update_equipo .close').click();
		const url = `${base_url}equipo/Cequipos/update`;
		$.ajax({
			url,
			type: 'POST',
			data: form,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done((data) => {
			if (JSON.parse(data).respuesta === 1) {
				datatable_destroy();
				list_data_table_server_side_filtros();
				$.unblockUI();
				notify('edit');
			} else {
				const response = JSON.parse(data);
				let message = `
					<div class=""><div class="panel panel-danger">
						<div class="panel-heading">Error</div>
							<div class="panel-body">
							${response}
							</div>
						</div>
					</div>
				`;
				$.unblockUI();
				$.blockUI({ message });
				setTimeout(() => {
					abrir_modal_update_equipo();
				}, 4000);
			}
		});
	});

	list_tadquisiciones();
	list_fuentes();
	list_tecnologias();
	list_cbiomedicas();
	list_criesgos();
	list_frecuencias();
	list_zonas();
	list_archivos();
	list_garantias();
	list_repuestos();

	function show_file(id) {
		const url = `${base_url}equipo/Cequipos/show_file`;
		$.ajax({ url, type: 'POST', data: { id } }).done((data) =>
			$('#modal_show_file .modal-body').html(data)
		);
	}

	function show_archivos(id) {
		const url = `${base_url}equipo/Cequipos/show_archivos`;
		$.ajax({
			url,
			type: 'POST',
			data: { id },
		}).done((data) => $('#modal_show_archivos .modal-body').html(data));
	}

	function show_capacitaciones(id) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/show_capacitaciones',
			type: 'POST',
			data: { id },
		}).done((data) => $('#modal_show_archivos .modal-body').html(data));
	}
	function show_equipo_archivos(id) {
		$('#modal_add_archivo .modal-body #equipo_id').val(id);
	}

	function recover_modal_edit(id, e, callback) {
		$('#form_update_equipo').trigger('reset');
		$('#form_repuesto_correctivo_general #equipo_id').val(id);

		$('.esconder').show();
		e.preventDefault();
		$('.reset_contenedor_orden_compra').html('');
		$('.reset_contenedor_contrato').html('');
		const message = `
			<h1>
				<span class="fa fa-refresh fa-spin"></span><div>Procesando</div>
			</h1>
			<br>
      <h3>Por favor espere</h3>
		`;
		$.blockUI({
			message,
			css: {
				width: '275px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
			},
		});

		$('#form_preventivo #equipo_id').val(id);
		$('#form_calibracion #equipo_id').val(id);
		$('#form_equipo_especificacion #equipo_id').val(id);
		$('#form_equipo_contacto #equipo_id').val(id);
		$('#form_preventivo #equipo_id').val(id);
		$('#form_calibracion #equipo_id').val(id);
		$('#form_repuesto #equipo_id').val(id);
		$('#form_correctivo_general #equipo_id').val(id);
		$('#form_observacion #equipo_id').val(id);

		const url = `${base_url}equipo/Cequipos/getOne`;
		$.ajax({
			url,
			type: 'POST',
			data: { id },
		}).done(function (data) {
			list_equipo_especificaciones(id);
			list_equipo_especificaciones2(id);
			list_equipo_contactos(id);
			list_equipo_contactos2(id);
			list_correctivos(id);
			list_correctivos_generales(id);
			list_correctivos_generales2(id);
			list_preventivos(id);
			list_preventivos2(id);
			list_observaciones(id);
			list_observaciones2(id);
			list_calibraciones(id);
			list_calibraciones2(id);
			list_equipo_repuestos(id);
			list_equipo_repuestos2(id);
			list_ordenes_activas(id);
			let equipo = JSON.parse(data);

			$('#form_preventivo .mostrar-primer-fecha').html('');
			$('#form_preventivo .mostrar-segunda-fecha').html('');
			$('#form_preventivo .mostrar-tercer-fecha').html('');
			$('#form_preventivo .mostrar-primer-fecha').html(equipo.preventivo_mes1);
			$('#form_preventivo .mostrar-segunda-fecha').html(equipo.preventivo_mes2);
			$('#form_preventivo .mostrar-tercer-fecha').html(equipo.preventivo_mes3);

			$('#modal_update_equipo #form_update_equipo #id').val(id);
			$('#modal_update_equipo #form_update_equipo #name').val(equipo.name);
			$('#modal_update_equipo #form_update_equipo #descripcion').val(
				equipo.descripcion
			);
			$('#modal_update_equipo #form_update_equipo #code').val(equipo.code);
			$('#modal_update_equipo #form_update_equipo #serial').val(equipo.serial);
			$('#modal_update_equipo #form_update_equipo #modelo').val(equipo.modelo);
			$('#modal_update_equipo #form_update_equipo #marca').val(equipo.marca);
			$('#modal_update_equipo #form_update_equipo .invima_id').val(
				equipo.registro_sanitario_id
			);

			if (
				equipo.file_registro_sanitario !== null &&
				equipo.file_registro_sanitario !== ''
			) {
				var anclor_file_registro_sanitario = '';
				anclor_file_registro_sanitario +=
					"<a title='" +
					equipo.registro_sanitario +
					"' class='glyphicon glyphicon-file' href='" +
					base_url +
					'assets/upload_registros_sanitarios/' +
					equipo.file_registro_sanitario +
					"' target='__blank'></a>";
				$(
					'#modal_update_equipo #form_update_equipo .file_registro_sanitario'
				).html(anclor_file_registro_sanitario);
			} else {
				const selection = `#modal_update_equipo #form_update_equipo .file_registro_sanitario`;
				$(selection).html('');
			}
			$('#modal_update_equipo #form_update_equipo #estadoequipo_id').val(
				equipo.estadoequipo_id
			);
			$('#modal_update_equipo #form_update_equipo #tmp_estado_equipo_id').val(
				equipo.estadoequipo_id
			);
			$('#modal_update_equipo #form_update_equipo #localizacion_actual').val(
				equipo.localizacion_actual
			);
			$(
				'#modal_update_equipo #form_update_equipo #tmp_localizacion_actual'
			).val(equipo.localizacion_actual);
			$('#modal_update_equipo #form_update_equipo #disponibilidad_id').val(
				equipo.disponibilidad_id
			);

			$('#modal_update_equipo #form_update_equipo #sede_id').val(
				equipo.sede_id
			);
			$('#modal_update_equipo #form_update_equipo #servicio_id').val(
				equipo.servicio_id
			);

			getAreaByservicio(equipo.servicio_id, equipo.area_id);

			$('#modal_update_equipo #form_update_equipo #fuente_id').val(
				equipo.fuente_id
			);
			$('#modal_update_equipo #form_update_equipo #tecnologia_id').val(
				equipo.tecnologia_id
			);
			$('#modal_update_equipo #form_update_equipo #frecuencia_id').val(
				equipo.frecuencia_id
			);
			$('#modal_update_equipo #form_update_equipo #cbiomedica_id').val(
				equipo.cbiomedica_id
			);
			$('#modal_update_equipo #form_update_equipo #criesgo_id').val(
				equipo.criesgo_id
			);
			$('#modal_update_equipo #form_update_equipo #tadquisicion_id').val(
				equipo.tadquisicion_id
			);
			if (
				equipo.tadquisicion_id == 2 ||
				equipo.tadquisicion_id == 3 ||
				equipo.tadquisicion_id == 4
			) {
				var html_orden_compra = '';
				html_orden_compra += "<div class='reset_contenedor_orden_compra'>";
				html_orden_compra += '<h3>Tipo de adquisicion&nbsp;';
				if (insertar_soporte_compra === 1) {
					html_orden_compra +=
						" <a data-toggle='modal' data-target='#modal_add_orden_compra' title='agregar nueva orden de compra a la base de datos' href='' class='glyphpicon glyphicon-plus' style='font-size:15px;font-weight:1000;color:black'></a>";
				}
				html_orden_compra += " </h3> <ul class='list-inline'>";
				html_orden_compra +=
					"<li class='list-inline-item' style='color:black;font-weight:900;'><a onClick='show_consulta_orden_compra(event,1)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar ordenes de compra'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Ordenes de compra</a></li>";
				html_orden_compra +=
					"<li class='list-inline-item' style='color:black;font-weight:900;'><a onClick='show_consulta_orden_compra(event,2)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar contratos'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Contratos-licitaciones</a></li>";
				html_orden_compra +=
					"<li class='list-inline-item' style='color:black;font-weight:900;'><a onClick='show_consulta_orden_compra(event,3)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar cruces de cuenta'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Cruces de cuentas</a></li>";
				html_orden_compra +=
					"<li class='list-inline-item' style='color:black;font-weight:900;'><a onClick='show_consulta_orden_compra(event,4)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar comodatos'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Comodatos</a></li>";
				html_orden_compra +=
					"</ul><input type='hidden' id='orden_compra_id' name='orden_compra_id' value='" +
					equipo.orden_compra_id +
					"'></input>";

				if (equipo.orden_compra_id != 0 && equipo.orden_compra_id !== null) {
					html_orden_compra +=
						"<span style='font-weight:800;' class='orden_compra_orden'>" +
						equipo.orden_compra +
						'</span>';
					html_orden_compra +=
						"<span class='file_orden_compra'><a title='" +
						equipo.file_orden_compra +
						"' class='glyphicon glyphicon-file' href='" +
						base_url +
						'assets/upload_ordenes_compra/' +
						equipo.file_orden_compra +
						"' target='__blank'></a></span><br>";
				} else {
					html_orden_compra +=
						"<span style='font-weight:800;' class='orden_compra_orden'></span>";
					html_orden_compra += "<span class='file_orden_compra'></span><br>";
				}
				html_orden_compra +=
					"<span style='font-size:10px;' onClick='cancelar_seleccion_orden_compra()' class='btn btn-danger glyphicon glyphicon-remove'></span>";
				html_orden_compra += '</div>';
				$('#modal_update_equipo .contenedor_orden_compra').html(
					html_orden_compra
				);
			}

			$('#modal_update_equipo #form_update_equipo #fecha_ad').val(
				equipo.fecha_ad
			);
			$('#modal_update_equipo #form_update_equipo #fecha_instalacion').val(
				equipo.fecha_instalacion
			);
			$('#modal_update_equipo #form_update_equipo #fecha_mantenimiento').val(
				equipo.fecha_mantenimiento
			);
			$(
				'#modal_update_equipo #form_update_equipo #fecha_vencimiento_garantia'
			).val(equipo.fecha_vencimiento_garantia);
			$('#modal_update_equipo #form_update_equipo #fecha_acta_recibo').val(
				equipo.fecha_acta_recibo
			);
			$('#modal_update_equipo #form_update_equipo #fecha_inicio_operacion').val(
				equipo.fecha_inicio_operacion
			);
			$('#modal_update_equipo #form_update_equipo #fecha_fabricacion').val(
				equipo.fecha_fabricacion
			);
			$('#modal_update_equipo #form_update_equipo #vida_util').val(
				equipo.vida_util
			);
			$('#modal_update_equipo #form_update_equipo #garantia').val(
				equipo.garantia
			);
			$('#modal_update_equipo #form_update_equipo #costo').val(
				equipo.costo_original
			);

			$('#modal_update_equipo .textarea-personalizado').summernote('destroy');
			$('#modal_update_equipo #form_update_equipo #accesorios').val(
				equipo.accesorios
			);
			$('#modal_update_equipo .textarea-personalizado').summernote({
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['fontname', ['fontname']],
					['table', ['table']],
				],
			});
			$(
				'#modal_update_equipo #form_update_equipo #verificacion_inventario'
			).val(equipo.verificacion_inventario);
			$(
				'#modal_update_equipo #form_update_equipo #fecha_recepcion_almacen'
			).val(equipo.fecha_recepcion_almacen);
			$('#modal_update_equipo #form_update_equipo #propietario_id').val(
				equipo.propietario_id
			);
			$('#modal_update_equipo #form_update_equipo #archivo_invima1').val();
			if (equipo.archivo_invima != '' && equipo.archivo_invima != null) {
				$('.verificacion_registro_invima').html(
					"<a href='" +
						base_url +
						'assets/upload_invimas/' +
						equipo.archivo_invima +
						"' target='__blank'>" +
						equipo.archivo_invima +
						'</a>'
				);
			} else {
				$('.verificacion_registro_invima').html('');
			}

			$('#modal_update_equipo #form_update_equipo .guia_id').val(0);
			$('#modal_update_equipo #form_update_equipo .contenedor_name_guia').html(
				''
			);
			$('.contenedor_archivo_guia').html(archivo);

			if (equipo.guia_id != 0) {
				$('#modal_update_equipo #form_update_equipo .guia_id').val(
					equipo.guia_id
				);
				$(
					'#modal_update_equipo #form_update_equipo .contenedor_name_guia'
				).html(equipo.name_guia);
				if (
					equipo.file_guia !== null &&
					equipo.file_guia !== undefined &&
					equipo.file_guia !== ''
				) {
					var archivo =
						`
                <a target="__blank" href="` +
						base_url +
						`assets/upload_guias/` +
						equipo.file_guia +
						`"><span class="fa fa-paperclip"></span></a>
                `;
					$('.contenedor_archivo_guia').html(archivo);
				}
			}

			$('#modal_update_equipo #form_update_equipo .manual_id').val(
				equipo.manual_id
			);
			var url_manual =
				`
              <a target="__blank" href="` +
				equipo.manual_url +
				`" class="fa fa-external-link-square btn btn-link"></a>
            `;
			$('#modal_update_equipo #form_update_equipo .contenedor_url_manual').html(
				url_manual
			);
			$(
				'#modal_update_equipo #form_update_equipo .contenedor_descripcion_manual'
			).html(equipo.manual_descripcion);

			$('#modal_update_equipo #form_update_equipo #centro').html(equipo.centro);
			$('#modal_update_equipo #form_update_equipo #pisos').html(equipo.pisos);

			$('#modal_update_equipo #form_update_equipo #activo_comodato').val(
				equipo.activo_comodato
			);
			$('#modal_update_equipo #form_update_equipo #movilidad').val(
				equipo.movilidad
			);
			$('#modal_update_equipo #form_update_equipo #codigo_antiguo').val(
				equipo.codigo_antiguo
			);
			$('#modal_update_equipo #form_update_equipo #evaluacion_desempenio').val(
				equipo.evaluacion_desempenio
			);
			$('#modal_update_equipo #form_update_equipo #calibracion').val(
				equipo.calibracion
			);
			if (equipo.image != '' && equipo.image != null) {
				$('#modal_update_equipo #form_update_equipo #preview_imagen').html(
					"<img width='70px' height='70px' src='" +
						base_url +
						'assets/upload_imagenes/' +
						equipo.image +
						"'></img>"
				);
			} else {
				$('#modal_update_equipo #form_update_equipo #preview_imagen').html(
					'(no registra imagen)'
				);
			}
			$('#modal_update_equipo .input_check').attr('checked', false);
			var vector_manual = unserialize(equipo.manual);
			if (vector_manual != null && vector_manual != 'N;') {
				for (var i = 1; i <= vector_manual.length; i++) {
					$(
						"#modal_update_equipo input:checkbox[value='" +
							vector_manual[i - 1] +
							"']"
					).attr('checked', true);
				}
			}
			var vector_plano = unserialize(equipo.plano);
			if (vector_plano != null && vector_plano != 'N;') {
				for (var i = 1; i <= vector_plano.length; i++) {
					$(
						"#modal_update_equipo input:checkbox[value='" +
							vector_plano[i - 1] +
							"']"
					).attr('checked', true);
				}
			}
			$('#modal_update_equipo #form_update_equipo #observacion_temporal').html(
				nl2br(equipo.observacion)
			);
			$('#modal_update_equipo #form_update_equipo #observacion').val('');

			if ($('#form_update_equipo #calibracion').val() != 'SI') {
				$('#form_update_equipo .contenedor_periodicidad').html('NO APLICA');
			} else {
				$('#form_update_equipo .contenedor_periodicidad').html('ANUAL');
			}

			callback();
		});
	}
	function list_tadquisiciones() {
		var tadquisiciones = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getTadquisiciones',
			type: 'post',
			data: {},
		}).done(function (data) {
			tadquisiciones = JSON.parse(data);
			tmp = "<option value=''>--SELECCIONE--</option>";
			$.each(tadquisiciones, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.tadquisicion_id').html(tmp);
		});
	}
	function list_fuentes() {
		var fuentes = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getFuentes',
			type: 'post',
			data: {},
		}).done(function (data) {
			fuentes = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(fuentes, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.fuente_id').html(tmp);
		});
	}
	function list_tecnologias() {
		var tecnologias = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getTecnologias',
			type: 'post',
			data: {},
		}).done(function (data) {
			tecnologias = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(tecnologias, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.tecnologia_id').html(tmp);
		});
	}
	function list_cbiomedicas() {
		var cbiomedicas = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getCbiomedicas',
			type: 'post',
			data: {},
		}).done(function (data) {
			cbiomedicas = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(cbiomedicas, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.cbiomedica_id').html(tmp);
		});
	}
	function list_criesgos() {
		var criesgos = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getCriesgos',
			type: 'post',
			data: {},
		}).done(function (data) {
			criesgos = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(criesgos, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.criesgo_id').html(tmp);
		});
	}
	function list_frecuencias() {
		var frecuencias = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getFrecuencias',
			type: 'post',
			data: {},
		}).done(function (data) {
			frecuencias = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(frecuencias, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.frecuencia_id').html(tmp);
		});
	}
	function list_zonas() {
		var zonas = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getZonas',
			type: 'post',
			data: {},
		}).done(function (data) {
			zonas = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(zonas, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('#filtro_zona').html(tmp);
		});
	}
	function list_garantias() {
		var garantias = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getGarantias',
			type: 'post',
			data: {},
		}).done(function (data) {
			garantias = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(garantias, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.periodos_garantias').html(tmp);
		});
	}
	function list_archivos() {
		//Para agregar nuevos archivos desde la ventana principal
		var archivos = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getArchivos',
			type: 'post',
			data: {},
		}).done(function (data) {
			archivos = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(archivos, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('#archivo_id').html(tmp);
		});
	}
	function list_repuestos() {
		var repuestos = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'repuesto/Crepuestos/get_datatable',
			type: 'post',
			data: {},
		}).done(function (data) {
			repuestos = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(repuestos, function (i, item) {
				tmp +=
					'<option value=' +
					item.id +
					'>' +
					item.code +
					' | ' +
					item.name +
					'</option>';
			});
			$('.repuesto_id').html(tmp);
		});
	}
	function list_repuestos_correctivos_preventivos() {
		var repuestos = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'repuesto/Crepuestos/get',
			type: 'post',
			data: {},
		}).done(function (data) {
			repuestos = JSON.parse(data);
			tmp = "<option value=''>---------</option>";
			$.each(repuestos, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			//$("#repuesto_id").html(tmp);
			$('.repuesto_id').html(tmp);
		});
	}
	function list_observaciones2(id) {
		var observaciones = '';
		var archivos = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getObservaciones',
			type: 'post',
			data: { equipo_id: id },
		}).done(function (data) {
			observaciones = JSON.parse(data);
			$.each(observaciones, function (i, item) {
				tmp += '<tr>';
				// tmp+="<td>"+item.id+"</td>";

				tmp += '<td>' + item.description + '</td>';
				tmp += '<td>' + item.created_at + '</td>';
				if (item.file != null) {
					tmp +=
						`<td class='esconder'><a  target='_blank' href='` +
						base_url +
						'assets/upload_observaciones/' +
						item.file +
						`' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></a>
                <div class="tmpa_` +
						item.id +
						`"></div>
                `;
					var clase;
					$.ajax({
						url: 'Cequipos/getArchivosObservacion',
						type: 'post',
						data: { observacion_id: item.id },
					}).done(function (data2) {
						archivos = JSON.parse(data2);
						var tmp2 = '';
						$.each(archivos, function (j, archivo) {
							tmp2 +=
								`<a title="` +
								archivo.titulo +
								`" target="__blank" href="` +
								base_url +
								`assets/upload_observaciones/` +
								archivo.file +
								`" class="glyphicon glyphicon-file" href=""></a>`;
						});
						clase = '.tmpa_' + item.id; // Creo una clase auxiliar con el id de la observacion
						$(clase).html(tmp2); // Contenedor de los archivos de cada observacion
						tmp2 = '';
					});
					tmp += `</td>`;
				} else {
					tmp +=
						`<td class='esconder'>

                  <div class="tmpa_` +
						item.id +
						`"></div>
                `;
					var clase;
					$.ajax({
						url: 'Cequipos/getArchivosObservacion',
						type: 'post',
						data: { observacion_id: item.id },
					}).done(function (data2) {
						archivos = JSON.parse(data2);
						var tmp2 = '';
						$.each(archivos, function (j, archivo) {
							tmp2 +=
								`<a title="` +
								archivo.titulo +
								`" target="__blank" href="` +
								base_url +
								`assets/upload_observaciones/` +
								archivo.file +
								`" class="glyphicon glyphicon-file" href=""></a>`;
						});
						clase = '.tmpa_' + item.id;
						$(clase).html(tmp2);
						tmp2 = '';
					});
					tmp += `</td>`;
				}
				tmp += "<td class='esconder'>";

				if (editar_observacion == 1) {
					tmp +=
						`<a href="#" data-toggle="modal" data-target="#modal_add_archivo_observacion" onClick="modalArchivoObservacion(event,` +
						item.id +
						`)" class="btn btn-primary fa fa-paperclip"></a>&nbsp;`;

					if (item.repuesto_pendiente === 'si') {
						tmp +=
							"<span style='color: red;' class='glyphicon glyphicon-wrench'>RP</span><a data-toggle='modal' data-target='#modal_update_observacion' onClick='recover_modal_edit_observacion(" +
							item.id +
							")' class='btn btn-danger glyphicon glyphicon-pencil' style='padding:5px;'></a>";
					} else {
						tmp +=
							"<a data-toggle='modal' data-target='#modal_update_observacion' onClick='recover_modal_edit_observacion(" +
							item.id +
							")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>";
					}
				}
				tmp += '</td>';
				tmp += "<td class='esconder'>";
				if (eliminar_observacion === 1) {
					tmp +=
						"<a onClick='delete_observacion(" +
						item.id +
						',' +
						item.equipo_id +
						",event)' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>";
				}
				tmp += '</td>';

				tmp += '</tr>';
			});
			$('#form_update_equipo .tblObservaciones tbody').html(tmp);
		});
	}
	function list_equipo_repuestos_correctivo_general(id) {
		var equipo_repuestos = '';
		var tmp = '';
		$.ajax({
			url: base_url + 'equipo/Cequipos/getEquipoRepuestosCorrectivosgenerales',
			type: 'post',
			data: { correctivo_general_id: id },
		}).done(function (data) {
			equipo_repuestos = JSON.parse(data);
			$.each(equipo_repuestos, function (i, item) {
				tmp += '<tr>';
				tmp +=
					'<td>' +
					item.repuesto +
					' <strong>(' +
					item.codigo_repuesto +
					')</strong></td>';
				tmp += '<td>' + item.observacion + '</td>';
				tmp += '<td>' + item.fecha + '</td>';
				tmp += '<td>' + item.cantidad_entregada + '</td>';
				if (item.file != null) {
					tmp +=
						"<td class='esconder'><a  target='_blank' href='" +
						base_url +
						'assets/upload_equipo_repuestos/' +
						item.file +
						"' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></a></td>";
				} else {
					tmp += "<td class='esconder'></td>";
				}
				tmp +=
					"<td class='esconder'>" +
					"<a data-toggle='modal' data-target='#modal_update_equipo_repuesto' onClick='recover_modal_edit_equipo_repuesto(" +
					item.id +
					")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>" +
					'</td>';
				tmp +=
					"<td class='esconder'>" +
					"<a onClick='delete_equipo_repuesto(" +
					item.id +
					',' +
					item.equipo_id +
					",event)' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>" +
					'</td>';
				tmp += '</tr>';
			});
			$('#modal_update_correctivo_general .tblEquipoRepuestos tbody').html(tmp);
		});
	}
	function datatable_destroy() {
		$('#tblEquipos').dataTable().fnClearTable();
		$('#tblEquipos').dataTable().fnDestroy();
	}
	$('.errores').on('click', () => $('.errores').hide());
	function validacionImagen1() {
		var fileInput = document.getElementById('image1');
		var filePath = fileInput.value;
		var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
		if (!allowedExtensions.exec(filePath)) {
			alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
			fileInput.value = '';
			return false;
		}
	}
	function validacionArchivo() {
		var fileInput = document.getElementById('file');
		var filePath = fileInput.value;
		var allowedExtensions = /(.xlsx|.xls)$/i;
		if (!allowedExtensions.exec(filePath)) {
			alert('Solo se permiten archivos con extensiones .xls y. xlsx');
			fileInput.value = '';
			return false;
		}
	}
	function validacionArchivo1() {
		var fileInput = document.getElementById('file1');
		var filePath = fileInput.value;
		var allowedExtensions = /(.xlsx|.xls)$/i;
		if (!allowedExtensions.exec(filePath)) {
			alert('Solo se permiten archivos con extensiones .xls y. xlsx');
			fileInput.value = '';
			return false;
		}
	}
	function validacionArchivoPdf() {
		var fileInput = document.getElementById('archivo_invima');
		var filePath = fileInput.value;
		var allowedExtensions = /(.pdf)$/i;
		if (!allowedExtensions.exec(filePath)) {
			alert('Solo se permiten archivos con extension .pdf');
			fileInput.value = '';
			return false;
		}
	}
	function validacionArchivoPdf1() {
		var fileInput = document.getElementById('archivo_invima1');
		var filePath = fileInput.value;
		var allowedExtensions = /(.pdf)$/i;
		if (!allowedExtensions.exec(filePath)) {
			alert('Solo se permiten archivos con extension .pdf');
			fileInput.value = '';
			return false;
		}
	}

	function aplicar_filtro() {
		datatable_destroy();
		list_data_table_server_side_filtros();
		$('#modal_filter_equipo .close').click();
	}

	$('#tblEquipos tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tabla.api().row(tr);
		if (row.child.isShown()) {
			row.child.hide();
			tr.removeClass('shown');
		} else {
			row.child(formato(row.data())).show();
			tr.addClass('shown');
		}
	});
	function formato(d) {
		var tmp = '';
		if (d.observacion !== null) {
			tmp += '<table>';
			tmp +=
				'<tr><td><strong>Observaciones: </strong></td><td>' +
				nl2br(d.observacion) +
				'</td></tr>';
			tmp += '</table>';
		} else {
			tmp += '<h3>No data avalaible</h3>';
		}
		return tmp;
	}

	function pasar_equipo_id(equipo_id) {
		$('#form_observacion').trigger('reset');
		$('#form_observacion #equipo_id').val(equipo_id);
	}
	$('#form_observacion').submit(function (e) {
		e.preventDefault();

		var formulario = new FormData(this);
		$('#btn_add_observacion').attr('disabled', 'disabled');
		$('#mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#mensaje').html('Procesando..........');
		$.ajax({
			url: `${base_url}equipo/Cequipos/addObservacion`,
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);

			$('#form_observacion #description').val('');
			$('#modal_add_observacion .close').click();

			$('#btn_add_observacion').removeAttr('disabled', 'disabled');
			$('#mensaje').html('');
			$('#mensaje').removeClass(
				'glyphicon glyphicon-refresh glyphicon-refresh-animate'
			);
			datatable_destroy();
			list_data_table_server_side_filtros();

			list_observaciones(JSON.parse(respuesta.equipo_id));
			list_observaciones2(JSON.parse(respuesta.equipo_id));

			if (
				respuesta.repuesto_id != null &&
				respuesta.repuesto_id != '' &&
				respuesta.repuesto_id != undefined
			) {
				funcion_email_observacion(
					respuesta.equipo_id,
					respuesta.observacion_id
				);
			}
		});
	});
	function funcion_email_observacion(equipo_id, observacion_id) {
		$.ajax({
			url: base_url + 'Cemail/send_email_observacion',
			type: 'post',
			data: {
				equipo_id: equipo_id,
				observacion_id: observacion_id,
			},
		}).done(function (data) {
			alert(
				'Se ha enviado la información del repuesto pendiente a los correos correspondientes'
			);
		});
	}
	function recover_modal_edit_observacion(id) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/getOneObservacion',
			type: 'POST',
			data: { id },
		}).done((data) => {
			var observacion = JSON.parse(data);

			$('#modal_update_observacion #form_update_observacion #id').val(
				observacion.id
			);
			$('#modal_update_observacion #form_update_observacion #equipo_id').val(
				observacion.equipo_id
			);
			$('#modal_update_observacion #form_update_observacion #description').val(
				observacion.description
			);
			if (observacion.repuesto_pendiente == 'si') {
				$(
					'#modal_update_observacion #form_update_observacion #repuesto_pendiente'
				).removeAttr('disabled', 'disabled');
				$(
					'#modal_update_observacion #form_update_observacion #repuesto_pendiente'
				).prop('checked', true);
			} else {
				$(
					'#modal_update_observacion #form_update_observacion #repuesto_pendiente'
				).prop('checked', false);
			}
		});
	}

	$('#form_update_observacion').submit(function (e) {
		e.preventDefault();
		const form = new FormData(this);
		$('#modal_update_observacion #btn_update_observacion').attr(
			'disabled',
			'disabled'
		);
		$('#mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#mensaje').html('Procesando..........');
		const url = `${base_url}equipo/Cequipos/updateObservacion`;
		$.ajax({
			url,
			type: 'post',
			data: form,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done((data) => {
			let response = JSON.parse(data);
			const { equipo_id, cambio, observacion_id } = response;
			$('#form_update_observacion #description').val('');
			list_observaciones(JSON.parse(equipo_id));
			list_observaciones2(JSON.parse(equipo_id));
			list_data_table_server_side_filtros();
			$('#modal_update_observacion .close').click();
			$('#modal_update_observacion #btn_update_observacion').removeAttr(
				'disabled',
				'disabled'
			);
			if (cambio === 'si') funcion_email_observacion(equipo_id, observacion_id);
		});
	});

	function delete_observacion(id, equipo_id, e) {
		e.preventDefault();
		var confirmacion = '';
		confirmacion = confirm(
			'Esta a punto de eliminar la observación refernnciada, desea continuar?'
		);
		if (confirmacion) {
			const url = `${base_url}equipo/Cequipos/deleteObservacion`;
			$.ajax({
				url,
				type: 'post',
				data: { id, equipo_id },
			}).done((data) => {
				list_observaciones(equipo_id);
				list_observaciones2(equipo_id);
				datatable_destroy();
				list_data_table_server_side_filtros();
			});
		}
	}
	$('#form_repuesto').submit(function (e) {
		e.preventDefault();
		const form = new FormData(this);
		$('#btn_add_repuesto').attr('disabled', 'disabled');
		$('#mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#mensaje').html('Procesando..........');
		const url = `${base_url}equipo/Cequipos/addEquipoRepuesto`;
		$.ajax({
			url,
			type: 'post',
			data: form,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done((data) => {
			$('form_repuesto').trigger('reset');
			list_equipo_repuestos(JSON.parse(data));
			list_equipo_repuestos2(JSON.parse(data));
			$('#modal_add_repuesto .close').click();

			$('#btn_add_repuesto').removeAttr('disabled', 'disabled');
			$('#mensaje').html('');
			$('#mensaje').removeClass(
				'glyphicon glyphicon-refresh glyphicon-refresh-animate'
			);
			datatable_destroy();
			list_data_table_server_side_filtros();
		});
	});
	$('#form_repuesto_correctivo_general').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$('#btn_add_repuesto_correctivo_general').attr('disabled', 'disabled');
		$('#mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('#mensaje').html('Procesando..........');
		$.ajax({
			url: base_url + 'equipo/Cequipos/addEquipoRepuestoCorrectivoGeneral',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done((data) => {
			var respuesta = JSON.parse(data);
			$('form_repuesto').trigger('reset');
			list_equipo_repuestos(respuesta.equipo_id);
			list_equipo_repuestos2(respuesta.equipo_id);
			list_equipo_repuestos_correctivo_general(respuesta.correctivo_general_id);
			$('#modal_add_repuesto .close').click();
			$('#modal_add_repuesto_correctivo_general .close').click();
			$('#btn_add_repuesto_correctivo_general').removeAttr(
				'disabled',
				'disabled'
			);
			$('#mensaje').html('');
			$('#mensaje').removeClass(
				'glyphicon glyphicon-refresh glyphicon-refresh-animate'
			);
			datatable_destroy();
			list_data_table_server_side_filtros();
		});
	});
	function recover_modal_edit_equipo_repuesto(id) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/getOneEquipoRepuesto',
			type: 'POST',
			data: { id: id },
		}).done(function (data) {
			var equipo_repuesto = JSON.parse(data);
			$('#modal_update_equipo_repuesto #form_update_equipo_repuesto #id').val(
				equipo_repuesto.id
			);
			$(
				'#modal_update_equipo_repuesto #form_update_equipo_repuesto #equipo_id'
			).val(equipo_repuesto.equipo_id);
			$(
				'#modal_update_equipo_repuesto #form_update_equipo_repuesto #repuesto_id'
			).val(equipo_repuesto.repuesto_id);
			$(
				'#modal_update_equipo_repuesto #form_update_equipo_repuesto #observacion'
			).val(equipo_repuesto.observacion);
			$(
				'#modal_update_equipo_repuesto #form_update_equipo_repuesto #fecha'
			).val(equipo_repuesto.fecha);
			$(
				'#modal_update_equipo_repuesto #form_update_equipo_repuesto #cantidad_entregada'
			).val(equipo_repuesto.cantidad_entregada);
		});
	}
	$('#form_update_equipo_repuesto').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$('#modal_update_equipo_repuesto #btn_update_equipo_repuesto').attr(
			'disabled',
			'disabled'
		);
		$.ajax({
			url: base_url + 'equipo/Cequipos/updateEquipoRepuesto',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			$('#form_update_equipo_repuesto #id').val('');
			$('#form_update_equipo_repuesto #equipo_id').val('');
			$('#form_update_equipo_repuesto #repuesto_id').val('');
			$('#form_update_equipo_repuesto #observacion').val('');
			$('#form_update_equipo_repuesto #fecha').val('');
			$('#form_update_equipo_repuesto #cantidad_entregada').val('');
			list_equipo_repuestos(JSON.parse(data));
			list_equipo_repuestos2(JSON.parse(data));
			$('#modal_update_equipo_repuesto #btn_update_equipo_repuesto').removeAttr(
				'disabled',
				'disabled'
			);
			$('#modal_update_equipo_repuesto .close').click();
		});
	});
	function delete_equipo_repuesto(id, equipo_id, e) {
		e.preventDefault();
		var confirmacion = '';
		confirmacion = confirm(
			'Esta a punto de eliminar el registro de repuesto, desea proceder?'
		);
		if (confirmacion) {
			$.ajax({
				url: base_url + 'equipo/Cequipos/deleteEquipoRepuesto',
				type: 'post',
				data: {
					id: id,
					equipo_id: equipo_id,
				},
			}).done(function (data) {
				list_equipo_repuestos(equipo_id);
				list_equipo_repuestos2(equipo_id);
				datatable_destroy();
				list_data_table_server_side_filtros();
			});
		} else {
			alert('Acción cancelada');
		}
	}

	function esconder() {
		$('.esconder').toggle();
	}
	function revelar() {
		$('.esconder').toggle();
	}
	$('.btn-print').click(function () {
		$('.impresion').print({
			title: 'Detalle del equipo',
		});
	});
	function incluir(id, tipo, e) {
		e.preventDefault();
		$.ajax({
			url: base_url + 'equipo/Cequipos/incluir',
			type: 'post',
			data: { id: id },
		}).done(function (data) {
			datatable_destroy();
			var tabla = '';
			list_data_table_server_side_filtros();
		});
	}
	function excluir(id, tipo, e) {
		e.preventDefault();
		var confirmacion = confirm(
			'Desea excluir el equipo del plan de mantenimiento?\nTenga en cuenta que se reseteara la fecha de preventivo'
		);
		if (confirmacion) {
			$.ajax({
				url: base_url + 'equipo/Cequipos/excluir',
				type: 'post',
				data: { id: id },
			}).done(function (data) {
				datatable_destroy();
				var tabla = '';
				list_data_table_server_side_filtros();

				if (tipo == 1) {
					list_data_table_server_side();
				} else if (tipo == 2) {
					list_data_table_server_side();
				}
			});
		} else {
			alert('El equipo no fue excluido');
		}
	}
	$('#form_equipo_contacto').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$('#btn_add_equipo_contacto').attr('disabled', 'disabled');
		$('.mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('.mensaje').html('Procesando..........');
		$.ajax({
			url: base_url + 'equipo/Cequipos/addEquipoContacto',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			$('#form_equipo_contacto #contacto_id').val('');
			list_equipo_contactos(JSON.parse(data));
			list_equipo_contactos2(JSON.parse(data));
			$('#modal_add_equipo_contacto .close').click();
			$('.mensaje').html('');
			$('.mensaje').removeClass(
				'glyphicon glyphicon-refresh glyphicon-refresh-animate'
			);
			$('#btn_add_equipo_contacto').removeAttr('disabled');
		});
	});
	function delete_equipo_contacto(id, equipo_id) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/deleteEquipoContacto',
			type: 'post',
			data: {
				id: id,
				equipo_id: equipo_id,
			},
		}).done(function (data) {
			list_equipo_contactos(equipo_id);
			list_equipo_contactos2(equipo_id);
		});
	}
	function nl2br(str, is_xhtml) {
		if (typeof str === 'undefined' || str === null) {
			return '';
		}
		var breakTag =
			is_xhtml || typeof is_xhtml === 'undefined' ? '<br />' : '<br>';
		return (str + '').replace(
			/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
			'$1' + breakTag + '$2'
		);
	}
	function unserialize(data) {
		var that = this,
			utf8Overhead = function (chr) {
				var code = chr.charCodeAt(0);
				if (code < 0x0080) {
					return 0;
				}
				if (code < 0x0800) {
					return 1;
				}
				return 2;
			},
			error = function (type, msg, filename, line) {
				throw new that.window[type](msg, filename, line);
			},
			read_until = function (data, offset, stopchr) {
				var i = 2,
					buf = [],
					chr = data.slice(offset, offset + 1);
				while (chr != stopchr) {
					if (i + offset > data.length) {
						error('Error', 'Invalid');
					}
					buf.push(chr);
					chr = data.slice(offset + (i - 1), offset + i);
					i += 1;
				}
				return [buf.length, buf.join('')];
			},
			read_chrs = function (data, offset, length) {
				var i, chr, buf;

				buf = [];
				for (i = 0; i < length; i++) {
					chr = data.slice(offset + (i - 1), offset + i);
					buf.push(chr);
					length -= utf8Overhead(chr);
				}
				return [buf.length, buf.join('')];
			},
			_unserialize = function (data, offset) {
				var dtype,
					dataoffset,
					keyandchrs,
					keys,
					contig,
					length,
					array,
					readdata,
					readData,
					ccount,
					stringlength,
					i,
					key,
					kprops,
					kchrs,
					vprops,
					vchrs,
					value,
					chrs = 0,
					typeconvert = function (x) {
						return x;
					};

				if (!offset) {
					offset = 0;
				}
				dtype = data.slice(offset, offset + 1).toLowerCase();
				dataoffset = offset + 2;
				switch (dtype) {
					case 'i':
						typeconvert = function (x) {
							return parseInt(x, 10);
						};
						readData = read_until(data, dataoffset, ';');
						chrs = readData[0];
						readdata = readData[1];
						dataoffset += chrs + 1;
						break;
					case 'b':
						typeconvert = function (x) {
							return parseInt(x, 10) !== 0;
						};
						readData = read_until(data, dataoffset, ';');
						chrs = readData[0];
						readdata = readData[1];
						dataoffset += chrs + 1;
						break;
					case 'd':
						typeconvert = function (x) {
							return parseFloat(x);
						};
						readData = read_until(data, dataoffset, ';');
						chrs = readData[0];
						readdata = readData[1];
						dataoffset += chrs + 1;
						break;
					case 'n':
						readdata = null;
						break;
					case 's':
						ccount = read_until(data, dataoffset, ':');
						chrs = ccount[0];
						stringlength = ccount[1];
						dataoffset += chrs + 2;

						readData = read_chrs(
							data,
							dataoffset + 1,
							parseInt(stringlength, 10)
						);
						chrs = readData[0];
						readdata = readData[1];
						dataoffset += chrs + 2;
						if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
							error('SyntaxError', 'String length mismatch');
						}
						break;
					case 'a':
						readdata = {};

						keyandchrs = read_until(data, dataoffset, ':');
						chrs = keyandchrs[0];
						keys = keyandchrs[1];
						dataoffset += chrs + 2;

						length = parseInt(keys, 10);
						contig = true;

						for (i = 0; i < length; i++) {
							kprops = _unserialize(data, dataoffset);
							kchrs = kprops[1];
							key = kprops[2];
							dataoffset += kchrs;

							vprops = _unserialize(data, dataoffset);
							vchrs = vprops[1];
							value = vprops[2];
							dataoffset += vchrs;

							if (key !== i) contig = false;

							readdata[key] = value;
						}

						if (contig) {
							array = new Array(length);
							for (i = 0; i < length; i++) array[i] = readdata[i];
							readdata = array;
						}

						dataoffset += 1;
						break;
					default:
						error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
						break;
				}
				return [dtype, dataoffset - offset, typeconvert(readdata)];
			};
		return _unserialize(data + '', 0)[2];
	}
	function notify(action = '') {
		var msj = '';
		var tipo = '';
		if (action === 'add') {
			msj = 'Equipo Agregado exitosamente';
			tipo = 'success';
		} else if (action === 'edit') {
			msj = 'Equipo Editado exitosamente';
			tipo = 'info';
		} else if (action === 'del') {
			msj = 'Equipo Eliminado exitosamente';
			tipo = 'danger';
		} else if (action === 'add_archivo') {
			msj = 'Archivo agregado exitosametne';
			tipo = 'success';
		} else if (action === 'del_archivo') {
			msj = 'Archivo eliminado exitosamente';
			tipo = 'danger';
		} else if (action === 'add_especificacion') {
			msj = 'Acción realizada exitosamente';
			tipo = 'success';
		} else {
			msj = action;
			tipo = 'danger';
		}

		$.notify(
			{
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
	$('#form_equipo #calibracion,#form_update_equipo #calibracion').on(
		'change',
		() => {
			if ($('#form_equipo #calibracion').val() !== 'SI') {
				$('#form_equipo .contenedor_periodicidad').html('NO APLICA');
			} else {
				$('#form_equipo .contenedor_periodicidad').html('ANUAL');
			}
			if ($('#form_update_equipo #calibracion').val() !== 'SI') {
				$('#form_update_equipo .contenedor_periodicidad').html('NO APLICA');
			} else {
				$('#form_update_equipo .contenedor_periodicidad').html('ANUAL');
			}
		}
	);
	function modal_garantia_casi_vencida(e) {
		e.preventDefault();

		$.ajax({
			url: base_url + 'equipo/Cequipos/get_garantiaCasiVencida',
			type: 'post',
			data: {},
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = "<table id='tabla_garantiaCasiVencida' class='table'>";
			tmp += '<thead>';
			tmp += '<tr>';
			tmp += '<th>ID</th>';
			tmp += '<th>Nombre</th>';
			tmp += '<th>Marca</th>';
			tmp += '<th>Modelo</th>';
			tmp += '<th>Serie</th>';
			tmp += '<th>Codigo</th>';
			tmp += '<th>Fecha de adquisición</th>';
			tmp += '<th>Tiempo de garantia</th>';
			tmp += '<th>Inclusion plan de mantenimiento</th>';
			tmp += '</tr>';
			tmp += '</thead>';
			tmp += '<tbody>';
			$.each(respuesta, function (i, item) {
				tmp += '<tr>';
				tmp += '<td>' + item.id + '</td><td>' + item.name + '</td>';
				tmp += '<td>' + item.marca + '</td><td>' + item.modelo + '</td>';
				tmp += '<td>' + item.serial + '</td><td>' + item.code + '</td>';
				tmp += '<td>' + item.fecha_ad + '</td>';
				tmp += '<td>' + item.tiempo_garantia + '</td>';
				tmp += '<td>' + item.inclusion_plan + '</td>';
				tmp += '</tr>';
			});
			tmp += '</tbody>';
			tmp += '</table>';

			$('#modal_garantia_casi_vencida .modal-body ').html(tmp);
			$('#tabla_garantiaCasiVencida').DataTable();
		});
	}
	function modal_garantia_vencida(e) {
		e.preventDefault();

		$.ajax({
			url: base_url + 'equipo/Cequipos/get_garantiaVencida',
			type: 'post',
			data: {},
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = "<table id='tabla_garantiaVencida' class='table'>";
			tmp += '<thead>';
			tmp += '<tr>';
			tmp += '<th>ID</th>';
			tmp += '<th>Nombre</th>';
			tmp += '<th>Marca</th>';
			tmp += '<th>Modelo</th>';
			tmp += '<th>Serie</th>';
			tmp += '<th>Codigo</th>';
			tmp += '<th>Fecha de adquisición</th>';
			tmp += '<th>Tiempo de garantia</th>';
			tmp += '<th>Inclusion plan de mantenimiento</th>';
			tmp += '</tr>';
			tmp += '</thead>';
			tmp += '<tbody>';
			$.each(respuesta, function (i, item) {
				tmp += '<tr>';
				tmp += '<td>' + item.id + '</td><td>' + item.name + '</td>';
				tmp += '<td>' + item.marca + '</td><td>' + item.modelo + '</td>';
				tmp += '<td>' + item.serial + '</td><td>' + item.code + '</td>';
				tmp += '<td>' + item.fecha_ad + '</td>';
				tmp += '<td>' + item.tiempo_garantia + '</td>';
				tmp += '<td>' + item.inclusion_plan + '</td>';
				tmp += '</tr>';
			});
			tmp += '</tbody>';
			tmp += '</table>';

			$('#modal_garantia_vencida .modal-body ').html(tmp);
			$('#tabla_garantiaVencida').DataTable();
		});
	}
	//temporizador_recarga= setTimeout(function(){ $(".contenedor_alerta_garantia").hide(); }, 10000);//1000=1min
	function delete_equipo_archivo(id, event) {
		event.preventDefault();
		var confirmacion = confirm('Desea eliminar el archivo?');
		if (confirmacion) {
			$.ajax({
				url: base_url + 'equipo/Cequipos/delete_equipo_archivo',
				type: 'post',
				data: { id },
			}).done(function () {
				$('#modal_show_archivos .close').click();

				datatable_destroy();
				list_data_table_server_side_filtros();
				notify('del_archivo');
			});
		} else {
			alert('No se elimino el archivo');
		}
	}
	$('#multiple_capacitaciones').submit(function (e) {
		e.preventDefault();
		$('#modal_multiple #btn_add_multiple_capacitacion').attr(
			'disabled',
			'disabled'
		);
		var formulario = new FormData(this);
		formulario.append('servicios', $('#modal_multiple .servicio_id').val());
		formulario.append('areas', $('#modal_multiple .area_id').val());

		$.ajax({
			url: base_url + 'equipo/Cequipos/addMultipleCapacitaciones',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			$('#modal_multiple #btn_add_multiple_capacitacion').removeAttr(
				'disabled',
				'disabled'
			);

			datatable_destroy();
			list_data_table_server_side_filtros();
			$('#modal_multiple .close').click();
			$('#modal_multiple input').html('');
			notify('add_archivo');
		});
	});
	$('#multiple_imagenes').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$('#btn_add_multiple_imagenes').attr('disabled', 'disabled');

		$.ajax({
			url: base_url + 'equipo/Cequipos/addMultipleImagenes',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			datatable_destroy();
			list_data_table_server_side_filtros();
			$('#btn_add_multiple_imagenes').removeAttr('disabled', 'disabled');
			$('#modal_multiple .close').click();
			$('#modal_multiple input').html('');
			notify('add_especificacion');
		});
	});
	function funcion_modal_obsoletos(e) {
		e.preventDefault();
		$.ajax({
			url: base_url + 'equipo/Cequipos/show_obsoletos',
			type: 'post',
			data: { id: 1 },
		}).done(function (data) {
			$('#modal_obsoletos .modal-body').html(data);
			$('.datatable-obsoletos').dataTable();
		});
	}
	function modalArchivoCorrectivoGeneral(correctivo_general_id, equipo_id) {
		$('#form_archivo_correctivo_general #correctivo_general_id').val(
			correctivo_general_id
		);
		$('#form_archivo_correctivo_general #equipo_id').val(equipo_id);
	}
	$('#form_archivo_correctivo_general').on('submit', function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$('#btn_add_archivo_correctivo_general').attr('disabled', 'disabled');

		$.ajax({
			url: base_url + 'equipo/Cequipos/add_archivo_correctivo_general',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			$('#btn_add_archivo_correctivo_general').removeAttr(
				'disabled',
				'disabled'
			);
			$('#modal_add_archivo_correctivo .close').click();

			$('.tblCorrectivosGenerales tbody').html('');
			list_correctivos_generales2(
				$('#form_archivo_correctivo_general #equipo_id').val()
			);
		});
	});
	function delete_archivo_correctivo_general(id, e, equipo_id) {
		e.preventDefault();
		var confirmacion = confirm(
			'Esta a punto de eliminar el archivo, desea proceder?'
		);
		if (confirmacion) {
			$.ajax({
				url: base_url + 'equipo/Cequipos/deleteArchivoCorrectivoGeneral',
				type: 'post',
				data: { id: id },
			}).done(function (data) {
				$('.tblCorrectivosGenerales tbody').html('');
				list_correctivos_generales2(equipo_id).val();
			});
		} else {
			alert('Acción cancelada');
		}
	}
	function abrir_modal_update_equipo() {
		$('.localizacion_actual').attr('disabled', 'disabled');
		$('.abrir_modal_update_equipo').click();
		$.unblockUI();
	}
	function abrir_modal_add_equipo() {
		$('.abrir_modal_add_equipo').click();
	}
	function abrir_modal_copy_equipo() {
		$('.abrir_modal_copy_equipo').click();
	}
	function desbloquear_add_equipo() {
		$.unblockUI();
		abrir_modal_add_equipo();
	}
	function desbloquear_copy_equipo() {
		$.unblockUI();
		abrir_modal_copy_equipo();
	}
	function set_fecha_programada_add() {
		var fecha = $('#modal_add_preventivo #fecha_mantenimiento').val();
		var separado = fecha.split('-');
		var anio = separado[0];
		var mes = separado[1];
		var dia = separado[2];
		var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
		$('#modal_add_preventivo #fecha_programada').val(fecha_programada);
	}
	function set_fecha_programada_edit() {
		var fecha = $('#modal_update_preventivo #fecha_mantenimiento').val();
		var separado = fecha.split('-');
		var anio = separado[0];
		var mes = separado[1];
		var dia = separado[2];
		var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
		$('#modal_update_preventivo #fecha_programada').val(fecha_programada);
	}
	function set_fecha_programada_add_calibracion() {
		var fecha = $('#modal_add_calibracion #fecha_calibracion').val();
		var separado = fecha.split('-');
		var anio = separado[0];
		var mes = separado[1];
		var dia = separado[2];
		var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
		$('#modal_add_calibracion #fecha_programada').val(fecha_programada);
	}
	function set_fecha_programada_edit_calibracion() {
		var fecha = $('#modal_update_calibracion #fecha_calibracion').val();
		var separado = fecha.split('-');
		var anio = separado[0];
		var mes = separado[1];
		var dia = separado[2];
		var fecha_programada = anio + '-' + mes + '-' + lastday(anio, mes);
		$('#modal_update_calibracion #fecha_programada').val(fecha_programada);
	}
	function lastday(y, m) {
		return new Date(y, m, 0).getDate();
	}
	function formatoMoneda(value) {
		let val = (value / 1).toFixed(2).replace('.', ',');
		return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	}
	$('.mostrar_formulario_repuesto').on('click', function (e) {
		$('.contenedor_formulario_repuesto').toggle();
		$('.formulario_repuesto input').val('');
	});
	$('.formulario_repuesto').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$.ajax({
			url: base_url + 'repuesto/Crepuestos/add_repuesto_from_equipos',
			type: 'POST',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.respuesta == 2) {
				alert(respuesta.informacion);
				$('#form_repuesto .repuesto_id').html('');
				list_repuestos();
			} else {
				alert('Nuevo Repuesto agregado exitosamente');
				$('.contenedor_formulario_repuesto').toggle();
				list_repuestos();
			}
		});
	});
	$('.mostrar_formulario_contacto').on('click', function (e) {
		$('.contenedor_formulario_contacto').toggle();
		$('.contenedor_formulario_contacto input').val('');
		list_tcontactos();
	});
	$('.agregar_contacto').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url: base_url + 'ubicacion/Ccontactos/add',
			type: 'POST',
			data: {
				name: $(
					'.contenedor_formulario_contacto .auxiliar_nombre_contacto'
				).val(),
				email: $(
					'.contenedor_formulario_contacto .auxiliar_email_contacto'
				).val(),
				telefono: $(
					'.contenedor_formulario_contacto .auxiliar_telefono_contacto'
				).val(),
				tcontacto_id: $(
					'.contenedor_formulario_contacto .auxiliar_tcontacto'
				).val(),
			},
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.respuesta == 2) {
				alert(respuesta.informacion);
			} else {
				alert('Nuevo contacto registrado exitosamente');
				list_contactos();
				$('.contenedor_formulario_contacto').toggle();
			}
		});
	});
	function dar_baja(equipo_id) {
		$('.form_equipo_baja .equipo_id').val(equipo_id);
	}
	$('.form_equipo_baja').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);

		$.ajax({
			url: base_url + 'equipo/Cbajas/add_equipo_baja',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			alert('El equipo ha sido dado de baja');
			$('#modal_add_equipo_baja .close').click();
			list_data_table_server_side_filtros();
			$('.baja_id').val('');
		});
	});
	function eliminar_equipo_baja(id, equipo_id) {
		var confirmacion = confirm('Desea eliminar la relación?');
		if (confirmacion) {
			$.ajax({
				url: base_url + 'equipo/Cbajas/delete_equipo_baja',
				type: 'post',
				data: { id: id },
			}).done(function (data) {
				alert('Se ha borrado la relacion de baja');
				$('.equipo_baja_fila_' + id).html('');
			});
		}
	}
	function list_codificaciones_cierres() {
		$.ajax({
			url: base_url + 'orden/Cordenes/getCierres',
			type: 'post',
			data: {},
		}).done(function (data) {
			var cierres = JSON.parse(data);
			select_cierres = "<option value=''>------------------</option>";
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
			$(
				'#modal_update_correctivo_general #form_update_correctivo_general #cierre_id'
			).html('');
			$(
				'#modal_update_correctivo_general #form_update_correctivo_general #cierre_id'
			).html(select_cierres);
			$(
				'#modal_add_correctivo_general #form_correctivo_general #cierre_id'
			).html('');
			$(
				'#modal_add_correctivo_general #form_correctivo_general #cierre_id'
			).html(select_cierres);
		});
	}
	list_codificaciones_cierres();
	function seleccion_contenedor_adquisicion_copy(e) {
		var tipo_adquisicion = $('#modal_copy .tadquisicion_id').val();
		if (tipo_adquisicion !== 2)
			$('#modal_copy .contenedor_adquisicion_compra').hide();
		else $('#modal_copy .contenedor_adquisicion_compra').show();
	}
	function recover_modal_copy(equipo_id) {
		$.ajax({
			url: base_url + 'equipo/Cequipos/getOne',
			type: 'post',
			data: { id: equipo_id },
		}).done((data) => {
			var respuesta = JSON.parse(data);
			$('#modal_copy #id').val(respuesta.id);
			$('#modal_copy #image').val(respuesta.image);
			$('#modal_copy #name').val(respuesta.name);
			$('#modal_copy #descripcion').val(respuesta.descripcion);
			$('#modal_copy #serial').val(respuesta.serial);
			$('#modal_copy #code').val(respuesta.code);
			$('#modal_copy #modelo').val(respuesta.modelo);
			$('#modal_copy #marca').val(respuesta.marca);
			$('#modal_copy #invima_id').val(respuesta.registro_sanitario_id);
			$('#modal_copy #sede_id').val(respuesta.sede_id);
			$('#modal_copy #servicio_id').val(respuesta.servicio_id);
			getAreaByservicio(respuesta.servicio_id, respuesta.area_id);
			$('#modal_copy #fuente_id').val(respuesta.fuente_id);
			$('#modal_copy #tecnologia_id').val(respuesta.tecnologia_id);
			$('#modal_copy #frecuencia_id').val(respuesta.frecuencia_id);
			$('#modal_copy #cbiomedica_id').val(respuesta.cbiomedica_id);
			$('#modal_copy #criesgo_id').val(respuesta.criesgo_id);
			$('#modal_copy #tadquisicion_id').val(respuesta.tadquisicion_id);
			$('#modal_copy #fecha_ad').val(respuesta.fecha_ad);
			$('#modal_copy #fecha_instalacion').val(respuesta.fecha_instalacion);
			$('#modal_copy #fecha_mantenimiento').val(respuesta.fecha_mantenimiento);
			$('#modal_copy #fecha_vencimiento_garantia').val(
				respuesta.fecha_vencimiento_garantia
			);
			$('#modal_copy #fecha_acta_recibo').val(respuesta.fecha_acta_recibo);
			$('#modal_copy #fecha_inicio_operacion').val(
				respuesta.fecha_inicio_operacion
			);
			$('#modal_copy #fecha_fabricacion').val(respuesta.fecha_fabricacion);
			$('#modal_copy #vida_util').val(respuesta.vida_util);
			$('#modal_copy #garantia').val(respuesta.garantia);
			$('#modal_copy #costo').val(respuesta.costo);
			$('#modal_copy #v1').val(respuesta.v1);
			$('#modal_copy #v2').val(respuesta.v2);
			$('#modal_copy #v3').val(respuesta.v3);
			$('#modal_copy .textarea-personalizado').summernote('destroy');
			$('#modal_copy #accesorios').val(respuesta.accesorios);
			$('#modal_copy .textarea-personalizado').summernote({
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['fontname', ['fontname']],
					['table', ['table']],
				],
			});
			$('#modal_copy #verificacion_inventario').val(
				respuesta.verificacion_inventario
			);
			$('#modal_copy #fecha_recepcion_almacen').val(
				respuesta.fecha_recepcion_almacen
			);
			$('#modal_copy .imagen_guardada').removeAttr('src');
			$('#modal_copy .imagen_guardada').attr(
				'src',
				base_url + 'assets/upload_imagenes/' + respuesta.image
			);
			$('#modal_copy #centro').html(respuesta.centro);
			$('#modal_copy #pisos').html(respuesta.pisos);
			$('#modal_copy #activo_comodato').val(respuesta.activo_comodato);
			$('#modal_copy #movilidad').val(respuesta.movilidad);
			$('#modal_copy #codigo_antiguo').val(respuesta.codigo_antiguo);
			$('#modal_copy #evaluacion_desempenio').val(
				respuesta.evaluacion_desempenio
			);
			$('#modal_copy #calibracion').val(respuesta.calibracion);
			$('#modal_copy #propietario_id').val(respuesta.propietario_id);
			$('#modal_copy #costo').val(respuesta.costo_original);
			$('#modal_copy .input_check').attr('checked', false);
			var vector_manual = unserialize(respuesta.manual);
			if (vector_manual != null && vector_manual != 'N;') {
				for (var i = 1; i <= vector_manual.length; i++) {
					$(
						"#modal_copy input:checkbox[value='" + vector_manual[i - 1] + "']"
					).attr('checked', true);
				}
			}
			var vector_plano = unserialize(respuesta.plano);
			if (vector_plano != null && vector_plano != 'N;') {
				for (var i = 1; i <= vector_plano.length; i++) {
					$(
						"#modal_copy input:checkbox[value='" + vector_plano[i - 1] + "']"
					).attr('checked', true);
				}
			}
			$('#modal_copy #observacion_temporal').html(nl2br(respuesta.observacion));
			$('#modal_copy #observacion').val('');
			if (
				respuesta.file_registro_sanitario != null &&
				respuesta.file_registro_sanitario != ''
			) {
				var anclor_file_registro_sanitario = '';
				anclor_file_registro_sanitario +=
					"<a title='" +
					respuesta.registro_sanitario +
					"' class='glyphicon glyphicon-file' href='" +
					base_url +
					'assets/upload_registros_sanitarios/' +
					respuesta.file_registro_sanitario +
					"' target='__blank'></a>";
				$('#modal_copy .file_registro_sanitario').html(
					anclor_file_registro_sanitario
				);
			} else {
				$('#modal_copy .file_registro_sanitario').html('');
			}

			if (respuesta.guia_id !== 0) {
				$('#modal_copy .guia_id').val(respuesta.guia_id);
				$('#modal_copy .contenedor_name_guia').html(respuesta.name_guia);
				if (
					respuesta.file_guia !== null &&
					respuesta.file_guia !== undefined &&
					respuesta.file_guia !== ''
				) {
					var archivo =
						`
                <a target="__blank" href="` +
						base_url +
						`assets/upload_guias/` +
						respuesta.file_guia +
						`"><span class="fa fa-paperclip"></span></a>
                `;
					$('.contenedor_archivo_guia').html(archivo);
				}
			}

			$('#modal_copy .manual_id').val(respuesta.manual_id);
			var url_manual = '';
			url_manual =
				`
              <a target="__blank" href="` +
				respuesta.manual_url +
				`" class="fa fa-external-link-square btn btn-link"></a>
            `;
			$('#modal_copy .contenedor_url_manual').html('');
			$('#modal_copy .contenedor_url_manual').html(url_manual);
			$('#modal_copy .contenedor_descripcion_manual').html('');
			$('#modal_copy .contenedor_descripcion_manual').html(
				respuesta.manual_descripcion
			);
			if (respuesta.tadquisicion_id === 2) {
				var html_orden_compra = '';
				html_orden_compra += "<div class='reset_contenedor_orden_compra'>";
				html_orden_compra += '<h3>Tipo de adquisicion&nbsp; ';
				if (insertar_soporte_compra === 1) {
					html_orden_compra +=
						"<a data-toggle='modal' data-target='#modal_add_orden_compra' title='agregar nueva orden de compra a la base de datos' href='' class='glyphpicon glyphicon-plus' style='font-size:15px;font-weight:1000;color:black'></a>";
				}
				html_orden_compra += ' </h3> <ul>';
				html_orden_compra +=
					"<li><a onClick='show_consulta_orden_compra(event,1)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar ordenes de compra'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Ordenes de compra</a></li>";
				html_orden_compra +=
					"<li><a onClick='show_consulta_orden_compra(event,2)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar contratos'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Contratos-licitaciones</a></li>";
				html_orden_compra +=
					"<li><a onClick='show_consulta_orden_compra(event,3)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar cruces de cuenta'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Cruces de cuentas</a></li>";
				html_orden_compra +=
					"<li><a onClick='show_consulta_orden_compra(event,4)' data-toggle='modal' data-target='#modal_consulta_orden_compra' title='Consultar comodatos'  href='' target='__blank' class='btn glyphicon glyphicon-search'>Comodatos</a></li>";
				html_orden_compra +=
					"</ul><input type='hidden' id='orden_compra_id' name='orden_compra_id' value='" +
					respuesta.orden_compra_id +
					"'></input>";
				if (
					respuesta.orden_compra_id !== 0 &&
					respuesta.orden_compra_id !== null
				) {
					html_orden_compra +=
						"<span style='font-weight:800;' class='orden_compra_orden'>" +
						respuesta.orden_compra +
						'</span>';
					html_orden_compra +=
						"<span class='file_orden_compra'><a title='" +
						respuesta.file_orden_compra +
						"' class='glyphicon glyphicon-file' href='" +
						base_url +
						'assets/upload_ordenes_compra/' +
						respuesta.file_orden_compra +
						"' target='__blank'></a></span><br>";
				} else {
					html_orden_compra +=
						"<span style='font-weight:800;' class='orden_compra_orden'></span>";
					html_orden_compra += "<span class='file_orden_compra'></span><br>";
				}
				html_orden_compra +=
					"<span style='font-size:10px;' onClick='cancelar_seleccion_orden_compra()' class='btn btn-danger glyphicon glyphicon-remove'></span>";
				html_orden_compra += '</div>';
				$('#modal_copy .contenedor_orden_compra').html(html_orden_compra);
			}
		});
	}
	$('#modal_copy #form_equipo_copy').submit(function (e) {
		// Agregar un nuevo equipo
		e.preventDefault();
		var formulario = new FormData(this);
		$('#btn_copy_equipo').attr('disabled', 'disabled');
		$('.mensaje').addClass(
			'glyphicon glyphicon-refresh glyphicon-refresh-animate'
		);
		$('.mensaje').html('Procesando..........');
		$('#modal_copy .close').click();
		$.blockUI({
			message:
				'<h1><div class="glyphicon glyphicon-refresh"></dv>Procesando</h1><br><h2>Por favor espere</h2>',
			css: {
				width: '275px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
			},
		});
		$.ajax({
			url: base_url + 'equipo/Cequipos/copy',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			if (data == 1) {
				datatable_destroy();

				list_data_table_server_side_filtros();
				$.unblockUI();
				notify('add');
				if (!$('#check').is(':checked'))
					document.getElementById('form_equipo_copy').reset();
			} else {
				var respuesta = JSON.parse(data);
				contenido =
					'<div class=""><div class="panel panel-danger"><div class="panel-heading">Error</div><div class="panel-body">' +
					respuesta +
					'</div></div></div>';
				$.unblockUI(); // Del mensaje de procesando
				$.blockUI({ message: contenido }); // Muestro un mensaje con los errores
				setTimeout(function () {
					desbloquear_copy_equipo();
				}, 4000);
			}
			$('#btn_copy_equipo').removeAttr('disabled', 'disabled');
			$('.mensaje').html('');
			$('.mensaje').removeClass(
				'glyphicon glyphicon-refresh glyphicon-refresh-animate'
			);
		});
	});

	function borrar_filtro_servicio_area_especial(e) {
		$('#modal_filter_equipo form').trigger('reset');
		$('.consulta_id').val('');
		$('.estado_id').val('');
		$('.estado_id_cg').val('');
		e.preventDefault();
		$('.servicio_id_auxiliar').val(0);
		$('.area_id_auxiliar').val(0);
		list_data_table_server_side_filtros();
	}
	// function ObtenerListadoNombreEquipos() {
	// 	let result = ``;
	// 	var tmp = ``;
	// 	try {
	// 		result = $.ajax({
	// 			url: `${base_url}equipo/Cequipos/ObtenerListadoNombreEquipos`,
	// 			type: 'post',
	// 			data: {},
	// 		});
	// 		respuesta = JSON.parse(result);
	// 		$.each(respuesta, function (i, item) {
	// 			tmp +=
	// 				`
	//               <option value="` +
	// 				item.name +
	// 				`">` +
	// 				item.name +
	// 				`</option>
	//               `;
	// 			$('.datalistNombreEquipos').html('');
	// 			$('.datalistNombreEquipos').html(tmp);
	// 		});
	// 	} catch (error) {
	// 		console.log(error);
	// 	}
	// }
	// function ObtenerListadoModeloEquipos() {
	// 	let result = ``;
	// 	var tmp = ``;
	// 	var respuesta = ``;
	// 	try {
	// 		result = $.ajax({
	// 			url: base_url + 'equipo/Cequipos/ObtenerListadoModeloEquipos',
	// 			type: 'post',
	// 			data: {},
	// 		});
	// 		respuesta = JSON.parse(result);
	// 		$.each(respuesta, function (i, item) {
	// 			tmp +=
	// 				`
	//               <option value="` +
	// 				item.modelo +
	// 				`">` +
	// 				item.modelo +
	// 				`</option>
	//               `;
	// 		});
	// 		$('.datalistModeloEquipos').html('');
	// 		$('.datalistModeloEquipos').html(tmp);
	// 	} catch (error) {
	// 		console.log(error);
	// 	}
	// }
	function ObtenerListadoMarcaEquipos() {
		var tmp = ``;
		var respuesta = ``;
		let result = ``;
		try {
			result = $.ajax({
				url: base_url + 'equipo/Cequipos/ObtenerListadoMarcaEquipos',
				type: 'post',
				data: {},
			});
			respuesta = JSON.parse(result);
			tmp = '';
			$.each(respuesta, function (i, item) {
				tmp +=
					`
              <option value="` +
					item.marca +
					`">` +
					item.marca +
					`</option>
              `;
			});
			$('.datalistMarcaEquipos').html('');
			$('.datalistMarcaEquipos').html(tmp);
		} catch (error) {
			console.log(error);
		}
	}
	function mostrar_adquisicion_equipos(e, tipo) {
		e.preventDefault();
		var rango_fechas = $('.rango-fechas').val();
		$('.auxiliar_adquisicion').click();
		$.ajax({
			url: base_url + 'equipo/Cequipos/getByAdquisicion',
			type: 'post',
			data: { tipo, rango_fechas },
		}).done(function (data) {
			$('#modal_show_adquisicion .modal-body').html(data);
			$('.nav-tabs a').click(function () {
				$(this).tab('show');
			});
			$('.tblAdquisicion').dataTable({
				aaSorting: [[6, 'desc']],
				dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
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
				lengthMenu: [
					[2, 5, 10, 20],
					[2, 5, 10, 20],
				],
			});
		});
	}
	function mostrar_instalacion_equipos(e, tipo) {
		e.preventDefault();
		var rango_fechas = $('.rango-fechas').val();
		$('.auxiliar_instalacion').click();
		$.ajax({
			url: base_url + 'equipo/Cequipos/getByInstalacion',
			type: 'post',
			data: { rango_fechas, tipo },
		}).done(function (data) {
			$('#modal_show_instalacion .modal-body').html(data);
			$('.nav-tabs a').click(function () {
				$(this).tab('show');
			});
			$('.tblInstalacion').dataTable({
				aaSorting: [[6, 'desc']],
				dom: '<"top"iflp<"clear">>rt<"bottom"ilp<"clear">>',
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
				lengthMenu: [
					[2, 5, 10, 20],
					[2, 5, 10, 20],
				],
			});
		});
	}
	$(
		'.contenedor_estados_from_equipos .estado_id,.contenedor_estados_from_equipos .estado_id_cg'
	).on('change', function () {
		list_data_table_server_side_filtros();
	});
	list_cierres_from_correctivos_generales();
	function list_cierres_from_correctivos_generales() {
		$.ajax({
			url: base_url + 'correctivo_general/Ccierres/getUsed',
			type: 'post',
			data: {},
		}).done(function (data) {
			var cierres = JSON.parse(data);
			var tmp = "<option value=''>--------</option>";
			$.each(cierres, function (i, item) {
				tmp +=
					`
              <option value="` +
					item.id +
					`">` +
					item.name +
					`</option>
              `;
			});
			$('.contenedor_estados_from_equipos .estado_id_cg').html(tmp);
		});
	}
	function consultarExistenciaId() {
		var id = $('.consulta_id').val();
		if (id != '') {
			$.ajax({
				url: base_url + 'equipo/Cequipos/consultarId',
				type: 'post',
				data: {
					id: $('.consulta_id').val(),
				},
			}).done(function (data) {
				var respuesta = JSON.parse(data);
				if (respuesta == null) {
					$('.mensaje-consulta-id')
						.html('No hay registros que coincidan')
						.fadeIn()
						.delay(3000)
						.fadeOut('slow');
				} else {
					list_data_table_server_side_filtros();
				}
			});
		} else {
			$('.mensaje-consulta-id')
				.html('Favor ingresar valor')
				.fadeIn()
				.delay(3000)
				.fadeOut('slow');
		}
	}
	$('#form_equipo_especificacion #especificacion_id').on('change', function () {
		if (this.value === 12) {
			$('#modal_add_equipo_especificacion .contenedor_archivo').show();
			$(
				'#modal_add_equipo_especificacion .contenedor_archivo #file'
			).removeAttr('disabled', 'disabled');

			$('#modal_add_equipo_especificacion .contenedor_valor').hide();
			$('#modal_add_equipo_especificacion .contenedor_valor #valor').attr(
				'disabled',
				'disabled'
			);
		} else {
			$('#modal_add_equipo_especificacion .contenedor_archivo').hide();
			$('#modal_add_equipo_especificacion .contenedor_archivo #file').attr(
				'disabled',
				'disabled'
			);

			$('#modal_add_equipo_especificacion .contenedor_valor').show();
			$('#modal_add_equipo_especificacion .contenedor_valor #valor').removeAttr(
				'disabled',
				'disabled'
			);
		}
	});
	$(document).on('hidden.bs.modal', '.modal', function () {
		$('.modal:visible').length && $(document.body).addClass('modal-open');
	});
	function detail_depurar_nombres() {
		$.ajax({
			url: base_url + 'equipo/Cequipos/get_listado_nombres_equipos',
			type: 'post',
			data: {},
		}).done(function (data) {
			$('#modal_depurar_nombres .contenido-modal').html(data);
			$(
				'#modal_depurar_nombres .contenido-modal .tbl-depurar-nombres'
			).DataTable({
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
				dom: '<"top"ifl<"clear">>rt<"bottom"ilp<"clear">>',
				lengthMenu: [
					[5, 10, 20],
					[5, 10, 20],
				],
			});
			$('.nav-tabs a').click(() => $(this).tab('show'));
		});
	}
	$('#modal_depurar_nombres .form-depuracion-nombres-equipos').submit(function (
		e
	) {
		e.preventDefault();
		var formulario = new FormData(this);
		$.ajax({
			url: base_url + 'equipo/Cequipos/update_name_from_depuracion',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			if (data == 1) {
				alert('Se ha ejecutado la modificacion correspondiente');
				$('#modal_depurar_nombres .form-depuracion-nombres-equipos').trigger(
					'reset'
				); // reseteo formulario
				detail_depurar_nombres();
			} else {
				alert('no se seleccionaron nombres a modificar');
			}
		});
	});
	function relaiconar_nombre_destino(name) {
		$(
			'#modal_depurar_nombres .form-depuracion-nombres-equipos .nombre_equipo_destino'
		).val(name);
	}
	$('#form_equipo_archivo #archivo_id').on('change', function () {
		var equipo_id = $('#form_equipo_archivo #archivo_id').val();
		var archivo_id = this.value;
		var input = `
            <div class="row">
              <div class="col-sm-3">
                <input required="" min="2015-01-01" type="date" name="fecha_capacitacion" id="fecha_capacitacion" value=""  class="form-control">
              </div>
              <div class="col-sm-2">
                <input type="time" name="hora_capacitacion" id="hora_capacitacion" class="hora_capacitacion form-control">
              </div>
            </div>
          `;
		var input_otro = `
            <div class="row">
              <div class="col-sm-5">
                <input type="text" name="otro" id="otro" class="otro form-control" placeholder="Indique tipo de documento">
              </div>
            </div><br>
          `;
		if (archivo_id == 9) {
			$('#form_equipo_archivo .contenedor_fecha_capacitacion').html(input); // Si se selecciona capacitación
		} else if (archivo_id == 19) {
			$('#form_equipo_archivo .contenedor_fecha_capacitacion').html(input_otro); // Si se selecciona otros documentos de ingreso
		} else {
			$('#form_equipo_archivo .contenedor_fecha_capacitacion').html('');
		}
	});
}
function show_equipo(id, v1 = '', v2 = '', v3 = '') {
	$('.esconder').show();
	$.ajax({
		url: base_url + 'equipo/Cequipos/show',
		type: 'POST',
		data: {
			id,
			tipo_id: $('.tipo_id').val(),
		},
	}).done(function (data) {
		list_preventivos(id); //Llama la tabla de preventivos
		list_preventivos2(id); //Llama la tabla de preventivos
		list_correctivos(id); //Llama la tabla de preventivos
		list_correctivos_generales(id); //Llama la tabla de correctivos
		list_observaciones(id); //Llama la tabla de observaciones
		list_observaciones2(id); //Llama la tabla de observaciones
		list_calibraciones(id); //Llama la tabla de calibraciones
		list_calibraciones2(id); //Llama la tabla de calibraciones
		list_equipo_repuestos(id); //Llama la tabla de repuestos
		list_equipo_repuestos2(id); //Llama la tabla de repuestos
		list_equipo_especificaciones(id); //Llama la tabla de equipo_especificaciones
		list_equipo_especificaciones2(id); //Llama la tabla de equipo_especificaciones
		list_equipo_contactos(id);
		list_equipo_contactos2(id);
		list_contactos();
		list_contingencias(id);
		$('#form_preventivo #equipo_id').val(id);
		$('#form_preventivo .mostrar-primer-fecha').html('');
		$('#form_preventivo .mostrar-segunda-fecha').html('');
		$('#form_preventivo .mostrar-tercer-fecha').html('');
		$('#form_preventivo .mostrar-primer-fecha').html(v1);
		$('#form_preventivo .mostrar-segunda-fecha').html(v2);
		$('#form_preventivo .mostrar-tercer-fecha').html(v3);
		$('#form_calibracion #equipo_id').val(id);
		$('#form_repuesto #equipo_id').val(id);
		$('#form_equipo_especificacion #equipo_id').val(id);
		$('#form_equipo_contacto #equipo_id').val(id);
		$('#modal_show_equipo .modal-body').html(data);
	});
}
function list_correctivos(id) {
	var correctivos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getCorrectivos',
		type: 'POST',
		data: { equipo_id: id },
	}).done(function (data) {
		correctivos = JSON.parse(data);
		$.each(correctivos, function (i, item) {
			tmp +=
				'<tr height="27" style="mso-height-source:userset;height:20.25pt" >'; //
			tmp +=
				`<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">` +
				item.id +
				`
            <a href="" class="glyphicon glyphicon-calendar" data-toggle="modal" data-target="#modal_timeline_orden" onclick="getTimeline(` +
				item.id +
				`)"></a>`;
			if (item.repuesto_pendiente_condicion == 'si')
				tmp +=
					`<div style='color: red;' title="` +
					item.repuesto_pendiente +
					`" class="glyphicon glyphicon-wrench">RP</div>`;
			tmp += `</td>`;
			tmp +=
				"<td colspan='18' class='xl20126419' width='259' style='border-right:.5pt solid black;width:200pt'>Reporte:&nbsp;(" +
				item.fecha_inicio +
				')<br>' +
				item.descripcion +
				'<br>';
			if (item.diagnostico != null && item.diagnostico != '')
				tmp +=
					'Diagnostico:&nbsp;(' +
					item.fecha_diagnostico +
					')<br>' +
					item.diagnostico +
					'<br>';
			if (item.reparacion != null && item.reparacion != '') {
				if (item.fecha_fin != null)
					tmp +=
						'Reparacion:&nbsp;(' +
						item.fecha_fin +
						')<br>' +
						item.reparacion +
						'<br>';
				else
					tmp +=
						'Reparacion:&nbsp;(' +
						item.fecha_asignacion_cierre +
						')<br>' +
						item.reparacion +
						'<br>';
			}
			tmp += '</td>';
			tmp +=
				'<td colspan="13" class="xl18526419" width="63" style="width:48pt">' +
				item.estado +
				'</td>';
			tmp +=
				"<td colspan='10' class='xl20126419' width='348' style='border-right:.5pt solid black;width:263pt'>";
			if (item.image != null && item.image != '')
				tmp +=
					"<a class='esconder' href='" +
					base_url +
					'assets/upload_correctivos_generales/' +
					item.image +
					"' target='_blank'><label class='badge'>Reporte</label><br>";
			if (item.file_diagnostico != null && item.file_diagnostico != '')
				tmp +=
					"<a class='esconder' href='" +
					base_url +
					'assets/upload_correctivos_generales/' +
					item.file_diagnostico +
					"' target='_blank'><label class='badge'>Diagnostico</label><br>";
			if (item.file_cierre != null && item.file_cierre != '')
				tmp +=
					"<a class='esconder' href='" +
					base_url +
					'assets/upload_correctivos_generales/' +
					item.file_cierre +
					"' target='_blank'><label class='badge'>Cierre</label>";
			tmp += '</td></tr>';
		});
		$('#contenedor_detalle_equipo .apendice_tickets').append(tmp);
	});
}
function list_observaciones(id) {
	var observaciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getObservaciones',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		observaciones = JSON.parse(data);
		$.each(observaciones, function (i, item) {
			tmp += "<tr class=xl1526419 height=21 style='height:15.75pt'>";
			tmp +=
				"<td colspan=5 height=21 class=xl20526419 width=161 style='border-right:.5pt solid black;height:15.75pt;width:120pt'>" +
				item.id +
				'</td>';
			tmp +=
				"<td colspan=34 class=xl20426419 width=203 style='border-right:.5pt solid black;border-left:none;width:158pt'>" +
				item.description +
				'</td>';
			tmp +=
				"<td colspan=14 class=xl20826419 width=192 style='width:146pt'>" +
				item.created_at +
				'</td>';
			if (item.file != null) {
				tmp +=
					"<td colspan=10 class=xl20426419 width=196 style='width:209pt'><a  target='_blank' href='" +
					base_url +
					'assets/upload_observaciones/' +
					item.file +
					"' class='btn bnt-info esconder'><span class='glyphicon glyphicon-file'></span></a></td>";
			} else {
				tmp +=
					"<td colspan=10 class=xl20426419 width=196 style='width:209pt'></td>";
			}
			tmp += '</tr>';
		});
		$('#contenedor_detalle_equipo .tblObservaciones tbody').html(tmp);
	});
}
function list_observaciones2(id) {
	var observaciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getObservaciones',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		observaciones = JSON.parse(data);
		$.each(observaciones, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.description + '</td>';
			tmp += '<td>' + item.created_at + '</td>';
			if (item.file != null) {
				tmp +=
					"<td class='esconder'><a  target='_blank' href='" +
					base_url +
					'assets/upload_observaciones/' +
					item.file +
					"' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></a></td>";
			} else {
				tmp += "<td class='esconder'></td>";
			}
			tmp += "<td class='esconder'>";
			if (editar_observacion == 1) {
				if (item.repuesto_pendiente == 'si') {
					tmp +=
						"<span style='color: red;' class='glyphicon glyphicon-wrench'>RP</span><a data-toggle='modal' data-target='#modal_update_observacion' onClick='recover_modal_edit_observacion(" +
						item.id +
						")' class='btn btn-danger glyphicon glyphicon-pencil' style='padding:5px;'></a>";
				} else {
					tmp +=
						"<a data-toggle='modal' data-target='#modal_update_observacion' onClick='recover_modal_edit_observacion(" +
						item.id +
						")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>";
				}
			}
			tmp += '</td>';
			tmp += "<td class='esconder'>";
			if (eliminar_observacion == 1) {
				tmp +=
					"<a onClick='delete_observacion(" +
					item.id +
					',' +
					item.equipo_id +
					",event)' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>";
			}
			tmp += '</td>';

			tmp += '</tr>';
		});
		$('#form_update_equipo .tblObservaciones tbody').html(tmp);
	});
}
function list_equipo_repuestos(id) {
	var equipo_repuestos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEquipoRepuestos',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		equipo_repuestos = JSON.parse(data);
		$.each(equipo_repuestos, function (i, item) {
			tmp +=
				'<tr height="27" style="mso-height-source:userset;height:20.25pt" >';
			tmp +=
				'<td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;width:61pt">' +
				item.cantidad_entregada +
				'(' +
				item.observacion +
				')</td>';
			tmp +=
				'<td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;width:200pt">' +
				item.fecha +
				'</td>';
			tmp +=
				`<td colspan="13" class="xl18526419" width="63" style="width:48pt">` +
				item.repuesto +
				` <strong>			
              (` +
				item.codigo_repuesto +
				`)</strong>
              <br />
              (<strong>Usuario</strong>: <div><span class="glyphicon glyphicon-user"></span>` +
				item.usuario +
				`</div>)
              </td>`;
			if (item.file != null && item.file != '') {
				tmp +=
					"<td colspan='10' class='xl20126419' width='348' style='border-right:.5pt solid black;width:263pt'><div class='esconder'><a  target='_blank' href='" +
					base_url +
					'assets/upload_equipo_repuestos/' +
					item.file +
					"' class='btn bnt-info'><span class='glyphicon glyphicon-file esconder'></span></div></a></td><td class='xl1526419'></td>";
			} else {
				tmp +=
					'<td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;width:263pt"></td><td class="xl1526419"></td>';
			}
			tmp += '</tr>';
		});
		$('#contenedor_detalle_equipo .apendice_equipo_repuesto').append(tmp);
	});
}
function list_equipo_repuestos2(id) {
	var equipo_repuestos = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEquipoRepuestos',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		equipo_repuestos = JSON.parse(data);
		$.each(equipo_repuestos, function (i, item) {
			tmp += '<tr>';
			tmp +=
				`
              <td>` +
				item.repuesto +
				` 
              <strong>(` +
				item.codigo_repuesto +
				`)</strong>
              <br />
              (<strong>Usuario</strong>: <div><span class="glyphicon glyphicon-user"></span>` +
				item.usuario +
				`</div>)
              </td>`;
			tmp += '<td>' + item.observacion + '</td>';
			tmp += '<td>' + item.fecha + '</td>';
			tmp += '<td>' + item.cantidad_entregada + '</td>';
			if (item.file != null) {
				tmp +=
					"<td class='esconder'><a  target='_blank' href='" +
					base_url +
					'assets/upload_equipo_repuestos/' +
					item.file +
					"' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></a></td>";
			} else {
				tmp += "<td class='esconder'></td>";
			}
			tmp +=
				"<td class='esconder'>" +
				"<a data-toggle='modal' data-target='#modal_update_equipo_repuesto' onClick='recover_modal_edit_equipo_repuesto(" +
				item.id +
				")' class='btn btn-success glyphicon glyphicon-pencil' style='padding:5px;'></a>" +
				'</td>';
			tmp +=
				"<td class='esconder'>" +
				"<a onClick='delete_equipo_repuesto(" +
				item.id +
				',' +
				item.equipo_id +
				",event)' class='btn btn-warning glyphicon glyphicon-minus' style='padding:5px;'></a>" +
				'</td>';
			tmp += '</tr>';
		});
		$('#form_update_equipo .tblEquipoRepuestos tbody').html(tmp);
	});
}
function list_equipo_contactos(id) {
	var equipo_contacto = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEquipoContactos',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		equipo_contacto = JSON.parse(data);
		$.each(equipo_contacto, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.contacto + '</td>';
			tmp += '<td>' + item.email + '</td>';
			tmp += '<td>' + item.telefono + '</td>';
			tmp += '<td>' + item.tcontacto + '</td>';
			tmp += '</tr>';
		});
		$('#contenedor_detalle_equipo .tblEquipo_contactos tbody').html(tmp);
	});
}
function list_equipo_contactos2(id) {
	var equipo_contacto = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getEquipoContactos',
		type: 'post',
		data: { equipo_id: id },
	}).done(function (data) {
		equipo_contacto = JSON.parse(data);
		$.each(equipo_contacto, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.contacto + '</td>';
			tmp += '<td>' + item.email + '</td>';
			tmp += '<td>' + item.telefono + '</td>';
			tmp += '<td>' + item.tcontacto + '</td>';
			tmp +=
				"<td style='width: 10%;' class='esconder'>" +
				"<a onClick='delete_equipo_contacto(" +
				item.id +
				',' +
				item.equipo_id +
				")' class='btn btn-danger glyphicon glyphicon-minus' style='padding:5px;'></a>" +
				'</td>';
			tmp += '</tr>';
		});
		$('#form_update_equipo .tblEquipo_contactos tbody').html(tmp);
	});
}
list_estados();
function list_estados() {
	$.ajax({
		url: base_url + 'orden/Cestados/getUsed',
		type: 'post',
		data: {},
	}).done(function (data) {
		var estados = JSON.parse(data);
		var tmp = "<option value=''>--------</option>";
		$.each(estados, function (i, item) {
			tmp +=
				`
              <option value="` +
				item.id +
				`">` +
				item.descripcion +
				`</option>
              `;
		});
		$('.contenedor_estados_from_equipos .estado_id').html(tmp);
		$('.orden_activa .estado_id').html(tmp);
	});
}
function list_ordenes_activas(equipo_id) {
	$.ajax({
		url: base_url + 'orden/Cordenes/getByDevice',
		type: 'post',
		data: {
			equipo_id: equipo_id,
		},
	}).done(function (data) {
		var tmp = '';
		var respuesta = JSON.parse(data);
		$.each(respuesta, function (i, item) {
			tmp +=
				`
              <tr>
              <td>` +
				item.id +
				`</td>
              <td>` +
				item.fecha_inicio +
				`</td>
              <td>` +
				item.descripcion +
				`</td>
              <td>` +
				item.estado +
				`</td>
              <td><a href="" class="glyphicon glyphicon-calendar" data-toggle="modal" data-target="#modal_timeline_orden" onclick="getTimeline(` +
				item.id +
				`)"></a>`;
			if (item.repuesto_pendiente_condicion == 'si') {
				tmp +=
					`<div style='color: red;' title="` +
					item.repuesto_pendiente +
					`" class="glyphicon glyphicon-wrench">RP</div>`;
			}
			tmp += `</td></tr>`;
		});
		$('.tblCorrectivos tbody').html(tmp);
	});
}
