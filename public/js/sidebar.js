var isOpen;

$().ready(function(){
    isOpen = (getCookie('openSideBar')=='true')? true : false
    sidebar(isOpen);
});

$('.btn-menu').click(function(){
    isOpen = !isOpen;
    setTransition();
    sidebar(isOpen);
    setCookie('openSideBar', isOpen);
});

function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function setTransition(){
    $('.sidebar').css('transition','all 0.5s ease-in');
    $('.content').css('transition','all 0.5s ease-in');
    $('#sidebar-text').css('transition','all 0.5s ease-in');
}

function sidebar(isOpen){
    if(isOpen){
        $('#sidebar-text').css('left','60px');
        $('.content').css('margin-left','150px');
        $('.btn-menu').removeClass('text-primary');
        $('.btn-menu').addClass('text-white');
        $('.btn-menu').css('background-color','#3BA99C');
    }else{
        $('#sidebar-text').css('left','-30px');
        $('.content').css('margin-left','60px');
        $('.btn-menu').addClass('text-primary');
        $('.btn-menu').removeClass('text-white');
        $('.btn-menu').css('background-color','');
    }
}
