var isOpen;

$().ready(function(){
    isOpen = (getCookie('openSideBar')=='true')? true : false
    sidebar(isOpen);
    var path = $(location).attr('pathname').substr(1).split("/", 1);

    switch(path[0]){
        case 'user':
            $('.nav-user').css('color', '#F8F684');
            break;
        case 'organization':
            $('.nav-organization').css('color', '#F8F684');
            break;
        case 'project':
            $('.nav-project').css('color', '#F8F684');
            break;
        case 'calendar':
            $('.nav-calendar').css('color', '#F8F684');
            break;
        case 'follow':
            $('.nav-follow').css('color', '#F8F684');
            break;
    }
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
        $('.btn-menu').css('background-color','');
        $('#sidebar-text').css('left','-30px');
        $('.content').css('margin-left','60px');
        $('.btn-menu').addClass('text-primary');
        $('.btn-menu').removeClass('text-white');
    }
}


