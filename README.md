BUILDING AN EPHEMERAL CHAT SYSTEM THAT LASTS 44 MINS

- I installed the necessary stuff, reverb, redis, php-redis
- the redis and php redis are globally installed

- i also did not have npm  -- since i am on wsl
- so i installed node as well

- i also intalled laravel, this is the revised version, the beta version is already built
- in the app dir (laravel app) -- i installed reverb
using the composer require reverb and all that

- i also used npm to install laravel echo, axios and pusher js
they'll serve as the listeners on the client side of the app

"axios": "^1.x.x",
"laravel-echo": "^2.x.x",
"pusher-js": "^8.x.x",

- now we can get started:

- i started with the <x-layout> first; this comprises of header and footer
- in the resources/views, create a dir named components
in the components dir, this will house the layout's header and footer blade files for the app

- next, i installed alpine js - this won't be used in many parts of the app, just in few places eg: footer blade file

next is the app.js -- see the app.js file
we made the necessary imports and configs there
setting up the windows.Echo({}) -- to configure the client side listeners pusher , axios
and all that with the server side broadcasts : reverb -- explain the windows.Echo config


Next is the app.css i just pasted the initial app.css in the beta version to this
