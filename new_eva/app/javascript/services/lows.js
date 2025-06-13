import { dataModules } from '../datasource/datasource.js';
import { BASE_URL } from './baseUrl.js';

export const getLows = async () => {
	return await fetch(`${BASE_URL}${dataModules.LOW.controllerPath}/get`)
		.then((response) => response.json())
		.then((data) => data);
};

export const getLow = async (id) => {
	const formData = new FormData();
	formData.append('id', id);
	return await fetch(`${BASE_URL}${dataModules.LOW.controllerPath}/getOne`, {
		method: 'POST',
		body: formData,
	})
		.then((response) => {
			console.log({ response });
			return response.json();
		})
		.then((data) => {
			if (!data.ok) {
				throw new Error('Request failed with status ' + data.status);
			}
			console.log({ data });
			return data;
		});
};
