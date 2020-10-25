<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();
$category_list = category_list($connection);
$current_time = time();
$error = null;
$user_name_lot_add = null;
$bet_step = null;
$lot_end_date = null;
$bet_price = null;
$start_price = null;
$lot_price = null;
$min_bet = null;
$lot_description_id = null;

$page_content = include_template('lot-template.php', [
    'category_list' => $category_list
]);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lot_id = filter_input(INPUT_GET, 'id');

    // запрос в бд
    $lot_description_list = sql_lot_description_list($connection, $lot_id);
    $bets = bets($connection, $lot_id);

    $user_name_lot_add = check_array_key($lot_description_list, 'user_name', false);
    $bet_step = check_array_key($lot_description_list, 'bet_step', false);
    $lot_end_date = check_array_key($lot_description_list, 'end_date', true);
    $bet_price = check_array_key($bets['0'], 'bet_price', false);
    $start_price = check_array_key($lot_description_list, 'start_price', false);
    $lot_description_id = check_array_key($lot_description_list, 'id', false);

    $lot_price = lot_price_calculation($bet_price, $bet_step, $start_price);
    $min_bet = min_bet_calculation($lot_price, $bet_step);

    if ($lot_id === $lot_description_id) {
        $page_content = include_template('lot-template.php', [
            'lot' => $lot_description_list,
            'category' => $category_list,
            'lot_id' => $lot_id,
            'lot_price' => $lot_price,
            'min_bet' => $min_bet,
            'user_name_lot_add' => $user_name_lot_add,
            'lot_end_date' => $lot_end_date,
            'current_time' => $current_time,
            'bets' => $bets
        ]);
    }
};

if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // параметр запроса из формы для обновления страницы
    $lot_id = check_array_key($_POST, 'id', false);
    $user_id = check_array_key($_SESSION['user'], 'id', false);

    // запросы в бд
    $lot_description_list = sql_lot_description_list($connection, $lot_id);
    $bets = bets($connection, $lot_id);

    $user_name_lot_add = check_array_key($lot_description_list, 'user_name', false);
    $bet_step = check_array_key($lot_description_list, 'bet_step', false);
    $lot_end_date = check_array_key($lot_description_list, 'end_date', true);
    $bet = check_array_key($_POST, 'cost', false);
    $bet_price = check_array_key($bets['0'], 'bet_price', false);
    $lot_description_id = check_array_key($lot_description_list, 'id', false);
    $lot_price = lot_price_calculation($bet_price, $bet_step, $start_price);
    $min_bet = min_bet_calculation($lot_price, $bet_step);

    // валидация
    if (empty($bet)) {
        $error = 'Заполните поле';
    } else {
        if ((int)$bet <= 0 || !ctype_digit($bet)) {
            $error = 'Введите целое число больше 0';
        } else {
            if (($bet - $lot_price) < $bet_step) {
                $error = 'минимальная ставка ' . $min_bet;
            }
        }
    }

    // массив с данными для подготовленного выражения
    $stmt_data = [$bet, $user_id, $lot_id];

    if (!$error) {
        $sql_add_to_db = 'INSERT INTO bet (creation_date, bet_price, user_id, lot_id) VALUES (NOW(), ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql_add_to_db, $stmt_data);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header('Location: lot.php?id=' . $lot_id);
        } else {
            print(mysqli_error($connection));
        }
    }

    if ($lot_id === $lot_description_id) {
        $page_content = include_template('lot-template.php', [
            'lot' => $lot_description_list,
            'category' => $category_list,
            'lot_id' => $lot_id,
            'lot_price' => $lot_price,
            'min_bet' => $min_bet,
            'bets' => $bets,
            'user_name_lot_add' => $user_name_lot_add,
            'lot_end_date' => $lot_end_date,
            'current_time' => $current_time,
            'error' => $error
        ]);
    }
};

$layout = include_template('layout.php', [
    'page_content' => $page_content,
    'category_list' => $category_list,
    'page_title' => 'Лот'
]);

print($layout);
