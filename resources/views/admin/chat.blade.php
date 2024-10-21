<x-admin-layout>
    <style>
        .user-list-item.selected {
            background-color: #e2e8f0; /* Light gray background */
            border-left: 4px solid #e5c846; /* Add a left border for emphasis */
        }
    </style>
    <div class="flex h-screen w-full">
        <!-- Sidebar -->
        <div class="w-2/5 p-4 border-r border-gray-200 overflow-y-auto">
            <h3 class="text-lg font-semibold mb-4">Clients</h3>
            <div id="user-list" class="space-y-2">
                <!-- User list items will be populated here -->
            </div>
        </div>

        <!-- Chat Container -->
        <div class="w-3/5 flex flex-col">
            <div class="flex flex-col h-full border border-gray-200 bg-gray-100">
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
    </div>

    <script>
        window.authUserId = @json(auth()->id());
        window.authUserType = @json(auth()->user()->usertype);
        let currentReceiverId = null;
    
        async function fetchUserList() {
            try {
                const response = await fetch('/get-users');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const users = await response.json();
                const userList = document.getElementById('user-list');
    
                userList.innerHTML = '';
    
                // Fetch unread message counts for all users
                const unreadCountsResponse = await fetch('/get-unread-message-counts');
                const unreadCounts = await unreadCountsResponse.json();
                const unreadCountsMap = Object.fromEntries(unreadCounts.map(item => [item.sender_id, item.message_count]));
    
                users.forEach(user => {
                    // Concatenate first name and last name, or fallback to name
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
    
                        // Fetch messages for the selected user
                        await fetchMessages();
    
                        // Mark the messages as read for the selected user
                        await markMessagesAsRead(user.id);  // Pass the sender's user ID here
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

        // Function to poll for updates
        // function startPolling() {
        //     // Fetch user list every 5 seconds
        //     setInterval(fetchUserList, 5000); // Adjust time as needed
        // }

        // // Initial call to fetch the user list and start polling
        // document.addEventListener('DOMContentLoaded', function() {
        //     fetchUserList(); // Initial fetch
        //     startPolling(); // Start polling for updates
        // });
    
        async function fetchMessages() {
            if (!currentReceiverId) return;
    
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
            setInterval(fetchMessages, 2000);
        });
    </script>
    
</x-admin-layout>
