module.exports = {
    // mode: 'history',
	routes: [
        {
            path: '/nguoi-dung',
            name: 'userIndex',
            component: () => import('@/components/user/index')
        },
        {
            path: '/phan-quyen/module/:project_id',
            name: 'permissionModule',
            component: () => import('@/components/permission/module/index')
        },
        {
            path: '/phan-quyen',
            component: () => import('@/components/permission/index')
        },
        {
            path: '/phan-quyen/du-an',
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
};