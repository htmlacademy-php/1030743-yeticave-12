<?php
require_once('helpers.php');

$is_auth = rand(0, 1);
$user_name = 'Булат';

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

// подключает к бд
function connect_to_db() {
    $connection = mysqli_connect('yeticave', 'root', '', 'yeticave');
    mysqli_set_charset($connection, "utf8");

    if ($connection == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }

    return $connection;
};

