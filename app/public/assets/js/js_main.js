$(document).ready(function(){
    $('body').on('click', '.support.item',function () {
        $('.show-popup-support').toggleClass('display-block');
    });
    $('body').on('click', 'ul li.item',function () {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
    });
    $('body').on('click', '.pull-right-btn-sidebar',function () {
        $('.main-sidebar').toggleClass('sider-width');
        $('.content-wrapper').toggleClass('margin-left-50');
        $('.icon-sidebar').toggleClass('display-inline-block');
    })
    $('body').on('click', '.header-control .fa.fa-ellipsis-h',function () {
        $(this).siblings('.menu-header-control').toggleClass('display-inline-block');

    })

    $('body').on('click', '.hehe',function () {
        console.log('ddgg')

    })
});
