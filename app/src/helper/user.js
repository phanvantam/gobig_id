import Store from '@/store/index.js';
import Router from '@/router/index.js';
import HelperIndex from '@/helper/index.js';
import ConfigPermission from '@/config/permission.js';

export default {
	permission(module_label, redirect=false) {
		const PROJECT = ConfigPermission.project;
		const MODULES = ConfigPermission.modules;
		const PERMISSION = Store.getters.getData('user/permission', []);
		const ADMIN = Store.getters.getData('user/is_admin', false);
		if(ADMIN || this.positionCheck('IT')) {
			return true;
		}
		var module_access = [];
		PERMISSION.map(item=> {
			if(item.project.code === PROJECT) {
				module_access = 'code' in item.modules ? item.modules.code : [];
			}
		})
		var result = [];
		module_label.split('|').map(label=>{
			const MODULE_CODE = HelperIndex.arrayGet(MODULES, label);
			result.push(module_access.includes(MODULE_CODE));	
		})

		const ACCESS = result.includes(true);
		if(redirect) {
			if(ACCESS === false) {
				Router.push({name: 'error_404'});
			}
		} else {
			return ACCESS;
		}
	},
	positionCheck(label) {
		const POSITIONS = ConfigPermission.positions;
		const POSITION = Store.getters.getData('user/position');
		if((POSITION.key !== null && label in POSITIONS) && POSITIONS[label] === POSITION.key) {
			return true;
		}
		return false;
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