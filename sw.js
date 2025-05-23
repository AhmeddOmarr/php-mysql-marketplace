const CACHE_NAME = 'agarly-v2';
const OFFLINE_URL = '/php-mysql-marketplace/offline.html';
const ASSETS_TO_CACHE = [
  '/php-mysql-marketplace/',
  '/php-mysql-marketplace/index.php',
  '/php-mysql-marketplace/category.php',
  '/php-mysql-marketplace/shop-details.php',
  '/php-mysql-marketplace/shoping-cart.php',
  '/php-mysql-marketplace/heart.php',
  '/php-mysql-marketplace/checkout.php',
  '/php-mysql-marketplace/src/css/bootstrap.min.css',
  '/php-mysql-marketplace/src/css/style.css',
  '/php-mysql-marketplace/src/css/font-awesome.min.css',
  '/php-mysql-marketplace/src/css/elegant-icons.css',
  '/php-mysql-marketplace/src/css/nice-select.css',
  '/php-mysql-marketplace/src/css/jquery-ui.min.css',
  '/php-mysql-marketplace/src/css/owl.carousel.min.css',
  '/php-mysql-marketplace/src/css/slicknav.min.css',
  '/php-mysql-marketplace/src/js/jquery-3.3.1.min.js',
  '/php-mysql-marketplace/src/js/bootstrap.min.js',
  '/php-mysql-marketplace/src/js/jquery.nice-select.min.js',
  '/php-mysql-marketplace/src/js/jquery-ui.min.js',
  '/php-mysql-marketplace/src/js/jquery.slicknav.js',
  '/php-mysql-marketplace/src/js/mixitup.min.js',
  '/php-mysql-marketplace/src/js/owl.carousel.min.js',
  '/php-mysql-marketplace/src/js/main.js',
  '/php-mysql-marketplace/src/images/logo.png',
  '/php-mysql-marketplace/src/images/icons/icon-192x192.png',
  '/php-mysql-marketplace/src/images/icons/icon-512x512.png',
  'https://cdn.jsdelivr.net/npm/sweetalert2@11',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
  'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(ASSETS_TO_CACHE);
      })
  );
});

self.addEventListener('fetch', (event) => {
  if (event.request.mode === 'navigate') {
    event.respondWith(
      fetch(event.request)
        .catch(() => {
          return caches.match(OFFLINE_URL);
        })
    );
  } else {
    event.respondWith(
      caches.match(event.request)
        .then((response) => {
          return response || fetch(event.request);
        })
    );
  }
});

self.addEventListener('activate', (event) => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

self.addEventListener('push', (event) => {
  const data = event.data.json();
  const options = {
    body: data.body,
    icon: '/src/images/icons/icon-192x192.png',
    badge: '/src/images/icons/icon-72x72.png',
    data: {
      url: data.url
    }
  };
  
  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data.url)
  );
}); 