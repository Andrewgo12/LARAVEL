function funcion_modal_correctivos_generales_abiertos(e) {
	e.preventDefault();
	$.ajax({
		url:
			base_url +
			'correctivo_general/Ccorrectivos_generales/show_correctivos_generales_abiertos',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_correctivos .modal-body').html(data);
		list_datatable_server_side_correctivos_abiertos();
	});
}
let counter = 0;
let wrapper = $('.containerrep');
$('.add_new_rep').on('click', function (e) {
	e.preventDefault();
	let max_fields = 10;
	if (counter < max_fields) {
		counter++;
		$(wrapper).append(`
		<div class = "row">
			<div class = "col col-sm-10">
				<input placeholder="Repuesto Nro. [${counter}]" class="form-control" type="text" name="lista_repuestos_pendientes[]"/>
			</div>	
			<div class = "col col-sm-2">
				<a href="#" class="delete fa fa-minus btn btn-danger btn-xs"></a>
			</div>	
		</div>`);
	} else {
		alert('Too many inputs');
	}
});
$(wrapper).on('click', '.delete', function (e) {
	e.preventDefault();
	$(this).parents('div').eq(1).remove();
	counter--;
});
/** Setting RP */
set_repuestos_pendientes();
function set_repuestos_pendientes(correctivo_general_id = 0) {
	clear_repuestos_pendientes();

	if (correctivo_general_id != 0) {
		$.ajax({
			url:
				base_url +
				'correctivo_general/Ccorrectivos_generales/get_repuestos_pendientes',
			type: 'post',
			data: { correctivo_general_id: correctivo_general_id },
		}).done(function (data) {
			data2 = JSON.parse(data);
			if (data2.length != 0) {
				console.log(data2);
				let returned = '';
				returned += `
			<table class = "table table-bordered">
				<tr> 
					<th> Respuesto pendiente </th>
					<th> Fecha de asociación </th>
					<th> Status </th>
				</tr>
				`;
				$.each(data2, function (i, row) {
					returned += `<tr>`;
					returned += `<td>${row.name} </td>`;
					returned += `<td>${row.created_at} </td>`;
					returned += `<td style ="cursor: pointer"> <div style="${
						row.status == 0 ? 'color : green' : 'color : red'
					}" id='repuesto_pendiente_${row.id}'  class='repuesto_pendiente_${
						row.id
					}' onClick="change_status_repuestos_pendientes(${row.id},${
						row.status
					}, this)"> ${row.status == 0 ? 'Inactivo' : 'Activo'}</div> </td>`;
					returned += `</tr>`;
				});
				returned += `
			</table>
			`;
				$('.containerrep_table').html('');
				$('.containerrep_table').html(returned);
			}
		});
	} else {
		$('.containerrep_table').html('');
	}
}
function clear_repuestos_pendientes() {
	$('.containerrep_table').html('');
	$('.containerrep').html('');
}
function change_status_repuestos_pendientes(
	repuesto_pendiente_id = 0,
	status = 0,
	el
) {
	$.ajax({
		url:
			base_url +
			'correctivo_general/Ccorrectivos_generales/toggle_state_repuesto_pendiente',
		type: 'post',
		data: { repuesto_pendiente_id: repuesto_pendiente_id },
	}).done(function (data) {
		let answer = JSON.parse(data);
		if (answer.status == 1) {
			$('.' + el.id + '').html(`<div style = "color: red">Activo</div>`);
		} else {
			$('.' + el.id + '').html(`<div style = "color: green">Inactivo</div>`);
		}
	});
}
