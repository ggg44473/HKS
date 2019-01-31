var userId = document.getElementById('userName').dataset.uid;

var notificationsWrapper = $('.dropdown-notifications');
var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
var notificationsCountElem = notificationsToggle.find('i[data-count]');
var notificationsCount = parseInt(notificationsCountElem.data('count'));
var notifications = notificationsWrapper.find('ul.dropdown-content');

function addNotification(notification) {
    var existingNotifications = notifications.html();
    var avatar = notification.data.icon;
    var newNotificationHtml = `
      <li class="notification active">
      <a href="${notification.data.link}?readNid=${notification.id}">
          <div class="media">
            <div class="media-left">
              <div class="media-object">
                <img src="${avatar}" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
              </div>
            </div>
            <div class="media-body">
              <strong class="notification-title">` + notification.data.message + `</strong>
              <!--p class="notification-desc">Extra description can go here</p-->
              <div class="notification-meta">
                <small class="timestamp">` + notification.created_at + `</small>
              </div>
            </div>
          </div>
          </a>
      </li>
    `;
    notifications.html(newNotificationHtml + existingNotifications);

    notificationsCount += 1;
    notificationsCountElem.attr('data-count', notificationsCount);
    notificationsWrapper.find('.notif-count').text(notificationsCount);
}

$(document).ready(function () {
    axios.get('/notifications').then(({
        data
    }) => {
        data.reverse().forEach(notification => {
            addNotification(notification.data);
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
