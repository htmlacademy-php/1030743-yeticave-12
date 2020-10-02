<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();

if ($connection) {
  $sql_new_lots = 'SELECT lot.id, lot_name, start_price, end_date, category_id, category.name, image, bet.lot_id, bet_price, bet_count
  FROM lot 
  JOIN category ON lot.category_id = category.id 
  LEFT JOIN (SELECT lot_id, MAX(bet_price) as bet_price, COUNT(lot_id) as bet_count FROM bet GROUP BY lot_id) bet 
  ON lot.id = bet.lot_id 
  WHERE end_date > CURRENT_DATE()
  ORDER BY lot.creation_date DESC';

  $result_new_lots = mysqli_query($connection, $sql_new_lots);
  $new_lots = mysqli_fetch_all($result_new_lots, MYSQLI_ASSOC);

  print_r($new_lots);

  $category_list = category_list($connection);

};

$page_content = include_template('main.php', [
  'category_list' => $category_list,
  'new_lots' => $new_lots
]); 

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Yeti Cave'
]);

print($layout);


