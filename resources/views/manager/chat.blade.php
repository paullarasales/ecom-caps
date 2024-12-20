<x-manager-layout>
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
    
    <div class="flex h-[80vh]  w-full">
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

        async function fetchUserList() {
            try {
                const response = await fetch('/get-users');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const users = await response.json();
                const userList = document.getElementById('user-list');

                userList.innerHTML = '';

                const filteredUsers = users;

                // Fetch unread message counts for all users
                const unreadCountsResponse = await fetch('/get-unread-message-counts');
                const unreadCounts = await unreadCountsResponse.json();
                const unreadCountsMap = Object.fromEntries(unreadCounts.map(item => [item.sender_id, item.message_count]));

                filteredUsers.forEach(user => {
                    const displayName = (user.firstname && user.lastname) 
                        ? `${user.firstname} ${user.lastname}` 
                        : user.name;

                    const unreadCount = unreadCountsMap[user.id] || 0;

                    const userElement = document.createElement('div');
                    userElement.className = 'relative user-list-item capitalize p-2 rounded-md cursor-pointer transition duration-300 hover:bg-gray-200';
                    userElement.textContent = displayName;  // Display name only
    
                    // Create the unread count badge
                    const badge = document.createElement('span');
                    badge.className = `absolute top-2 right-3 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold messagenotification-badge ${unreadCount > 0 ? '' : 'hidden'}`;
                    badge.textContent = unreadCount; // Set the unread count
    
                    // Append badge to the user element
                    userElement.appendChild(badge); 
                    userElement.dataset.userId = user.id;

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
                        await fetchMessages(); // Fetch messages for the selected user
                        await markMessagesAsRead(user.id);  // Pass the receiver's user ID here

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
        async function markMessagesAsRead(receiverId) {
            try {
                const response = await fetch(`/mark-messages-as-read/${currentReceiverId}`, { // Send sender's ID
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ receiverId })  // Send receiver's ID as well
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
    if (!currentReceiverId) return;

    try {
        const response = await fetch(`/get-messages-for-managers?receiver_id=${currentReceiverId}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const messages = await response.json();
        const messageList = document.getElementById('message-list');

        messageList.innerHTML = '';

        messages.forEach(msg => {
            const msgElement = document.createElement('div');
            const senderName = document.createElement('div');

            // Determine the sender type
            const isSenderAuthManager = msg.sender.id === window.authUserId;
            const isSenderFellowManager = msg.sender.usertype === 'manager' && !isSenderAuthManager;
            const isChattingWithManager = currentReceiverId === msg.sender.id && msg.sender.usertype === 'manager';
            const isSenderUser = msg.sender.id === currentReceiverId && msg.sender.usertype === 'user';
            const isSenderadmin = msg.sender.id === currentReceiverId && msg.sender.usertype === 'admin';
            const isSenderowner = msg.sender.id === currentReceiverId && msg.sender.usertype === 'owner';

            // Style messages based on the sender
            if (isSenderAuthManager) {
                // Authenticated manager's messages
                msgElement.className = 'message p-2 rounded-md max-w-max break-words bg-green-200 text-right ml-auto';
            } else if (isChattingWithManager) {
                // Messages from a fellow manager being chatted with
                msgElement.className = 'message p-2 rounded-md max-w-max break-words bg-gray-200 text-left mr-auto border border-yellow-300';
            } else if (isSenderFellowManager) {
                // Messages from other fellow managers
                msgElement.className = 'message p-2 rounded-md max-w-max break-words bg-green-200 text-left mr-auto';
            } else if (isSenderUser) {
                // Messages from the selected user
                msgElement.className = 'message p-2 rounded-md max-w-max break-words bg-gray-200 text-left mr-auto border border-yellow-300';
            } else if (isSenderadmin) {
                // Messages from the selected user
                msgElement.className = 'message p-2 rounded-md max-w-max break-words bg-gray-200 text-left mr-auto border border-yellow-300';
            } else if (isSenderowner) {
                // Messages from the selected user
                msgElement.className = 'message p-2 rounded-md max-w-max break-words bg-gray-200 text-left mr-auto border border-yellow-300';
            }

            msgElement.textContent = msg.content;

            // // Append sender name only if the selected person is a user
            // if (isSenderUser) {
            //     senderName.className = `text-sm font-semibold ${
            //         isSenderAuthManager ? 'text-right text-green-700' : 'text-left text-yellow-700'
            //     }`;

            //     let senderText = '';
            //     if (msg.sender.firstname && msg.sender.lastname) {
            //         senderText = `Sent by: ${msg.sender.firstname} ${msg.sender.lastname}`;
            //     } else if (msg.sender.firstname) {
            //         senderText = `Sent by: ${msg.sender.firstname}`;
            //     } else if (msg.sender.lastname) {
            //         senderText = `Sent by: ${msg.sender.lastname}`;
            //     } else {
            //         senderText = `Sent by: ${msg.sender.name}`;
            //     }

            //     senderName.textContent = senderText;
            //     messageList.appendChild(senderName);
            // }

            messageList.appendChild(msgElement);
        });

        // Scroll to the latest message
        messageList.scrollTop = messageList.scrollHeight;
    } catch (error) {
        console.error('Error fetching messages:', error);
    }
}




        async function sendMessage() {
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value;

            if (message.trim() !== '' && currentReceiverId) { // Ensure a receiver is selected
                await fetch('/send-message-to-user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message, receiver_id: currentReceiverId })
                });
                messageInput.value = '';
                fetchMessages(); // Optionally refresh the messages after sending
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('send-button');

            button.addEventListener('click', sendMessage);
            fetchUserList();
            setInterval(fetchMessages, 2000);
        });
    </script>
</x-manager-layout>
