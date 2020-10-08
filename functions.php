<?php
require_once('helpers.php');

// текущее вреям
$current_time = time();

// сессия
session_start();

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

// проверяет чтобы осталось больше суток до кокнчания аукциона
function is_time_left_24 ($current_time) {
    $time_stamp = time();
    $end_time_timestamp = strtotime($current_time);
    $time_left = $end_time_timestamp - $time_stamp;
  
    if ($time_left < 86400) {
      return false;
    } 
      return true;
  };

// запрос в бд на получение списка категорий
function category_list ($connection) {
    $sql_category_list = 'SELECT id, name, character_code FROM category';
    $result_category_list = mysqli_query($connection, $sql_category_list);
    return mysqli_fetch_all($result_category_list, MYSQLI_ASSOC);
};

// дата создания ставки
function get_creation_date ($creation_date) {
    $date = date_create($creation_date);
    $time_stamp = time();
    $bet_creation_date = strtotime($creation_date);
    $seconds_in_day = 86400;
    $seconds_in_hour = 3600;
    $seconds_in_minute = 60;
    $difference = $time_stamp - $bet_creation_date;

    if ($difference < $seconds_in_minute) {
      return ' только что';
    } 
    if ($difference <= $seconds_in_hour) {
      $time_left = floor($difference / $seconds_in_minute);
      return $time_left . get_noun_plural_form($time_left, ' минуту назад', ' минуты назад', ' минут назад');
    } 
    if ($difference <= $seconds_in_day) {
      $time_left = floor($difference / $seconds_in_hour);
      return $time_left . get_noun_plural_form($time_left, ' час назад', ' часа назад', ' часов назад');
    } 
    if ($difference <= ($seconds_in_day * 2)) {
      return ' вчера в ' . date_format($date, 'H:i');
    } else {
      return date_format($date, 'd.m.y \в H:i');
    }
  }

// запрос в БД для описания лота для сценария lot.php
function sql_lot_description_list ($connection, $lot_id) {
  $sql_lot_description_list = 'SELECT lot.id, lot_name, image, lot_description, start_price, end_date, bet_step, users.name as user_name, category.name FROM lot
  JOIN users ON user_lot_add_id = users.id
  JOIN category ON lot.category_id = category.id WHERE lot.id = ' . $lot_id;  
  $result_sql_lot_description_list = mysqli_query($connection, $sql_lot_description_list);
  return mysqli_fetch_assoc($result_sql_lot_description_list);
};

// запрос в БД для получения ставок для сценария lot.php
function bets ($connection, $lot_id) {
  $sql_bets = 'SELECT bet_price, creation_date, user_id, users.name  FROM bet 
  JOIN users ON user_id = users.id
  WHERE bet.lot_id = ' . $lot_id . '
  ORDER BY creation_date DESC';
  $result_bets = mysqli_query($connection, $sql_bets);
  return mysqli_fetch_all($result_bets, MYSQLI_ASSOC);
}
