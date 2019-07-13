import Index from './index';
import User from './user';

export default {
	install (Vue, options) {
		Vue.prototype.$helper = Object.assign({}, Index, {user: User})
	}
}