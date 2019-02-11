$(function () {
    $('#'+getCookie("open")).addClass('show');

});

$('.collapse').on('show.bs.collapse', function () {
    setCookie("open", $(this).attr("id"));
});

$('.collapse').on('hide.bs.collapse',function () {
    if(getCookie('open') == $(this).attr("id")) setCookie("open",'');
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
