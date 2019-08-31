<template>
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="/index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>ID</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>ID</b>Gobig</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ user_info.fullname }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                    <p>
                                        {{ user_info.fullname }}
                                        <small>Email: {{ user_info.email }}</small>
                                        <small>Chức vụ: {{ user_position.name }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <router-link :to="{name:'userProfile'}" class="btn btn-default btn-flat">Profile</router-link>
                                    </div>
                                    <div class="pull-right">
                                        <a href="javascript:void(0);" @click="logout" class="btn btn-default btn-flat">Đăng xuất</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ $helper.arrayGet(user_info, 'fullname') }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview" v-if="$helper.user.permission('user.index|user.manager')">
                        <a href="#">
                            <i class="fa fa-dashboard"></i>
                            <span>Người dùng</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <router-link :to="{name:'user'}"><i class="fa fa-circle-o"></i>Danh sách</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview" v-if="$helper.user.permission('permission.index|permission.manager') || $helper.user.positionCheck('IT')">
                        <a href="#">
                            <i class="fa fa-dashboard"></i>
                            <span>Phân quyền</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li v-if="$helper.user.permission('permission.index|permission.manager')">
                                <router-link :to="{name:'permission'}"><i class="fa fa-circle-o"></i>Danh sách quyền</router-link>
                            </li>
                            <li v-if="$helper.user.positionCheck('IT')">
                                <router-link :to="{name:'permissionProject'}"><i class="fa fa-circle-o"></i>Dự án</router-link>
                            </li>
                            <li v-if="$helper.user.positionCheck('IT')">
                                <router-link :to="{name:'permissionPosition'}"><i class="fa fa-circle-o"></i>Chức vụ</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <router-view/>
         <!--    <div class="wp-loading" v-show="loading">
                <div class="spinner">
                  <div class="dot1"></div>
                  <div class="dot2"></div>
                </div>
            </div>
 -->        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
            reserved.
        </footer>
    </div>
</template>

<script>

export default {
    computed: {
        // loading() {
        //     return this.$store.getters.getData('loading', false);
        // },
        user_info() {
            return this.$store.getters.getData('user/info', {});
        },
        user_position() {
            return this.$store.getters.getData('user/position', {});
        },
    },
    methods: {
        logout() {
            this.$helper.user.removeAccessToken();
            this.$router.push({name: 'login'});
        },
    },
    mounted() {
        $('.sidebar-menu').tree();
        let content_wrapper_height = $(document).height() - $('.wrapper>.main-header').outerHeight() - $('.wrapper>.main-footer').outerHeight();
        $('.wrapper>.content-wrapper').css('min-height', `${content_wrapper_height}px`);
    }
}
</script>
<style lang="scss"></style>

