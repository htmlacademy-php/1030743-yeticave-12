<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();

if ($connection) {
  $category_list = category_list($connection);
};

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // получения заголовка категории
    $category_headers = $_GET['id'] ?? '';

    $cur_page = $_GET['page'] ?? 1;
    $page_items_limit = 9;

    // запрос в бд для получения количества найденных лотов
    $sql_category_lots = 'SELECT lot.id, lot_name, start_price, end_date, category_id, image, category.name, category.character_code FROM lot
    JOIN category ON lot.category_id = category.id 
    WHERE end_date > CURRENT_DATE() AND category.id = (?)';
    $stmt = db_get_prepare_stmt($connection, $sql_category_lots, [$category_headers]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // количество найденных лотов
    $lot_count = mysqli_num_rows($result);

    // формула расчета показа пагинации
    $pages_count = ceil($lot_count / $page_items_limit);
    $offset = ($cur_page - 1) * $page_items_limit;

    $pages = range(1, $pages_count);
  
    // запрос в бд для получения количества найденных лотов со смещением
    if ($category_headers) {
      $sql_category_lots = "SELECT lot.id, lot_name, start_price, end_date, category_id, image, category.name, category.character_code FROM lot
      JOIN category ON lot.category_id = category.id 
      WHERE end_date > CURRENT_DATE() AND category.id = (?)
      LIMIT $page_items_limit OFFSET $offset";
      $stmt = db_get_prepare_stmt($connection, $sql_category_lots, [$category_headers]);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $category_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

      $category_name = $category_lots['0']['name'];
    }
}

$page_content = include_template('categories.php', [
  'category' => $category_list,
  'lots' => $category_lots,
  'cur_page' => $cur_page,
  'pages_count' => $pages_count,
  'pages' => $pages,
  'category_name' => $category_name
  ]); 

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'category_name' => $category_name,
  'page_title' => 'Лоты по категориям'
]);

print($layout);