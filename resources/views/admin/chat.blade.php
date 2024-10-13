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
                    <input type="text" id="message-input" placeholder="Type a message" class="flex-1 p-2 border border-gray-200 rounded-md mr-2">
                    <button id="send-button" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
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

                users.forEach(user => {
                    // Concatenate first name and last name, or fallback to name
                    const displayName = (user.firstname && user.lastname) 
                        ? `${user.firstname} ${user.lastname}` 
                        : user.name;

                    const userElement = document.createElement('div');
                    userElement.className = 'user-list-item capitalize p-2 rounded-md cursor-pointer transition duration-300 hover:bg-gray-200';
                    userElement.textContent = displayName;  // Use displayName instead of user.name
                    userElement.dataset.userId = user.id;

                    userElement.addEventListener('click', () => {

                        // Remove highlight from previously selected user
                        const previouslySelected = document.querySelector('.user-list-item.selected');
                        if (previouslySelected) {
                            previouslySelected.classList.remove('selected');
                        }

                        // Highlight the currently selected user
                        userElement.classList.add('selected');

                        currentReceiverId = user.id;
                        fetchMessages();
                    });

                    userList.appendChild(userElement);
                });
            } catch (error) {
                console.error('Error fetching user list:', error);
            }
        }


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
