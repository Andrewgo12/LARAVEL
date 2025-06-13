function editar_permiso(id, accion) {
	$.ajax({
		url: base_url + 'administrador/Cacciones/edit',
		type: 'post',
		data: {
			id: id,
			accion: accion,
		},
	}).done(function (data) {
		acciones = JSON.parse(data);
		var tmp = '';
		$.each(acciones, function (i, item) {
			tmp += '<tr>';
			tmp += '<td>' + item.modulo + '&nbsp;</td>';
			if (item.leer == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",1)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",1)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			if (item.insertar == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",2)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",2)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			if (item.editar == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",3)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",3)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			if (item.eliminar == 1) {
				tmp +=
					"<td><span style='font-size:13px;color:green'>Habilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",4)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			} else {
				tmp +=
					"<td><span style='font-size:13px;color:red'>Inhabilitado</span>&nbsp;<span onClick='editar_permiso(" +
					item.id +
					",4)' class='glyphicon glyphicon-retweet' style='font-size:12px;'></span></td>";
			}
			tmp += '</tr>';
		});
		$('#modal_update_usuario .tbl_acciones tbody').html(tmp);
	});
}
