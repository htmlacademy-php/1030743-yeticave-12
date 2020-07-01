<?php
require_once('helpers.php');

$is_auth = rand(0, 1);

$user_name = 'Булат';
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"]; 
$announcements = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'picture-url' => 'img/lot-1.jpg'
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'picture-url' => 'img/lot-2.jpg'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'picture-url' => 'img/lot-3.jpg'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'picture-url' => 'img/lot-4.jpg'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'picture-url' => 'img/lot-5.jpg'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'picture-url' => 'img/lot-6.jpg'
    ]
];


// форматирует ставку
function bet_formatter ($bet) {
    $min_number = 1000;
    if ($bet <= $min_number) {
        return $bet = ceil($bet) . ' ₽';
    }
        return $bet = number_format($bet, '0', ',', ' ') . ' ₽';
};

// дата до окончания аукциона

function get_time_left ($time_end) {
    $time_stamp = time();
    $seconds_in_hour = 3600;
    $seconds_in_minutes = 60;
    $end_time_stamp = strtotime($time_end);
    $time_stamp_difference = $end_time_stamp - $time_stamp;
    $hours_until_end = floor($time_stamp_difference / $seconds_in_hour);
    if (strlen($hours_until_end) < 2) {
        $hours_until_end = '0' . $hours_until_end;
    }

    $minutes_until_end = floor(($time_stamp_difference / $seconds_in_minutes) % 60);
    if (strlen($minutes_until_end) < 2) {
        $minutes_until_end = '0' . $minutes_until_end;
    }
    
    return [$hours_until_end, $minutes_until_end];
};

// рендерит время показа лота 

function show_time_left ($time) {
    return $time[0] . ':' . $time[1];
};


