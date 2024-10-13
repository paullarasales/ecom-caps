<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex h-screen w-full">
                    <!-- Sidebar -->
                    <div class="w-2/5 p-4 border-r border-gray-200 overflow-y-auto">
                        <h3 class="text-lg font-semibold mb-4">Messages</h3>
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
            </div>
        </div>
    </div>

    <script>
        window.authUserId = @json(auth()->id());
        window.authUserType = @json(auth()->user()->usertype);
        let currentReceiverId = null;

        async function fetchUserList() {
        try {
            const response = await fetch('/get-managers'); // Call the correct endpoint
            if (!response.ok) {
                console.error('Error fetching user list:', response.statusText);
                return; // Stop execution if response is not OK
            }

            const users = await response.json();
            console.log('Fetched users:', users); // Log the fetched users
            const userList = document.getElementById('user-list');

            userList.innerHTML = '';

            // Check if there are users returned
            if (users.length > 0) {
                const user = users[0]; // Assuming the response contains one manager
                const userElement = document.createElement('div');
                userElement.className = 'user-list-item p-2 rounded-md cursor-pointer transition duration-300 ease-in-out hover:bg-gray-200';
                userElement.textContent = 'The Siblings Catering Services';
                userElement.dataset.userId = user.id;

                userElement.addEventListener('click', () => {
                    currentReceiverId = user.id;
                    fetchMessages();
                });

                userList.appendChild(userElement);
            } else {
                console.log('No managers found.'); // Log if no users are found
            }
        } catch (error) {
            console.error('Error fetching user list:', error);
        }
    }


    async function fetchMessages() {
    try {
        const response = await fetch(`/get-messages-for-user`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const messages = await response.json();
        const messageList = document.getElementById('message-list');

        messageList.innerHTML = '';

        messages.forEach(msg => {
            const msgElement = document.createElement('div');
            msgElement.className = `message p-2 rounded-md max-w-max break-words ${
                msg.sender_id === window.authUserId ? 'bg-yellow-100 border border-gray-200 text-right ml-auto' : 'bg-gray-200 text-left mr-auto border border-yellow-300'
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
                        body: JSON.stringify({ message, receiver_id: currentReceiverId }) // Send to manager
                    });
                    messageInput.value = '';
                    fetchMessages();
                }
            });

            fetchUserList();
            setInterval(fetchMessages, 2000);
        });
    </script>
</x-app-layout>
