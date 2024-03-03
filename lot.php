<?php
include_once './utils/helpers.php';
include_once './utils/model.php';
include_once './utils/init.php';

$is_auth = rand(0, 1);

$user_name = 'Korbut Dmitriy';
$title = 'Main page';

if (!$con) {
  die('error');
}

$sql = get_categories_sql_query();
$categories_res = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($categories_res, MYSQLI_ASSOC);

$id = filter_input(INPUT_GET, 'lot', FILTER_SANITIZE_NUMBER_INT);
$page_404 = include_template('404.php', [
  'categories' => $categories
]);

if (!$id) {
  print($page_404);
  die();
}

$sql = get_lot_info($id);
$lots_res = mysqli_query($con, $sql);
$lot = mysqli_fetch_assoc($lots_res);

if (!$lot) {
  print($page_404);
  die();
}

$content = include_template('lot_info.php', [
  "categories" => $categories,
  "lot" => $lot,
]);

$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
  'title' => $title,
  'user_name' => $user_name,
  'content' => $content,
  'categories' => $categories,
]);

print ($layout_content);

