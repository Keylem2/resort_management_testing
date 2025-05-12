<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Blue Belle Resort')</title>
  @vite(['resources/css/app.css'])
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body { 
      font-family: 'Open Sans', sans-serif; 
      overflow-x: hidden;
    }
    h1, h2 { 
      font-family: 'Playfair Display', serif; 
    }
    
    /* Updated Navigation Panel */
    .nav-panel {
      position: fixed;
      top: 0;
      right: -100%;
      width: 80%;
      max-width: 350px;
      height: 100vh;
      background-color: white;
      z-index: 50;
      transition: right 0.3s ease-in-out;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    }
    
    .nav-panel.open {
      right: 0;
    }
    
    .nav-panel a {
      font-size: 1.25rem;
      margin: 0.75rem 0;
      font-weight: 500;
      transition: all 0.3s ease;
      padding: 0.5rem 0;
    }
    
    .nav-panel a:hover { 
      transform: translateX(5px); 
      color: #f59e0b;
    }
    
    .nav-panel .active { 
      color: #f59e0b; 
    }
    
    .nav-panel .close {
      position: absolute;
      top: 1.25rem;
      right: 1.25rem;
      font-size: 1.5rem;
      cursor: pointer;
      color: #333;
    }
    
    .nav-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 40;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
    }
    
    .nav-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    
    #navbar-brand { 
      font-size: 2.5rem; 
      transition: transform 0.3s ease;
    }
    
    #navbar-brand:hover {
      transform: scale(1.05);
    }
    
    .font-playfair {
      font-family: 'Playfair Display', serif;
    }
    
    .font-sans {
      font-family: 'Open Sans', sans-serif;
    }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">
  @include('partials.resort-nav')
  
  <main>
    @yield('content')
  </main>

  @stack('scripts')
</body>
</html>