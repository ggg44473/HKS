$('.name').on('click', function(){
    $(this).hide();
    $('.name-input').removeClass('u-hidden');
    $('.name-input').select();
    $('.name-input').blur(function(){
        $('#userForm').submit();
    });
});


$('.motto').on('click', function(){
    $(this).hide();
    $('.motto-input').removeClass('u-hidden');
    $('.name-input').select();
    $('.motto-input').blur(function(){
        $('#userForm').submit();
    });
});

$('.motto-input').blur(function(){
    $('#userForm').submit();
});
