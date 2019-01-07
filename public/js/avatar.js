//用圖片連接上傳圖片form
function onloadphoto(){
    form.avatar.click();
}

$("#fileSelect").on('change',function(){
    form.submitAvatar.click();
});