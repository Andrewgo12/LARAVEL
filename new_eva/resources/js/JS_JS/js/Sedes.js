if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
	$('.sede_id_auxiliar').on('change', function () {
		try {
			var sede_id = this.value;
			if (sede_id == '') {
				sede_id = 3;
			}
			select_servicios_from_sede(sede_id);
			$('.servicio_id_auxiliar').val(0);
			$('.area_id_auxiliar').val(0);
		} catch (error) {
			console.log(error);
		}
	});
	$('.sede').on('change', function () {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getFromSede',
			type: 'post',
			data: { sede_id: this.value },
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = "<option value=''>---------</option>";
			$.each(respuesta, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$(
				'#modal_update_equipo #form_update_equipo #servicio_id, #modal_copy #form_equipo_copy #servicio_id, #modal_add_equipo #form_equipo #servicio_id'
			).html(tmp);
		});
	});
	$('.control_sede').on('change', function () {
		cambiar_sesion_sede(this.value);
		list_data_table_server_side_filtros();
	});
	function cambiar_sesion_sede(sede_id) {
		$.ajax({
			url: base_url + 'ubicacion/Csedes/cambiar_sesion_sede',
			type: 'post',
			data: { sede_seleccionada: sede_id },
		}).done(function (data) {});
	}
} else {
	//select_sedes_busqueda_equipos();
	function select_sedes_busqueda_equipos() {
		$.ajax({
			url: base_url + 'ubicacion/Csedes/getAll',
			type: 'POST',
			data: {},
		}).done(function (data) {
			var sedes = '';
			var tmp = '';
			sedes = JSON.parse(data);
			tmp += "<option value=''>-----------</option>";
			$.each(sedes, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$('.sede_id_auxliar').html(tmp);
		});
	}
	$('table .sede_id_auxiliar').on('change', function () {
		var sede_id = this.value;
		if (sede_id == '') {
			sede_id = 3;
		}
		//cambiar_sesion_sede(sede_id);
		select_servicios_from_sede(sede_id);
		$('table .servicio_id_auxiliar').val(0);
		$('table .area_id_auxiliar').val(0);
	});
	$('.panel-ubicacion .sede_id_auxiliar').on('change', function () {
		var sede_id = this.value;
		if (sede_id == '') {
			sede_id = 3;
		}
		//cambiar_sesion_sede(sede_id);
		select_servicios_from_sede(sede_id);
		$('.panel-ubicacion .servicio_id_auxiliar').val(0);
		$('.panel-ubicacion .area_id_auxiliar').val(0);
	});
	$('.sede').on('change', function () {
		$.ajax({
			url: base_url + 'ubicacion/Cservicios/getFromSede',
			type: 'post',
			data: { sede_id: this.value },
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			var tmp = "<option value=''>---------</option>";
			$.each(respuesta, function (i, item) {
				tmp += '<option value=' + item.id + '>' + item.name + '</option>';
			});
			$(
				'#modal_update_equipo #form_update_equipo #servicio_id, #modal_copy #form_equipo_copy #servicio_id, #modal_add_equipo #form_equipo #servicio_id'
			).html(tmp);
		});
	});
	$('.contenedor-orden .sede_id').on('change', function () {
		var sede_id = this.value;
		select_servicios_from_sede(sede_id);
		$('.contenedor-orden .servicio_id_auxiliar').val(0);
		$('.contenedor-orden .area_id_auxiliar').val(0);
	});
	function funcion_seleccion_servicio_auxiliar(value) {
		$('table .servicio_id_auxiliar').val(0);
		var sede_id = value;
		select_servicios_from_sede(sede_id);
		list_data_table_server_side_general(value);
	}
	function funcion_seleccion_servicio_auxiliar_from_add_orden(value) {
		$('table .servicio_id_auxiliar').val(0);
		var sede_id = value;
		select_servicios_from_sede_from_add_orden(sede_id);
		list_data_table_server_side_general(value);
	}
}
//select_sedes();
function select_sedes() {
	$.ajax({
		url: base_url + 'ubicacion/Csedes/getAll',
		type: 'POST',
		data: {},
	}).done(function (data) {
		var sedes = '';
		var tmp = '';
		sedes = JSON.parse(data);
		tmp += "<option value=''>-----------</option>";
		$.each(sedes, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.name + '</option>';
		});
		$('#form_servicio #sede_id').html(tmp);
		$('.sede').html(tmp);
		$('.sede_id').html(tmp);
		$('.sede_id_auxliar').html(tmp);
	});
}
