// Function to fetch unread notification count
function fetchUnreadCount() {
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notification-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        });
}

// Function to fetch latest notifications
function fetchLatestNotifications() {
    fetch('/notifications/latest')
        .then(response => response.json())
        .then(data => {
            const notificationList = document.getElementById('notification-list');
            if (!notificationList) return;
            
            if (data.notifications.length === 0) {
                notificationList.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">No new notifications</div>';
                return;
            }
            
            let html = '';
            data.notifications.forEach(notification => {
                const isRead = notification.read ? 'text-gray-500' : 'font-semibold';
                html += `
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 ${isRead}" 
                       onclick="markAsRead(${notification.id}); return false;">
                        <div class="text-sm">${notification.message}</div>
                        <div class="text-xs text-gray-500">${timeAgo(new Date(notification.created_at))}</div>
                    </a>
                `;
            });
            
            notificationList.innerHTML = html;
        });
}

// Function to mark notification as read
function markAsRead(id) {
    fetch(`/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchUnreadCount();
            fetchLatestNotifications();
        }
    });
}

// Helper function to format time ago
function timeAgo(date) {
    const seconds = Math.floor((new Date() - date) / 1000);
    
    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + " years ago";
    
    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + " months ago";
    
    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + " days ago";
    
    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + " hours ago";
    
    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + " minutes ago";
    
    return Math.floor(seconds) + " seconds ago";
}

// Make functions globally available
window.fetchLatestNotifications = fetchLatestNotifications;
window.markAsRead = markAsRead;

// Initialize everything when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    fetchUnreadCount();
    fetchLatestNotifications();
});