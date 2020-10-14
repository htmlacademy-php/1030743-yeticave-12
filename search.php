<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();
$category_list = category_list($connection);

$page_content = include_template('search-lot.php', [
  'category' => $category_list
  ]);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && strlen($_GET['search']) > 0) {

  // получения заголовка поискового запроса
  $search_headers = $_GET['search'] ?? '';

  $cur_page = $_GET['page'] ?? 1;
  $page_items_limit = 9;

  // запрос в бд для получения количества найденных лотов
  $sql_lot_count = "SELECT * FROM lot
  JOIN category ON lot.category_id = category.id 
  WHERE end_date > NOW() AND MATCH (lot_name, lot_description) AGAINST(?)";

  $stmt = db_get_prepare_stmt($connection, $sql_lot_count, [$search_headers]);
  mysqli_stmt_execute($stmt);
  $lot_count_res = mysqli_stmt_get_result($stmt);
  $lot_count = mysqli_num_rows($lot_count_res);

  // формула расчета показа пагинации
  $pages_count = ceil($lot_count / $page_items_limit);
  $offset = ($cur_page - 1) * $page_items_limit;

  $pages = range(1, $pages_count);

  // запрос в бд для получения количества найденных лотов со смещением
  if ($lot_count) {
    $sql_search = "SELECT * FROM lot
    WHERE end_date > NOW() AND MATCH (lot_name, lot_description) AGAINST(?)
    ORDER BY creation_date DESC
    LIMIT $page_items_limit OFFSET $offset";
    $stmt = db_get_prepare_stmt($connection, $sql_search, [$search_headers]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $search_result = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  $page_content = include_template('search-lot.php', [
    'category' => $category_list,
    'lots' => $search_result,
    'search_headers' => $search_headers,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count,
    'pages' => $pages
    ]);
} else {
  $page_content = include_template('search-lot.php', [
    'category' => $category_list, 
    'lots' => false
    ]);
}

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Поиск'
]);

print($layout);