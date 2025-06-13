function areaObj() {
	this._data;
}
areaObj.prototype = {
	get information() {
		return this._data;
	},
	set information(value) {
		this._data = value;
	},
};
/* CRUD */
areaObj.prototype.ServiceGetAll = async function () {
	const url = `${base_url}ubicacion/Careas/ServiceGetAll`;
	const response = await fetch(url);
	return response.json();
};
areaObj.prototype.ServiceGetOne = async function (id = '') {
	const url = `${base_url}ubicacion/Careas/ServiceGetOne`;
	const response = await fetch(`${url}/${id}`);
	return response.json();
};
areaObj.prototype.ServiceGetByService = async function (id = '') {
	const url = `${base_url}ubicacion/Careas/ServiceGetByService`;
	const response = await fetch(`${url}/${id}`);
	return response.json();
};
areaObj.prototype.ServiceInsert = async function (form = '') {
	const url = `${base_url}ubicacion/Careas/add`;
	let response = await $.ajax({
		url,
		type: 'post',
		data: form,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	});
	response = JSON.parse(response);
	if (response.error) {
		let msj = response.error.replace('<p>', '').replace('</p>', '');
		alert(msj);
		return;
	}
	alert('Nueva area agregada exitosamente');
	this.closeModal('#modal_add_area');
};
areaObj.prototype.ServiceUpdate = async function (form = '') {
	const url = `${base_url}ubicacion/Careas/update`;
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
areaObj.prototype.ServiceDelete = async function (id, e) {
	e.preventDefault();
	const url = `${base_url}ubicacion/Careas/delete`;
	const area = await this.ServiceGetOne(id);
	const response = await fetch(`${url}/${id}`);
	if (response) {
		if (tableAreas) {
			tableAreas.ajax.reload(null, false);
		}
		alert(`Area ${area.name} Eliminada Exitosamente`);
		return;
	}
	alert('Algo fue mal');
};
areaObj.prototype.HandleSubmitUpdate = async function (e) {
	e.preventDefault();
	const formCatched = document.querySelector(
		'#modal_update_area .form_update_area'
	);
	const form = new FormData(formCatched);
	await this.ServiceUpdate(form);

	if (tableAreas) tableAreas.ajax.reload(null, false);

	this.closeModal('#modal_update_area');
};
areaObj.prototype.HandleSubmitInsert = async function (e) {
	e.preventDefault();
	const formCatched = document.querySelector('#modal_add_area .form_add_area');
	const form = new FormData(formCatched);
	await this.ServiceInsert(form);

	if (tableAreas) tableAreas.ajax.reload(null, false);
};
areaObj.prototype.OpenModalUpdate = async function (id = '', e) {
	e.preventDefault();

	const servicios = new serviceObj();
	const pisos = new pisoObj();

	await servicios.PrintSelect('#modal_update_area #servicio_id');
	await pisos.PrintSelect('#modal_update_area #piso_id');

	const area = await this.ServiceGetOne(id);

	document.querySelector('#modal_update_area #id').value = area.id;
	document.querySelector('#modal_update_area #name').value = area.name;
	document.querySelector('#modal_update_area #piso_id').value = area.piso_id;
	$('#modal_update_area #piso_id').select2();
	$('#modal_update_area #servicio_id').val(area.servicio_id);
	// $('#modal_update_area #servicio_id').select2();
};
areaObj.prototype.OpenModalInsert = async function (e) {
	e.preventDefault();

	const servicios = new serviceObj();
	const pisos = new pisoObj();

	await servicios.PrintSelect('#modal_add_area #servicio_id');
	await pisos.PrintSelect('#modal_add_area #piso_id');
	$('#modal_add_area #piso_id').select2();
	// $('#modal_add_area #servicio_id').select2();
};
areaObj.prototype.printTable = async function () {
	const areas = await this.ServiceGetAll();
	let table = '';
	areas.map((area, i) => {
		table += `
        <tr>
          <td>${area.name}</td>
          <td>${area.servicio}</td>
          <td>${area.sede}</td>
          <td>${area.piso}</td>
          <td>
              <a data-toggle='modal' 
                data-target='#modal_update_area'
                href=''
                class='btn btn-primary btn-xs  glyphicon glyphicon-pencil'
                onClick='(new areaObj()).OpenModalUpdate(${area.id},event)'>
              </a>
              <a href=''
                class='btn btn-danger btn-xs glyphicon glyphicon-remove'
                onClick='(new areaObj).ServiceDelete(${area.id},event)'>
              </a>
          </td>
        </tr>
      `;
	});
	$('.tblAreas').dataTable().fnClearTable();
	$('.tblAreas').dataTable().fnDestroy();
	$('.tblAreas tbody').html(table);
	this.table = $('.tblAreas').dataTable({ stateSave: true });
};
areaObj.prototype.printDataTable = async function () {
	const url = `${base_url}ubicacion/Careas/ServiceGetAll`;
	return await $('.tblAreas').DataTable({
		ajax: {
			url,
			method: 'POST',
			data: {},
			dataSrc: '',
		},
		columns: [
			{ data: 'name' },
			{ data: 'servicio' },
			{ data: 'sede' },
			{ data: 'piso' },
			{
				orderable: true,
				render: function (data, type, area) {
					return `
            <a data-toggle='modal' 
              data-target='#modal_update_area'
              href=''
              class='btn btn-primary btn-xs  glyphicon glyphicon-pencil'
              onClick='(new areaObj()).OpenModalUpdate(${area.id},event)'>
            </a>
            <a href=''
              class='btn btn-danger btn-xs glyphicon glyphicon-remove'
              onClick='(new areaObj).ServiceDelete(${area.id},event)'>
            </a>`;
				},
			},
		],
	});
};
areaObj.prototype.PrintSelect = async function (selector = '') {
	const areas = this.ServiceGetAll();
	areas.then((data) => {
		let select = `<option value=''>----------</option>`;
		data.map((area, i) => {
			select += `<option value='${area.id}'>${area.name}</option>`;
		});
		$(selector).html(select);
	});
};
areaObj.prototype.PrintSelectByService = async function (
	selector = '',
	service_id = ''
) {
	const areas = this.ServiceGetByService(service_id);
	areas.then((data) => {
		let select = `<option value=''>----------</option>`;
		data.map((area, i) => {
			select += `<option value='${area.id}'>${area.name}</option>`;
		});
		$(selector).html(select);
	});
};
areaObj.prototype.closeModal = function (identifier) {
	$(`${identifier} .close`).click();
};
areaObj.prototype.setData = function (value) {
	this.information = value;
};
areaObj.prototype.getData = function () {
	return this.information;
};
