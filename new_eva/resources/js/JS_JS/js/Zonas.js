function select_zonas() {
	$.ajax({
		url: base_url + 'administrador/Czonas/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var zonas = JSON.parse(data);
		var tmp = "<option value=''>---seleccione-----</option>";
		$.each(zonas, function (i, item) {
			tmp +=
				`
			<option value="` +
				item.id +
				`">` +
				item.name +
				`</option>
		`;
		});
		$('.zona_id').html(tmp);
	});
}
