import Vue from 'vue'
import Router from 'vue-router'
import Env from'@/config/env.js';

Vue.use(Router)

var routes = [];

switch(Env.MODE) {
    case 'PC':
        routes = require('./index.js');
    break;
    case 'MOBILE':
        routes = require('./mobile.js');
    break; 
}

export default new Router(routes);