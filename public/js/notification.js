var userId = document.getElementById('userName').dataset.uid;

var notificationsWrapper = $('.dropdown-notifications');
var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
var notificationsCountElem = notificationsToggle.find('i[data-count]');
var notificationsCount = parseInt(notificationsCountElem.data('count'));
var notifications = notificationsWrapper.find('ul.dropdown-content');

function addNotification(notification, read_at) {
    var existingNotifications = notifications.html();
    var avatar = notification.data.icon;
    var link = notification.data.link.split("#");
    var newNotificationHtml = `
      <li class="notification active">
    `;
    var readNotificationHtml = `
      <li class="notification">
    `;
    var contentNotification = `
        <a href="${link[0]}?readNid=${notification.id}${link[1] != "undefined" ? "#"+link[1] : ''}">
          <div class="row pt-2 pb-2 w-100">
            <div class="col-auto align-self-center text-center ml-md-4">
              <div class="media-object">
                <img src="${avatar}" class="img-circle avatar-md">
              </div>
            </div>
            <div class="col align-self-center pl-0">
              <strong class="notification-title text-black-50" style=" white-space: pre-wrap; word-wrap: break-word;">` + notification.data.message + `</strong>
              <!--p class="notification-desc">Extra description can go here</p-->
              <div class="notification-meta">
                <small class="timestamp">` + notification.created_at + `</small>
              </div>
            </div>
          </div>
        </a>
      </li>
    `;
    if (read_at != null) {
        notifications.html(readNotificationHtml + contentNotification + existingNotifications);
    } else {
        notifications.html(newNotificationHtml + contentNotification + existingNotifications);
        notificationsCount += 1;
        $('#bell').addClass('notification-icon');
        $('#bell').removeClass('text-muted');
    }

    notificationsCountElem.attr('data-count', notificationsCount);
    notificationsWrapper.find('.notif-count').text(notificationsCount);
}

$(document).ready(function () {
    axios.get('/notifications').then(({
        data
    }) => {
        data.reverse().forEach(notification => {
            addNotification(notification.data, notification.read_at);
        });
    });
});

Echo.private('App.User.' + userId)
    .notification((notification) => {
        addNotification(notification);
        if (('Notification' in window)) {
            if (Notification.permission === 'default' || Notification.permission === 'undefined') {
                Notification.requestPermission(function (permission) {});
            }
            var notify = new Notification('Goal Care', {
                body: notification.data.message,
                icon: notification.data.icon
            });
            notify.onclick = function (notify) { // 綁定點擊事件
                notify.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open(`${notification.data.link}?readNid=${notification.id}`); // 打開特定網頁
            }
        }
    });
