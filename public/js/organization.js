// $(function(){
//     $.getJSON('/api/organization', function(data){
//         console.log(data);
//     });
// });

//公司上傳頭像顯示
$('#companyIcon').hover(function(){
    $(this).children('.fa-building').hide();
    $(this).children('.fa-upload').show();
},function(){
    $(this).children('.fa-building').show();
    $(this).children('.fa-upload').hide();
});

$('#companyIcon').click(function(){
    $('#companyImgUpload').click();
});

$('#companyImg').click(function(){
    $('#companyImgUpload').click();
});

$('#companyImgUpload').change(function(){
    readURL(this);
    $('#companyImg').removeClass('u-hidden');
    $('#companyIcon').hide();
});

//部門上傳頭像顯示
$('#departmentIcon').hover(function(){
    $(this).children('.fa-images').hide();
    $(this).children('.fa-upload').show();
},function(){
    $(this).children('.fa-images').show();
    $(this).children('.fa-upload').hide();
});

$('#departmentIcon').click(function(){
    $('#departmentImgUpload').click();
});

$('#departmentImg').click(function(){
    $('#departmentImgUpload').click();
});

$('#departmentImgUpload').change(function(){
    readURL(this);
    $('#departmentImg').removeClass('u-hidden');
    $('#departmentIcon').hide();
});

function readURL(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#companyImg").attr('src', e.target.result);
            $("#departmentImg").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

//tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})