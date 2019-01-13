// $(function(){
//     $.getJSON('/api/organization', function(data){
//         console.log(data);
//     });
// });

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

function readURL(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#companyImg").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('#addMember').click(function(){

});