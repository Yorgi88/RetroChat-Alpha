import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Alpine from 'alpinejs';



window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws'],
    disableStats: true
});

window.Alpine = Alpine;
Alpine.start();


// Debug: log connection state changes
if (window.Echo?.connector?.pusher) {
    window.Echo.connector.pusher.connection.bind('state_change', (states) => {
        console.log('Pusher state change:', states.previous, '->', states.current);
    });

    window.Echo.connector.pusher.connection.bind('error', (err) => {
        console.error('Pusher error:', err);
    });
}