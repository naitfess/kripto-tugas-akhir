<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-base-300 text-base-100 flex items-center justify-center min-h-screen px-4">
    <!-- Container -->
    <div class="card w-full max-w-md bg-base-200 p-6 md:p-8 rounded-lg shadow-lg">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-200">LOGIN</h1>
        <form action="{{ route('login.handler') }}" method="POST">
            @csrf
            <div class="w-full max-w-sm bg-base-200 p-6">
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
                    <p class="text-sm text-red-500 hidden mt-1" id="username-error">Username is required</p>
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
                        type="submit">Login</button>
                    <p class="text-sm text-center text-gray-400">
                        Don't have an account?
                        <a href="/register" class="text-primary font-bold underline">Register here</a>
                    </p>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            // Reset error states
            document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

            let isValid = true;

            // Validate Username
            const username = document.getElementById('username');
            const usernameContainer = document.getElementById('username-container');
            if (username.value.trim() === '') {
                document.getElementById('username-error').classList.remove('hidden');
                usernameContainer.classList.add('border-red-500');
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
