import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
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
            path: '/dang-nhap',
            name: 'login',
            meta: {
                layout: 'client'
            },
            component: () => import('@/components/user/login')
        },
	]
});