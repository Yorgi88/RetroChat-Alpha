<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Maximum Users Per Room
    |--------------------------------------------------------------------------
    |
    | The cap on how many users can be in a single room simultaneously.
    | The first user (the creator) is the host; subsequent users are joiners.
    | Room is considered "full" when this count is reached.
    |
    */
    'max_users' => 2,

    /*
    |--------------------------------------------------------------------------
    | Room Lifetime (seconds)
    |--------------------------------------------------------------------------
    |
    | How long a room lives from creation, in seconds.
    | 2640 seconds = 44 minutes. After this, all Redis keys auto-expire.
    |
    */
    'lifetime_seconds' => 2640,

    /*
    |--------------------------------------------------------------------------
    | Room Code Length
    |--------------------------------------------------------------------------
    |
    | How many characters the generated room code contains.
    | Uppercase alphanumeric (A-Z, 0-9) — Base36.
    |
    */
    'code_length' => 6,

    /*
    |--------------------------------------------------------------------------
    | Room Code Character Set
    |--------------------------------------------------------------------------
    |
    | The characters allowed in generated room codes.
    | Excludes ambiguous characters (I, O, 0, 1) for readability.
    |
    */
    'code_charset' => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789',

    /*
    |--------------------------------------------------------------------------
    | Room Code Max Generation Attempts
    |--------------------------------------------------------------------------
    |
    | How many times to regenerate a code before giving up (collision guard).
    |
    */
    'code_max_attempts' => 10,
];