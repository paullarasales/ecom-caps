<x-manager-layout>
    <style>
        #chat-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #e2e8f0; 
            background-color: #f7fafc; 
        }

        #message-list {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin: 10px 0;
        }

        .message {
            padding: 0.5rem;
            border-radius: 0.375rem;
            max-width: 70%;
            word-wrap: break-word;
        }

        .sender {
            align-self: flex-end;
            background-color: #d1fae5; 
            text-align: right;
            margin-right: 20px;
        }

        .receiver {
            align-self: flex-start;
            background-color: #edf2f7;
            text-align: left;
            margin-left: 20px;
            border: 1px solid yellow;
        }

        #message-input-container {
            display: flex;
            padding: 1rem;
            border-top: 1px solid #e2e8f0; 
            background-color: #ffffff;
        }

        #message-input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #e2e8f0; 
            border-radius: 0.375rem;
        }

        #send-button {
            margin-left: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #2563eb;
        }

        #container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        #sidebar {
            width: 40%;
            padding: 1rem;
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
        }

        #chat-container-wrapper {
            width: 60%;
            display: flex;
            flex-direction: column;
        }

        .user-list-item {
        padding: 0.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .user-list-item:hover {
            background-color: #e2e8f0;
        }
    </style>

    <div id="container">
        <!-- Sidebar -->
        <div id="sidebar">
            <h3 class="text-lg font-semibold mb-4">Clients</h3>
            <div id="user-list">
                
            </div>
        </div>

        <!-- Chat Container -->
        <div id="chat-container-wrapper">
            <div id="chat-container">
                <div id="message-list">
                </div>
                <div id="message-input-container">
                    <input type="text" id="message-input" placeholder="Type a message" class="flex-1 mr-2">
                    <button id="send-button">Send</button>
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
                console.log(users);
                const userList = document.getElementById('user-list');

                userList.innerHTML = '';

                users.forEach(user => {
                    const userElement = document.createElement('div');
                    userElement.className = 'user-list-item';
                    userElement.textContent = user.name;
                    userElement.dataset.userId = user.id;

                    userElement.addEventListener('click', () => {
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
                console.log(messages);
                const messageList = document.getElementById('message-list');

                messageList.innerHTML = '';

                messages.forEach(msg => {
                    const msgElement = document.createElement('div');
                    msgElement.className = `message ${msg.sender_id === window.authUserId ? 'sender' : 'receiver'}`;
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
</x-manager-layout>
