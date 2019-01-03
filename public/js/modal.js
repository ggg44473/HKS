
function showRegister(){
    $('#register').css('display','inline-block');
    $('#login').css('display','none');
}

function showLogin(){
    $('#login').css('display','inline-block');
    $('#register').css('display','none');
}

function showModal(){
    $('#modal').removeClass('fade');
    $('#modal').modal('show');
    $('#modal').addClass('fade');
}
