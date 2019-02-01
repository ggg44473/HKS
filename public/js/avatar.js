$('#avatar').click(function () {
    $('#input').click();
});

$("#input").change(function () {
    $('#avatarForm').submit();
});

//上傳頭像顯示
$('.uploadIcon').hover(function(){
    $(this).children('.fa-building').hide();
    $(this).children('.fa-images').hide();
    $(this).children('.fa-upload').show();
},function(){
    $(this).children('.fa-images').show();
    $(this).children('.fa-building').show();
    $(this).children('.fa-upload').hide();
});

$('.avatarImg').mouseover(function(){
    $(this).hide();
    $(this).siblings('.avatarImgUpload').removeClass('u-hidden');
});

$('.avatarImgUpload').mouseleave(function(){
    $(this).siblings('.avatarImg').show();
    $(this).addClass('u-hidden');
});

$('.uploadIcon').click(function(){
    $(this).siblings('.imgUpload').click();
});

$('.avatarImgUpload').click(function(){
    $(this).siblings('.imgUpload').click();
});

$('.imgUpload').change(function(){
    readURL(this);
    $(this).siblings('.avatarImg').removeClass('u-hidden');
    $('.uploadIcon').hide();
});

function readURL(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function (e) {
            console.log(input);
            $(input).siblings('.avatarImg').attr('src', e.target.result);
            $(input).siblings('.avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

