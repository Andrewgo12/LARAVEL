import { dataModules } from './datasource/datasource.js';

export const Router = () => {
	const { pathname } = window.location;
	if (pathname.includes(dataModules.MEDICAL_DEVICES.controllerPath))
		console.log('Medical devices.');
	if (pathname.includes(dataModules.MANUALS.controllerPath))
		console.log('Manuals.');
	if (pathname.includes(dataModules.USERS.controllerPath)) console.log('Users');
	if (pathname.includes(dataModules.OC.controllerPath)) console.log('OC');
	if (pathname.includes(dataModules.INDUSTRIAL_DEVICES.controllerPath))
		console.log('Industrial devices');
	if (pathname.includes(dataModules.LOW.controllerPath)) console.log('Bajas');
};
