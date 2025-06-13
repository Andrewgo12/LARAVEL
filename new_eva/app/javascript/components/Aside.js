import { renderMenuItems } from '../asideFunctions.js';
import {
	adminMenuItems,
	capacitationMenuItems,
	configMenuItems,
	devicesMenuItems,
	orderMenuItems,
	partsMenuItems,
	planMenuItems,
	reportMenuItems,
} from '../datasource/datasource.js';

const menuItems = [
	{
		selector: '#menuDevices',
		menuItems: devicesMenuItems,
	},
	{
		selector: '#menuAdmin',
		menuItems: adminMenuItems,
	},
	{
		selector: '#menuConfig',
		menuItems: configMenuItems,
	},
	{
		selector: '#menuTickets',
		menuItems: orderMenuItems,
	},
	{
		selector: '#menuPlan',
		menuItems: planMenuItems,
	},
	{
		selector: '#menuSpareParts',
		menuItems: partsMenuItems,
	},
	{
		selector: '#menuCapacitations',
		menuItems: capacitationMenuItems,
	},
	{
		selector: '#menuReports',
		menuItems: reportMenuItems,
	},
];

export const renderAsideMenu = () =>
	menuItems.forEach((item) => renderMenuItems(item));
