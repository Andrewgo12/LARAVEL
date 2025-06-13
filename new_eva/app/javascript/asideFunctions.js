import { getPermissions } from './getPermissions.js';


/**
 * The function renders menu items based on user permissions.
 * @returns The function `renderMenuItems` returns nothing (i.e., `undefined`). It modifies the HTML
 * content of a specified menu element based on the provided menu items and user permissions.
 */
export const renderMenuItems = ({ selector, menuItems }) => {
	const permissions = getPermissions();
	const $menu = document.querySelector(selector);
	if (!$menu || !menuItems || menuItems.length === 0) return;
	let menuContent = '';
  //TODO
	menuItems.forEach(({ icon, url, title, moduleName, isHidden }) => {
		if (!permissions[moduleName] || !permissions[moduleName].read || isHidden ) return;
		menuContent += `
    <li class="nav-item">
      <a href="${url}">
      <i class="${icon}"></i>
      ${title}</a>
    </li>
    `;
	});
	$menu.innerHTML = menuContent;
};
