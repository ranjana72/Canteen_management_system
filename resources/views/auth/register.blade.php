<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register – Academia Canteen</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f6f8] min-h-screen flex items-center justify-center font-primary">

    <div class="w-full max-w-md px-4">

        {{-- Logo / heading --}}
        <div class="text-center mb-7">
            <div class="w-14 h-14 mx-auto mb-4 rounded-[14px] bg-[#0047AB] flex items-center justify-center text-2xl shadow-sm">
                🍽️
            </div>
            <h1 class="text-[22px] font-bold text-[#1a1a1a] tracking-tight">Academia Canteen</h1>
            <p class="text-[#6b7280] text-[13px] mt-1">Create your account</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-[16px] shadow-[0_1px_3px_rgba(0,0,0,0.06),0_8px_24px_rgba(0,0,0,0.06)] border border-gray-100 p-8">

            @if(session('error'))
                <div class="mb-5 px-4 py-2.5 bg-red-50 border border-red-200 text-red-700 rounded-[8px] text-[13px]">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf

                {{-- Full Name --}}
                <div>
                    <label for="name" class="block text-[13px] font-semibold text-[#1a1a1a] mb-1.5">
                        Full Name
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full px-3.5 py-2.5 border rounded-[9px] text-[13px] text-[#1a1a1a] placeholder:text-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-[#0047AB]/15 focus:border-[#0047AB] {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50/50' }}"
                        placeholder="Enter your full name"
                    >
                    @error('name')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[13px] font-semibold text-[#1a1a1a] mb-1.5">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-3.5 py-2.5 border rounded-[9px] text-[13px] text-[#1a1a1a] placeholder:text-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-[#0047AB]/15 focus:border-[#0047AB] {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50/50' }}"
                        placeholder="example@gmail.com"
                    >
                    @error('email')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[13px] font-semibold text-[#1a1a1a] mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-3.5 py-2.5 pr-11 border border-gray-200 bg-gray-50/50 rounded-[9px] text-[13px] text-[#1a1a1a] placeholder:text-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-[#0047AB]/15 focus:border-[#0047AB]"
                            placeholder="Minimum 8 characters"
                        >
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-[#0047AB]">
                            <svg id="eyeOpen1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-[18px] h-[18px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeClosed1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-[18px] h-[18px] hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58A2 2 0 0012 14a2 2 0 001.42-.58M9.88 5.09A9.77 9.77 0 0112 5c4.48 0 8.27 2.94 9.54 7a9.96 9.96 0 01-4.04 5.13M6.23 6.23A9.96 9.96 0 002.46 12c1.27 4.06 5.06 7 9.54 7a9.7 9.7 0 004.19-.95"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-[13px] font-semibold text-[#1a1a1a] mb-1.5">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full px-3.5 py-2.5 pr-11 border border-gray-200 bg-gray-50/50 rounded-[9px] text-[13px] text-[#1a1a1a] placeholder:text-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-[#0047AB]/15 focus:border-[#0047AB]"
                            placeholder="Confirm password"
                        >
                        <button type="button" id="togglePassword2" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-[#0047AB]">
                            <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-[18px] h-[18px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeClosed2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-[18px] h-[18px] hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58A2 2 0 0012 14a2 2 0 001.42-.58M9.88 5.09A9.77 9.77 0 0112 5c4.48 0 8.27 2.94 9.54 7a9.96 9.96 0 01-4.04 5.13M6.23 6.23A9.96 9.96 0 002.46 12c1.27 4.06 5.06 7 9.54 7a9.7 9.7 0 004.19-.95"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#0047AB] hover:bg-[#00368a] active:bg-[#003370] text-white font-semibold py-2.5 px-4 rounded-[9px] text-[13px] shadow-sm transition-colors">
                    Create Account
                </button>

            </form>

            <p class="mt-6 text-center text-[13px] text-[#6b7280]">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#0047AB] hover:underline font-semibold">
                    Login
                </a>
            </p>

        </div>
    </div>

    <script>
        function wireToggle(inputId, btnId, openId, closedId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(btnId);
            const eyeOpen = document.getElementById(openId);
            const eyeClosed = document.getElementById(closedId);
            toggle.addEventListener('click', function () {
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            wireToggle('password', 'togglePassword', 'eyeOpen1', 'eyeClosed1');
            wireToggle('password_confirmation', 'togglePassword2', 'eyeOpen2', 'eyeClosed2');
        });
    </script>

</body>
</html>