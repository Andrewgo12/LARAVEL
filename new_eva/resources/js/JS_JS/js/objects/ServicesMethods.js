function serviceObj() {}

serviceObj.prototype.ServiceGetAll = async function () {
	const url = base_url + 'ubicacion/Cservicios/ServiceGetAll';
	const services = await fetch(url);
	return services.json();
};
serviceObj.prototype.ServiceGetOne = async function (id = '') {
	const url = `${base_url}ubicacion/Cservicios/ServiceGetOne`;
	const response = await fetch(`${url}/${id}`);
	return response.json();
};
serviceObj.prototype.ServiceGetBysede = async function (id = '') {
	const url = `${base_url}ubicacion/Cservicios/ServiceGetBysede`;
	const response = await fetch(`${url}/${id}`);
	return response.json();
};
serviceObj.prototype.ServiceInsert = async function (form = '') {
	const url = `${base_url}ubicacion/Cservicios/add`;
	let response = await $.ajax({
		url,
		type: 'post',
		data: form,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	});
	console.log(response);
	response = JSON.parse(response);
	if (response.error) {
		let msj = response.error.replace('<p>', '').replace('</p>', '');
		alert(msj);
		return;
	}
	alert('Nuevo servicio agregado exitosamente');
	this.closeModal('#modal_add_servicio');
};
serviceObj.prototype.ServiceUpdate = async function (form = '') {
	const url = `${base_url}ubicacion/Cservicios/update`;
	await $.ajax({
		url,
		type: 'post',
		data: form,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	});
};
serviceObj.prototype.ServiceDelete = async function (id, e) {
	e.preventDefault();
	const url = `${base_url}ubicacion/Cservicios/delete`;
	const service = await this.ServiceGetOne(id);
	const objectAreas = new areaObj();
	const areas = await objectAreas.ServiceGetByService(id);

	if (areas.length == 1) {
		alert(
			`No es posible eliminar el servicio Porque tiene ${areas.length} area asociada`
		);
		return;
	}
	if (areas.length > 1) {
		alert(
			`No es posible eliminar el servicio Porque tiene ${areas.length} areas asociadas`
		);
		return;
	}

	const deleteControl = confirm(`Desea eliminar el servicio ${service.name}?`);
	if (deleteControl) {
		const response = await fetch(`${url}/${id}`);
		if (response) {
			if (tableServices) {
				tableServices.ajax.reload(null, false);
			}
			alert(`Servicio ${service.name} Eliminado Exitosamente`);
			return;
		}
		alert('Algo fue mal');
		return;
	}
	alert('Eliminación cancelada');
};
serviceObj.prototype.HandleSubmitUpdate = async function (e) {
	e.preventDefault();
	const formCatched = document.querySelector(
		'#modal_update_servicio .form_update_servicio'
	);
	const form = new FormData(formCatched);
	await this.ServiceUpdate(form);

	if (tableServices) tableServices.ajax.reload(null, false);

	this.closeModal('#modal_update_servicio');
};
serviceObj.prototype.HandleSubmitInsert = async function (e) {
	e.preventDefault();
	const formCatched = document.querySelector(
		'#modal_add_servicio .form_add_servicio'
	);
	const form = new FormData(formCatched);
	await this.ServiceInsert(form);

	if (tableServices) tableServices.ajax.reload(null, false);
};
serviceObj.prototype.OpenModalUpdate = async function (id = '', e) {
	e.preventDefault();

	const zones = new zoneObj();
	const pisos = new pisoObj();
	const centros = new centroObj();
	const sedes = new sedeObj();

	await zones.PrintSelect('#modal_update_servicio #zona_id');
	await pisos.PrintSelect('#modal_update_servicio #piso_id');
	await centros.PrintSelect('#modal_update_servicio #centro_id');
	await sedes.PrintSelect('#modal_update_servicio #sede_id');

	const service = await this.ServiceGetOne(id);

	document.querySelector('#modal_update_servicio #id').value = service.id;
	document.querySelector('#modal_update_servicio #name').value = service.name;

	$('#modal_update_servicio #zona_id').val(service.zona_id);
	// $('#modal_update_servicio #zona_id').select2();

	$('#modal_update_servicio #piso_id').val(service.piso_id);
	// $('#modal_update_servicio #piso_id').select2();

	$('#modal_update_servicio #centro_id').val(service.centro_id);
	// $('#modal_update_servicio #centro_id').select2();

	$('#modal_update_servicio #sede_id').val(service.sede_id);
	// $('#modal_update_servicio #sede_id').select2();
};
serviceObj.prototype.OpenModalInsert = async function (e) {
	e.preventDefault();

	const zones = new zoneObj();
	const pisos = new pisoObj();
	const centros = new centroObj();
	const sedes = new sedeObj();

	await zones.PrintSelect('#modal_add_servicio #zona_id');
	await pisos.PrintSelect('#modal_add_servicio #piso_id');
	await centros.PrintSelect('#modal_add_servicio #centro_id');
	await sedes.PrintSelect('#modal_add_servicio #sede_id');
};
serviceObj.prototype.printDataTable = async function () {
	const url = `${base_url}ubicacion/Cservicios/ServiceGetAll`;
	return await $('.tblServicios').DataTable({
		ajax: {
			url,
			method: 'POST',
			data: {},
			dataSrc: '',
		},
		columns: [
			{ data: 'name' },
			{ data: 'zona' },
			{ data: 'centro' },
			{ data: 'sede' },
			{ data: 'cantidad_equipos' },
			{ data: 'cantidad_areas' },
			{
				orderable: true,
				render: function (data, type, servicio) {
					return `
            <a data-toggle='modal' 
              data-target='#modal_update_servicio'
              href=''
              class='btn btn-primary btn-xs  glyphicon glyphicon-pencil'
              onClick='(new serviceObj()).OpenModalUpdate(${servicio.id},event)'>
            </a>
            <a href=''
              class='btn btn-danger btn-xs glyphicon glyphicon-remove'
              onClick='(new serviceObj).ServiceDelete(${servicio.id},event)'>
            </a>`;
				},
			},
		],
	});
};
serviceObj.prototype.PrintSelect = async function (selector = '') {
	const services = this.ServiceGetAll();
	services.then((data) => {
		let select = `<option value=''>----------</option>`;
		data.map((service, i) => {
			select += `<option value='${service.id}'>${service.name}</option>`;
		});
		$(selector).html(select);
	});
};
serviceObj.prototype.PrintSelectBySede = async function (
	selector = '',
	sede_id = ''
) {
	const services = this.ServiceGetBysede(sede_id);
	services.then((data) => {
		let select = `<option value=''>----------</option>`;
		data.map((service, i) => {
			select += `<option value='${service.id}'>${service.name}</option>`;
		});
		$(selector).html(select);
	});
};
serviceObj.prototype.closeModal = function (identifier) {
	$(`${identifier} .close`).click();
};
