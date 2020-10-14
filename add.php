<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();
$category_list = category_list($connection);
$required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$errors = [];

$page_content = include_template('add-lot.php', [
  'category' => $category_list
  ]); 

if (isset($_SESSION['user'])) {
// данные из формы
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = $_POST;

    // валидация
    // проверяет поле на заполненность
    foreach ($required_fields as $field) {
      if (empty($_POST[$field])) {
          $errors[$field] = 'Заполните поле';
      }
    };

    // валидация загруженного файла
    if ($_FILES['picture']['name']) {
      $tmp_name = $_FILES['picture']['tmp_name'];
      $filename = uniqid() . $_FILES['picture']['name'];
      $form_data['path'] = 'uploads/' . $filename;
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $file_type = finfo_file($finfo, $tmp_name);
      
      if ($file_type === 'image/jpeg' || $file_type === 'image/png') {
        move_uploaded_file($_FILES['picture']['tmp_name'], 'uploads/' . $filename);
      } else {
        $errors['picture'] = 'Загрузите картинку в формате jpg/png';
      }
    } else {
      $errors['picture'] = 'Загрузите картинку в формате jpg/png';
    };

    if (strlen($form_data['lot-name']) > 100) {
      $errors['lot-name'] = 'Максимальная длинна поля 100 символов';
    };

    if ($form_data['category'] === 'Выберите категорию') {
      $errors['category'] = 'Категория не выбрана';
    };

    if (strlen($form_data['message']) > 255) {
      $errors['lot-name'] = 'Максимальная длинна поля 255 символов';
    };

    if ((int)$form_data['lot-rate'] <= 0 || !ctype_digit($form_data['lot-rate'])) {
      $errors['lot-rate'] = 'Введите целое число больше 0';
    };

    if ((int)$form_data['lot-step'] <= 0 || !ctype_digit($form_data['lot-step'])) {
      $errors['lot-step'] = 'Введите целое число больше 0';
    };

    if (!is_date_valid($form_data['lot-date']) || !is_time_left_24($form_data['lot-date'])) {
      $errors['lot-date'] = 'Введите дату в формате «ГГГГ-ММ-ДД», введеная дата должна отличаться от текущей минимум на 1 день';
    };

    if (!count($errors)) {
      $current_user_id = $_SESSION['user']['id'];
      $form_data['user_lot_add_id'] = $current_user_id;

      // подготовленное выражение для вставки в бд
      $sql_add_to_db = 'INSERT INTO lot (creation_date, lot_name, category_id, lot_description, start_price, bet_step, end_date, image, user_lot_add_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = db_get_prepare_stmt($connection, $sql_add_to_db, $form_data);
      $result = mysqli_stmt_execute($stmt);
    } else {
      $page_content = include_template('add-lot.php', [
        'category' => $category_list,
        'errors' => $errors,
        'form_data' => $form_data
        ]); 
    }

    if ($result) {
      $lot_id = mysqli_insert_id($connection);
      header('Location: lot.php?id=' . $lot_id);
    }
  }
} else {
  $page_content = include_template('403.php', [
    'category' => $category_list
    ]); 
}

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'category_list' => $category_list,
  'page_title' => 'Добавление нового лота'
]);

print($layout);