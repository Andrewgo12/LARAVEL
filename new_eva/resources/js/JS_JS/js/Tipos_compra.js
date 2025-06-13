if (controlador == 'Cordenes_compra') {
	select_tipos_compra();
}
function select_tipos_compra() {
	$.ajax({
		url: base_url + 'tipos_compra/Ctipos_compra/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		tmp = "<option value=''>-----</option>";
		$.each(respuesta, function (i, item) {
			tmp += '<option value=' + item.id + '>' + item.tipo_compra + '</option>';
		});
		$('#modal_add_orden_compra .select_tipos_compra').html(tmp);
		$('#modal_update_orden_compra .select_tipos_compra').html(tmp);
	});
}
