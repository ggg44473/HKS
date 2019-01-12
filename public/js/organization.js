$(function(){
    $.getJSON('/api/organization', function(data){
        console.log(data);
    });
});