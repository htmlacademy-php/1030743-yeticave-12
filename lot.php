<?php
require_once('helpers.php');
require_once('templates/data.php');

$lot_id  = filter_input(INPUT_GET, 'id');

$connection = connect_to_db();

if ($connection) {
  $sql_category_list = 'SELECT name, character_code FROM category';
  $result_category_list = mysqli_query($connection, $sql_category_list);
  $category_list = mysqli_fetch_all($result_category_list, MYSQLI_ASSOC);

  $sql_lot_description_list = 'SELECT lot.id, lot_name, image, lot_description, end_date, category.name FROM lot
  JOIN category ON lot.category_id = category.id'; 
  $result_sql_lot_description_list = mysqli_query($connection, $sql_lot_description_list);
  $lot_description_list = mysqli_fetch_all($result_sql_lot_description_list, MYSQLI_ASSOC);
};

foreach($lot_description_list as $lot_description) {
  if ($lot_id === $lot_description['id']) {
    $lot = $lot_description;
    
    $page_content = include_template('lot-template.php', [
      'lot' => $lot
      ]); 
    break;
  } else {
    $page_content = include_template('404.php'); 
  } 
}

print_r($lot);

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Yeti Cave',
  'is_auth' => $is_auth, 
  'user_name' => $user_name
]);

print($layout);