<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Blue Belle Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            background-image: url('{{ asset("images/auth-bg.jpg") }}');
            background-size: cover;
            background-position: center;
        }
        .auth-card {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.92);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Resort Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 font-serif">Blue Belle Resort</h1>
            <p class="text-gray-600 mt-2">Welcome back to your paradise getaway</p>
        </div>

        <!-- Login Card -->
        <div class="auth-card rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-[#f59e0b] py-4 px-6">
                <h2 class="text-xl font-bold text-white text-center">Sign In</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="p-6 space-y-5">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#f59e0b] focus:ring-2 focus:ring-[#f59e0b]/20 transition">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#f59e0b] focus:ring-2 focus:ring-[#f59e0b]/20 transition">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#f59e0b] focus:ring-[#f59e0b]">
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#f59e0b] hover:text-[#d97706]">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                    Sign In
                </button>
            </form>

            <!-- Registration Link -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-[#f59e0b] hover:text-[#d97706] font-medium">Register here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>