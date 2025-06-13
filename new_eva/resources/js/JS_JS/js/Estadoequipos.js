if (controlador == 'Cestadoequipos') {
	list_data_table();
	select_tipoestado();
	function select_tipoestado() {
		$.ajax({
			url: base_url + 'ubicacion/Cestadoequipos/getTipoEstado',
			type: 'post',
			data: {},
		}).done(function (data) {
			var tipos_estados = JSON.parse(data);
			var tmp = `<option value="">---------</option>`;
			$.each(tipos_estados, function (i, tipo_estado) {
				tmp +=
					`<option value=` +
					tipo_estado.id +
					`>` +
					tipo_estado.nombre +
					`</option>`;
			});
			$('.tipoestado_id').html(tmp);
		});
	}
	function list_data_table() {
		var tabla = '';

		tabla = $('#tblEstadoequipos').DataTable({
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
				url: base_url + 'ubicacion/Cestadoequipos/get_datatable',
				type: 'POST',
				dataSrc: '',
			},
			columns: [
				{ data: 'name' },
				{ data: 'status' },
				{ data: 'status' },
				{
					orderable: true,
					render: function (data, type, row) {
						var tmp = '';
						tmp +=
							'&nbsp;<a style="padding:5px" href="#" class=" btn btn-primary glyphicon glyphicon-pencil"  onClick="recover_modal_edit(' +
							row.id +
							',event)" ></a>';
						tmp +=
							'&nbsp;<a style="padding:5px" href="#" class=" btn btn-danger fa fa-minus-circle"  onClick="delete_estadoequipo(' +
							row.id +
							',event)" ></a>';
						tmp +=
							'&nbsp;<a style="padding:5px" href="#" class=" btn btn-success fa fa-check"  onClick="active_estadoequipo(' +
							row.id +
							',event)" ></a>';

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
						if (row.status == 1) {
							tmp +=
								`<span style="font-weight:800;color:` +
								row.color +
								`">Activo</span>`;
						} else {
							tmp +=
								`<span style="font-weight:800;color:` +
								row.color +
								`">Inactivo</span>`;
						}
						return tmp;
					},
				},

				{
					targets: [2],
					data: 'id',
					render: function (data, type, row) {
						var tmp = '';
						if (row.tipo != null) {
							tmp += `<span>` + row.tipo + `</span>`;
						}

						return tmp;
					},
				},
			],
		});
	}
	function datatable_destroy() {
		// destruir data table
		$('#tblEstadoequipos').dataTable().fnClearTable();
		$('#tblEstadoequipos').dataTable().fnDestroy();
	}
	function recover_modal_edit(id, e) {
		e.preventDefault();
		$.ajax({
			url: base_url + 'ubicacion/Cestadoequipos/getOne',
			type: 'POST',
			data: { id: id },
		}).done(function (data) {
			$('#btn_update_estado_equipo').removeAttr('disabled');
			var estadoequipo = '';
			estadoequipo = JSON.parse(data);
			$('#form_estadoequipo #id').val(estadoequipo.id);
			$('#form_estadoequipo #name').val(estadoequipo.name);
			$('#form_estadoequipo #tipoestado_id').val(estadoequipo.tipoestado_id);
			$('#form_estadoequipo #color').val(estadoequipo.color);
		});
	}
	$('#form_estadoequipo').submit(function (e) {
		e.preventDefault();
		var formulario = '';
		var respuesta = '';

		if ($('#condicion').val() == 1) {
			//Editar
			formulario = new FormData(this);

			$.ajax({
				url: base_url + 'ubicacion/Cestadoequipos/update',
				type: 'post',
				data: formulario,
				dataType: 'html',
				cache: false,
				contentType: false,
				processData: false,
			}).done(function (data) {
				respuesta = JSON.parse(data);
				if (respuesta.respuesta == 1) {
					notify('edit');
					datatable_destroy();
					list_data_table();
				} else if (respuesta.respuesta == 2) {
					notify(respuesta.informacion);
				}
			});
		} else {
			//Agregar
			formulario = new FormData(this);

			$.ajax({
				url: base_url + 'ubicacion/Cestadoequipos/add',
				type: 'post',
				data: formulario,
				dataType: 'html',
				cache: false,
				contentType: false,
				processData: false,
			}).done(function (data) {
				respuesta = JSON.parse(data);
				if (respuesta.respuesta == 1) {
					notify('add');
					datatable_destroy();
					list_data_table();
				} else if (respuesta.respuesta == 2) {
					notify(respuesta.informacion);
				}
			});
		}
	});
	function delete_estadoequipo(id, e) {
		e.preventDefault();
		var confirmacion = confirm('¿Estas seguro de Inactivar el registro?');
		if (confirmacion) {
			$.ajax({
				url: base_url + 'ubicacion/Cestadoequipos/delete',
				type: 'POST',
				data: {
					id: id,
				},
				success: function (data) {
					datatable_destroy();
					list_data_table();
					notify('del');
				},
			});
		} else {
			alert('Eliminación cancelada');
		}
	}
	function active_estadoequipo(id, e) {
		e.preventDefault();
		$.ajax({
			url: base_url + 'ubicacion/Cestadoequipos/active',
			type: 'POST',
			data: {
				id: id,
			},
			success: function (data) {
				datatable_destroy();
				list_data_table();
				notify('act');
			},
		});
	}
	function notify(action = '') {
		//mensajes de alerta
		var msj = '';
		var tipo = '';
		if (action == 'add') {
			msj = 'Estado Agregado exitosamente';
			tipo = 'success';
		} else if (action == 'edit') {
			msj = 'Estado Editado exitosamente';
			tipo = 'info';
		} else if (action == 'act') {
			msj = 'Estado Activado exitosamente';
			tipo = 'success';
		} else if (action == 'del') {
			msj = 'Estado Eliminado exitosamente';
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
if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
	select_disponibilidad();
	select_funcionalidad();
	function select_disponibilidad() {
		$.ajax({
			url: base_url + 'ubicacion/Cestadoequipos/getDisponibilidad',
			type: 'post',
			data: {},
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = `<option value='0'>---------</option>`;
			$.each(respuesta, function (i, item) {
				tmp += `<option value="` + item.id + `">` + item.name + `</option>`;
			});
			$('.disponibilidad_id').html(tmp);
		});
	}
	function select_funcionalidad() {
		$.ajax({
			url: base_url + 'ubicacion/Cestadoequipos/getFuncionalidad',
			type: 'post',
			data: {},
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = `<option value=''>---------</option>`;
			$.each(respuesta, function (i, item) {
				tmp += `<option value="` + item.id + `">` + item.name + `</option>`;
			});
			$('.estadoequipo_id').html(tmp);
		});
	}
	$('#modal_update_equipo #form_update_equipo .estadoequipo_id').on(
		'change',
		function () {
			var almacenado = $('.tmp_estado_equipo_id').val();
			var seleccionado = $(this).val();
			if (seleccionado != almacenado) {
				$('.localizacion_actual').removeAttr('disabled');
				$('.localizacion_actual').val('');
			} else {
				$('.localizacion_actual').attr('disabled', 'disabled');
				$('.localizacion_actual').val($('.tmp_localizacion_actual').val());
			}
		}
	);
}
