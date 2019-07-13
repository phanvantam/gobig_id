import Axios from 'axios'
import Router from '@/router/index'
import Env from'@/config/env.js';
import HelperUser from '@/helper/user';
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
 
const instance = Axios.create({
	baseURL: Env.BASE_URL_API,
	headers: {     
		'Content-Type': 'application/json',
		post: {
	        'Content-Type': 'application/x-www-form-urlencoded',
		}
    }
});

instance.interceptors.request.use(function (config) {
	NProgress.start();
	config.headers.Authorization = "Bearer "+ HelperUser.getAccessToken();
   return config;
});

instance.interceptors.response.use(function(response) {
   NProgress.done();
	let result = {
		status: 1,
		data: []
	}
	if(response.data instanceof Object && 'status' in response.data) {
		result.status = response.data.status;
		if(result.status === 1) {
			result.data = response.data.data;
		} else {
			result.messages = 'messages' in response.data ? response.data.messages : null;
		}
	}
	return result;
}, e=> {
	NProgress.done();
	return Promise.reject(e);
});

export default instance;