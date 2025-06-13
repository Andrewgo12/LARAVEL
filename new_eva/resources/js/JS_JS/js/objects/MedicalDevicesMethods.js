function medicaldeviceObj() {}

medicaldeviceObj.prototype.SetFilterLocation = async function () {
	const services = new serviceObj();
	if ($('.sede_id_auxiliar').val() == '') {
		await services.PrintSelect('.servicio_id_auxiliar');
		// await $('.servicio_id_auxiliar').select2();
		return;
	}
	await services.PrintSelectBySede('.servicio_id_auxiliar', sede_id);
	// await $('.servicio_id_auxiliar').select2();
};
