<?php
$config = [
    'id' => 'yii2-location',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'components' => [
        'geolocation' => [
            'class' => 'yiiplus\location\baidulbsyun\GeoLocation',
            'ak' => '',
        ],
        'iplocation' => [
            'class' => 'yiiplus\location\baidulbsyun\IpLocation',
            'ak' => '',
        ]
    ],
];

return $config;