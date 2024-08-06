<x-app-layout>
    <style>
        #chat-container {
            display: flex;
            flex-direction: column;
            height: 80vh;
            border: 1px solid #e2e8f0; /* Tailwind gray-300 */
            padding: 1rem;
            background-color: #f7fafc; /* Tailwind gray-100 */
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
            border-radius: 0.375rem; /* Tailwind rounded */
            max-width: 70%;
            word-wrap: break-word;
        }

        .sender {
            align-self: flex-end;
            background-color: #d1fae5; /* Tailwind green-100 */
            text-align: right;
        }

        .receiver {
            align-self: flex-start;
            background-color: #edf2f7; /* Tailwind gray-200 */
            text-align: left;
        }

        #message-input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #e2e8f0; /* Tailwind gray-300 */
            border-radius: 0.375rem; /* Tailwind rounded */
        }

        #send-button {
            margin-left: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #3b82f6; /* Tailwind blue-500 */
            color: white;
            border-radius: 0.375rem; /* Tailwind rounded */
            border: none;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #2563eb; /* Tailwind blue-600 */
        }
    </style>

    <div id="chat-container">
        <div id="message-list">
            <!-- Messages will be appended here -->
        </div>
        <div class="flex items-center mt-4">
            <input type="text" id="message-input" placeholder="Type a message">
            <button id="send-button">Send</button>
        </div>
    </div>

    <script>
        // Pass PHP variables to JavaScript
        window.authUserId = @json(auth()->id());
        window.authUserType = @json(auth()->user()->usertype);

        function getReceiverId() {
            // Implement logic to get the receiver ID
            // Example: get the value from a dropdown or set a fixed ID for now
            const receiverSelect = document.getElementById('receiver-select');
            return receiverSelect ? receiverSelect.value : null;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('send-button');

            button.addEventListener('click', async () => {
                const messageInput = document.getElementById('message-input');
                const message = messageInput.value;

                if (message.trim() !== '') {
                    const receiverId = window.authUserType === 'customer' ? null : getReceiverId(); // Get receiver ID

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

                    // Scroll to the bottom of the message list
                    messageList.scrollTop = messageList.scrollHeight;
                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            }

            setInterval(fetchMessages, 2000);
        });
    </script>
</x-app-layout>
