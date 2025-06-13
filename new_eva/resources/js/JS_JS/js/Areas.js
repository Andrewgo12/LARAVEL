const InstancedAreas = new areaObj().printDataTable();
var tableAreas;
InstancedAreas.then((table) => {
	tableAreas = table;
});

if (controlador != 'Careas') {
	function getAreaByservicio(servicio_id, area_id) {
		//Funcion especifica para setear area en la edicion del equipo
		$.ajax({
			url: base_url + 'ubicacion/Careas/getAreaByservicio',
			type: 'post',
			data: { servicio_id: servicio_id },
		}).done(function (data) {
			var areas = JSON.parse(data);
			var tmp = "<option value=''>---------</option>";
			$.each(areas, function (i, item) {
				tmp += "<option value='" + item.id + "'>" + item.name + '</option>';
			});
			$('#modal_update_equipo .area_id,#modal_copy .area_id').html(tmp);
			$('#modal_update_equipo .area_id,#modal_copy .area_id').val(area_id);
			// $("#modal_update_equipo .area_id,#modal_copy .area_id").select2({
			// 	placeholder: "" + areas.name + "",
			// });
		});
	}
	if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
		function select_areas_auxiliar(servicio_id) {
			//Funcion para retornar un select con todas las areas de un servicio
			$.ajax({
				url: base_url + 'ubicacion/Careas/getAreaByservicio',
				type: 'post',
				data: { servicio_id: servicio_id },
			}).done(function (data) {
				var areas = JSON.parse(data);
				var tmp = "<option value='' selected='selected'>---------</option>";
				$.each(areas, function (i, item) {
					tmp += "<option value='" + item.id + "'>" + item.name + '</option>';
				});
				$('.area_id_auxiliar').html(tmp);
				// $(".area_id_auxiliar").select2();
			});
		}
		$('.area_id_auxiliar').on('change', function () {
			list_data_table_server_side_filtros();
		});
		$(
			'#modal_update_equipo .servicio_id,#modal_add_equipo .servicio_id,#modal_copy .servicio_id'
		).on('change', function () {
			$.ajax({
				url: base_url + 'ubicacion/Careas/getAreaByservicio',
				type: 'post',
				data: { servicio_id: this.value },
			}).done(function (data) {
				var respuesta = JSON.parse(data);
				var tmp = "<option value=''>---------</option>";
				$.each(respuesta, function (i, item) {
					tmp += '<option value=' + item.id + '>' + item.name + '</option>';
				});
				$(
					'#modal_update_equipo #form_update_equipo .area_id,#modal_add_equipo .area_id,#modal_copy .area_id'
				).html('');
				$(
					'#modal_update_equipo #form_update_equipo .area_id,#modal_add_equipo .area_id,#modal_copy .area_id'
				).html(tmp);
				// $("#modal_update_equipo #form_update_equipo .area_id,#modal_add_equipo .area_id,#modal_copy .area_id").select2();
			});
		});
	} else {
		//list_areas();
		function list_areas() {
			$.ajax({
				url: base_url + 'ubicacion/Careas/getAll',
				type: 'post',
				data: {},
			}).done(function (data) {
				var areas = JSON.parse(data);
				var tmp = '';
				$.each(areas, function (i, item) {
					tmp += '<tr>';
					tmp += '<td>' + item.name + '</td>';
					tmp += '<td>' + item.servicio + '</td>';
					tmp += '<td>' + item.sede + '</td>';
					tmp += '<td>' + item.piso + '</td>';
					tmp += '<td>';
					if (editar_area == 1) {
						tmp +=
							"<a data-toggle='modal' data-target='#modal_update_area' href='' class='btn btn-primary btn-xs  glyphicon glyphicon-pencil' onClick='recover_modal_edit_area(" +
							item.id +
							",event)'></a>";
					}
					if (eliminar_area == 1) {
						tmp +=
							"<a href='' class='btn btn-danger btn-xs glyphicon glyphicon-remove' onClick='delete_area(" +
							item.id +
							",event)'></a>";
					}
					tmp += '</td>';
					tmp += '</tr>';
				});

				$('.tblAreas').dataTable().fnClearTable();
				$('.tblAreas').dataTable().fnDestroy();
				$('.tblAreas tbody').html(tmp);
				$('.tblAreas').dataTable();
			});
		}
		function llamar_relaciones() {
			list_servicios();
		}
		$('#modal_add_area .form_add_area').submit(function (e) {
			e.preventDefault();
			$('#modal_add_area .form_add_area .btn_add_area').attr(
				'disabled',
				'disabled'
			);
			var formulario = new FormData(this);
			$.ajax({
				url: base_url + 'ubicacion/Careas/add',
				type: 'post',
				data: formulario,
				dataType: 'html',
				cache: false,
				contentType: false,
				processData: false,
			}).done(function (data) {
				respuesta = JSON.parse(data);
				if (respuesta.caso == 1) {
					alert('Area ingresada exitosamente');
					$('#modal_add_area .close').click();
					list_areas();
					select_areas($('#modal_update_equipo .servicio_id').val());
					$('#modal_add_area .form_add_area #name').val('');
					$('#modal_add_area .form_add_area .btn_add_area').removeAttr(
						'disabled',
						'disabled'
					);
					//$("#modal_add_area .form_add_area").trigger("reset");
				} else {
					alert(respuesta.informacion_error);
				}
			});
		});
		function delete_area(id, e) {
			e.preventDefault();
			$.ajax({
				url: base_url + 'ubicacion/Careas/delete',
				type: 'post',
				data: { id: id },
			}).done(function (data) {
				list_areas();
			});
		}
		function recover_modal_edit_area(id) {
			list_servicios_sin_select2();
			$.ajax({
				url: base_url + 'ubicacion/Careas/getOne',
				type: 'post',
				data: { id: id },
			}).done(function (data) {
				var area = JSON.parse(data);
				$('#modal_update_area #id').val(area.id);
				$('#modal_update_area #name').val(area.name);
				// $("#modal_update_area #servicio_id").select2({
				// 	placeholder: area.servicio,
				// });
				$('#modal_update_area #servicio_id').val(area.servicio_id);
			});
		}
		$('#modal_update_area .form_update_area').submit(function (e) {
			e.preventDefault();
			var formulario = new FormData(this);
			$('#modal_update_area .form_update_area .btn_update_area').attr(
				'disabled',
				'disabled'
			);
			$.ajax({
				url: base_url + 'ubicacion/Careas/update',
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
					$('#modal_update_area .close').click();

					$('#modal_update_area .form_update_area .btn_update_area').removeAttr(
						'disabled',
						'disabled'
					);
					list_areas();
				} else {
					alert(respuesta.informacion_error);
				}
			});
		});
		function select_areas_all(servicio_id) {
			//Funcion para retornar un select con todas las areas de un servicio, es creada para el select del multiple
			$.ajax({
				url: base_url + 'ubicacion/Careas/getAll',
				type: 'post',
				data: {},
			}).done(function (data) {
				var areas = JSON.parse(data);
				var tmp = "<option value=''>---------</option>";
				$.each(areas, function (i, item) {
					tmp +=
						"<option value='" +
						item.id +
						"'>" +
						item.sede +
						'|' +
						item.servicio +
						'|' +
						item.name +
						'</option>';
				});
				$('#modal_multiple .area_id').html(tmp);
				// $("#modal_multiple .area_id").select2();
			});
		}
		select_areas_all();
		function select_areas(servicio_id) {
			//Funcion para retornar un select con todas las areas de un servicio
			$.ajax({
				url: base_url + 'ubicacion/Careas/getAreaByservicio',
				type: 'post',
				data: { servicio_id: servicio_id },
			}).done(function (data) {
				var areas = JSON.parse(data);
				var tmp = "<option value=''>---------</option>";
				$.each(areas, function (i, item) {
					tmp += "<option value='" + item.id + "'>" + item.name + '</option>';
				});
				$('.area_id').html(tmp);
				// $(".area_id").select2();
			});
		}
		function select_areas_auxiliar(servicio_id) {
			//Funcion para retornar un select con todas las areas de un servicio
			$.ajax({
				url: base_url + 'ubicacion/Careas/getAreaByservicio',
				type: 'post',
				data: { servicio_id },
			}).done(function (data) {
				var areas = JSON.parse(data);
				var tmp = "<option value='' selected='selected'>---------</option>";
				$.each(areas, function (i, item) {
					tmp += "<option value='" + item.id + "'>" + item.name + '</option>';
				});
				$('.area_id_auxiliar').html(tmp);
				// $(".area_id_auxiliar").select2();
			});
		}

		function cambio_area_server_side() {
			//var area_id=$(".area_id_auxiliar").val();
			list_data_table_server_side_general();
		}
	}
}
