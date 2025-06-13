function userObj() { }

userObj.prototype.ServiceGetAll = async function () {
  const url = base_url + "administrador/Cservicios/ServiceGetAll";
  const services = await fetch(url);
  return services.json();
}
userObj.prototype.ServiceGetOne = async function (id = '') {
  const url = `${base_url}administrador/Cservicios/ServiceGetOne`;
  const response = await fetch(`${url}/${id}`);
  return response.json();
};
