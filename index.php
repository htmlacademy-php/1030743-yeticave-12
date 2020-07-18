<?php
require_once('helpers.php');
require_once('templates/data.php');

$connection_db = mysqli_connect('yeticave', 'root', '', 'yeticave');
mysqli_set_charset($connection_db, "utf8");

if ($connection_db) {
  $sql_new_lots = 'SELECT lot_name, start_price, end_date, category_id, category.name, bet.bet_price, image FROM lot 
  JOIN category ON lot.category_id = category.id 
  JOIN bet ON bet.id = lot.id';

  $result_new_lots = mysqli_query($connection_db, $sql_new_lots);
  $new_lots = mysqli_fetch_all($result_new_lots, MYSQLI_ASSOC);
  print_r($new_lots);

  $sql_category_list = 'SELECT name, character_code FROM category';

  $result_category_list = mysqli_query($connection_db, $sql_category_list);
  $category_list = mysqli_fetch_all($result_category_list, MYSQLI_ASSOC);
  print('<br>');
  print_r($category_list);

} 
else { 
  print("Ошибка подключения: " . mysqli_connect_error());
};

$page_content = include_template('main.php', [
  'category_list' => $category_list,
  'new_lots' => $new_lots
]); 

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Yeti Cave',
  'is_auth' => $is_auth, 
  'user_name' => $user_name
]);

print($layout);

