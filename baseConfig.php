<?php

return [
    'app' => [
        'helpUrl' => '', // url to index.php file of this project, you should redefine it in config.php
        'stickerCommand' => '/leo',
    ],
    'slack' => [
        'slashCommandToken' => '', // slash command token, you should redefine it in config.php
        'incomingWebHookURL' => '', // incoming hook endpoint, you should redefine it in config.php
        'webApiToken' => '', // slack web api token, you should redefine it in config.php
    ],
    'image' => [
        'basePath' => realpath('./images/'),
        'baseUrl' => '', // base url for images, you should redefine it in config.php
        'size' => 250,
        'map' => [
            'surprise' => '1.png',
            'unsatisfied' => '2.png',
            'sad' => '3.png',
            'wonder' => '4.png',
            'regret' => '5.png',
            'joy' => '6.png',
            'fear' => '7.png',
            'irrelevant' => '8.png',
            'shining' => '9.png',
            'bored' => '10.png',
            'depressed' => '11.png',
            'nervous' => '12.png',
            'happy' => '13.png',
            'modest' => '14.png',
            'thumbs' => '15.png',
            'zen' => '16.png',
            'hurt' => '17.png',
            'sleepy' => '18.png',
            'shy' => '19.png',
            'distrust' => '20.png',
            'ill' => '21.png',
            'offended' => '22.png',
            'meek' => '23.png',
            'cry' => '24.png',
            'calm' => '25.png',
            'obsessed' => '26.png',
            'guilty' => '27.png',
            'think' => '28.png',
        ]
    ]
];
