<?php
// You should rename this file to config.php
// You can redefine any of baseConfig.php values here

return array_replace_recursive(
    require 'baseConfig.php',
    [
        'app' => [
            'helpUrl' => '', // url to index.php file of this project
        ],
        'slack' => [
            'token' => '', // slash command token
            'endpoint' => '', // incoming hook endpoint, for example: https://hooks.slack.com/services/<something>
            'webApiToken' => '', // slack web api token
        ],
        'image' => [
            'baseUrl' => '', // base url for images, for example: http://example.com/images
        ]
    ]
);
