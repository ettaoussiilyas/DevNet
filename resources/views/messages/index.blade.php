<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <input type="hidden" id="current-user-id" value="{{ Auth::id() }}">
                    <div class="flex h-[600px]">
                        <!-- Users list -->
                        <div class="w-1/3 border-r border-gray-200 overflow-y-auto">
                            <div class="p-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold">Conversations</h2>
                            </div>
                            <div id="users-list" class="divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <div class="user-item p-4 hover:bg-gray-50 cursor-pointer" data-user-id="{{ $user['id'] }}">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $user['image']) }}" alt="{{ $user['name'] }}">
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm font-medium text-gray-900">{{ $user['name'] }}</p>
                                                    @if($user['last_message_time'])
                                                        <p class="text-xs text-gray-500">{{ $user['last_message_time'] }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm text-gray-500 truncate">
                                                        {{ $user['last_message'] ?? 'No messages yet' }}
                                                    </p>
                                                    @if($user['unread_count'] > 0)
                                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-[#8D77AB] rounded-full">
                                                            {{ $user['unread_count'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-gray-500">
                                        No conversations found
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Chat area -->
                        <div class="w-2/3 flex flex-col">
                            <div id="chat-header" class="p-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold">Select a conversation</h2>
                            </div>
                            
                            <div id="messages-container" class="flex-1 p-4 overflow-y-auto">
                                <!-- Messages will be loaded here -->
                                <div class="flex justify-center items-center h-full text-gray-500">
                                    Select a user to start messaging
                                </div>
                            </div>
                            
                            <div id="message-form" class="p-4 border-t border-gray-200 hidden">
                                <form id="send-message-form" class="flex">
                                    <input type="text" id="message-input" class="flex-1 rounded-l-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Type your message...">
                                    <button type="submit" class="bg-[#8D77AB] text-white px-4 py-2 rounded-r-md hover:bg-[#8D77AB]/90">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    
        // Add a simple loading indicator style
        const style = document.createElement('style');
        style.textContent = `
            .loader {
                border: 3px solid #f3f3f3;
                border-radius: 50%;
                border-top: 3px solid #8D77AB;
                width: 30px;
                height: 30px;
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    
        // Add this right after the DOMContentLoaded event
        document.addEventListener('DOMContentLoaded', function() {
            
            loadUsers();
            updateMessageBadge();
            
            // Add click handlers to initial user items
            document.querySelectorAll('.user-item').forEach(item => {
                item.addEventListener('click', function() {
                    console.log('Initial user item clicked:', this.getAttribute('data-user-id'));
                    selectedUserId = parseInt(this.getAttribute('data-user-id'));
                    loadConversation(selectedUserId);
                    
                    // Highlight selected user
                    document.querySelectorAll('.user-item').forEach(el => {
                        el.classList.remove('bg-gray-100');
                    });
                    this.classList.add('bg-gray-100');
                });
            });
        });
        
        let currentUserId = parseInt(document.getElementById('current-user-id').value);
        let selectedUserId = null;
        
        // Function to update message badge count
        function updateMessageBadge() {
            fetch('/messages/unread-count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('messages-badge');
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
        
        function loadUsers() {
            console.log('Fetching users...');
            fetch('/messages/users')
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Users data:', data);
                    const usersList = document.getElementById('users-list');
                    usersList.innerHTML = '';
                    
                    if (!data.users || data.users.length === 0) {
                        usersList.innerHTML = `
                            <div class="p-4 text-center text-gray-500">
                                No connected users found. Connect with other users to start messaging.
                            </div>
                        `;
                        return;
                    }
                    
                    data.users.forEach(user => {
                        const lastMessage = user.last_message ? user.last_message : 'No messages yet';
                        const lastMessageTime = user.last_message_time ? new Date(user.last_message_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                        const unreadBadge = user.unread_count > 0 ? `<span class="bg-red-500 text-white text-xs rounded-full px-2 py-1">${user.unread_count}</span>` : '';
                        
                        usersList.innerHTML += `
                            <div class="user-item p-4 hover:bg-gray-100 cursor-pointer ${selectedUserId === user.id ? 'bg-gray-100' : ''}" data-user-id="${user.id}">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                                            ${user.image ? `<img src="/storage/${user.image}" alt="${user.name}" class="w-full h-full object-cover">` : user.name.charAt(0)}
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-semibold">${user.name}</div>
                                            <div class="text-sm text-gray-500 truncate w-40">${lastMessage}</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="text-xs text-gray-500">${lastMessageTime}</div>
                                        ${unreadBadge}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Add click event to user items
                    document.querySelectorAll('.user-item').forEach(item => {
                        item.addEventListener('click', function() {
                            console.log('User item clicked directly:', this.getAttribute('data-user-id'));
                            selectedUserId = parseInt(this.getAttribute('data-user-id'));
                            loadConversation(selectedUserId);
                            
                            // Highlight selected user
                            document.querySelectorAll('.user-item').forEach(el => {
                                el.classList.remove('bg-gray-100');
                            });
                            this.classList.add('bg-gray-100');
                        });
                    });
                });
        }
        
        // Load conversation with selected user
        function loadConversation(userId) {
            console.log('Loading conversation for user ID:', userId);
            
            // Show loading indicator
            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.innerHTML = '<div class="flex justify-center items-center h-full"><div class="loader">Loading...</div></div>';
            
            fetch(`/messages/conversation/${userId}`)
                .then(response => {
                    console.log('Conversation response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Conversation data:', data);
                    const chatHeader = document.getElementById('chat-header');
                    const messageForm = document.getElementById('message-form');
                    
                    // Update chat header
                    chatHeader.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                                ${data.user.image ? `<img src="/storage/${data.user.image}" alt="${data.user.name}" class="w-full h-full object-cover">` : data.user.name.charAt(0)}
                            </div>
                            <h2 class="text-lg font-semibold ml-3">${data.user.name}</h2>
                        </div>
                    `;
                    
                    // Show message form
                    messageForm.classList.remove('hidden');
                    
                    // Display messages
                    messagesContainer.innerHTML = '';
                    
                    if (data.messages.length === 0) {
                        messagesContainer.innerHTML = `
                            <div class="flex justify-center items-center h-full text-gray-500">
                                No messages yet. Start a conversation!
                            </div>
                        `;
                    } else {
                        data.messages.forEach(message => {
                            const isCurrentUser = parseInt(message.sender_id) === currentUserId;
                            const messageTime = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                            
                            messagesContainer.innerHTML += `
                                <div class="mb-4 ${isCurrentUser ? 'text-right' : ''}">
                                    <div class="inline-block max-w-[70%] ${isCurrentUser ? 'bg-[#8D77AB] text-white' : 'bg-gray-200'} rounded-lg px-4 py-2">
                                        <div>${message.content}</div>
                                        <div class="text-xs ${isCurrentUser ? 'text-gray-200' : 'text-gray-500'} mt-1">${messageTime}</div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        // Scroll to bottom
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                })
                .catch(error => {
                    console.error('Error loading conversation:', error);
                    messagesContainer.innerHTML = `
                        <div class="flex justify-center items-center h-full text-red-500">
                            Error loading conversation. Please try again.
                        </div>
                    `;
                });
        }
        
        // Send message
        document.getElementById('send-message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!selectedUserId) return;
            
            const messageInput = document.getElementById('message-input');
            const content = messageInput.value.trim();
            
            if (content === '') return;
            
            // Send message via AJAX
            fetch(`/messages/send/${selectedUserId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear input
                    messageInput.value = '';
                    
                    // Reload conversation to show the new message
                    loadConversation(selectedUserId);
                }
            });
        });
        
        // Listen for new messages
        window.Echo.private(`messages.${currentUserId}`)
            .listen('.message.received', (e) => {
                console.log('New message received:', e);
                // If we're currently viewing the conversation with the sender, reload it
                if (selectedUserId && selectedUserId == e.sender_id) {
                    loadConversation(selectedUserId);
                } else {
                    // Otherwise just refresh the users list to show new message
                    // Update message badge
                    updateMessageBadge();
                    
                    // Show notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-white shadow-lg rounded-lg p-4 max-w-sm z-50';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                                ${e.sender_image ? `<img src="/storage/${e.sender_image}" alt="${e.sender_name}" class="w-full h-full object-cover">` : e.sender_name.charAt(0)}
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold">${e.sender_name}</div>
                                <div class="text-sm">${e.content}</div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(notification);
                    
                    // Remove notification after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                }
            });
        
        // Refresh unread count every 30 seconds
        setInterval(updateMessageBadge, 30000);
    </script>
    @endpush
</x-app-layout>