function manualObj() {}

manualObj.prototype.ServiceGetOne = async function (id = '') {
	const url = `${base_url}manual/Cmanuales/ServiceGetOne`;
	const response = await fetch(`${url}/${id}`);
	return response.json();
};
manualObj.prototype.ServiceInsert = async function (form = '') {
	const url = `${base_url}manual/Cmanuales/add`;
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
	alert('Nuevo manual agregado exitosamente');
	this.closeModal('#modal_add_manual');
};
manualObj.prototype.ServiceUpdate = async function (form = '') {
	const url = `${base_url}manual/Cmanuales/update`;
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
manualObj.prototype.ServiceDelete = async function (id, e) {
	e.preventDefault();
	const url = `${base_url}manual/Cmanuales/delete`;
	const manual = await this.ServiceGetOne(id);
	const response = await fetch(`${url}/${id}`);
	if (response) {
		if (tableManuals) {
			tableManuals.ajax.reload(null, false);
		}
		alert(`Manual ${manual.descripcion} Eliminado Exitosamente`);
		return;
	}
	alert('Algo fue mal');
};
manualObj.prototype.HandleSubmitUpdate = async function (e) {
	e.preventDefault();
	const formCatched = document.querySelector(
		'#modal_update_manual .form_update_manual'
	);
	const form = new FormData(formCatched);
	await this.ServiceUpdate(form);

	if (tableManuals) tableManuals.ajax.reload(null, false);

	this.closeModal('#modal_update_manual');
};
manualObj.prototype.HandleSubmitInsert = async function (e) {
	e.preventDefault();
	const formCatched = document.querySelector(
		'#modal_add_manual .form_add_manual'
	);
	const form = new FormData(formCatched);
	await this.ServiceInsert(form);

	if (tableManuals) tableManuals.ajax.reload(null, false);
};
manualObj.prototype.OpenModalUpdate = async function (id = '', e) {
	e.preventDefault();
	const manual = await this.ServiceGetOne(id);

	document.querySelector('#modal_update_manual #id').value = manual.id;
	document.querySelector('#modal_update_manual #descripcion').value =
		manual.descripcion;
	document.querySelector('#modal_update_manual #url').value = manual.url;
};
manualObj.prototype.printDataTable = async function () {
	const url = `${base_url}manual/Cmanuales/ServiceGetAll`;
	return await $('.tabla-manuales').DataTable({
		ajax: {
			url,
			method: 'POST',
			data: {},
			dataSrc: '',
		},
		columns: [
			{ data: 'id' },
			{ data: 'descripcion' },
			{ data: 'url' },
			{
				orderable: true,
				render: function (data, type, manual) {
					return `
            <a data-toggle='modal' 
              data-target='#modal_update_manual'
              href=''
              class='btn btn-primary btn-xs  glyphicon glyphicon-pencil'
              onClick='(new manualObj()).OpenModalUpdate(${manual.id},event)'>
            </a>
            <a href=''
              class='btn btn-danger btn-xs glyphicon glyphicon-remove'
              onClick='(new manualObj).ServiceDelete(${manual.id},event)'>
            </a>`;
				},
			},
		],
		columnDefs: [
			{
				targets: [2],
				render(data, type, manual) {
					return `<a class='glyphicon glyphicon-th-list' href='${manual.url}' target='__blank' ></a>`;
				},
			},
		],
	});
};
manualObj.prototype.closeModal = function (identifier) {
	$(`${identifier} .close`).click();
};
