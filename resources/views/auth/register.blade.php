<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Blue Belle Resort</title>
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
            <p class="text-gray-600 mt-2">Create your account to book your stay</p>
        </div>

        <!-- Registration Card -->
        <div class="auth-card rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-[#f59e0b] py-4 px-6">
                <h2 class="text-xl font-bold text-white text-center">New Account</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="p-6 space-y-5">
                @csrf

                <!-- Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#f59e0b] focus:ring-2 focus:ring-[#f59e0b]/20 transition">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
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

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#f59e0b] focus:ring-2 focus:ring-[#f59e0b]/20 transition">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    Already registered? 
                    <a href="{{ route('login') }}" class="text-[#f59e0b] hover:text-[#d97706] font-medium">Sign in here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>