import Vue from 'vue'
import Router from 'vue-router'
import HelperUser from '@/helper/user';
import HelperIndex from '@/helper/index';
import Store from '@/store/index';
import UserRepository from '@/repositories/UserRepository';

Vue.use(Router);

const ROUTER = new Router({
    mode: 'history',
	routes: [
        {
            path: '/',
            component: () => import('@/components/user/index')
        },
        {
            path: '/nguoi-dung',
            name: 'user',
            component: () => import('@/components/user/index')
        },
        {
            path: '/phan-quyen/module/:project_id',
            name: 'permissionModule',
            component: () => import('@/components/permission/module/index')
        },
        {
            path: '/phan-quyen',
            name: 'permission',
            component: () => import('@/components/permission/index')
        },
        {
            path: '/phan-quyen/du-an',
            name: 'permissionProject',
            component: () => import('@/components/permission/project/index')
        },
        {
            path: '/phan-quyen/chuc-vu',
            name: 'permissionPosition',
            component: () => import('@/components/permission/position/index')
        },
        {
            path: '/dang-nhap',
            name: 'login',
            meta: {
                layout: 'client',
                auth: false
            },
            component: () => import('@/components/user/login')
        },
	]
});

ROUTER.beforeEach((to, from, next) => {
    UserRepository.getInfo()
    .then(response=> {
        if(to.name === 'login') {
            next(from);
        } else {
            Store.dispatch('setData', {key: 'user/login', value: true});
            Store.dispatch('setData', {key: 'user/info', value: {
                email: response.email,
                id: response.id,
                fullname: response.fullname,
            }});
            Store.dispatch('setData', {key: 'user/permission', value: response.permission});
            const MODULE_LABEL = HelperIndex.arrayGet(to, 'meta.module');
            if(MODULE_LABEL !== null) {
                const ACCESS = HelperUser.permission(MODULE_LABEL);
                if(ACCESS === false) {
                    next({name: 'error_404'});
                } else {
                    next();
                }
            } else {
                next();
            }
        }
    })
    .catch(e=> {
        if(e.response.status === 401) {
            const AUTH = HelperIndex.arrayGet(to, 'meta.auth', true);
            if(AUTH) {
                next({name: 'login'});
            } else {
                next();
            }
        }
    })
});

export default ROUTER;