$(document).ready(function () {
	// $('#tadquisicion_id option').prop('selected', true);
	// $('.select2').select2();
	select_tipos_adquisicion();
	select_estados_actuales();
	select_responsables_mantenimiento();
	$('.nav-tabs a').click(function () {
		$(this).tab('show');
	});
	$('.nav-tabs a').on('shown.bs.tab', function (event) {
		var x = $(event.target).text(); // active tab
		var y = $(event.relatedTarget).text(); // previous tab

		if (x == 'Preventivos') {
			sessionStorage.seleccion_actual = 'Preventivos';
			pg2_grafica_1_1();
			pg2_grafica_2_1();
			pg2_grafica_3_1();
		}
		if (x == 'Correctivos') {
			sessionStorage.seleccion_actual = 'Correctivos';
			pg1_grafica_1_1();
			pg1_grafica_1_2();
			pg1_grafica_1_3();
			pg1_grafica_2_1();
			pg1_grafica_2_2();
			pg1_grafica_2_3();
			pg1_grafica_3_1();
			pg1_grafica_3_2();
		}
		if (x == 'Equipos') {
			sessionStorage.seleccion_actual = 'Equipos';
			pg3_grafica_1_1();
			pg3_grafica_1_2();
			pg3_grafica_1_3();
			pg3_grafica_2_1();
			pg3_grafica_3_1();
			pg3_grafica_4_1();
		}
		// console.log(x);
		// console.log(y);
		$('.act span').text(x);
		$('.prev span').text(y);
	});
});

function select_tipos_adquisicion() {
	var tadquisiciones = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'equipo/Cequipos/getTadquisiciones',
		type: 'post',
		data: {},
	}).done(function (data) {
		tadquisiciones = JSON.parse(data);
		// tmp="<option value=''>--SELECCIONE--</option>";
		tmp = "<option value=''>-------</option>";
		$.each(tadquisiciones, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.name + '</option>';
		});
		$('.tadquisicion_id').html(tmp);
	});
}
function select_estados_actuales() {
	var estados_actuales = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'ubicacion/Cestadoequipos/get_usados',
		type: 'post',
		data: {},
	}).done(function (data) {
		estados_actuales = JSON.parse(data);
		// tmp="<option value=''>--SELECCIONE--</option>";
		tmp = '';
		$.each(estados_actuales, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.name + '</option>';
		});
		$('.estadoequipo_id').html(tmp);
	});
}
function select_responsables_mantenimiento() {
	var responsables = '';
	var tmp = '';
	$.ajax({
		url: base_url + 'contacto/Ccontactos/getProveedoresMantenimiento',
		type: 'post',
		data: {},
	}).done(function (data) {
		responsables = JSON.parse(data);
		// tmp="<option value=''>--SELECCIONE--</option>";
		tmp = "<option value=''>-----</option>";
		$.each(responsables, function (i, item) {
			tmp += '<option>' + item.responsable + '</option>';
		});
		$('.responsable_mantenimiento').html(tmp);
	});
}

$('.seleccion_subproceso').on('change', function () {
	if (sessionStorage.seleccion_actual == 'Correctivos') {
		pg1_grafica_1_1();
		pg1_grafica_1_2();
		pg1_grafica_1_3();
		pg1_grafica_2_1();
		pg1_grafica_2_2();
		pg1_grafica_2_3();
		pg1_grafica_3_1();
		pg1_grafica_3_2();
	}

	if (sessionStorage.seleccion_actual == 'Preventivos') {
		pg2_grafica_1_1();
		pg2_grafica_2_1();
		pg2_grafica_3_1();
	}
	if (sessionStorage.seleccion_actual == 'Equipos') {
		pg3_grafica_1_1();
		pg3_grafica_1_2();
		pg3_grafica_1_3();
		pg3_grafica_2_1();
		pg3_grafica_3_1();
		pg3_grafica_4_1();
	}
});

$('.tadquisicion_id').on('change', function () {
	if (sessionStorage.seleccion_actual == 'Correctivos') {
		pg1_grafica_1_1();
		pg1_grafica_1_2();
		pg1_grafica_1_3();
		pg1_grafica_2_1();
		pg1_grafica_2_2();
		pg1_grafica_2_3();
		pg1_grafica_3_1();
		pg1_grafica_3_2();
	}

	if (sessionStorage.seleccion_actual == 'Preventivos') {
		pg2_grafica_1_1();
		pg2_grafica_2_1();
		pg2_grafica_3_1();
	}
	if (sessionStorage.seleccion_actual == 'Equipos') {
		pg3_grafica_1_1();
		pg3_grafica_1_2();
		pg3_grafica_1_3();
		pg3_grafica_2_1();
		pg3_grafica_3_1();
		pg3_grafica_4_1();
	}
});

$('.sede_id').on('change', function () {
	if (sessionStorage.seleccion_actual == 'Correctivos') {
		pg1_grafica_1_1();
		pg1_grafica_1_2();
		pg1_grafica_1_3();
		pg1_grafica_2_1();
		pg1_grafica_2_2();
		pg1_grafica_2_3();
		pg1_grafica_3_1();
		pg1_grafica_3_2();
	}

	if (sessionStorage.seleccion_actual == 'Preventivos') {
		pg2_grafica_1_1();
		pg2_grafica_2_1();
		pg2_grafica_3_1();
	}
	if (sessionStorage.seleccion_actual == 'Equipos') {
		pg3_grafica_1_1();
		pg3_grafica_1_2();
		pg3_grafica_1_3();
		pg3_grafica_2_1();
		pg3_grafica_3_1();
		pg3_grafica_4_1();
	}
});
$('.estadoequipo_id').on('change', function () {
	if (sessionStorage.seleccion_actual == 'Correctivos') {
		pg1_grafica_1_1();
		pg1_grafica_1_2();
		pg1_grafica_1_3();
		pg1_grafica_2_1();
		pg1_grafica_2_2();
		pg1_grafica_2_3();
		pg1_grafica_3_1();
		pg1_grafica_3_2();
	}

	if (sessionStorage.seleccion_actual == 'Preventivos') {
		pg2_grafica_1_1();
		pg2_grafica_2_1();
		pg2_grafica_3_1();
	}
	if (sessionStorage.seleccion_actual == 'Equipos') {
		pg3_grafica_1_1();
		pg3_grafica_1_2();
		pg3_grafica_2_1();
		pg3_grafica_3_1();
		pg3_grafica_4_1();
	}
});

$('.responsable_mantenimiento').on('change', function () {
	pg2_grafica_1_1();
	pg2_grafica_2_1();
	pg2_grafica_3_1();
});

function pg1_grafica_1_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getGeneratedByDate',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad Total');
							datos.addColumn('number', 'Cantidad Electrico');
							datos.addColumn('number', 'Cantidad Mecanico');
							datos.addColumn('number', 'Cantidad Locativo');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([
									[
										registro.mes,
										parseInt(registro.cantidad),
										parseInt(registro.cantidad_electrico),
										parseInt(registro.cantidad_mecanico),
										parseInt(registro.cantidad_locativo),
									],
								]);
							});
							var options = {
								title: 'Tickets generados  vs Tiempo',
								subtitle: 'Tickets',
								width: 500,
								height: 300,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: maximo / 2,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Tickets',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + 1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.LineChart(
								document.getElementById('creados')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_1_2() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getClosedByDate',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							datos.addColumn('number', 'Cantidad Electrico');
							datos.addColumn('number', 'Cantidad Mecanico');
							datos.addColumn('number', 'Cantidad Locativo');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([
									[
										registro.mes,
										parseInt(registro.cantidad),
										parseInt(registro.cantidad_electrico),
										parseInt(registro.cantidad_mecanico),
										parseInt(registro.cantidad_locativo),
									],
								]);
							});
							var options = {
								title: 'Tickets cerrados vs tiempo',
								subtitle: 'Tickets',
								width: 500,
								height: 300,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: maximo / 2,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Tickets',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + 1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.LineChart(
								document.getElementById('cerrados')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_1_3() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getByStatus',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Estado');
							datos.addColumn('number', 'Cantidad');
							$.each(respuesta, function (i, registro) {
								datos.addRows([[registro.estado, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Estado actual de las ordenes',
								is3D: true,
								width: 500,
								height: 300,
							};
							var chart = new google.visualization.PieChart(
								document.getElementById('estados')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_2_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getCorrectivosGeneralesGeneratedByDate',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([[registro.mes, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Correctivos generales Solicitados vs Tiempo',
								subtitle: 'Correctivos generales',
								width: 500,
								height: 300,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: maximo / 2,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Correctivos generales',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + maximo * 0.1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.LineChart(
								document.getElementById('correctivos_generales_creados')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_2_2() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getCorrectivosGeneralesClosedByDate',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([[registro.mes, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Correctivos generales cerrados  vs Tiempo',
								subtitle: 'Correctivos generales',
								width: 500,
								height: 300,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: maximo / 2,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Correctivos generales',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + maximo * 0.1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.LineChart(
								document.getElementById('correctivos_generales_cerrados')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_2_3() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getCorrectivosGeneralesByStatus',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Estado');
							datos.addColumn('number', 'Cantidad');
							$.each(respuesta, function (i, registro) {
								datos.addRows([[registro.estado, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Estado actual de los correctivos generales',
								is3D: true,
								width: 500,
								height: 300,
							};
							var chart = new google.visualization.PieChart(
								document.getElementById('correctivos_generales_estados')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_3_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getTicketsIndicador',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Porcentaje');
							datos.addColumn('number', 'Porcentaje Electricos');
							datos.addColumn('number', 'Porcentaje Mecanicos');
							datos.addColumn('number', 'Porcentaje Locativos');
							var maximo = 100;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.porcentaje_cerrados) > maximo) {
									maximo = parseInt(registro.porcentaje_cerrados);
								}
								datos.addRows([
									[
										registro.mes,
										parseInt(registro.porcentaje_cerrados),
										parseInt(registro.porcentaje_electricos),
										parseInt(registro.porcentaje_mecanicos),
										parseInt(registro.porcentaje_locativos),
									],
								]);
							});
							var options = {
								title: '% de cierre Tickets',

								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: maximo / 10,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Tickets',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + maximo * 0.1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.ColumnChart(
								document.getElementById('tickets_indicador')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg1_grafica_3_2() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getCorrectivosGeneralesIndicador',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Porcentaje');
							var maximo = 100;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.porcentaje_cerrados) > maximo) {
									maximo = parseInt(registro.porcentaje_cerrados);
								}
								datos.addRows([
									[registro.mes, parseInt(registro.porcentaje_cerrados)],
								]);
							});
							var options = {
								title: '% de cierre Correctivos generales',
								subtitle: 'Correctivos generales',
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: maximo / 10,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Correctivos generales',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + maximo * 0.1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.ColumnChart(
								document.getElementById('correctivos_generales_indicador')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg2_grafica_1_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getPreventivosProgramados',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
								responsable_mantenimiento: $(
									'.responsable_mantenimiento'
								).val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([[registro.mes, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Preventivos programados  vs Tiempo',
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},

								// width: '100%',
								// height: 400,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: 5,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Mantenimientos preventivos programados',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + 1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.ColumnChart(
								document.getElementById('preventivos_programados_indicador')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg2_grafica_2_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getPreventivosEjecutados',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
								responsable_mantenimiento: $(
									'.responsable_mantenimiento'
								).val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([[registro.mes, parseInt(registro.cantidad)]]);
							});

							var options = {
								title: 'Preventivos ejecutados  vs Tiempo',
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},

								// width: '100%',
								// height: 400,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: 5,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Mantenimientos preventivos ejecutados',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + 1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.ColumnChart(
								document.getElementById('preventivos_ejecutados_indicador')
							);
							chart.draw(datos, options);

							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg2_grafica_3_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getPreventivosIndicador',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
								responsable_mantenimiento: $(
									'.responsable_mantenimiento'
								).val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Porcentaje');
							datos.addColumn('number', 'Limite');
							var maximo = 100;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.porcentaje) > maximo) {
									maximo = parseInt(registro.porcentaje);
								}
								datos.addRows([
									[registro.mes, parseInt(registro.porcentaje), 100],
								]);
							});

							var options = {
								title: '% de ejecución Mantenimientos preventivos',

								seriesType: 'bars',
								series: { 1: { type: 'line' } },
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},

								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: 10,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Preventivos',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + maximo * 0.1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'right' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.ComboChart(
								document.getElementById('preventivos_indicador_ejecucion')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg3_grafica_1_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getDistributionCbiomedicaOnDevices',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Clasificacion biomedica');
							datos.addColumn('number', 'Cantidad');
							$.each(respuesta, function (i, registro) {
								datos.addRows([
									[registro.cbiomedica, parseInt(registro.cantidad)],
								]);
							});

							var options = {
								title: 'Distribucion por clasificacion biomedica',
								is3D: true,
								width: 500,
								height: 300,
							};
							var chart = new google.visualization.PieChart(
								document.getElementById('DistributionCbiomedica')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg3_grafica_1_2() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getDistributionCriesgoOnDevices',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Clasificacion de riesgo');
							datos.addColumn('number', 'Cantidad');
							$.each(respuesta, function (i, registro) {
								datos.addRows([
									[registro.criesgo, parseInt(registro.cantidad)],
								]);
							});

							var options = {
								title: 'Distribucion por riesgo',
								is3D: true,
								width: 500,
								height: 300,
							};
							var chart = new google.visualization.PieChart(
								document.getElementById('DistributionRiesgo')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}
function pg3_grafica_1_3() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getDistributionEstadosByDevice',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Estado actual');
							datos.addColumn('number', 'Cantidad');
							$.each(respuesta, function (i, registro) {
								datos.addRows([
									[registro.estadoequipo, parseInt(registro.cantidad)],
								]);
							});

							var options = {
								title: 'Distribucion por Estado actual',
								is3D: true,
								width: 500,
								height: 300,
							};
							var chart = new google.visualization.PieChart(
								document.getElementById('DistributionEstado')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg3_grafica_2_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getEquiposAdquisiciones',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([[registro.mes, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Adquisicion equipos  vs Tiempo',
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},

								// width: '100%',
								// height: 400,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: 5,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Adquisicion',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + 1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.AreaChart(
								document.getElementById('DistribucionAdquisicion')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg3_grafica_3_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url: base_url + 'Ccharts/getEquiposInstalaciones',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Cantidad');
							var maximo = 0;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.cantidad) > maximo) {
									maximo = parseInt(registro.cantidad);
								}
								datos.addRows([[registro.mes, parseInt(registro.cantidad)]]);
							});
							var options = {
								title: 'Instalacion equipos  vs Tiempo',
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},

								// width: '100%',
								// height: 400,
								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: 5,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Instalacion',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + 1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'bottom' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.AreaChart(
								document.getElementById('DistribucionInstalacion')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(pg1_graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}

function pg3_grafica_4_1() {
	$.ajax({
		// url: 'https://www.google.com/jsapi?callback',
		url: base_url + 'js/loader.js',
		cache: true,
		dataType: 'script',
		success: function () {
			google.load(
				'visualization',
				'1',
				{
					packages: ['corechart'],
					callback: function () {
						$.ajax({
							url:
								base_url + 'Ccharts/getEquipoInstalacionAdquisicionIndicador',
							type: 'post',
							data: {
								subproceso_id: $('.seleccion_subproceso').val(),
								sede_id: $('.sede_id').val(),
								tadquisicion_id: $('.tadquisicion_id').val(),
								estadoequipo_id: $('.estadoequipo_id').val(),
							},
						}).done(function (data) {
							var respuesta = JSON.parse(data);
							var datos = new google.visualization.DataTable();
							datos.addColumn('string', 'Mes');
							datos.addColumn('number', 'Porcentaje');
							datos.addColumn('number', 'Limite');
							var maximo = 100;
							$.each(respuesta, function (i, registro) {
								if (parseInt(registro.porcentaje) > maximo) {
									maximo = parseInt(registro.porcentaje);
								}
								datos.addRows([
									[registro.mes, parseInt(registro.porcentaje), 100],
								]);
							});

							var options = {
								title: '% de instalacion respecto a la adquisicion',

								seriesType: 'bars',
								series: { 1: { type: 'line' } },
								left: 0,
								width: '100%',
								height: 400,
								chartArea: {
									left: '10%',
									width: '100%',
								},

								vAxis: {
									minorGridlines: {
										count: 19,
									},
									gridlines: {
										count: 10,
									},
									textStyle: {
										fontSize: 10,
									},
									title: 'Porcentaje',
									titleTextStyle: {
										fontName: 'Oswald',
										italic: false,
										color: '#990000',
									},
									viewWindow: {
										min: 0,
										max: maximo + maximo * 0.1,
									},
								},
								hAxis: {
									textPosition: 'out',
									// direction : -1,
									showEveryText: 7,
									viewWindow: {
										min: 0,
									},
									slantedText: true,
								},
								legend: { position: 'right' },
								// legend: { position: "none" },
								curveType: 'function',
							};
							var chart = new google.visualization.ComboChart(
								document.getElementById('InstalacionAdquisicionIndicador')
							);
							chart.draw(datos, options);
							//google.charts.setOnLoadCallback(drawChart(graficar));
						});
					},
				} //Fin de packages
			); //Fin de google.load

			return true;
		},
	});
}
