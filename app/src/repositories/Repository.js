import Axios from 'axios'
import Env from'@/config/env.js';

import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
 
const instance = Axios.create({
	baseURL: Env.BASE_URL_API,
	headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    }
});

instance.interceptors.request.use(function (config) {
	NProgress.start();

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
			result.messages = response.data.messages;
		}
	}
	return result;
});


export default instance;