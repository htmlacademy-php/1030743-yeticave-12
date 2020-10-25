<?php
require_once('helpers.php');
require_once('functions.php');

session_start();
$connection = connect_to_db();
$category_list = category_list($connection);
$category_name = null;

$page_content = include_template('categories.php', [
    'category' => $category_list
]);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // получения заголовка категории
    $category_headers = check_array_key($_GET, 'id') ?? '';

    $cur_page = check_array_key($_GET, 'page') ?? 1;
    $page_items_limit = 9;

    // запрос в бд для получения количества найденных лотов
    $sql_category_lots = 'SELECT lot.id, creation_date, lot_name, start_price, end_date, category_id, 
    image, category.name, category.character_code FROM lot
    JOIN category ON lot.category_id = category.id 
    WHERE end_date > NOW() AND category.id = (?)
    ORDER BY creation_date DESC';
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
    if ($lot_count) {
        $sql_category_lots = "SELECT lot.id, lot_name, start_price, end_date, category_id, 
        image, lot_description, category.name, category.character_code FROM lot
        JOIN category ON lot.category_id = category.id 
        WHERE end_date > NOW() AND category.id = (?)
        LIMIT $page_items_limit OFFSET $offset";
        $stmt = db_get_prepare_stmt($connection, $sql_category_lots, [$category_headers]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $category_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $category_name = check_array_key($category_lots['0'], 'name');

        $page_content = include_template('categories.php', [
            'category' => $category_list,
            'lots' => $category_lots,
            'cur_page' => $cur_page,
            'pages_count' => $pages_count,
            'pages' => $pages,
            'category_name' => $category_name
        ]);
    }
} else {
    $page_content = include_template('404.php', [
        'category' => $category_list
    ]);
}

$layout = include_template('layout.php', [
    'page_content' => $page_content,
    'category_list' => $category_list,
    'category_name' => $category_name,
    'page_title' => 'Лоты по категориям'
]);

print($layout);