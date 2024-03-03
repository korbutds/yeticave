<?php
include_once './utils/helpers.php';
include_once './utils/model.php';
include_once './utils/init.php';

if (!$con) {
  die('No connection');
}

$is_auth = rand(0, 1);

$user_name = 'Korbut Dmitriy';
$title = 'Main page';
$head = '<link href="/css/flatpickr.min.css" rel="stylesheet" />';

$sql = get_categories_sql_query();
$categories_req = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($categories_req, MYSQLI_ASSOC);

$content = include_template('add_lot.php', [
  'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
  'title' => $title,
  'user_name' => $user_name,
  'content' => $content,
  'categories' => $categories,
  'head' => $head,
]);

print($layout_content);
