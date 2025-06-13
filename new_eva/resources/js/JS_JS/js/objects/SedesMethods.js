function sedeObj() { }

sedeObj.prototype.ServiceGetAll = async function () {
  const url = base_url + "ubicacion/Csedes/ServiceGetAll";
  const sedes = await fetch(url);
  return sedes.json();
}
sedeObj.prototype.ServiceGetOne = async function (id = '') {
  const url = `${base_url}ubicacion/Csedes/ServiceGetOne`;
  const response = await fetch(`${url}/${id}`);
  return response.json();
};
sedeObj.prototype.PrintSelect = async function (selector = '') {
  const sedes = this.ServiceGetAll();
  sedes.then(data => {
    let select = '';
    data.map((sede, i) => {
      select += `<option value='${sede.id}'>${sede.name}</option>`;
    });
    $(selector).html(select);
  });
}
