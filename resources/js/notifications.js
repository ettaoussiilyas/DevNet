// Function to fetch latest notifications
function fetchLatestNotifications() {
    fetch('/notifications/latest')
        .then(response => response.json())
        .then(data => {
            const notificationList = document.getElementById('notification-list');
            if (!notificationList) return;
            
            if (data.notifications.length === 0) {
                notificationList.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">No notifications</div>';
                return;
            }
            
            let html = '';
            data.notifications.forEach(notification => {
                const isRead = notification.read ? 'bg-white' : 'bg-[#E1EACD]/30';
                const textColor = notification.read ? 'text-gray-600' : 'text-[#8D77AB] font-semibold';
                
                const url = notification.post_id ? `/posts/${notification.post_id}` : '#';
                
                html += `
                    <a href="${url}" class="block px-4 py-3 hover:bg-gray-50 ${isRead} border-b border-gray-100" 
                       onclick="if(!event.target.classList.contains('mark-read-btn')) markAsRead(${notification.id})">
                        <div class="flex items-start">
                            <div class="flex-grow">
                                <p class="${textColor} text-sm">${notification.message}</p>
                                <p class="text-xs text-gray-400 mt-1">${notification.created_at}</p>
                            </div>
                            <button class="mark-read-btn ml-2 text-xs text-gray-400 hover:text-[#8D77AB]" 
                                    onclick="event.preventDefault(); markAsRead(${notification.id})">
                                ${notification.read ? '' : 'Mark as read'}
                            </button>
                        </div>
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

// Function to mark all notifications as read
function markAllAsRead() {
    fetch('/notifications/mark-all-as-read', {
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

// Function to fetch unread notification count
const fetchUnreadCount = () => {
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
};

// Make functions globally available
window.fetchLatestNotifications = fetchLatestNotifications;
window.markAsRead = markAsRead;
window.markAllAsRead = markAllAsRead;
window.fetchUnreadCount = fetchUnreadCount;

// Initialize everything when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only fetch notifications if we're on a page that has the notification elements
    const notificationBadge = document.getElementById('notification-badge');
    
    if (notificationBadge) {
        fetchUnreadCount();
        
        // Add click event to notification icon to load notifications when clicked
        const notificationTrigger = notificationBadge.closest('button');
        if (notificationTrigger) {
            notificationTrigger.addEventListener('click', function() {
                fetchLatestNotifications();
            });
        }
    }
});