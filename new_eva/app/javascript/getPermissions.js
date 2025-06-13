/**
 * The function retrieves permissions for different modules based on whether the user has read access
 * or not.
 * @returns The function `getPermissions` returns an object `hashMap` which contains the permissions
 * for each module. The keys of the object are the module names and the values are objects with a
 * `read` property that indicates whether the user has permission to read that module or not.
 */
export const getPermissions = () => {
	const { actions } = window || [];
	if (!actions) return {};
	const hashMap = {};
	actions.forEach(
		({ modulo, leer, editar, insertar, eliminar }) =>
			(hashMap[modulo] = {
				read: leer === '1',
				edit: editar === '1',
				insert: insertar === '1',
				delete: eliminar === '1',
			})
	);
	return hashMap;
};
