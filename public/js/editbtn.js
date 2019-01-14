$('.okr-close-btn').on('click',function(){
    if ($(this).children('.fa-edit').length>0) {
        $(this).children('.fa-edit').remove();
        $(this).append('<i class="fas fa-times pt-0 pr-1"></i>');
        $(this).parents('.okr-card').find('.btn-edit-group').fadeIn();
    }else{
        $(this).children('.fa-times').remove();
        $(this).append('<i class="far fa-edit"></i>');
        $(this).parents('.okr-card').find('.btn-edit-group').hide();
    }
});