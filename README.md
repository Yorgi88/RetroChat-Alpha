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
- next, add the welcome-retro file and test, set the test route in the web.php file

-- i also pasted created the rooms dir that houses create and join blade files
- pasted the contents from the beta

- How i handle uniqueness : a unique random user_id is generated for the users
- this is what redis, the websockets would use to distinguish the users persistently
- then we wrap up these unique user_ids with a dummy name, comprising of adjective and noun

- these are all tied to the individual browser sessionb btw
- i do not want any orphan rooms
- meaning all the real actions occur when the user hits the proceed btn
- recall that redis generate the room code when the user is in the welcome-retro file
- i wrote a copy feature to enable the host user to copy the code and share it with the 
- guest user

- so when the host clicks "proceed", these happen:
- Generate user ID
- generate display name
- store in the session
- create a room in redis
- set self as host
- redirect to rooms/
- 

- i also addressed idempotency
- for example, a user can create a room, hit the proceed btn
- then open another tab, get room code and hit proceed btn again
- i made it in a way the browser checks session identity before each room creation
- so if a user session identity still exists in session
- it won't matter, in the second tab the user still gets the same user id and display name initially allocated

- NO DUPLICATES!

- Now, we need a place to handle our generation logic;
- in the app dir, create a Services dir, this would house two files
- IdentityService and RoomService
- also , in the config dir, create a rooms.php file

- also in the config dir , created the identity_words.php file -- this houses the cheeky display names for the users

- i added 50 extra each; now its 100 X 100
- now back to the app dir; the IdentityService file and the RoomService file
- lets look at the code and revise

- in the IdentityService code: 

- I started with the ensureSessionIdentity(): method
- this method checks if the user that wants to create the room already has a session identity -- recall the idempotency stuff?
- so if the user has no identity, then generate one for the user and store it in the Session

- for now we done with the IdentityService file, we move on to room service
- this would be the largest file here

- it handles room code generation
- room creation
- room joining
- room leaving

- i have written the barebones for now before we go into the create, join , leave etc

for now, i wrote the helper internal methods
- like the generateCode method, keysFor, roomExists, randomCode methods

- the randomCode method helps loop 6 times, generating a unique charset which would be the
- 6 digit room code

