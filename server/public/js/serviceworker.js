// The cache name
const CACHE_NAME = 'regattatracker-v1';

// The files to cache
const filesToCache = [
    '/offline',
    '/css/bulma.min.css',
    '/js/script.js'
];

// On install cache all files
self.addEventListener('install', event => {
    event.waitUntil(caches.open(CACHE_NAME).then(cache => cache.addAll(filesToCache)));
});

// When activated check if there is a new serviceworker version
self.addEventListener('activate', event => {
    event.waitUntil(caches.keys().then(cacheNames => {
        return Promise.all(
            cacheNames.filter(cacheName => cacheName != CACHE_NAME)
                .map(cacheName => caches.delete(cacheName))
        );
    }));
});

// When no connection return the offline page
self.addEventListener('fetch', event => {
    event.respondWith(caches.match(event.request).then(response => {
        return response || fetch(event.request).catch(() => caches.match('/offline'));
    }));
});
