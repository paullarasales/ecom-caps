<x-admin-layout>
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
        }

        .receiver {
            align-self: flex-start;
            background-color: #edf2f7;
            text-align: left;
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
    </style>

    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="w-1/4 p-4 overflow-y-auto">
            <h3 class="text-lg font-semibold mb-4">Customers</h3>
            <div class="space-y-2">
                
            </div>
        </div>

        <!-- Message Container -->
        <div class="flex-1 bg-gray-100 p-4 overflow-y-auto">
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

        function getReceiverId() {
            const receiverSelect = document.getElementById('receiver-select');
            return receiverSelect ? receiverSelect.value : null;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('send-button');

            button.addEventListener('click', async () => {
                const messageInput = document.getElementById('message-input');
                const message = messageInput.value;

                if (message.trim() !== '') {
                    const receiverId = window.authUserType === 'customer' ? null : getReceiverId(); 

                    await fetch('/send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message, receiver_id: receiverId })
                    });
                    messageInput.value = '';
                }
            });

            async function fetchMessages() {
                try {
                    const response = await fetch('/get-messages');
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

            setInterval(fetchMessages, 2000);
        });
    </script> 
</x-admin-layout>