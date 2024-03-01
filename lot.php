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

$lot = filter_input(INPUT_GET, 'lot', FILTER_SANITIZE_NUMBER_INT);

if (!$lot) {
  die('error');
}

$sql = get_categories_sql_query();
$categories_res = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($categories_res, MYSQLI_ASSOC);

$sql = get_lot_info($lot);
$lots_res = mysqli_query($con, $sql);
$lot = mysqli_fetch_assoc($lots_res);

$lot_info = include_template('lot_info.php', [
  "categories" => $categories,
  "lot" => $lot,
]);
$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
  'title' => $title,
  'user_name' => $user_name,
  'content' => $lot_info,
  'categories' => $categories,
]);

print ($layout_content);