$(document).ready(function(){
    $('.btn-edit-group').hide();
});
$('.close').on('click',function(){
    if ($(this).children('.fa-edit').length>0) {
        $(this).children('.fa-edit').remove();
        $(this).append('<i class="fas fa-times pt-0 pr-1"></i>');
        $(this).parents('.card').find('.btn-edit-group').show();
    }else{
        $(this).children('.fa-times').remove();
        $(this).append('<i class="far fa-edit"></i>');
        $(this).parents('.card').find('.btn-edit-group').hide();
    }
});