function showRegister(){
    $('#register').css('display','inline-block');
    $('#login').css('display','none');
    $('.invalid-feedback').remove();
    $('.form-control').removeClass('is-invalid');
}

function showLogin(){
    $('#login').css('display','inline-block');
    $('#register').css('display','none');
    $('.invalid-feedback').remove();
    $('.form-control').removeClass('is-invalid');
}

function showModal(){
    $('#modal').removeClass('fade');
    $('#modal').modal('show');
    $('#modal').addClass('fade');
}
