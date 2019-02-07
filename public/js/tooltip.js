//tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.tooltipBtn').tooltip();
});

$('.modal').on('shown.bs.modal', function(e){
    $('.tooltipBtn').one('focus', function(e){$(this).blur();});
});
