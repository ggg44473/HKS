var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

$('#started_at').datepicker({
    uiLibrary: 'bootstrap4',
    icons: {
        rightIcon: '<i class="far fa-calendar-alt"></i>'
    },
    format: 'yyyy/mm/dd',
    maxDate: function () {
        return $('#finished_at').val();
    }
});

$('#finished_at').datepicker({
    uiLibrary: 'bootstrap4',
    icons: {
        rightIcon: '<i class="far fa-calendar-alt"></i>'
    },
    format: 'yyyy/mm/dd',
    minDate: function () {
        return $('#started_at').val();
    }
});

$('#filter_started_at').datepicker({
    uiLibrary: 'bootstrap4',
    icons: {
        rightIcon: '<i class="far fa-calendar-alt"></i>'
    },
    format: 'yyyy/mm/dd',
    maxDate: function () {
        return $('#filter_start').val();
    }
});

$('#filter_finished_at').datepicker({
    uiLibrary: 'bootstrap4',
    icons: {
        rightIcon: '<i class="far fa-calendar-alt"></i>'
    },
    format: 'yyyy/mm/dd',
    minDate: function () {
        return $('#filter_finish').val();
    }
});

$('.started_at').datepicker({
    uiLibrary: 'bootstrap4',
    icons: {
        rightIcon: '<i class="far fa-calendar-alt"></i>'
    },
    format: 'yyyy/mm/dd',
    maxDate: function () {
        return $(this).parents('.modal-body').find('.finished_at').val();
    }
});

$('.finished_at').datepicker({
    uiLibrary: 'bootstrap4',
    icons: {
        rightIcon: '<i class="far fa-calendar-alt"></i>'
    },
    format: 'yyyy/mm/dd',
    minDate: function () {
        return $(this).parents('.modal-body').find('.started_at').val();
    }
});
