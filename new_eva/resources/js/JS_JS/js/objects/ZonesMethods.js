function zoneObj() { }

zoneObj.prototype.ServiceGetAll = async function () {
  const url = `${base_url}administrador/Czonas/ServiceGetAll`;
  const response = await fetch(url);
  return response.json();
};

zoneObj.prototype.PrintSelect = async function (selector = '') {
  const zones = await this.ServiceGetAll();
  let select = '';
  zones.map((zone, i) => {
    select += `<option value='${zone.id}'>${zone.name}</option>`;
  })
  $(selector).html(select);
}