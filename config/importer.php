<?php

return [
    'default' => 'randomuser',

    'providers' => [
        'randomuser' => [
            'api_url' => 'https://randomuser.me/api',
            'params' => [
                'inc' => 'gender,name,email,login,location,phone,nat',
                'nat' => 'au',
                'results' => 100,
                'format' => 'json'
            ],
            'root_element' => 'results'
        ],

        'dummy' => [
            'api_url' => '',
            'params' => [

            ],
            'root_element' => ''
        ]
    ]
];
