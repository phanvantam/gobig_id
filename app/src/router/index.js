import Vue from 'vue'
import Router from 'vue-router'
import HelperUser from '@/helper/user';
import HelperIndex from '@/helper/index';
import Store from '@/store/index';
import UserRepository from '@/repositories/UserRepository';
import ConfigPermission from '@/config/permission.js';

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
            meta: {
                module: 'especially.it'
            },
            component: () => import('@/components/permission/module/index')
        },
        {
            path: '/phan-quyen',
            name: 'permission',
            meta: {
                module: 'especially.it'
            },
            component: () => import('@/components/permission/index')
        },
        {
            path: '/phan-quyen/du-an',
            name: 'permissionProject',
            meta: {
                module: 'especially.it'
            },
            component: () => import('@/components/permission/project/index')
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
    const AUTH = HelperIndex.arrayGet(to, 'meta.auth', true);

    UserRepository.getInfo()
    .then(response=> {
        if(AUTH === false) {
            next(from);
        } else {
            Store.dispatch('setData', {key: 'user/info', value: response});
            let permission = null;
            response.permission.map(item=> {
                if(item.project.code === ConfigPermission.project) {
                    permission = item;
                }
            })
            if(permission !== null) {
                Store.dispatch('setData', {key: 'user/permission', value: permission});
                const module_label = HelperIndex.arrayGet(to, 'meta.module');
                if(module_label !== null) {
                    const access = HelperUser.permission(module_label);
                    if(access === false) {
                        next({name: 'error_404'});
                    } else {
                        next();
                    }
                }
                next();
            } else {
                Vue.notify({
                    text: 'Tài khoản chưa được cấp quyền truy cập',
                    type: 'error'
                })
                HelperUser.removeAccessToken();
                next({name: 'login'});
            }
        }
    })
    .catch(e=> {
        if(e.response.status === 401) {
            if(AUTH) {
                next({name: 'login'});
            } else {
                next();
            }
        }
    })
});

export default ROUTER;