import { renderMenuItems } from './asideFunctions.js';
import {
	adminMenuItems,
	capacitationMenuItems,
	configMenuItems,
	devicesMenuItems,
	orderMenuItems,
	partsMenuItems,
	planMenuItems,
	reportMenuItems,
} from './datasource/datasource.js';
import { getPermissions } from './getPermissions.js';

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

const renderMenu = () => menuItems.forEach((item) => renderMenuItems(item));

renderMenu();
