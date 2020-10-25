<?php
require_once('functions.php');
require_once('helpers.php');

$connection = connect_to_db();
$category_list = category_list($connection);
$required_fields = ['email', 'password'];
$errors = [];

$page_content = include_template('sign-in.php', [
    'category' => $category_list
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = $_POST;

    // валидация
    // проверяет поле на заполненность
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Заполните поле';
        }
    };

    // проверка корректности заполнения поля email
    if (strlen($form_data['email']) > 64) {
        $errors['email'] = 'Максимальная длинна поля 64 символа';
    };

    if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email';
    };

    // проверка корректности заполнения поля пароль
    if (strlen($form_data['password']) < 6 || strlen($form_data['password']) > 30) {
        $errors['password'] = 'Длина пароля должна быть от 6 до 30 символов';
    }

    if (!preg_match("/^[a-zA-Z0-9]+$/", $form_data['password'])) {
        $errors['password'] = 'Пароль должен содеражть только латинсие буквы и цифры';
    }

    // работа с бд
    if (!count($errors) && $connection) {
        $email = mysqli_real_escape_string($connection, $form_data['email']);
        $login_sql = "SELECT * FROM users WHERE email = '$email'";
        $login_result = mysqli_query($connection, $login_sql);

        $user = $login_result ? mysqli_fetch_array($login_result, MYSQLI_ASSOC) : null;

        if (mysqli_num_rows($login_result) < 1) {
            $errors['email'] = 'Введеный email не найден';
        }

        if (!password_verify($form_data['password'], $user['password'])) {
            $errors['password'] = 'Введеный пароль не верный';
        }

        if (!count($errors) && $user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: /index.php');
        }
    }

    if (count($errors)) {
        $page_content = include_template('sign-in.php', [
            'category' => $category_list,
            'errors' => $errors,
            'form_data' => $form_data
        ]);
    } elseif (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    }
} elseif (isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit();
}

$layout = include_template('layout.php', [
    'page_content' => $page_content,
    'category_list' => $category_list,
    'page_title' => 'Авторизация'
]);

print($layout);
