import Store from '@/store/index.js';
import Router from '@/router/index.js';
import HelperIndex from '@/helper/index.js';
import ConfigPermission from '@/config/permission.js';

export default {
	permission(module_label) {
		// return true;
		const PROJECT = ConfigPermission.project;
		const MODULES = ConfigPermission.modules;
		const PERMISSION = Store.getters.getData('user/permission', null);

		var module_access = PERMISSION !== null && 'code' in PERMISSION.modules ? PERMISSION.modules.code : [];
		var result = [];
		module_label.split('|').map(label=>{
			const MODULE_CODE = HelperIndex.arrayGet(MODULES, label);
			result.push(module_access.includes(MODULE_CODE));	
		})

		const ACCESS = result.includes(true);
		
		return ACCESS;
	},
	positionCheck(label) {
		return true;
		// const POSITIONS = ConfigPermission.positions;
		// const POSITION = Store.getters.getData('user/position');
		// if((POSITION.key !== null && label in POSITIONS) && POSITIONS[label] === POSITION.key) {
		// 	return true;
		// }
		// return false;
	},
	saveAccessToken(value, exp=1) {
		HelperIndex.setCookie('ACCESS_TOKEN', value, exp);
	},
	getAccessToken() {
		return HelperIndex.getCookie('ACCESS_TOKEN');
	},
	removeAccessToken() {
		HelperIndex.setCookie('ACCESS_TOKEN', null, 0);
	},
}