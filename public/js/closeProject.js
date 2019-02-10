$(function () {
    var hash = $(location).attr('hash');
    if (hash == '#closeProject') {
        $('#project-tab').removeClass('active');
        $('#closeProject-tab').addClass('active');
        $('#project').removeClass(['show', 'active']);
        $('#closeProject').addClass(['show', 'active']);
    }
});

$('#closeProject-tab').on('click', function () {
    location.hash = '#closeProject';
});

$('#project-tab').on('click', function () {
    location.hash = '';
});
