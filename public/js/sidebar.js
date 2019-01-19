$(document).ready(function(){
    var isOpen = (getCookie('openSideBar')=='true')? true : false;

    if(isOpen){
        $('#sidebar-text').css('left','60px');
        $('.content').css('margin-left','150px');
        $('.navbar').css('padding-left','166px');
        $('.btn-menu').removeClass('text-primary');
        $('.btn-menu').addClass('text-white');
        $('.btn-menu').css('background-color','#3BA99C');
    }else{
        $('#sidebar-text').css('left','-30px');
        $('.content').css('margin-left','60px');
        $('.navbar').css('padding-left','76px');
        $('.btn-menu').addClass('text-primary');
        $('.btn-menu').removeClass('text-white');
        $('.btn-menu').css('background-color','');
    }

    $('.btn-menu').click(function(){
        isOpen = !isOpen;
        setTransition();
        if(isOpen){
            $('#sidebar-text').css('left','60px');
            $('.content').css('margin-left','150px');
            $('.navbar').css('padding-left','166px');
            $(this).removeClass('text-primary');
            $(this).addClass('text-white');
            $(this).css('background-color','#3BA99C');
        }else{
            $('#sidebar-text').css('left','-30px');
            $('.content').css('margin-left','60px');
            $('.navbar').css('padding-left','76px');
            $(this).addClass('text-primary');
            $(this).removeClass('text-white');
            $(this).css('background-color','');
        }
        setCookie('openSideBar', isOpen);
    });

    $('#sidebar').hover(function(){
        setTransition();
        if(!isOpen){
            $('#sidebar-text').css('left','60px');
            $('.content').css('margin-left','150px');
            $('.navbar').css('padding-left','166px');
        }},function(){
        setTransition();
        if(!isOpen){
            $('#sidebar-text').css('left','-30px');
            $('.content').css('margin-left','60px');
            $('.navbar').css('padding-left','76px');
        }
    });

    $('#sidebar-text').hover(function(){
        setTransition();
        if(!isOpen){
            $('#sidebar-text').css('left','60px');
            $('.content').css('margin-left','150px');
            $('.navbar').css('padding-left','166px');
        }},function(){
        setTransition();
        if(!isOpen ){
            $('#sidebar-text').css('left','-30px');
            $('.content').css('margin-left','60px');
            $('.navbar').css('padding-left','76px');
        }
    });
});

function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function setTransition(){
    $('.navbar').css('transition','all 0.5s ease-in');
    $('.sidebar').css('transition','all 0.5s ease-in');
    $('.content').css('transition','all 0.5s ease-in');
    $('#sidebar-text').css('transition','all 0.5s ease-in');
}