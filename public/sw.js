const CACHE_NAME = 'futsal-v1';
const urlsToCache = [
  '/manifest.json'
];

self.addEventListener('install', event => {
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(clients.claim());
});

self.addEventListener('fetch', event => {
  // Hanya intercept file statis, biarkan navigasi halaman (Login/Register) berjalan normal
  if (event.request.mode === 'navigate') {
    return;
  }
  
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});
