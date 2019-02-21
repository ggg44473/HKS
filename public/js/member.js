$('input').on('change',function(){
    $(this).parents('tr').find('.store-btn').removeClass('text-black-50');
    console.log($(this).parents('tr').find('.store-btn'));
});
$('select').on('change', function(){
    $(this).parents('tr').find('.store-btn').removeClass('text-black-50');
});
