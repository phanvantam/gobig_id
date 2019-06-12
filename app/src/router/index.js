module.exports = {
    // mode: 'history',
	routes: [
        {
            path: '/nguoi-dung',
            name: 'userIndex',
            component: () => import('@/components/user/index')
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