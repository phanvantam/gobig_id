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
            <div class="sidebar">
                <ul class="sidebar-menu">
                    <li class="item first">
                        <a href="javascript:;" class="member link">
                            <img src="https://graph.facebook.com/1914661111981139/picture?height=50&width=50" alt=""
                                 class="img avatar">
                            <span>Nguyễn Long</span>
                            <a href="javascript:;">
                                <i class="fa fa-bell-o"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">bạn có 0 thông báo mới</li>
                                <li class="footer"><a href="javascript:;">Xem tất cả</a></li>
                            </ul>
                        </a>
                    </li>
                    <!-- <li class="list-bot item">
                        <router-link :to="{ name: 'userIndex'}" class="link">
                            <i class="icon ion-logo-wordpress"></i>
                            <span>Người dùng</span>
                        </router-link>
                    </li><li class="list-bot item">
                        <router-link :to="{ name: 'typeIndex'}" class="link">
                            <i class="icon ion-logo-wordpress"></i>
                            <span>Cấp độ</span>
                        </router-link>
                    </li> -->
                    <li class="support item">
                        <a href="javascript:;" class="link">
                            <i class="fa fa-question-circle"></i>
                            <span>Hỗ trợ</span>
                        </a>
                        <div class="popper show-popup-support">
                            <ul class="list-inline help-list">
                                <li class="text-left">
                                    <a target="_blank" href="">
                                        <i class="fa fa-life-ring"></i>
                                        <span>Hướng dẫn sử dụng</span></a></li>
                                <li class="text-left">
                                    <a target="_blank" href="">
                                        <i class="fa fa-comment"></i>
                                        <span>Livechat hỗ trợ 1:1</span></a>
                                </li>
                                <li class="text-left">
                                    <a target="_blank" href="">
                                        <i class="fa fa-users"></i>
                                        <span>Cộng đồng hỗ trợ</span></a>
                                </li>
                                <li class="text-left"><a class="hotline">
                                    <i class="fa fa-phone"></i>
                                    <span><span>Hotline&nbsp;</span>
                                                    <span>0963195861</span>
                                                </span>
                                </a>
                                </li>
                                <li>
                                    <div class="ref-permission-container">
                                        <p>Click vào nút bấm này nếu bot dừng hoạt động</p>
                                        <button type="button" class="btn btn-default btn-messenger btn-flat">Refresh
                                            Permissions
                                        </button>
                                    </div>
                                </li>
                                <li class="text-left">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <a target="_blank" href="">Terms Of Service</a>
                                        </div>
                                        <div class="col-xs-6">
                                            <a target="_blank" href="">Privacy Policy</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="bot-scene-title">
                <div class="bot-scene-title-content bot-title-content">
                    <div class="scene-title">
                        <nav>
                            <h4>GOBIG - Quản lý người dùng</h4>
                        </nav>
                    </div>
                    <div class="scene-tools">
                        <!-- <div class="flex-display">
                            <div class="dashboard_page__img">
                                <img src="//graph.facebook.com/946385792221717/picture?width=32&amp;height=32"
                                     class="radius-cycle" style="height: 34px;"></div>
                            <div class="dashboard_page__info">
                                <div class="dashboard_page__info__name"
                                     title="Thích Ship Gì - Gì Cũng Ship - View Đồ Ăn">Thích Ship Gì - Gì Cũng Ship -
                                    View Đồ Ăn
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <router-view/>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'App'
    }
</script>
<style lang="scss"></style>

