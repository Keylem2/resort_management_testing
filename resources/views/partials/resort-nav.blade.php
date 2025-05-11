<!-- Navbar -->
<nav id="navbar" class="fixed top-0 left-0 w-full flex items-center justify-between p-5 text-white z-30 transition-all duration-300">
  <!-- Enhanced Brand Text -->
  <a href="{{ route('home') }}" id="navbar-brand" class="text-3xl font-bold text-white transition-all duration-300 hover:text-yellow-300">
    <span class="font-playfair italic">Blue</span> 
    <span class="font-playfair italic">Belle</span> 
    <span class="font-sans uppercase tracking-widest text-sm block mt-1">Resort</span>
  </a>
  
  <div id="navbar-menu" class="space-y-1 cursor-pointer z-40">
    <div class="w-6 h-0.5 bg-white transition-all duration-300"></div>
    <div class="w-6 h-0.5 bg-white transition-all duration-300"></div>
    <div class="w-6 h-0.5 bg-white transition-all duration-300"></div>
  </div>
</nav>

<!-- Navigation Overlay Background -->
<div id="nav-overlay" class="nav-overlay"></div>

<!-- Navigation Panel -->
<!-- Navigation Panel -->
<div id="nav-panel" class="nav-panel">
  <span class="close" id="close-nav">&times;</span>
  <h1 class="text-lg font-bold mb-6">Blue Belle Resort</h1> <!-- Reduced margin -->
  
  <div class="flex flex-col gap-3"> <!-- Tighter gap (0.75rem) -->
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }} py-1">Home</a>
    <a href="{{ route('user.rooms.index') }}" class="{{ request()->routeIs('user.rooms.index') ? 'active' : '' }} py-1">Rooms</a>
    <a href="#" class="py-1">About</a>
    <a href="#" class="py-1">Events</a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }} py-1">Contact</a>
    
    @auth
      @if(auth()->user()->usertype === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="py-1">Admin Dashboard</a>
  @elseif(auth()->user()->usertype === 'front_desk')
    <a href="{{ route('frontdesk.dashboard') }}" class="py-1">Front Desk Dashboard</a>
  @elseif(auth()->user()->usertype === 'finance')
    <a href="{{ route('finance.dashboard') }}" class="py-1">Finance Dashboard</a>
  @else
    <a href="{{ route('dashboard') }}" class="py-1">My Dashboard</a>
  @endif
      
      <form method="POST" action="{{ route('logout') }}" class="py-1"> <!-- Same spacing -->
        @csrf
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); this.closest('form').submit();"
           class="block">Logout</a>
      </form>
    @else
      <a href="{{ route('login') }}" class="py-1">Login</a>
      <a href="{{ route('register') }}" class="py-1">Register</a>
    @endauth
  </div>
</div>

<script>
  const navbar = document.getElementById('navbar');
  const brand = document.getElementById('navbar-brand');
  const menu = document.getElementById('navbar-menu');
  const navOverlay = document.getElementById('nav-overlay');
  const navPanel = document.getElementById('nav-panel');
  const closeNav = document.getElementById('close-nav');
  const menuBars = menu.querySelectorAll('div');

  // Scroll effect
  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      navbar.classList.remove('text-white');
      navbar.classList.add('bg-white', 'text-black', 'shadow');
      brand.classList.remove('text-white');
      brand.classList.add('text-black');
      menuBars.forEach(bar => bar.classList.remove('bg-white'));
      menuBars.forEach(bar => bar.classList.add('bg-black'));
    } else {
      navbar.classList.remove('bg-white', 'text-black', 'shadow');
      navbar.classList.add('text-white');
      brand.classList.remove('text-black');
      brand.classList.add('text-white');
      menuBars.forEach(bar => bar.classList.remove('bg-black'));
      menuBars.forEach(bar => bar.classList.add('bg-white'));
    }
  });

  // Toggle navigation panel
  menu.addEventListener('click', () => {
    navPanel.classList.add('open');
    navOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  // Close navigation panel
  function closeNavigation() {
    navPanel.classList.remove('open');
    navOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  closeNav.addEventListener('click', closeNavigation);
  navOverlay.addEventListener('click', closeNavigation);
</script>