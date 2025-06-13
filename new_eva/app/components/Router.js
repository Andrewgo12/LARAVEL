import { renderGuides, setUpdateCounter } from '../guides.js';
import manualsWindow from './ManualsWindow.js';
import { ajax } from './helpers/ajax.js';

export const Router = async () => {
	let { pathname } = location;
	if (pathname === '/equipo/Cequipos') console.log('Medical devices');
	if (pathname === '/manual/Cmanuales') {
		const manualsControl = await manualsWindow();
		manualsControl.initializeManuals();
		manualsControl.show_consulta_manual;
	}
	if (pathname === '/Home') {
		renderGuides();
		setUpdateCounter();
	}


};
