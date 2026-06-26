<?php

return [

    'default' => env('AI_PROVIDER', 'groq'),

    'providers' => [
        'groq' => [
            'driver' => 'groq',
            'key'    => env('GROQ_API_KEY'),
        ],
        'gemini' => [
            'driver' => 'gemini',
            'key'    => env('GEMINI_API_KEY'),
        ],
    ],

    'models' => [
        'text' => env('AI_TEXT_MODEL', 'llama-3.3-70b-versatile'),
    ],

];
