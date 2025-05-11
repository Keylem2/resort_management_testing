@extends('layouts.resort')

@section('title', 'Contact Us - Blue Belle Resort')

@section('content')
<!-- Hero Section -->
<section class="relative h-[50vh] bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('images/top.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="relative z-10 text-center text-white">
        <h1 class="text-5xl font-bold">Contact</h1>
        <p class="text-sm mt-2 text-yellow-400 uppercase tracking-widest">Home / Contact</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 px-6 md:px-20 bg-white grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
    <!-- Contact Form -->
    <div>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Name" class="border w-full px-4 py-2 rounded" />
                <input type="text" placeholder="Phone" class="border w-full px-4 py-2 rounded" />
            </div>
            <input type="email" placeholder="Email" class="border w-full px-4 py-2 rounded" />
            <textarea rows="5" placeholder="Write Message" class="border w-full px-4 py-2 rounded"></textarea>
            <button class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded px-6 py-2">Send Message</button>
        </form>
    </div>

    <!-- Contact Info -->
    <div class="space-y-6">
        <div>
            <p class="uppercase text-sm font-semibold text-gray-500">Address:</p>
            <p>Dasmarinas Paliparan<br>Cavite</p>
        </div>
        <div>
            <p class="uppercase text-sm font-semibold text-gray-500">Phone:</p>
            <p>(+1) 234 4567 8910</p>
        </div>
        <div>
            <p class="uppercase text-sm font-semibold text-gray-500">Email:</p>
            <p>bluebelle@gmail.com</p>
        </div>
    </div>
</section>
@endsection