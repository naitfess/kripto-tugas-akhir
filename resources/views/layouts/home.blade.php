@extends('layouts.app')

@section('content')
    <!-- Chat Section -->
    <div id="chat-section"
        class="scard bg-base-300 rounded-box lg:w-3/4 h-[80%] flex flex-col transition-all duration-300 ease-in-out">
        <!-- Chat Container -->
        @if (request()->is('/'))
            <p>hello</p>
        @else
            <div id="chat-container"
                class="flex flex-col flex-grow overflow-y-auto mb-4 space-y-4 scrollbar-thin scrollbar-thumb-rounded scrollbar-thumb-base-100 scrollbar-track-gray-700">
                <div id="chat-header" class="chat-header sticky top-0 bg-base-300 pb-3 z-5 text-primary p-4 rounded-box">
                    Chat with {{ $selectedUser->username }}
                </div>
                @foreach ($messages as $message)
                    <div id="chat-body" class="flex-grow px-4">
                        <div class="chat {{ $message->from_user_id == Auth::id() ? 'chat-end' : 'chat-start' }}">
                            <div class="chat-bubble break-words max-w-[80%]">
                                {{ $message->message }}
                            </div>
                            <div class="chat-footer opacity-50">
                                {{ $message->created_at->format('H:i') }}{{ $message->from_user_id == Auth::id() ? ', ' . ($message->is_read == 0 ? 'delivered' : 'seen') : '' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Input Area (Textarea dan Tombol Send) -->
            <form action="{{ route('chat.send', ['username' => $selectedUser->username]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input name="messageType" class="messageType" type="hidden" value="message">
                <div id="input-area" class="input-area flex items-center space-x-4 p-4 mt-auto flex-shrink-0">
                    <div class="dropdown dropdown-top">
                        <div tabindex="0" role="button">
                            <button type="button" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.0" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                            </button>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow mb-2">
                            <li><a>Image</a></li>
                            <li><a>File</a></li>
                        </ul>
                    </div>
                    <textarea name="message" class="textarea textarea-bordered w-full resize-none" rows="1"
                        placeholder="Write a message..."></textarea>
                    <button class="btn btn-primary" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form>
        @endif
    </div>

    <script>
        // Fungsi untuk scroll ke bawah secara otomatis
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Fungsi untuk menambahkan event listener ke dropdown
        function addDropdownEventListeners() {
            document.querySelectorAll('.dropdown-content a').forEach(item => {
                item.addEventListener('click', function(event) {
                    const option = event.target.innerText;
                    const inputArea = document.getElementById('input-area');
                    const messageType = document.querySelector('.messageType');

                    // Bersihkan area input sebelum menambahkan input baru
                    inputArea.innerHTML = ''; // Menghapus semua elemen dalam input area

                    // Tambahkan input sesuai dengan opsi yang dipilih
                    if (option === 'File') {
                        messageType.value = 'file';
                        const backButton = document.createElement('button');
                        backButton.type = 'button';
                        backButton.className = 'btn btn-secondary mt-2';
                        backButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    `;
                        backButton.onclick = resetInputArea;
                        inputArea.appendChild(backButton);

                        const fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.name = 'file';
                        fileInput.className = 'file-input file-input-bordered w-full mt-2';
                        inputArea.appendChild(fileInput);
                    } else if (option === 'Image') {
                        messageType.value = 'image';
                        const backButton = document.createElement('button');
                        backButton.type = 'button';

                        backButton.className = 'btn btn-secondary mt-2';
                        backButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    `;
                        backButton.onclick = resetInputArea;
                        inputArea.appendChild(backButton);

                        const imageInput = document.createElement('input');
                        imageInput.type = 'file';
                        imageInput.name = 'image';
                        imageInput.accept = 'image/*';
                        imageInput.className = 'file-input file-input-bordered w-full mt-2';
                        inputArea.appendChild(imageInput);

                        const textArea = document.createElement('textarea');
                        textArea.className = 'textarea textarea-bordered w-full resize-none mt-2';
                        textArea.placeholder = 'Write a message you want to hide...';
                        textArea.name = 'hiddenMessage';
                        textArea.rows = 1;
                        inputArea.appendChild(textArea);
                    }

                    const sendButton = document.createElement('button');
                    sendButton.className = 'btn btn-primary mt-2';
                    sendButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>`;
                    inputArea.appendChild(sendButton);

                    // Scroll to the bottom after the input changes
                    scrollToBottom();
                });
            });
        }

        // Fungsi untuk mereset input area ke tampilan awal
        function resetInputArea() {
            const messageType = document.querySelector('.messageType');
            messageType.value = 'message';
            const inputArea = document.getElementById('input-area');
            inputArea.innerHTML = `
    <div class="dropdown dropdown-top">
        <div tabindex="0" role="button">
            <button type="button" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                </svg>
            </button>
        </div>
        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow mb-2">
            <li><a>Image</a></li>
            <li><a>File</a></li>
        </ul>
    </div>
    <textarea name="message" class="textarea textarea-bordered w-full resize-none" rows="1" placeholder="Write a message..."></textarea>
    <button class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0"
            stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
        </svg>
    </button>
`;

            addDropdownEventListeners();

            // Scroll to the bottom after resetting the input area
            scrollToBottom();
        }

        // Menambahkan event listener saat halaman pertama kali dimuat
        window.onload = () => {
            addDropdownEventListeners();
            scrollToBottom(); // Scroll to bottom when the page loads
        };
    </script>
@endsection
