function centroObj() { }

centroObj.prototype.ServiceGetAll = async function () {
  const url = base_url + "ubicacion/Ccentros/ServiceGetAll";
  const centros = await fetch(url);
  return centros.json();
}
centroObj.prototype.ServiceGetOne = async function (id = '') {
  const url = `${base_url}ubicacion/Ccentros/ServiceGetOne`;
  const response = await fetch(`${url}/${id}`);
  return response.json();
};

centroObj.prototype.PrintSelect = async function (selector = '') {
  const centros = this.ServiceGetAll();
  centros.then(data => {
    let select = '';
    data.map((service, i) => {
      select += `<option value='${service.id}'>${service.name}</option>`;
    });
    $(selector).html(select);
  });
}