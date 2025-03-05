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
                                <!-- Users will be loaded here -->
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
        let currentUserId = parseInt(document.getElementById('current-user-id').value);
        let selectedUserId = null;
        
        // Load users with latest messages
        function loadUsers() {
            fetch('/messages/users')
                .then(response => response.json())
                .then(data => {
                    const usersList = document.getElementById('users-list');
                    usersList.innerHTML = '';
                    
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
                        item.addEventListener('click', () => {
                            selectedUserId = item.dataset.userId;
                            loadConversation(selectedUserId);
                            
                            // Highlight selected user
                            document.querySelectorAll('.user-item').forEach(el => {
                                el.classList.remove('bg-gray-100');
                            });
                            item.classList.add('bg-gray-100');
                        });
                    });
                });
        }
        
        // Load conversation with selected user
        function loadConversation(userId) {
            fetch(`/messages/conversation/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const messagesContainer = document.getElementById('messages-container');
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
                            const isCurrentUser = message.sender_id === currentUserId;
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
                    
                    // Refresh users list to update unread counts
                    loadUsers();
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
                // If we're currently viewing the conversation with the sender, reload it
                if (selectedUserId && selectedUserId == e.sender_id) {
                    loadConversation(selectedUserId);
                } else {
                    // Otherwise just refresh the users list to show new message
                    loadUsers();
                    
                    // Show notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-white shadow-lg rounded-lg p-4 max-w-sm';
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
        
        // Initial load
        loadUsers();
        
        // Refresh users list every 30 seconds
        setInterval(loadUsers, 30000);
    </script>
    @endpush
</x-app-layout>