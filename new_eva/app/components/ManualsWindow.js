function show_consulta_manual() {
	$.ajax({
		url: base_url + 'manual/Cmanuales/show',
		type: 'post',
		data: {},
	}).done(function (data) {
		$('#modal_consulta_manual .modal-body').html(data);
		$('.datatable-manuales').dataTable({
			language: {
				lengthMenu: 'Mostrar _MENU_ registros por pagina',
				zeroRecords: 'No se encontraron resultados en su busqueda',
				searchPlaceholder: 'Buscar registros',
				info: 'Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros',
				infoEmpty: 'No existen registros',
				infoFiltered: '',
				search: 'Buscar:',
				paginate: {
					first: 'Primero',
					last: 'Último',
					next: 'Siguiente',
					previous: 'Anterior',
				},
			},
			paging: true,
			filter: true,
			info: true,
			stateSave: true,
			dom: '<"top"ifp<"clear">>rlt<"bottom"ilp<"clear">>',
		});
	});
}

function asociar_manual(id, e) {
	e.preventDefault();
	const url = `${base_url}manual/Cmanuales/getOne`;
	$.ajax({
		url,
		type: 'POST',
		data: { id },
	}).done(function (data) {
		const result = JSON.parse(data);

		$('#modal_update_equipo #form_update_equipo .manual_id').val(result.id);
		var url =
			`
        <a target="__blank" href="` +
			result.url +
			`" class="fa fa-external-link-square btn btn-link"></a>
      `;
		$('#modal_update_equipo #form_update_equipo .contenedor_url_manual').html(
			url
		);
		$(
			'#modal_update_equipo #form_update_equipo .contenedor_descripcion_manual'
		).html(result.descripcion);
		$('#modal_copy #form_equipo_copy .manual_id').val(result.id);
		$('#modal_copy #form_equipo_copy .contenedor_url_manual').html(url);
		$('#modal_copy #form_equipo_copy .contenedor_descripcion_manual').html(
			result.descripcion
		);
		$('#modal_consulta_manual .close').click();
	});
}

const manualsWindow = async () => {
	const initializeManuals = () => {
		const InstancedManuals = new manualObj().printDataTable();
		InstancedManuals.then((table) => {
			const tableManuals = table;
		});
	};

	return {
		initializeManuals,
		show_consulta_manual,
		asociar_manual,
	};
};

export default manualsWindow;
