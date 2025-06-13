select_tipos_fallas();
function select_tipos_fallas() {
	$.ajax({
		url: base_url + 'correctivo_general/Ctipos_fallas/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		let respuesta = JSON.parse(data);
		tmp = `<option value=''>-----</option>`;
		$.each(respuesta, function (i, item) {
			tmp += `<option value="${item.id}">${item.name}</option>`;
		});
		$('#modal_update_correctivo_general .tipo_falla_id').html(tmp);
		$('#modal_add_correctivo_general .tipo_falla_id').html(tmp);
	});
}
