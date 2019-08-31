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
            meta: {
                module: 'user.manager|user.index'
            },
            component: () => import('@/components/user/index')
        },
        {
            path: '/nguoi-dung/profile',
            name: 'userProfile',
            component: () => import('@/components/user/profile')
        },
        {
            path: '/phan-quyen/module/:project_id',
            name: 'permissionModule',
            component: () => import('@/components/permission/module/index')
        },
        {
            path: '/phan-quyen',
            name: 'permission',
            meta: {
                module: 'permission.manager|permission.index'
            },
            component: () => import('@/components/permission/index')
        },
        {
            path: '/phan-quyen/du-an',
            name: 'permissionProject',
            meta: {
                position: 'IT'
            },
            component: () => import('@/components/permission/project/index')
        },
        {
            path: '/phan-quyen/chuc-vu',
            name: 'permissionPosition',
            meta: {
                position: 'IT'
            },
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
        {
            path: '/404',
            name: 'error_404',
            component: () => import('@/components/error/404.vue')
        },
        {
            path: '*',
            redirect: {name: 'error_404'}
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
            Store.dispatch('setData', {key: 'user/position', value: response.position});
            Store.dispatch('setData', {key: 'user/is_admin', value: response.position.key === 'ADMIN'});
            const MODULE_LABEL = HelperIndex.arrayGet(to, 'meta.module');
            const POSITION_LABEL = HelperIndex.arrayGet(to, 'meta.position');
            if(MODULE_LABEL !== null) {
                const ACCESS = HelperUser.permission(MODULE_LABEL);
                if(ACCESS === false) {
                    next({name: 'error_404'});
                } else {
                    next();
                }
            } else if(POSITION_LABEL !== null) {
                const value = HelperUser.positionCheck(POSITION_LABEL);
                if(value === false) {
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