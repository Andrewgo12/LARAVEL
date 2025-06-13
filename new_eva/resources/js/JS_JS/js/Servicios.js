const InstancedServices = new serviceObj().printDataTable();
var tableServices;
InstancedServices.then((table) => {
	tableServices = table;
});
if (controlador === 'Cequipos' || controlador === 'Cequipos_ind') {
	$('#form_equipo #servicio_id').on('change', function () {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getUbicacion',
			type: 'post',
			data: { id: $(this).val() },
		}).done(function (data) {
			const response = JSON.parse(data);
			$('#form_equipo #piso').html(response.piso);
			$('#form_equipo #centro').html(response.centro);
			$('#form_equipo #codigo_centro').html(response.codigo_centro);
		});
	});
	$('#form_update_equipo #servicio_id').on('change', function () {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getUbicacion',
			type: 'post',
			data: { id: $(this).val() },
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			$('#form_update_equipo #piso').html(respuesta.piso);
			$('#form_update_equipo #centro').html(respuesta.centro);
			$('#form_update_equipo #codigo_centro').html(respuesta.codigo_centro);
		});
	});
	$('#form_equipo_copy #servicio_id').on('change', function () {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getUbicacion',
			type: 'post',
			data: { id: $(this).val() },
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			$('#form_equipo_copy #piso').html(respuesta.piso);
			$('#form_equipo_copy #centro').html(respuesta.centro);
			$('#form_equipo_copy #codigo_centro').html(respuesta.codigo_centro);
		});
	});
	select_servicios_from_sede();
	function select_servicios_from_sede(sede_id = '') {
		let resultData = ``;
		$.ajax({
			url: `${base_url}ubicacion/Cservicios/getFromSede`,
			type: 'post',
			data: { sede_id },
		}).done(function (result) {
			const services = JSON.parse(result);
			resultData = `<option value=''>---------</option>`;
			$.each(services, function (i, service) {
				resultData += `<option value='${service.id}'> ${service.name}</option>`;
			});
			$('.servicio_id_auxiliar').html('');
			$('.servicio_id_auxiliar').html(resultData);
			$('.servicio_id').html('');
			$('.servicio_id').html(resultData);
		});
	}

	function list_zonas() {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getZonas',
			type: 'POST',
			data: {},
		}).done(function (data) {
			var zonas = '';
			var tmp = '';
			zonas = JSON.parse(data);
			tmp += "<option value=''>-----------</option>";
			$.each(zonas, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('#form_servicio #zona_id').html(tmp);
		});
	}
	function list_centros() {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getCentros',
			type: 'POST',
			data: {},
		}).done(function (data) {
			var centros = '';
			var tmp = '';
			centros = JSON.parse(data);
			tmp += "<option value=''>-----------</option>";
			$.each(centros, function (i, item) {
				tmp +=
					'<option value=' +
					item.id +
					'>' +
					item.code +
					'-' +
					item.name +
					'</option>';
			});
			$('#form_servicio #centro_id,.centro').html('');
			$('#form_servicio #centro_id,.centro').html(tmp);
		});
	}
	function list_pisos() {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getPisos',
			type: 'POST',
			data: {},
		}).done(function (data) {
			var pisos = '';
			var tmp = '';
			pisos = JSON.parse(data);
			tmp += "<option value=''>-----------</option>";
			$.each(pisos, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('#form_servicio #piso_id,.piso,.piso_id').html(tmp);
		});
	}
	list_zonas();
	list_centros();
	list_pisos();
	$('#form_add_servicio').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/add',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			respuesta = JSON.parse(data);
			if (respuesta.respuesta == 1) {
				//notify_servicio("add");
				$('#modal_add_servicio .close').click();
				alert('Servicio agregado exitosamente');
				list_servicios();
			} else if (respuesta.respuesta == 2) {
				// notify_servicio(respuesta.informacion);
				alert(respuesta.informacion);
			}
		});
	});
} else {
	if (controlador != 'Cservicios') {
		list_data_table();
		list_pisos();
		list_zonas();
		list_centros();
		select_servicios_from_sede();
		function select_servicios_from_sede(sede_id = '') {
			result = $.ajax({
				url: base_url + 'ubicacion/Cservicios/getFromSede',
				type: 'post',
				data: { sede_id: sede_id },
			}).done(function (result) {
				areas = JSON.parse(result);
				tmp = "<option value=''>---------</option>";
				$.each(areas, function (i, area) {
					tmp += "<option value='" + area.id + "'>" + area.name + '</option>';
				});
				$('.servicio_id').html(tmp);
				$('.servicio_id_auxiliar').html(tmp);
			});
		}
		function select_servicios_from_sede_from_add_orden(sede_id = '') {
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/getFromSede',
				type: 'post',
				data: { sede_id: sede_id },
			}).done(function (data) {
				var areas = JSON.parse(data);
				var tmp = "<option value=''>---------</option>";
				$.each(areas, function (i, item) {
					tmp += "<option value='" + item.id + "'>" + item.name + '</option>';
				});
				$('table .servicio_id_auxiliar').html('');
				$('table .servicio_id_auxiliar').html(tmp);
			});
		}
		function list_servicios() {
			var servicios = '';
			var tmp = '';
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/get',
				type: 'post',
				data: {},
			}).done(function (data) {
				servicios = JSON.parse(data);

				tmp = "<option value=''>--SELECCIONE--</option>";
				$.each(servicios, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.name + '</option>';
				});
				$('.servicio_id').html('');
				$('.servicio_id').html(tmp);
			});
		}
		function list_servicios_sin_select2() {
			var servicios = '';
			var tmp = '';
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/get',
				type: 'post',
				data: {},
			}).done(function (data) {
				servicios = JSON.parse(data);

				tmp = "<option value=''>--SELECCIONE--</option>";
				$.each(servicios, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.name + '</option>';
				});
				$('.servicio_id').html(tmp);
			});
		}
		function list_servicios_auxiliar() {
			var servicios = '';
			var tmp = '';
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/get',
				type: 'post',
				data: {},
			}).done(function (data) {
				servicios = JSON.parse(data);

				tmp = "<option value=''>--SELECCIONE--</option>";
				$.each(servicios, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.name + '</option>';
				});
				$('.servicio_id_auxiliar').html('');
				$('.servicio_id_auxiliar').html(tmp);
			});
		}
		function list_data_table() {
			var tabla = '';

			tabla = $('#tblServicios').DataTable({
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
					url: base_url + 'ubicacion/Cservicios/get_datatable',
					type: 'POST',
					dataSrc: '',
				},
				columns: [
					{ data: 'name' },
					{ data: 'piso' },
					// {data:'centro'},
					{
						orderable: true,
						render: function (data, type, row) {
							var tmp = '';
							if (editar_servicio == 1) {
								tmp +=
									'&nbsp;<a style="padding:5px" href="#" class=" btn btn-primary glyphicon glyphicon-pencil"  onClick="recover_modal_edit_servicios(' +
									row.id +
									',event)" ></a>';
							}
							if (eliminar_servicio == 1) {
								tmp +=
									'&nbsp;<a style="padding:5px" href="#" class=" btn btn-danger fa fa-minus-circle"  onClick="delete_servicio(' +
									row.id +
									',event)" ></a>';
							}

							return tmp;
						},
					},
				],
				columnDefs: [
					{
						targets: [1],
						data: 'id',
						render: function (data, type, row) {
							var tmp = '';
							tmp += "<table class='table'>";
							tmp +=
								'<tr><td><strong>Piso: </strong></td><td>' +
								row.piso +
								'</td></tr>';
							tmp +=
								'<tr><td><strong>Zona: </strong></td><td>' +
								row.zona +
								'</td></tr>';
							tmp +=
								"<tr><td><strong>Cantidad de equipos biomedicos: </strong></td><td ><div style='font-size:30px;color:blue;'>" +
								row.cantidad_equipos +
								'</></td></tr>';
							if (row.centro != null) {
								tmp +=
									'<tr><td><strong>Centro costo: </strong></td><td>' +
									row.centro +
									'</td></tr>';
							}
							if (row.sede != null) {
								tmp +=
									"<tr><td><strong>Sede: </strong></td><td><span style='font-size:20px;color:green;font-weight:800;'>" +
									row.sede +
									'</span></td></tr>';
							}

							tmp += '</table>';

							return tmp;
						},
					},
				],
			});
		}
		function datatable_destroy() {
			// destruir data table

			$('#tblServicios').dataTable().fnClearTable();
			$('#tblServicios').dataTable().fnDestroy();
		}
		function list_pisos() {
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/getPisos',
				type: 'POST',
				data: {},
			}).done(function (data) {
				var pisos = '';
				var tmp = '';
				pisos = JSON.parse(data);
				tmp += "<option value=''>-----------</option>";
				$.each(pisos, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.name + '</option>';
				});
				$('#form_servicio #piso_id,.piso,.piso_id').html(tmp);
			});
		}
		function list_zonas() {
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/getZonas',
				type: 'POST',
				data: {},
			}).done(function (data) {
				var zonas = '';
				var tmp = '';
				zonas = JSON.parse(data);
				tmp += "<option value=''>-----------</option>";
				$.each(zonas, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.name + '</option>';
				});
				$('#form_servicio #zona_id').html(tmp);
			});
		}
		function list_centros() {
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/getCentros',
				type: 'POST',
				data: {},
			}).done(function (data) {
				var centros = '';
				var tmp = '';
				centros = JSON.parse(data);
				tmp += "<option value=''>-----------</option>";
				$.each(centros, function (i, item) {
					tmp +=
						'<option value=' +
						item.id +
						'>' +
						item.code +
						'-' +
						item.name +
						'</option>';
				});
				$('#form_servicio #centro_id,.centro').html('');
				$('#form_servicio #centro_id,.centro').html(tmp);
			});
		}
		function recover_modal_edit_servicios(id, e) {
			e.preventDefault();
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/getUbicacion',
				type: 'POST',
				data: { id: id },
			}).done(function (data) {
				$('#btn_update_equipo').removeAttr('disabled');
				var servicio = '';
				servicio = JSON.parse(data);
				$('#form_servicio #id').val(servicio.id);
				$('#form_servicio #name').val(servicio.name);
				$('#form_servicio #piso_id').val(servicio.piso_id);
				$('#form_servicio #zona_id').val(servicio.zona_id);
				$('#form_servicio #centro_id').val(servicio.centro_id);

				$('#form_servicio #sede_id').val(servicio.sede_id);
			});
		}
		$('#form_servicio').submit(function (e) {
			e.preventDefault();
			var formulario = '';
			var respuesta = '';

			if ($('#condicion').val() == 1) {
				//Editar
				formulario = new FormData(this);

				$.ajax({
					url: base_url + 'ubicacion/Cservicios/update',
					type: 'post',
					data: formulario,
					dataType: 'html',
					cache: false,
					contentType: false,
					processData: false,
				}).done(function (data) {
					respuesta = JSON.parse(data);
					if (respuesta.respuesta == 1) {
						notify_servicio('edit');
						datatable_destroy();
						list_data_table();
					} else if (respuesta.respuesta == 2) {
						notify_servicio(respuesta.informacion);
					}
				});
			} else {
				//Agregar
				formulario = new FormData(this);

				$.ajax({
					url: base_url + 'ubicacion/Cservicios/add',
					type: 'post',
					data: formulario,
					dataType: 'html',
					cache: false,
					contentType: false,
					processData: false,
				}).done(function (data) {
					respuesta = JSON.parse(data);
					if (respuesta.respuesta == 1) {
						notify_servicio('add');
						datatable_destroy();
						list_data_table();
					} else if (respuesta.respuesta == 2) {
						notify_servicio(respuesta.informacion);
					}
				});
			}
		});
		$('#form_add_servicio').submit(function (e) {
			e.preventDefault();
			var formulario = new FormData(this);
			$.ajax({
				url: base_url + 'ubicacion/Cservicios/add',
				type: 'post',
				data: formulario,
				dataType: 'html',
				cache: false,
				contentType: false,
				processData: false,
			}).done(function (data) {
				respuesta = JSON.parse(data);
				if (respuesta.respuesta == 1) {
					//notify_servicio("add");
					$('#modal_add_servicio .close').click();
					alert('Servicio agregado exitosamente');
					list_servicios();
				} else if (respuesta.respuesta == 2) {
					// notify_servicio(respuesta.informacion);
					alert(respuesta.informacion);
				}
			});
		});
		function delete_servicio(id, e) {
			e.preventDefault();
			var confirmacion = confirm('¿Estas seguro de Eliminar este registro?');
			if (confirmacion) {
				$.ajax({
					url: base_url + 'ubicacion/Cservicios/delete',
					type: 'POST',
					data: {
						id: id,
					},
					success: function (data) {
						datatable_destroy();
						list_data_table();
						notify_servicio('del');
					},
				});
			} else {
				alert('Eliminación cancelada');
			}
		}
		function notify_servicio(action = '') {
			//mensajes de alerta
			var msj = '';
			var tipo = '';
			if (action == 'add') {
				msj = 'Servicio Agregado exitosamente';
				tipo = 'success';
			} else if (action == 'edit') {
				msj = 'Servicio Editado exitosamente';
				tipo = 'info';
			} else if (action == 'del') {
				msj = 'Servicio Eliminado exitosamente';
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
		function aplicar_condicion(valor = '') {
			if (valor == 1) {
				$('#condicion').val('1'); // Editar
			} else {
				$('#condicion').val('2'); // Agrear
			}
		}
	}
}
