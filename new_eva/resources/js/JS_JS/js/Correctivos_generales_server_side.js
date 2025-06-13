function list_datatable_server_side_correctivos_abiertos() {
	$('.tblCorrectivosAbiertos').dataTable({
		language: {
			lengthMenu: 'Mostrar _MENU_ registros por pagina',
			zeroRecords: 'No se encontraron resultados en su busqueda',
			searchPlaceholder: 'Buscar registros',
			info: 'Mostrando Ordenes abiertas de _START_ al _END_ de un total de  _TOTAL_ Ordenes abiertas',
			infoEmpty: 'No existen ordenes abiertas',
			infoFiltered: '(filtrado de un total de _MAX_ ordenes abiertas)',
			search: 'Buscar:',
			paginate: {
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior',
			},
		},
		lengthMenu: [
			[5, 10, 20],
			[5, 10, 20],
		],
		paging: true,
		filter: true,
		info: true,
		stateSave: true,
		bDestroy: true,
		processing: true,
		serverSide: true,
		ajax: {
			url:
				base_url +
				'correctivo_general/Ccorrectivos_generales/get_datatable_server_side_correctivos_generales_abiertos',
			type: 'POST',
			data: {},
		},
		columns: [
			{ data: 'fecha_inicio' },
			{ data: 'equipo' },
			{ data: 'code_orden' },
			{ data: 'orden' },
			{ data: 'codigo_equipo' },
			{ data: 'serie_equipo' },
			{ data: 'servicio' },
			{ data: 'area' },
			{ data: 'avances' },
			{
				orderable: true,
				render: function (data, type, row) {
					tmp =
						`

			<a data-toggle="modal" data-target="#modal_update_correctivo_general" onclick="recover_modal_edit_correctivo_general(` +
						row.id +
						`)" class="btn btn-success glyphicon glyphicon-pencil" style="padding:5px;"></a>					
					`;
					return tmp;
				},
			},
		],
	});
}
