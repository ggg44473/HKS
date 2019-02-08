var isOpen;

$().ready(function(){
    isOpen = (getCookie('openSideBar'))? true : false
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
    addTransition();
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

function sidebar(isOpen){
    if(isOpen){
        $('#sidebar-text').addClass('open');
        $('.content').addClass('open');
        $('.btn-menu').addClass('open');
    }else{
        $('#sidebar-text').removeClass('open');
        $('.content').removeClass('open');
        $('.btn-menu').removeClass('open');
    }
}

function addTransition(){
    $('#sidebar-text').css('transition','all 0.5s ease-in');
    $('.content').css('transition','all 0.5s ease-in');
    $('.sidebar').css('transition','all 0.5s ease-in');
}
