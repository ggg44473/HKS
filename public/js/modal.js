$(function(){
    $('#modal').modal('show');
});

$('#modal').on('hidden.bs.modal', function () {
    window.location.assign("/");
});
