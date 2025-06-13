nombre_equipos_server_side();
$('#aplicar_cierre').on('click', function (e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'reporte/Creportes/getByFechaCierre',
		type: 'post',
		data: {
			fecha_inicio: $('#fecha_cierre_inicio').val(),
			fecha_fin: $('#fecha_cierre_fin').val(),
		},
	}).done(function (data) {
		var resultado = JSON.parse(data);
		$('#tiempo_menor').html(resultado.menor);
		$('#tiempo_mayor').html(resultado.mayor);
		$('#tiempo_promedio').html(resultado.promedio);
	});
});
$('#aplicar_creacion').on('click', function (e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'reporte/Creportes/getByFechaCreacion',
		type: 'post',
		data: {
			fecha_inicio: $('#fecha_creacion_inicio').val(),
			fecha_fin: $('#fecha_creacion_fin').val(),
		},
	}).done(function (data) {
		var resultado = JSON.parse(data);
		$('#tiempo_menor').html(resultado.menor);
		$('#tiempo_mayor').html(resultado.mayor);
		$('#tiempo_promedio').html(resultado.promedio);
	});
});
function nombre_equipos_server_side() {
	// Funcion para solicitar se entreguen los registros por ajax
	$('.lista_nombres').dataTable({
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
			[5, 10, 20, 'todo'],
		],
		paging: true,
		filter: true,
		info: true,
		stateSave: true,
		bDestroy: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base_url + 'equipo/Cequipos/nombres_get_server_side',
			type: 'POST',
			// data:{Snombre:$("#Snombre").val()}
			data: {},
		},
		columns: [
			{ data: 'name' },
			{
				orderable: true,

				render: function (data, type, row) {
					var tmp = '';

					return row.total;
				},
			},
		],
	});
}

$('.seleccion_anio,.seleccion_sede').on('change', function () {
	$('.tbl-cantidad-anio-mes tbody').html('');
	var seleccionado = '';
	var resultado = '';
	var tmp = "<option value=''>---------</option>";
	var otro = '';
	var tmp2 = '';
	seleccionado = $('.seleccion_anio').val();
	sede_seleccionada = $('.seleccion_sede').val();

	$.ajax({
		url: base_url + 'reporte/Creportes/get_meses',
		type: 'post',
		data: {
			anio: seleccionado,
		},
	}).done(function (data) {
		resultado = JSON.parse(data);
		$.each(resultado, function (i, item) {
			switch (item.mes) {
				case '1':
					otro = 'ENERO';
					break;
				case '2':
					otro = 'FEBRERO';
					break;
				case '3':
					otro = 'MARZO';
					break;
				case '4':
					otro = 'ABRIL';
					break;
				case '5':
					otro = 'MAYO';
					break;
				case '6':
					otro = 'JUNIO';
					break;
				case '7':
					otro = 'JULIO';
					break;
				case '8':
					otro = 'AGOSTO';
					break;
				case '9':
					otro = 'SEPTIEMPRE';
					break;
				case '10':
					otro = 'OCTUBRE';
					break;
				case '11':
					otro = 'NOVIEMBRE';
					break;
				case '12':
					otro = 'DICIEMBRE';
					break;
			}
			tmp += "<option value='" + item.mes + "'>" + otro + '</option>';
		});
		$('.seleccion_mes').html(tmp);
	});

	var tmp3 = '';
	var resultado2 = '';
	$.ajax({
		url: base_url + 'reporte/Creportes/preventivos_por_anio',
		type: 'post',
		data: {
			anio: seleccionado,
			sede: sede_seleccionada,
		},
	}).done(function (data) {
		resultado2 = JSON.parse(data);
		$.each(resultado2, function (i, item2) {
			tmp3 += '<tr>';
			tmp3 += '<td>' + item2.anio + '</td>';
			tmp3 += '<td>' + item2.propiedad + '</td>';
			tmp3 += '<td>' + item2.cantidad_programados + '</td>';
			tmp3 += '<td>' + item2.cantidad + '</td>';
			tmp3 += '<td>' + item2.porcentaje + ' %</td>';
			tmp3 += '</tr>';
		});
		$('.tbl-cantidad-anio tbody').html(tmp3);
	});

	var tmp4 = '';
	var resultado3 = '';

	$.ajax({
		url: base_url + 'reporte/Creportes/preventivos_por_anio_general',
		type: 'post',
		data: {
			anio: seleccionado,
			sede: sede_seleccionada,
		},
	}).done(function (data2) {
		resultado3 = JSON.parse(data2);
		$.each(resultado3, function (i, item3) {
			tmp4 += '<tr>';
			tmp4 += '<td>' + item3.anio + '</td>';
			tmp4 += '<td>' + item3.cantidad_programados + '</td>';
			tmp4 += '<td>' + item3.cantidad + '</td>';
			tmp4 += '<td>' + item3.porcentaje + ' %</td>';
			tmp4 += '</tr>';
		});
		$('.tbl-cantidad-anio-general tbody').html(tmp4);
	});
});

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
$('.seleccion_mes,.seleccion_sede').on('change', function () {
	var mes_seleccionado = '';
	var anio_seleccionado = '';
	var tmp = '';
	var resultado = '';
	mes_seleccionado = $('.seleccion_mes').val();
	anio_seleccionado = $('.seleccion_anio').val();
	sede_seleccionada = $('.seleccion_sede').val();

	$.ajax({
		url: base_url + 'reporte/Creportes/preventivos_por_anio_mes',
		type: 'post',
		data: {
			anio: anio_seleccionado,
			mes: mes_seleccionado,
			sede: sede_seleccionada,
		},
	}).done(function (data) {
		resultado = JSON.parse(data);
		$.each(resultado, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.propiedad + '</td>';
			tmp += '<td>' + item.anio + '</td>';
			tmp += '<td>' + item.mes_string + '</td>';
			tmp += '<td>' + item.cantidad_programados + '</td>';
			tmp += '<td>' + item.cantidad + '</td>';
			tmp += '<td>' + item.porcentaje + ' %</td>';
			tmp += '</tr>';
		});
		$('.tbl-cantidad-anio-mes tbody').html(tmp);
	});
	var tmp2 = '';
	var resultado2 = '';
	$.ajax({
		url: base_url + 'reporte/Creportes/preventivos_por_anio_mes_general',
		type: 'post',
		data: {
			anio: anio_seleccionado,
			mes: mes_seleccionado,
			sede: sede_seleccionada,
		},
	}).done(function (data2) {
		resultado2 = JSON.parse(data2);
		$.each(resultado2, function (i, item2) {
			tmp2 += '<tr>';
			tmp2 += '<td>' + item2.anio + '</td>';
			tmp2 += '<td>' + item2.mes_string + '</td>';
			tmp2 += '<td>' + item2.cantidad_programados + '</td>';
			tmp2 += '<td>' + item2.cantidad + '</td>';
			tmp2 += '<td>' + item2.porcentaje + ' %</td>';
			tmp2 += '</tr>';
		});
		$('.tbl-cantidad-anio-mes-general tbody').html(tmp2);
	});
});
function list_anios() {
	var resultado = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'reporte/Creportes/get_anios',
		type: 'post',
		data: {},
	}).done(function (data) {
		resultado = JSON.parse(data);
		tmp += "<option value=''>-----</option>";
		$.each(resultado, function (i, item) {
			tmp += "<option value='" + item.anio + "'>" + item.anio + '</option>';
		});

		$('.seleccion_anio').html(tmp);
	});
}

list_anios();
