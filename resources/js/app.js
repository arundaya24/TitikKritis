import './bootstrap';

console.log('SUBSCRIBING USER:', window.currentUserId);

if (window.Echo && window.currentUserId) {
    window.Echo.private(`App.Models.User.${window.currentUserId}`)
        .notification((notification) => {
            console.log('REALTIME NOTIFICATION:', notification);

            const bell = document.querySelector('.notif-bell-link');
            const dropdown = document.querySelector('.notif-dropdown-menu');

            if (!bell || !dropdown) {
                return;
            }

            let badge = document.querySelector('.notif-badge');

            if (badge) {
                let count = parseInt(badge.textContent) || 0;
                count++;
                badge.textContent = count > 9 ? '9+' : count;
            } else {
                badge = document.createElement('span');
                badge.className = 'badge rounded-pill bg-danger notif-badge';
                badge.textContent = '1';
                bell.appendChild(badge);
            }

            const emptyMessage = dropdown.querySelector('.notif-empty');

            if (emptyMessage) {
                emptyMessage.closest('li')?.remove();
            }

            const message =
                notification.message ??
                notification.data?.message ??
                'Notifikasi baru';

            const item = document.createElement('li');
            item.className = 'notif-item-wrapper';

            const form = document.createElement('form');
            form.method = 'POST';
            form.className = 'm-0 flex-grow-1';

            if (window.notificationReadUrlTemplate && notification.id) {
                form.action = window.notificationReadUrlTemplate.replace(
                    '__NOTIFICATION_ID__',
                    notification.id
                );
            }

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';

            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]'
            );

            csrf.value = csrfToken ? csrfToken.content : '';

            form.appendChild(csrf);

            const button = document.createElement('button');
            button.type = 'submit';
            button.className =
                'dropdown-item notif-item notif-unread py-2';

            const messageDiv = document.createElement('div');
            messageDiv.className = 'small';
            messageDiv.textContent = message;

            const timeDiv = document.createElement('div');
            timeDiv.className = 'text-muted';
            timeDiv.style.fontSize = '0.75rem';
            timeDiv.textContent = 'Baru saja';

            button.appendChild(messageDiv);
            button.appendChild(timeDiv);

            form.appendChild(button);
            item.appendChild(form);

            const divider = dropdown
                .querySelector('.dropdown-divider')
                ?.closest('li');

            if (divider) {
                divider.after(item);
            } else {
                dropdown.appendChild(item);
            }
        });
}
