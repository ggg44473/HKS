var userId = document.getElementById('userName').dataset.uid;

var notificationsWrapper = $('.dropdown-notifications');
var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
var notificationsCountElem = notificationsToggle.find('i[data-count]');
var notificationsCount = parseInt(notificationsCountElem.data('count'));
var notifications = notificationsWrapper.find('ul.dropdown-content');

Echo.private('App.User.' + userId)
    .notification((notification) => {
        var existingNotifications = notifications.html();
        var avatar = notification.data.icon;
        var newNotificationHtml = `
            <li class="notification active">
            <a href="${notification.data.link}">
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
                      <small class="timestamp">about a minute ago</small>
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
    });
