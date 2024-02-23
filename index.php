<?php
require_once './helpers.php';
require_once './init.php';
require_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Korbut Dmitriy'; // укажите здесь ваше имя
$title = 'Main page';

$categories = [];
$lots = [];
$page_content = '';

if (!$con) {
  $page_content = 'ERROR, achtung!!!';
} else {
  $sql = 'SELECT category, character_code as code FROM yeticave.categories';
  $res = mysqli_query($con, $sql);
  if ($res) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
  } else {
    $page_content = 'ERROR, achtung!!!';
  }

  $sql = get_lots()å;
  $res = mysqli_query($con, $sql);
  if ($res) {
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
  } else {
    $page_content = 'ERROR, achtung!!!';
  }
}

$page_content = include_template('main.php', ['categories' => $categories , 'lots' => $lots]);

$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
  'title' => $title,
  'user_name' => $user_name,
  'content' => $page_content,
  'categories' => $categories,
]);

print ($layout_content);
