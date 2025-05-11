@component('mail::message')
# Welcome to Blue Belle Resort!

<img src="{{ asset('images/logo.png') }}" alt="Blue Belle Resort" width="200" style="margin-bottom: 20px;">

Please verify your email address to access your account.

@component('mail::button', ['url' => $url, 'color' => '#f59e0b'])
Verify Email Address
@endcomponent

This link expires in 24 hours.  
If you didn't create an account, no action is needed.

Mahalo,<br>
The Blue Belle Resort Team
@endcomponent