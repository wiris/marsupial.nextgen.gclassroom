<?php

return [
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'scopes' => explode(',', env('GOOGLE_API_SCOPES')),
];
