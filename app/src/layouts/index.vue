<template>
    <div id="wrapper" class="">
        <div class="main-sidebar">
            <div class="change-bot-button">
                <div class="logo">
                    <a href="#">
                        <img src="@/../public/assets/images/logo.jpg" alt="" class="img img-logo">
                    </a>
                </div>
                <button class="dropdown pull-right-btn-sidebar">
                    <i class="fa fa-bars"></i>
                    <img src="@/../public/assets/images/icon.jpg" alt="" class="img img-logo icon-sidebar"
                         style="display: none">
                </button>
            </div>
            <div class="sidebar" v-if="user !== null">
                <ul class="sidebar-menu">
                    <li class="item first">
                        <a href="javascript:;" class="member link">
                            <img src="https://graph.facebook.com/1914661111981139/picture?height=50&width=50" alt=""
                                 class="img avatar">
                            <span>{{ user.fullname }}</span>
                            <a href="javascript:;">
                                <i class="fa fa-bell-o"></i>
                            </a>
                            <ul class="dropdown-menu-item">
                                <li class="">
                                    <a class="#">
                                        <i class="icon ion-md-reorder"></i>
                                        <span>Đăng xuất</span>
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </li>
                    <li class="support item">
                        <router-link :to="{name:'user'}" class="link">
                            <i class="fa fa-question-circle"></i>
                            <span>Người dùng</span>
                        </router-link>
                    </li>
                    <li class="support item">
                        <router-link :to="{name:'permission'}" class="link">
                            <i class="fa fa-question-circle"></i>
                            <span>Phân quyền</span>
                        </router-link>
                        <ul class="dropdown-menu-item">
                            <li class="">
                                <router-link :to="{name:'permission'}">
                                    <i class="icon ion-md-reorder"></i>
                                    <span>Danh sách</span>
                                </router-link>
                            </li>
                            <li class="">
                                <router-link :to="{name:'permissionProject'}">
                                    <i class="icon ion-md-reorder"></i>
                                    <span>Dự án</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-wrapper">
         <!--    <div class="bot-scene-title">
                <div class="bot-scene-title-content bot-title-content">
                    <div class="scene-title">
                        <nav>
                            <h4>GOBIG - Quản lý người dùng</h4>
                        </nav>
                    </div>
                    <div class="scene-tools">
                        <div class="flex-display">
                            <div class="dashboard_page__img">
                                <img src="//graph.facebook.com/946385792221717/picture?width=32&amp;height=32"
                                     class="radius-cycle" style="height: 34px;"></div>
                            <div class="dashboard_page__info">
                                <div class="dashboard_page__info__name"
                                     title="Thích Ship Gì - Gì Cũng Ship - View Đồ Ăn">Thích Ship Gì - Gì Cũng Ship -
                                    View Đồ Ăn
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <router-view/>
        </div>
    </div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository'
import HelperIndex from '@/helper/index.js'

export default {
    name: 'App',
    data: ()=> ({
        user: null 
    }),
    created() {
        this.getData();
    },
    methods: {
        getData() {
            UserRepository.getInfo()
            .then(response=> {
                this.user = response;
            })
        }
    }
}
</script>
<style lang="scss"></style>

