@extends('layouts.resort')

@section('title', 'Blue Belle Resort - Home')

@section('content')
  <!-- Hero Section -->
  <section class="relative h-[80vh] bg-cover bg-center" style="background-image: url('{{ asset('images/top.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-40"></div>

    <!-- Booking CTA -->
    <div class="absolute bottom-[-3rem] left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-lg p-6 w-full max-w-4xl z-10">
      <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-center md:text-left">
          <h3 class="text-xl font-bold text-gray-800">Ready for a relaxing getaway?</h3>
          <p class="text-gray-600">Book your stay at Blue Belle Resort today</p>
        </div>
        @auth
          @if(auth()->user()->usertype === 'admin')
            <a href="{{ route('admin.bookings.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded px-8 py-3 whitespace-nowrap">
              Book Now
            </a>
          @else
            <a href="{{ route('booking.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded px-8 py-3 whitespace-nowrap">
              Book Now
            </a>
          @endif
        @else
          <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-500 hover:scale-105 text-white font-semibold rounded px-8 py-3 whitespace-nowrap transition-transform duration-300 ease-in-out">
            Book Now
          </a>
        @endauth
      </div>
    </div>
  </section>

  <!-- Welcome Section -->
  <section class="mt-32 max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 items-center gap-8 px-4">
    <div>
      <h2 class="text-4xl font-bold mb-4">Welcome!</h2>
      <p class="text-gray-600 mb-6">
        Tucked away in the heart of Dasmariñas, Cavite, Blue Belle Resort began as a cozy family retreat in the early 2000s. Today, it has blossomed into a beloved haven for both locals and travelers. With its serene atmosphere, sparkling clean pools, and signature Caviteño hospitality, Blue Belle is the perfect destination for celebrations, family fun, or a peaceful weekend escape.
      </p>
    </div>
    <div class="relative rounded-xl overflow-hidden shadow-md">
      <video class="w-full h-full object-cover rounded-xl" autoplay muted loop playsinline controls>
        <source src="{{ asset('videos/homepage video 1.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </section>

  <!-- Rooms Section -->
  <section class="bg-white py-16 text-center px-6">
    <h2 class="text-3xl font-bold mb-6">Rooms & Suites</h2>
    <p class="text-gray-600 max-w-2xl mx-auto mb-12">
      At Blue Belle Resort, every room is designed with your comfort in mind. Whether you're on a quick getaway or a longer stay, our accommodations offer the perfect blend of relaxation and convenience. Enjoy clean, spacious interiors, cozy beds, and modern amenities in a peaceful setting.
      For those looking to elevate their stay, our exclusive suite offers added space, elegance, and privacy—perfect for couples, families, or special occasions. Experience warm hospitality and restful nights, only at Blue Belle.
    </p>
    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
      <!-- Couple Room -->
      <div>
        <div class="h-64 overflow-hidden rounded-lg shadow">
          <img src="https://images.unsplash.com/photo-1721742736307-1eed2fc2d56e" 
               class="w-full h-full object-cover" 
               alt="Couple Room">
        </div>
        <h3 class="text-xl font-semibold mt-4">Couple Room</h3>
        <p class="text-sm text-gray-500">₱2,500 / 22 HRS</p>
        <p class="text-sm text-gray-500">8 pax</p>
      </div>

      <!-- Family Room -->
      <div>
        <div class="h-64 overflow-hidden rounded-lg shadow">
          <img src="https://images.unsplash.com/photo-1721522281545-fad32dd5107a" 
               class="w-full h-full object-cover" 
               alt="Family Room">
        </div>
        <h3 class="text-xl font-semibold mt-4">Family Room</h3>
        <p class="text-sm text-gray-500">₱5,500 / 22 HRS</p>
        <p class="text-sm text-gray-500">8 pax</p>
      </div>

      <!-- Events Place -->
      <div>
        <div class="h-64 overflow-hidden rounded-lg shadow">
          <img src="{{ asset('images/events place.jpg') }}" 
               class="w-full h-full object-cover" 
               alt="Events Place">
        </div>
        <h3 class="text-xl font-semibold mt-4">Events Place</h3>
        <p class="text-sm text-gray-500">₱30,000 - ₱70,000++ <br> Depending on inclusion and duration</p>
        <p class="text-sm text-gray-500">50-100 pax</p>
      </div>
    </div>
  </section>

  <!-- Photos Section -->
  <section class="bg-gray-100 py-16 text-center px-6">
    <h2 class="text-3xl font-bold mb-6">Photos</h2>
    <p class="text-gray-600 max-w-2xl mx-auto mb-12">
      Located in Dasmariñas, Cavite, Blue Belle Resort started as a small family getaway in the early 2000s. Over the years, it grew into a relaxing resort loved by locals and visitors alike. Known for its peaceful vibe, clean pools, and warm Caviteño hospitality, Blue Belle continues to be a go-to spot for celebrations, family outings, and weekend escapes.
    </p>
    <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
      <img src="{{ asset('images/pool 1.jpg') }}" class="w-[500px] h-[300px] object-cover rounded-lg shadow" alt="Room Photo 1">
      <img src="{{ asset('images/pool 2.jpg') }}" class="w-[500px] h-[300px] object-cover rounded-lg shadow" alt="Room Photo 2">
      <img src="{{ asset('images/pool 3.jpg') }}" class="w-[500px] h-[300px] object-cover rounded-lg shadow" alt="Room Photo 3">
    </div>
  </section>

   <!-- Bottom Call-To-Action Section -->
   <section class="relative h-[450px] mt-12 overflow-hidden bg-gradient-to-r from-blue-800 via-blue-600 to-blue-500">
    <img src="{{ asset('images/flower.jpg') }}" alt="Background" class="w-full h-full object-cover object-bottom absolute inset-0 z-0 scale-105 opacity-60">
    <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>

    <div class="relative z-20 h-full flex flex-col items-center justify-center text-center max-w-4xl mx-auto px-6 text-white space-y-6">
      <h2 class="text-4xl md:text-5xl font-extrabold leading-tight">
        Discover the Comfort through <br> Blue Belle Resort
      </h2>
      <p class="text-lg md:text-xl font-light text-gray-200 max-w-2xl">
        Whether you're celebrating something special or just taking a break, we’ve got everything you need for a perfect escape.
      </p>
      <a id="reserveNowBtn" href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold text-lg md:text-xl px-10 py-4 rounded-xl shadow-lg transform transition duration-300 ease-in-out hover:scale-105">
        Reserve Now
      <a href="{{ route('virtual.tour') }}" class="bg-white text-blue-700 font-semibold text-lg md:text-xl px-10 py-4 rounded-xl shadow-lg hover:bg-blue-100 transform transition duration-300 ease-in-out hover:scale-105">
        Virtual Tour
      </a>
    </div>
  </section>

  <!-- Fade Overlay for Animation -->
  <div id="fadeOverlay" class="fixed inset-0 bg-white opacity-0 pointer-events-none transition-opacity duration-700 z-50"></div>

  <!-- Script for animation effect -->
  <script>
    const reserveBtn = document.getElementById('reserveNowBtn');
    const overlay = document.getElementById('fadeOverlay');

    // Handle Reserve Now button click
    reserveBtn.addEventListener('click', function(e) {
      e.preventDefault();
      overlay.classList.remove('opacity-0');
      overlay.classList.add('opacity-100', 'pointer-events-auto');

      setTimeout(() => {
        window.location.href = this.href;
      }, 700);
    });

    // Fix: Hide overlay again when coming back to the page
    window.addEventListener('pageshow', function () {
      overlay.classList.remove('opacity-100', 'pointer-events-auto');
      overlay.classList.add('opacity-0');
    });
  </script>
@endsection
