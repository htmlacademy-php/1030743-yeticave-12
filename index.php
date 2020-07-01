<?php
require_once('helpers.php');
require_once('templates/data.php');

$page_content = include_template('main.php', [
  'categories' => $categories,
  'announcements' => $announcements
]); 

$layout = include_template('layout.php', [
  'page_content' => $page_content,
  'categories' => $categories,
  'page_title' => 'Yeti Cave',
  'is_auth' => $is_auth, 
  'user_name' => $user_name
]);

print($layout);

