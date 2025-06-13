import { BASE_URL } from '../services/baseUrl.js';

const roleId = globalThis.role;

const parseAsInt = (numberString)=>{
  return parseInt(numberString.replace(/"/g, ''))
}

export const dataModules = {
	MEDICAL_DEVICES: {
		muduleName: 'equipos',
		controllerPath: 'equipo/Cequipos',
	},
	INDUSTRIAL_DEVICES: {
		muduleName: 'equipos industriales',
		controllerPath: 'equipos_ind/Cequipos_ind',
	},
	INVIMAS: {
		muduleName: 'inivimas',
		controllerPath: 'equipo/Cinvimas',
	},
	OC: {
		muduleName: 'soportes compra',
		controllerPath: 'ordenes_compra/Cordenes_compra',
	},
	LOW: {
		muduleName: 'bajas biomedicos',
		controllerPath: 'equipo/Cbajas',
	},
	CONTINGENCIES: {
		muduleName: 'contingencias',
		controllerPath: 'equipo/Ccontingencias',
	},
	QUICK_GUIDES: {
		muduleName: 'guias rapidas',
		controllerPath: 'guia/Cguias',
	},
	MANUALS: {
		muduleName: 'manuales',
		controllerPath: 'manual/Cmanuales',
	},
	USERS: {
		muduleName: 'usuarios',
		controllerPath: 'administrador/Cusuarios',
	},
	OWNERS: {
		muduleName: 'propietarios',
		controllerPath: 'propietario/Cpropietarios',
	},
	LOCATIONS: {
		muduleName: 'servicios',
		controllerPath: 'ubicacion/Cservicios',
	},
	STATUSES: {
		muduleName: 'estados',
		controllerPath: 'ubicacion/Cestadoequipos',
	},
	CONTACTS: {
		muduleName: 'contactos',
		controllerPath: 'contacto/Ccontactos',
	},
	AREAS: {
		muduleName: 'areas',
		controllerPath: 'ubicacion/Careas',
	},
	TICKETS: {
		muduleName: 'tickets propios',
		controllerPath: 'orden/Cordenes',
	},
	TICKETS_ACTIVE: {
		muduleName: 'tickets activos',
		controllerPath: 'orden/Cordenes/list_active',
	},
	TICKETS_CLOSED: {
		muduleName: 'tickets cerrados',
		controllerPath: 'orden/Cordenes/list_closed',
	},
	PLANS: {
		muduleName: 'planes mantenimiento',
		controllerPath: 'mantenimiento/Cplanes',
	},
	SPARE_PARTS: {
		muduleName: 'repuestos',
		controllerPath: 'repuesto/Crepuestos',
	},
	CAPACITATION: {
		muduleName: 'capacitaciones',
		controllerPath: 'capacitacion/Ccapacitaciones',
	},
	REPORTS: {
		muduleName: 'reportes',
		controllerPath: 'reporte/Creportes',
	},
};
export const devicesMenuItems = [
	{
		title: 'Biomedicos',
		moduleName: dataModules.MEDICAL_DEVICES.muduleName,
		url: `${BASE_URL}${dataModules.MEDICAL_DEVICES.controllerPath}`,
		icon: 'fa fa-medkit',
    //TODO
    isHidden: Boolean(roleId  && parseAsInt(globalThis.role) === 4),
	},
	{
		title: 'Industriales',
		moduleName: dataModules.INDUSTRIAL_DEVICES.muduleName,
		url: `${BASE_URL}${dataModules.INDUSTRIAL_DEVICES.controllerPath}`,
		icon: 'fa fa-industry',
    //TODO
    isHidden: Boolean(roleId  && parseAsInt(globalThis.role) === 4)
	},
	{
		title: 'Invimas',
		moduleName: dataModules.INVIMAS.muduleName,
		url: `${BASE_URL}${dataModules.INVIMAS.controllerPath}}`,
		icon: 'fa fa-flask',
	},
	{
		title: 'O.C',
		moduleName: dataModules.OC.muduleName,
		url: `${BASE_URL}${dataModules.OC.controllerPath}`,
		icon: 'fa fa-shopping-cart',
	},
	{
		title: 'Bajas',
		moduleName: dataModules.LOW.muduleName,
		url: `${BASE_URL}${dataModules.LOW.controllerPath}`,
		icon: 'fa fa-trash',
	},
	{
		title: 'Contingencias',
		moduleName: dataModules.CONTINGENCIES.muduleName,
		url: `${BASE_URL}${dataModules.CONTINGENCIES.controllerPath}`,
		icon: 'fa fa-exclamation-triangle',
	},
	{
		title: 'Guias rapidas',
		moduleName: dataModules.QUICK_GUIDES.muduleName,
		url: `${BASE_URL}${dataModules.QUICK_GUIDES.controllerPath}`,
		icon: 'fa fa-book',
	},
	{
		title: 'Manuales',
		moduleName: dataModules.MANUALS.muduleName,
		url: `${BASE_URL}${dataModules.MANUALS.controllerPath}`,
		icon: 'fa fa-th-large',
	},
];

export const adminMenuItems = [
	{
		title: 'Usuarios',
		moduleName: dataModules.USERS.muduleName,
		url: `${BASE_URL}${dataModules.USERS.controllerPath}`,
		icon: 'fa fa-users',
	},
	{
		title: 'Propietarios',
		moduleName: dataModules.OWNERS.muduleName,
		url: `${BASE_URL}${dataModules.OWNERS.controllerPath}`,
		icon: 'fa fa-user',
	},
];

export const configMenuItems = [
	{
		title: 'Servicios',
		moduleName: dataModules.LOCATIONS.muduleName,
		url: `${BASE_URL}${dataModules.LOCATIONS.controllerPath}`,
		icon: 'fa fa-cogs',
	},
	{
		title: 'Estados',
		moduleName: dataModules.STATUSES.muduleName,
		url: `${BASE_URL}${dataModules.STATUSES.controllerPath}`,
		icon: 'fa fa-cogs',
	},
	{
		title: 'Contactos',
		moduleName: dataModules.CONTACTS.muduleName,
		url: `${BASE_URL}${dataModules.CONTACTS.controllerPath}`,
		icon: 'fa fa-phone',
	},
	{
		title: 'Areas',
		moduleName: dataModules.AREAS.muduleName,
		url: `${BASE_URL}${dataModules.AREAS.controllerPath}`,
		icon: 'fa fa-map-marker',
	},
];

export const orderMenuItems = [
	{
		title: 'Mis tickets',
		moduleName: dataModules.TICKETS.muduleName,
		url: `${BASE_URL}${dataModules.TICKETS.controllerPath}`,
		icon: 'fa fa-ticket',
	},
	{
		title: 'Gestion de tickets',
		moduleName: dataModules.TICKETS_ACTIVE.muduleName,
		url: `${BASE_URL}${dataModules.TICKETS_ACTIVE.controllerPath}`,
		icon: 'fa fa-ticket',
	},
	{
		title: 'Tickets cerrados',
		moduleName: dataModules.TICKETS_CLOSED.muduleName,
		url: `${BASE_URL}${dataModules.TICKETS_CLOSED.controllerPath}`,
		icon: 'fa fa-ticket',
	},
];

export const planMenuItems = [
	{
		title: 'Mtto. Preventivo',
		moduleName: dataModules.PLANS.muduleName,
		url: `${BASE_URL}${dataModules.PLANS.controllerPath}`,
		icon: 'fa fa-wrench',
	},
];

export const partsMenuItems = [
	{
		title: 'Repuestos',
		moduleName: dataModules.SPARE_PARTS.muduleName,
		url: `${BASE_URL}${dataModules.SPARE_PARTS.controllerPath}`,
		icon: 'fa fa-cogs',
	},
];

export const capacitationMenuItems = [
	{
		title: 'Capacitaciones',
		moduleName: dataModules.CAPACITATION.muduleName,
		url: `${BASE_URL}${dataModules.CAPACITATION.controllerPath}`,
		icon: 'fa fa-graduation-cap',
	},
];

export const reportMenuItems = [
	{
		title: 'Reportes',
		moduleName: dataModules.REPORTS.muduleName,
		url: `${BASE_URL}${dataModules.REPORTS.controllerPath}`,
		icon: 'fa fa-file-text-o',
	},
	{
		title: 'Graficas',
		moduleName: dataModules.REPORTS.muduleName,
		url: `${BASE_URL}Ccharts`,
		icon: 'fa fa-bar-chart',
	},
];
