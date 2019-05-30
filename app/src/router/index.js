module.exports = {
    // mode: 'history',
	routes: [
        {
            path: '/kich-ban',
            name: 'scriptIndex',
            component: () => import('@/components/script/index')
        },
        {
            path: '/kich-ban/cap-nhat/:id',
            name: 'scriptEdit',
            meta: {
                edit: true
            },
            component: () => import('@/components/script/add')
        },
        {
            path: '/kich-ban/them-moi',
            name: 'scriptAdd',
            meta: {
                add: true
            },
            component: () => import('@/components/script/add')
        },
        {
            path: '/nhap-lieu',
            name: 'formData',
            component: () => import('@/components/formData/index')
        },
        {
            path: '/nhap-lieu/them-moi',
            name: 'formDataAdd',
            component: () => import('@/components/formData/add')
        },
        {
            path: '/nhap-lieu/cap-nhat/:id',
            name: 'formDataEdit',
            component: () => import('@/components/formData/edit')
        },
        {
            path: '/nhap-lieu/them-gia-tri',
            meta: {
                layout: 'client'
            },
            name: 'formDataAddValue',
            component: () => import('@/components/formData/addValue')
        },
        {
            path: '/fanpage',
            name: 'fanpageList',
            component: () => import('@/components/fanpage/index')
        },
        {
            path: '/fanpage/kich-ban-tu-khoa/:id',
            name: 'fanpageScriptKeyword',
            component: () => import('@/components/fanpage/connect_script/keyword')
        },
        {
            path: '/fanpage/detail/:id',
            name: 'fanpageDetail',
            component: () => import('@/components/fanpage/detail')
        },
        {
            path: '/customer',
            name: 'customerList',
            component: () => import('@/components/customer/index')
        },
        {
            path: '/chamsoc',
            name: 'chamsoc',
            component: () => import('@/components/customer/chamsoc.vue')
        },
        {
            path: '/login',
            name: 'login',
            meta: {
                layout: 'client'
            },
            component: () => import('@/components/user/login.vue')
        },
        {
            path: '/registration',
            name: 'registration',
            component: () => import('@/components/user/registration.vue')
        },
        {
            path: '/astic-keyword',
            name: 'astic-keyword',
            component: () => import('@/components/tmp/astic-keyword.vue')
        },
 
	]
};