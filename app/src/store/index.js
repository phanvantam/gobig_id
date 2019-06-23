
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

const state = ()=> ({
	data: {}
});

const getters = {
	getData: (state) => (key, $default=null) => {
		return state.data[key] || $default;
	},
};

const mutations = {
	addData(state, {key, value}) {
		let tmp = {};
		tmp[key] = value;
		state.data = Object.assign({}, state.data, tmp);
	}
};

const actions = {
	setData({commit}, {key, value=null}) {
		commit('addData', {key: key, value: value});
	}
};

export const store = new Vuex.Store({
	state: state,
	getters: getters,
	mutations: mutations,
	actions: actions,
});