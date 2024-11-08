<x-owner-layout>
    <style>
        .user-list-item.selected {
            background-color: #e2e8f0; /* Light gray background */
            border-left: 4px solid #e5c846; /* Add a left border for emphasis */
        }

        /* Hide sidebar on small screens */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .sidebar.show {
                display: block;
            }

            .chat-container.show {
                display: block;
                width: 100%;
            }

            .chat-container {
                display: none;
                width: 100%;
            }
        }

        /* Ensure chat container is full height */
        .chat-container {
            height: 100%;
        }
    </style>
    <div class="flex h-[80vh] w-full">
        <!-- Sidebar (User List) -->
        <div id="sidebar" class="sidebar lg:w-2/5 w-full mt-10 p-4 border-r border-gray-200 overflow-y-auto">
            <h3 class="text-lg font-semibold mb-4">User List</h3>
            <div id="user-list" class="space-y-2">
                <!-- User list items will be populated here -->
            </div>
        </div>

        <!-- Chat Container -->
        <div id="chat-container" class="chat-container w-full flex flex-col border-l border-gray-200 bg-gray-100">
            <div class="flex flex-col h-full">
                <!-- User name section (added this part) -->
                <div id="chat-header" class="p-4 border-b border-gray-200 bg-gray-200 flex justify-center items-center">
                    <h3 id="selected-user-name" class="text-lg font-semibold sm:ml-5">Select a user to chat</h3>
                </div>
                
                <div id="message-list" class="flex-1 overflow-y-auto p-4 space-y-2">
                    <!-- Messages will be populated here -->
                </div>
                <div class="flex p-4 border-t border-gray-200 bg-white">
                    <input type="text" id="message-input" placeholder="Type a message" class="flex-1 p-2 border border-gray-200 rounded-md mr-2 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                    <button id="send-button" class="ml-2 px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Send
                    </button>
                </div>
            </div>
        </div>

        <!-- Hamburger Button (Visible on small screens) -->
        <button id="hamburger-button" class="lg:hidden p-2  text-gray-900 font-bold text-xl rounded-full absolute top-4 left-4 z-10">
            &#9776;
        </button>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.authUserId = @json(auth()->id());
        window.authUserType = @json(auth()->user()->usertype);
        let currentReceiverId = null;
        let currentReceiverName = null; // Variable to store the selected user's name
        let sidebarVisible = false;

        // Toggle Sidebar Visibility
        document.getElementById('hamburger-button').addEventListener('click', function () {
            sidebarVisible = !sidebarVisible;
            const sidebar = document.getElementById('sidebar');
            const chatContainer = document.getElementById('chat-container');
            sidebar.classList.toggle('show', sidebarVisible);
            chatContainer.classList.toggle('show', !sidebarVisible);
        });

        let messagesCache = {}; // Cache for messages

        async function fetchUserList() {
            try {
                const response = await fetch('/get-users'); // Fetch users, admins, managers, and owners
                if (!response.ok) {
                    console.error('Error fetching user list:', response.statusText);
                    return;
                }

                const users = await response.json();
                const userList = document.getElementById('user-list');
                userList.innerHTML = '';

                // Fetch unread message counts for all users
                const unreadCountsResponse = await fetch('/get-unread-message-counts');
                const unreadCounts = await unreadCountsResponse.json();
                const unreadCountsMap = Object.fromEntries(unreadCounts.map(item => [item.sender_id, item.message_count]));

                users
                    .filter(user => user.usertype !== 'user') // Exclude users with usertype 'user'
                    .forEach(user => {
                        const userElement = document.createElement('div');
                        userElement.className = 'relative user-list-item capitalize p-2 rounded-md cursor-pointer transition duration-300 ease-in-out hover:bg-gray-200';
                        userElement.textContent = user.name;
                        userElement.dataset.userId = user.id;
                        const displayName = (user.firstname && user.lastname) 
                        ? `${user.firstname} ${user.lastname}` 
                        : user.name;

                        // Create the unread count badge
                        const unreadCount = unreadCountsMap[user.id] || 0;
                        if (unreadCount > 0) {
                            const badge = document.createElement('span');
                            badge.className = 'absolute top-2 right-3 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold';
                            badge.textContent = unreadCount; // Set the unread count
                            userElement.appendChild(badge);
                        }

                        userElement.addEventListener('click', async () => {
                            // Remove highlight from previously selected user
                            const previouslySelected = document.querySelector('.user-list-item.selected');
                            if (previouslySelected) {
                                previouslySelected.classList.remove('selected');
                            }

                            // Highlight the currently selected user
                            userElement.classList.add('selected');
                            
                            currentReceiverId = user.id;
                            currentReceiverName = displayName; // Save the selected user's name

                            // Update the chat header with the selected user's name
                            document.getElementById('selected-user-name').textContent = `${currentReceiverName}`;

                            // Fetch messages for the selected user
                            await fetchMessages();

                            // Mark messages as read for the selected user
                            await markMessagesAsRead(user.id);  // Pass the user's ID here

                            if (window.innerWidth <= 768) {
                            document.getElementById('sidebar').classList.remove('show');
                            document.getElementById('chat-container').classList.add('show');
                        }
                        });

                        userList.appendChild(userElement);
                    });
            } catch (error) {
                console.error('Error fetching user list:', error);
            }
        }

        // Function to mark messages as read
        async function markMessagesAsRead(senderId) {
            try {
                const response = await fetch(`/mark-messages-as-read/${senderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ receiverId: window.authUserId })  // Send receiver's ID as well
                });

                if (!response.ok) {
                    throw new Error('Failed to mark messages as read');
                }

                // Optionally refresh unread counts after marking as read
                await fetchUserList();
            } catch (error) {
                console.error('Error marking messages as read:', error);
            }
        }

        async function fetchMessages() {
            if (!currentReceiverId) {
                console.error('No receiver selected.');
                return;
            }

            // Check if messages are already cached
            if (messagesCache[currentReceiverId]) {
                displayMessages(messagesCache[currentReceiverId]);
                return; // Skip fetching from server if we have cached messages
            }

            try {
                const response = await fetch(`/get-messages?receiver_id=${currentReceiverId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const messages = await response.json();
                const messageList = document.getElementById('message-list');
                messageList.innerHTML = '';

                messages.forEach(msg => {
                    const msgElement = document.createElement('div');
                    msgElement.className = `message p-2 rounded-md max-w-max break-words ${
                        msg.sender_id === window.authUserId ? 'bg-green-200 text-right ml-auto' : 'bg-gray-200 text-left mr-auto border border-yellow-300'
                    }`;
                    msgElement.textContent = msg.content;
                    messageList.appendChild(msgElement);
                });

                messageList.scrollTop = messageList.scrollHeight;
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        }

        function displayMessages(messages) {
    const messageList = document.getElementById('message-list');
    messageList.innerHTML = '';

    messages.forEach(msg => {
        const msgElement = document.createElement('div');
        msgElement.className = `message p-2 rounded-md max-w-max break-words ${
            msg.sender_id === window.authUserId ? 'bg-green-200 text-right ml-auto' : 'bg-gray-200 text-left mr-auto border border-yellow-300'
        }`;
        msgElement.textContent = msg.content;
        messageList.appendChild(msgElement);
    });

    messageList.scrollTop = messageList.scrollHeight;
}

        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('send-button');

            button.addEventListener('click', async () => {
                const messageInput = document.getElementById('message-input');
                const message = messageInput.value;

                if (message.trim() !== '' && currentReceiverId) {
                    await fetch('/send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message, receiver_id: currentReceiverId })
                    });
                    messageInput.value = '';
                    fetchMessages();
                }
            });

            fetchUserList();
            setInterval(fetchMessages, 2000); // Update messages every 2 seconds
        });
    </script>
</x-owner-layout>
