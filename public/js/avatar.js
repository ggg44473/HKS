// function onloadphoto(){
//   form.avatar.click();
// }

// $("#fileSelect").on('change',function(){
//   form.submitAvatar.click();
// });

window.addEventListener('DOMContentLoaded', function () {
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $modal = $('#modal');
    var cropper;

    //顯示tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //input的change事件
    input.addEventListener('change', function (e) {
        var files = e.target.files;
        var reader;
        var file;
        var done = function (url) {
            // input.value = '';
            image.src = url;
            $modal.modal('show');
        };
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    //開啟modal
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    //點按crop btn
    document.getElementById('crop').addEventListener('click', function () {

        $('#avatarForm').submit();
        var canvas;
        $modal.modal('hide');
        // if (cropper) {
        //   canvas = cropper.getCroppedCanvas({
        //     width: 160,
        //     height: 160,
        //   });
        //   avatar.src = canvas.toDataURL();
        //   canvas.toBlob(function (blob) {
        // var formData = new FormData();
        // $('#avatarForm').append('avatar', blob, 'avatar.jpg');
        //});
        //}
    });
});
