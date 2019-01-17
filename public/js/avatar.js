$('#avatar').on('click', function () {
    form.avatar.click();
});

$("#input").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#avatar').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
