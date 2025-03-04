import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Set up axios defaults
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Wait for DOM to be loaded before setting up Echo and notification listeners
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Echo configuration
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true
    });

    // Only set up notification listener if userId exists
    if (window.userId) {
        window.Echo.private(`notifications.${window.userId}`)
            .listen('.notification.received', (data) => {
                // Update the notification badge
                const badge = document.getElementById('notification-badge');
                if (badge) {
                    const currentCount = parseInt(badge.textContent || '0');
                    badge.textContent = currentCount + 1;
                    badge.style.display = 'flex';
                }
                
                // Check if fetchLatestNotifications exists before calling
                if (typeof window.fetchLatestNotifications === 'function') {
                    window.fetchLatestNotifications();
                }
            });
    }
});