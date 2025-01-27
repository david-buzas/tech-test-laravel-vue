<?php
return [
    'countries_api' => [
        'uri' => env('API_COUNTRY_LIST_URI', 'https://restcountries.com/v3.1/all'),
        'options' => [
            'query' => [
                'fields' => 'name,flags',
            ],
        ],
    ]
];
