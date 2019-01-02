$(document).ready(function(){
    $('#loginModal').removeClass('fade');
    $('#loginModal').modal('show');
    $('#loginModal').addClass('fade');

});
$(function() {
    $('#loginModal').on('hide.bs.modal',
    function() {
        window.location.href = '/';
    })
});