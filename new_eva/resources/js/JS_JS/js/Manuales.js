if (controlador == 'Cequipos' || controlador == 'Cequipos_ind') {
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
}

/* if (controlador == "Cmanuales") {

    $("#modal_add_manual .form_add_manual").submit(function (e) {
      e.preventDefault();
      let formulario = new FormData(this);
      $.ajax({
        url: base_url + "manual/Cmanuales/add",
        type: "post",
        data: formulario,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
  
      }).done(function (data) {
        var respuesta = JSON.parse(data);
        if (respuesta.caso == 1) {
          alert("Manual agregado exitosamente");
          $("#modal_add_manual .close").click();
          $("#modal_add_manual .form_add_manual").trigger("reset");
          list_manuales();
        } else {
          alert(respuesta.informacion_error);
        }
  
      })
    }); 
     function recover_modal_edit_manual(id) {
      const Manual = manual.getOne(id);
      Manual.then(
        data => {
          $("#modal_update_manual #id").val(data.id);
          $("#modal_update_manual #descripcion").val(data.descripcion);
          $("#modal_update_manual #url").val(data.url);
        }
      );
    }
   $("#modal_update_manual .form_update_manual").submit(function (e) {
    e.preventDefault();
    var formulario = new FormData(this);

    $.ajax({
      url: base_url + "manual/Cmanuales/update",
      type: "post",
      data: formulario,
      dataType: "html",
      cache: false,
      contentType: false,
      processData: false

    }).done(function (data) {
      var respuesta = JSON.parse(data);
      if (respuesta.caso == 1) {
        alert("Informacion actualizada exitosamente");
        $("#modal_update_manual .close").click();
        list_manuales();
      } else {
        alert(respuesta.informacion_error);
      }
    });
  }); 
}
if (controlador == "Cequipos" || controlador == "Cequipos_ind") {

  function show_consulta_manual() {
    $.ajax({
      url: base_url + "manual/Cmanuales/show",
      type: "post",
      data: {
      }
    }).done(function (data) {
      $("#modal_consulta_manual .modal-body").html(data);
      $(".datatable-manuales").dataTable({

        "language": {
          "lengthMenu": "Mostrar _MENU_ registros por pagina",
          "zeroRecords": "No se encontraron resultados en su busqueda",
          "searchPlaceholder": "Buscar registros",
          "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
          "infoEmpty": "No existen registros",
          "infoFiltered": "",
          "search": "Buscar:",
          "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
          }
        },
        'paging': true,

        'filter': true,

        'info': true,

        'stateSave': true,

        'dom': '<"top"ifp<"clear">>rlt<"bottom"ilp<"clear">>',

      });

    });
  }

  function borrar_relacion_manual() {
    $("#modal_update_equipo #form_update_equipo .manual_id").val(0);
    $("#modal_update_equipo #form_update_equipo .contenedor_url_manual").html("");
    $("#modal_update_equipo #form_update_equipo .contenedor_descripcion_manual").html("");

    $("#modal_copy #form_equipo_copy .manual_id").val(0);
    $("#modal_copy #form_equipo_copy .contenedor_url_manual").html("");
    $("#modal_copy #form_equipo_copy .contenedor_descripcion_manual").html("");
  }

}

Reports.print(); */
