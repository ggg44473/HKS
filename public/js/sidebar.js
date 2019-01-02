$(document).ready(function(){
    var isClick = true;

    $('.btn-menu').click(function(){
        if(isClick == false){
            $('#sidebar-text').css('left','-30px');
            $('.content').css('margin-left','60px');
            $('.navbar').css('padding-left','76px');
            $(this).addClass('text-primary');
            $(this).removeClass('text-white');
            $(this).css('background-color','');
            isClick = true;
        }else{
            $('#sidebar-text').css('left','60px');
            $('.content').css('margin-left','150px');
            $('.navbar').css('padding-left','166px');
            $(this).removeClass('text-primary');
            $(this).addClass('text-white');
            $(this).css('background-color','#3BA99C');
            isClick = false;
        }
    });

    $('#sidebar').hover(function(){
        if(isClick == true){
            $('#sidebar-text').css('left','60px');
            $('.content').css('margin-left','150px');
            $('.navbar').css('padding-left','166px');
        }},function(){
        if(isClick == true ){
            $('#sidebar-text').css('left','-30px');
            $('.content').css('margin-left','60px');
            $('.navbar').css('padding-left','76px');
        }
    });

    $('#sidebar-text').hover(function(){
        if(isClick == true){
            $('#sidebar-text').css('left','60px');
            $('#app').css('margin-left','150px');
            $('.navbar').css('padding-left','166px');
        }},function(){
        if(isClick == true ){
            $('#sidebar-text').css('left','-30px');
            $('#app').css('margin-left','60px');
            $('.navbar').css('padding-left','76px');
        }
    });
});