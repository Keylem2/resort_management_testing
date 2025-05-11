<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | Blue Belle Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
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
    <div class="w-full max-w-md auth-card rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-[#f59e0b] py-4 px-6">
            <h2 class="text-xl font-bold text-white text-center">Verify Your Email</h2>
        </div>
        
        <div class="p-6">
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    A new verification link has been sent to your email address.
                </div>
            @endif
            
            <p class="text-gray-600 mb-4">
                Thanks for registering! Please check your email for a verification link.
            </p>
            
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-white font-bold py-2 px-4 rounded-lg transition">
                    Resend Verification Email
                </button>
            </form>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-sm text-[#f59e0b] hover:text-[#d97706]">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</body>
</html>