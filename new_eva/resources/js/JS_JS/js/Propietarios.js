if (controlador == 'Cpropietarios') {
	list_propietarios();
	function list_propietarios() {
		$.ajax({
			url: base_url + 'propietario/Cpropietarios/getAll',
			type: 'post',
			data: {},
		}).done(function (data) {
			var propietarios = JSON.parse(data);
			var tmp = '';
			$.each(propietarios, function (i, propietario) {
				tmp +=
					`
						<tr>
						  <td>` +
					propietario.nombre +
					`</td>
						  <td><img  class="img-responsive" src="` +
					base_url +
					`assets/upload_imagenes/` +
					propietario.logo +
					`" /></td>
						  <td>`;
				tmp +=
					'<a data-toggle="modal" data-target="#modal_update_propietario"  class="glyphicon glyphicon-pencil item-edicion " onclick="recover_modal_edit_propietario(' +
					propietario.id +
					')"></a>';
				tmp += `</td>	
						</tr>
					`;
			});
			$('.tabla-propietarios').dataTable().fnClearTable();
			$('.tabla-propietarios').dataTable().fnDestroy();
			$('.tabla-propietarios tbody').html(tmp);
			$('.tabla-propietarios').dataTable({
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
	$('#modal_add_propietario .form_add_propietario').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$.ajax({
			url: base_url + 'propietario/Cpropietarios/add',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.caso == 1) {
				alert('Propietario agregado exitosamente');
				$('#modal_add_propietario .close').click();
				$('#modal_add_propietario .form_add_propietario').trigger('reset');
				list_propietarios();
			} else {
				alert(respuesta.informacion_error);
			}
		});
	});
	function recover_modal_edit_propietario(id) {
		$.ajax({
			url: base_url + 'propietario/Cpropietarios/getOne',
			type: 'post',
			data: { id: id },
		}).done(function (data) {
			var propietario = JSON.parse(data);
			$('#modal_update_propietario #id').val(propietario.id);
			$('#modal_update_propietario #nombre').val(propietario.nombre);
		});
	}
	$('#modal_update_propietario .form_update_propietario').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);

		$.ajax({
			url: base_url + 'propietario/Cpropietarios/update',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.caso == 1) {
				alert('Informacion actualizada exitosamente');
				$('#modal_update_propietario .close').click();
				list_propietarios();
			} else {
				alert(respuesta.informacion_error);
			}
		});
	});
}
if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
	select_propietarios();
	function select_propietarios() {
		$.ajax({
			url: base_url + 'propietario/Cpropietarios/getAll',
			type: 'post',
			data: {},
		}).done(function (data) {
			var propietarios = JSON.parse(data);
			tmp = `<option value="">Seleccione un elemento de la lista</option>`;
			$.each(propietarios, function (i, propietario) {
				tmp +=
					`
					<option value=` +
					propietario.id +
					`>` +
					propietario.nombre +
					`</option>
				`;
			});

			$('.propietario_id').html('');
			$('.propietario_id').html(tmp);
		});
	}
	$('#modal_add_propietario .form_add_propietario').submit(function (e) {
		e.preventDefault();
		var formulario = new FormData(this);
		$.ajax({
			url: base_url + 'propietario/Cpropietarios/add',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.caso == 1) {
				alert('Propietario agregado exitosamente');
				$('#modal_add_propietario .close').click();
				select_propietarios();
			} else {
				alert(respuesta.informacion_error);
			}
		});
	});
}
