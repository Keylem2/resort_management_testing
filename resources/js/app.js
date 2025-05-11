import './bootstrap';

import Alpine from 'alpinejs';

import { Viewer } from '@photo-sphere-viewer/core';

window.PhotoSphereViewer = { Viewer }; // Make it globally available

window.Alpine = Alpine;

Alpine.start();
