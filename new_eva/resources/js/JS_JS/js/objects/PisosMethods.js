function pisoObj() { }
/* CRUD */
pisoObj.prototype.ServiceGetAll = async function () {
  const url = `${base_url}ubicacion/Cpisos/ServiceGetAll`;
  const response = await fetch(url);
  return response.json();
};

pisoObj.prototype.PrintSelect = async function (selector = '') {
  const pisos = await this.ServiceGetAll();
  let select = '';
  pisos.map((piso, i) => {
    select += `<option value='${piso.id}'>${piso.name}</option>`;
  });
  $(selector).html(select);
}
const Pisos = new pisoObj();