function list_proveedores_mantenimiento() {
	var tmp = "<option value=''>----Seleccione-----</option>";
	$.ajax({
		url: base_url + 'mantenimiento/Cproveedores_mantenimiento/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var proveedores_mantenimiento = JSON.parse(data);
		$.each(proveedores_mantenimiento, function (i, item) {
			tmp +=
				`
			<option value=` +
				item.id +
				`>
				` +
				item.name +
				`
			</option>`;
		});
		$('.proveedor_mantenimiento_id').html(tmp);
	});
}
list_proveedores_mantenimiento();
