<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();

if ($connection) {
  $sql_category_list = 'SELECT name, id FROM category';
  $result_category_list = mysqli_query($connection, $sql_category_list);
  $category_list = mysqli_fetch_all($result_category_list, MYSQLI_ASSOC);
};

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  // получения заголовка поискового запроса
  $search_headers = $_GET['search'] ?? '';


  if ($search_headers) {
    $sql_search = "SELECT * FROM lot
    JOIN category ON lot.category_id = category.id 
    WHERE MATCH (lot_name, lot_description) AGAINST(?)";
    $stmt = db_get_prepare_stmt($connection, $sql_search, [$search_headers]);
    $stmt_execute = mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $search_result = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  print_r($search_result);
}


$page_content = include_template('search-lot.php', [
  'category' => $category_list,
  'lots' => $search_result,
  'search_headers' => $search_headers
  ]); 

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Поиск'
]);

print($layout);