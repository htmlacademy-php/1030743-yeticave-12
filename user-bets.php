<?php
require_once('helpers.php');
require_once('functions.php');

session_start();
$connection = connect_to_db();
$category_list = category_list($connection);

$page_content = include_template('my-bets.php', [
    'category' => $category_list
]);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_GET['id'];
    // запрос в бд на получение моих ставок
    $sql_my_bets = 'SELECT lot.id, image, lot_name, bet.bet_price, end_date, user_lot_add_id, user_winner_id, 
      category_id, category.name, bet.creation_date, email, user_contacts FROM lot
      JOIN category ON category_id = category.id
      JOIN bet ON bet.lot_id = lot.id
      JOIN users ON users.id = bet.user_id
      WHERE bet.user_id = ' . $user_id;
    $result_sql_my_bets = mysqli_query($connection, $sql_my_bets);
    $my_bets = mysqli_fetch_all($result_sql_my_bets, MYSQLI_ASSOC);

    $page_content = include_template('my-bets.php', [
        'category' => $category_list,
        'my_bets' => $my_bets,
        'user_id' => $user_id
    ]);
} else {
    $page_content = include_template('403.php', [
        'category' => $category_list
    ]);
}

$layout = include_template('layout.php', [
    'page_content' => $page_content,
    'category_list' => $category_list,
    'page_title' => 'Мои ставки'
]);

print($layout);
