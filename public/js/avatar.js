$('#avatar').on('click', function () {
    form.avatar.click();
});

$("#input").change(function () {
    readURL(this);
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

$('#avatarImg').mouseover(function(){
    $(this).hide();
    $('#avatarImgUpload').removeClass('u-hidden');
});

$('#avatarImgUpload').mouseleave(function(){
    $('#avatarImg').show();
    $(this).addClass('u-hidden');
});

$('.uploadIcon').click(function(){
    $('#imgUpload').click();
});

$('#avatarImgUpload').click(function(){
    $('#imgUpload').click();
});

$('#imgUpload').change(function(){
    readURL(this);
    $('#avatarImg').removeClass('u-hidden');
    $('.uploadIcon').hide();
});

function readURL(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#avatarImg").attr('src', e.target.result);
            $('#avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

