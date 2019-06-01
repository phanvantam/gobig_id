module.exports = {
    // mode: 'history',
	routes: [
        {
            path: '/user',
            name: 'userIndex',
            component: () => import('@/components/user/index')
        },{
            path: '/type',
            name: 'typeIndex',
            component: () => import('@/components/type/index')
        },
	]
};