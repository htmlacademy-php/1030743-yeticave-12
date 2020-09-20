<?php
require_once('helpers.php');
require_once('functions.php');

$connection = connect_to_db();

if ($connection) {
  $sql_category_list = 'SELECT name, id FROM category';
  $result_category_list = mysqli_query($connection, $sql_category_list);
  $category_list = mysqli_fetch_all($result_category_list, MYSQLI_ASSOC);
};

$page_content = include_template('sign-up.php', [
  'category' => $category_list
  ]); 

  if (!isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form_data = $_POST;
    
      // валидация
      $required_fields = ['email', 'password', 'name', 'message'];
      $errors = [];
      
      // проверяет поле на заполненность
      foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Заполните поле';
        }
      };
    
      // валидация полей формы
      if (strlen($form_data['email']) > 64) {
        $errors['email'] = 'Максимальная длинна поля 64 символа';
      };

      if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email';
      }; 

      if (!$errors['email'] && $connection) {
        $email = mysqli_real_escape_string($connection, $form_data['email']);
        $email_sql = "SELECT email FROM users WHERE email = '$email'";
        $email_result = mysqli_query($connection, $email_sql);

        if (mysqli_num_rows($email_result) > 0) {
          $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
      };

      if (strlen($form_data['password']) < 6 || strlen($form_data['password']) > 30) {
        $errors['password'] = 'Длина пароля должна быть от 6 до 30 символов';
      } 

      if (!preg_match("/^[a-zA-Z0-9]+$/", $form_data['password'])) {
        $errors['password'] = 'Пароль должен содеражть только латинсие буквы и цифры';
      } 

      if (strlen($form_data['name']) > 100) {
        $errors['name'] = 'Максимальная длинна поля 100 символов';
      };

      if (strlen($form_data['message']) > 100) {
        $errors['message'] = 'Максимальная длинна поля 100 символов';
      };

      // подготовленное выражение для вставки в бд
      if (!count($errors)) {
        // хэширует пароль
        $password_hash = password_hash($form_data['password'], PASSWORD_DEFAULT);
        $form_data['password'] = $password_hash;
        
        $sql_add_to_db = 'INSERT INTO users (email, password, name, user_contacts) VALUES (?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql_add_to_db, $form_data);
        $result = mysqli_stmt_execute($stmt);
      } else {
        $page_content = include_template('sign-up.php', [
          'category' => $category_list,
          'errors' => $errors,
          'form_data' => $form_data
          ]); 
      }
    
      if ($result) {
        header('Location: login.php');
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
  'page_title' => 'Регистрация'
]);

print($layout);