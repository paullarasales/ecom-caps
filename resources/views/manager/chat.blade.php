<x-manager-layout>
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

                const filteredUsers = users.filter(user => user.usertype !== 'manager');

                filteredUsers.forEach(user => {
                    const displayName = (user.firstname && user.lastname) 
                        ? `${user.firstname} ${user.lastname}` 
                        : user.name;

                    const userElement = document.createElement('div');
                    userElement.className = 'user-list-item p-2 rounded-md cursor-pointer transition duration-300 hover:bg-gray-200';
                    userElement.textContent = displayName; 
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

            const isSenderManager = msg.sender.usertype === 'manager';

            msgElement.className = `message p-2 rounded-md max-w-max break-words ${isSenderManager ? 'bg-green-200 text-right ml-auto' : 'bg-gray-200 text-left mr-auto border border-yellow-300'}`;
            msgElement.textContent = msg.content;

            senderName.className = `text-sm font-semibold ${isSenderManager ? 'text-right text-green-700' : 'text-left text-yellow-700'}`;
            let senderText = '';

            if (msg.sender.firstname && msg.sender.lastname) {
                senderText = `Sent by: ${msg.sender.firstname} ${msg.sender.lastname}`;
            } else if (msg.sender.firstname) {
                senderText = `Sent by: ${msg.sender.firstname}`;
            } else if (msg.sender.lastname) {
                senderText = `Sent by: ${msg.sender.lastname}`;
            } else {
                senderText = `Sent by: ${msg.sender.name}`;
            }

            senderName.textContent = senderText;

            messageList.appendChild(senderName);
            messageList.appendChild(msgElement);
        });

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
