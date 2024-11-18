<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-base-300 text-base-100 flex items-center justify-center min-h-screen px-4">
    <!-- Container -->
    <div class="card w-full max-w-md bg-base-200 p-6 md:p-8 rounded-lg shadow-lg">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-200">REGISTER</h1>
        <form action="{{ route('register.handler') }}" method="POST">
            @csrf
            <div class="w-full max-w-sm bg-base-200 p-6">
                <!-- Input name -->
                <div class="form-control w-full mb-4">
                    <label class="input flex items-center gap-2 bg-base-100 p-2 rounded-md" id="name-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>

                        <input type="text" name="name" id="name"
                            class="grow bg-transparent placeholder-base-400 text-gray-300 focus:outline-none w-full"
                            placeholder="Name" />
                    </label>
                    @error('name')
                        <p class="text-sm text-red-500 hidden mt-1" id="name-error">{{ session('error') }}</p>
                    @enderror
                    <p class="text-sm text-red-500 hidden mt-1" id="name-error">Name is required</p>
                </div>

                <!-- Input Username -->
                <div class="form-control w-full mb-4">
                    <label class="input flex items-center gap-2 bg-base-100 p-2 rounded-md" id="username-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                        </svg>
                        <input type="text" name="username" id="username"
                            class="grow bg-transparent placeholder-base-400 text-gray-300 focus:outline-none w-full"
                            placeholder="Username" />
                    </label>
                    @error(session('username'))
                        <p class="text-sm text-red-500 hidden mt-1" id="name-error">{{ session('error') }}</p>
                    @enderror
                    <p class="text-sm text-red-500 hidden mt-1" id="username-error">Username is required</p>
                </div>

                <!-- Input Email -->
                <div class="form-control w-full mb-4">
                    <label class="input flex items-center gap-2 bg-base-100 p-2 rounded-md" id="email-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>

                        <input type="email" name="email" id="email"
                            class="grow bg-transparent placeholder-base-400 text-gray-300 focus:outline-none w-full"
                            placeholder="Email" />
                    </label>
                    <p class="text-sm text-red-500 hidden mt-1" id="email-error">Email is required</p>
                </div>

                <!-- Input Password -->
                <div class="form-control w-full mb-6">
                    <label class="input flex items-center gap-2 bg-base-100 p-2 rounded-md" id="password-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>

                        <input type="password" name="password" id="password"
                            class="grow bg-transparent placeholder-base-400 text-gray-300 focus:outline-none w-full"
                            placeholder="Password" />
                    </label>
                    <p class="text-sm text-red-500 hidden mt-1" id="password-error">Password is required</p>
                </div>

                <!-- Buttons -->
                <div class="form-control">
                    <button class="btn btn-primary w-full text-base-100 py-3 mb-4" onclick="validateForm()"
                        type="submit">Register</button>
                    <p class="text-sm text-center text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary font-bold underline">Login here</a>
                    </p>
                </div>
        </form>
    </div>
    </div>

    <script>
        function validateForm() {
            // Clear previous errors
            document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

            let isValid = true;

            // Validate Name
            const name = document.getElementById('name');
            const nameContainer = document.getElementById('name-container');
            if (name.value.trim() === '') {
                document.getElementById('name-error').classList.remove('hidden');
                nameContainer.classList.add('border-red-500');
                isValid = false;
            }

            // Validate Username
            const username = document.getElementById('username');
            const usernameContainer = document.getElementById('username-container');
            if (username.value.trim() === '') {
                document.getElementById('username-error').classList.remove('hidden');
                usernameContainer.classList.add('border-red-500');
                isValid = false;
            }

            // Validate Email
            const email = document.getElementById('email');
            const emailContainer = document.getElementById('email-container');
            if (email.value.trim() === '') {
                document.getElementById('email-error').classList.remove('hidden');
                emailContainer.classList.add('border-red-500');
                isValid = false;
            }

            // Validate Password
            const password = document.getElementById('password');
            const passwordContainer = document.getElementById('password-container');
            if (password.value.trim() === '') {
                document.getElementById('password-error').classList.remove('hidden');
                passwordContainer.classList.add('border-red-500');
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>
