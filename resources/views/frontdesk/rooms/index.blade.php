@extends('layouts.frontdesk')

@section('title', 'Rooms')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Rooms</h2>
                <p class="text-gray-600 mt-1">Browse and manage rooms in Blue Belle Resort</p>
            </div>
        </div>
    </div>

    <!-- Room Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Couple Room Category -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="h-64 bg-gray-100 relative">
                <div id="couple-room-preview" class="w-full h-full"></div>
            </div>
            <div class="p-5">
                <h3 class="text-xl font-bold text-gray-800">Couple Rooms</h3>
                <p class="text-gray-600 mt-1">{{ $coupleRooms->where('status', 'available')->count() }} of {{ $coupleRooms->count() }} available</p>
                <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('frontdesk.rooms.by_type', ['type' => 'Couple Room']) }}" class="text-primary-600 hover:text-primary-800 font-medium text-lg bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition-all">
    View all rooms
</a>
                    <button onclick="openFullscreenViewer('couple')" class="btn btn-sm btn-primary text-lg py-2 px-4 rounded-lg bg-green-500 text-white hover:bg-green-600 focus:outline-none transition-all">
                        <i class="fas fa-expand mr-1"></i> Fullscreen 360°
                    </button>
                </div>
            </div>
        </div>

        <!-- Family Room Category -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="h-64 bg-gray-100 relative">
                <div id="family-room-preview" class="w-full h-full"></div>
            </div>
            <div class="p-5">
                <h3 class="text-xl font-bold text-gray-800">Family Rooms</h3>
                <p class="text-gray-600 mt-1">{{ $familyRooms->where('status', 'available')->count() }} of {{ $familyRooms->count() }} available</p>
                <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('frontdesk.rooms.by_type', ['type' => 'Family Room']) }}" class="text-primary-600 hover:text-primary-800 font-medium text-lg bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition-all">
    View all rooms
</a>
                    <button onclick="openFullscreenViewer('family')" class="btn btn-sm btn-primary text-lg py-2 px-4 rounded-lg bg-green-500 text-white hover:bg-green-600 focus:outline-none transition-all">
                        <i class="fas fa-expand mr-1"></i> Fullscreen 360°
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen 360° Viewer Modal -->
<div id="360viewerModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90">
    <div class="absolute top-4 right-4">
        <button onclick="closeFullscreenViewer()" class="text-white text-2xl hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div id="fullscreen-360-viewer" class="w-full h-full"></div>
    
    <!-- Back to Rooms Button -->
    <div class="absolute bottom-4 left-4">
        <button onclick="window.location.href='{{ route('frontdesk.rooms.index') }}'" class="bg-amber-600 text-white py-2 px-4 rounded-lg hover:bg-amber-700 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back to Rooms
        </button>
    </div>
</div>

@push('styles')
<!-- Pannellum CSS -->
<link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css">
@endpush

@push('scripts')
<!-- Pannellum JS -->
<script src="https://cdn.pannellum.org/2.5/pannellum.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    pannellum.viewer('couple-room-preview', {
        "type": "equirectangular",
        "panorama": "/storage/360_images/couple_room_360.jpg",  // Update with actual path
        "autoLoad": true
    });

    pannellum.viewer('family-room-preview', {
        "type": "equirectangular",
        "panorama": "/storage/360_images/family_room_360.jpg",  // Update with actual path
        "autoLoad": true
    });
});

function openFullscreenViewer(roomType) {
    const modal = document.getElementById('360viewerModal');
    const viewerContainer = document.getElementById('fullscreen-360-viewer');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    viewerContainer.innerHTML = '<div id="fullscreen-viewer"></div>';

    pannellum.viewer('fullscreen-viewer', {
        "type": "equirectangular",
        "panorama": `/storage/360_images/${roomType}_room_360.jpg`,
        "autoLoad": true
    });
}

function closeFullscreenViewer() {
    const modal = document.getElementById('360viewerModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
@endpush
@endsection
