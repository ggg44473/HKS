var dragulaCards = dragula([
    document.querySelector('#dragCard'),
    document.querySelector('#dragCarddone'),
]);

var sort;
var sortDone;

dragulaCards.on('drop', function (el, target) {
    var children = Array.from($('#dragCard').children());
    var childrenDone = Array.from($('#dragCarddone').children());
    children.forEach(function (item, index) {
        sort[index] = item.id;
    });
    childrenDone.forEach(function (item, index) {
        sortDone[index] = item.id;
    });
    setCookie('sort', sort);
    setCookie('sortDone', sortDone);
});

$(function () {
    sort = getCookie('sort') ? getCookie('sort').split(',') : [];
    var elements = [];
    $.each(sort, function (i, position) {
        elements.push(document.getElementById(position));
    });
    $('#dragCard').append(elements);

    sortDone = getCookie('sortDone') ? getCookie('sortDone').split(',') : [];
    var elements2 = [];
    $.each(sortDone, function (i, position) {
        elements2.push(document.getElementById(position));
    });
    $('#dragCarddone').append(elements2);
});

$('.projectDone').on('click', function () {
    var index = getCookie('sort') ? getCookie('sort').split(',').indexOf($(this).parents('.projectCard').attr('id')) : -1;
    if (index > -1) {
        sort.splice(index, 1);
        setCookie('sort', sort);
    }
    var indexDone = getCookie('sortDone') ? getCookie('sortDone').split(',').indexOf($(this).parents('.projectCard').attr('id')) : -1;
    if (indexDone > -1) {
        sortDone.splice(indexDone, 1);
        setCookie('sortDone', sortDone);
    }
});

function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}
