<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();

if ($connection) {
  $category_list = category_list($connection);
};

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $user_id = $_GET['id'];

  if ($connection) {
    // запрос в бд на получение моих ставок
    $sql_my_bets = 'SELECT lot.id, image, lot_name, bet.bet_price, end_date, user_lot_add_id, category_id, category.name, bet.creation_date FROM lot
    JOIN category ON category_id = category.id
    JOIN bet ON bet.lot_id = lot.id WHERE bet.user_id = ' . $user_id; 
    $result_sql_my_bets = mysqli_query($connection, $sql_my_bets);
    $my_bets = mysqli_fetch_all($result_sql_my_bets, MYSQLI_ASSOC);
  };
}

$page_content = include_template('my-bets.php', [
  'category' => $category_list,
  'my_bets' => $my_bets
]); 

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Мои ставки'
]);

print($layout);
