// The cache name
var CACHE_NAME = 'regattatracker-v1';

// The files to cache
var filesToCache = [
    '/offline',
    '/css/bulma.min.css',
    '/js/script.js'
];

// On install cache all files
self.addEventListener('install', function (event) {
    event.waitUntil(caches.open(CACHE_NAME).then(function (cache) {
        return cache.addAll(filesToCache);
    }));
});

// When activated check if there is a new serviceworker version
self.addEventListener('activate', function (event) {
    event.waitUntil(caches.keys().then(function (cacheNames) {
        return Promise.all(cacheNames.filter(function (cacheName) {
            return cacheName != CACHE_NAME
        }).map(function (cacheName) {
            return caches.delete(cacheName);
        }));
    }));
});

// When no connection return the offline page
self.addEventListener('fetch', function (event) {
    event.respondWith(caches.match(event.request).then(function (response) {
        return response || fetch(event.request).catch(function () {
            return caches.match('/offline');
        });
    }));
});
