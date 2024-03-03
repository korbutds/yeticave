<?php
require_once './utils/helpers.php';
require_once './utils/model.php';
require_once './utils/init.php';
header("X-Academy: keks");
$is_auth = rand(0, 1);

$user_name = 'Korbut Dmitriy';
$title = 'Main page';


if (!$con) {
  $error = mysqli_connect_error();
  print('Не удалось подключитсья к БД');
  exit;
}

$sql = get_categories_sql_query();
$cat_req = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($cat_req, MYSQLI_ASSOC);

$sql = get_lots_sql_query();
$lot_req = mysqli_query($con, $sql);
$lots = mysqli_fetch_all($lot_req, MYSQLI_ASSOC);


$page_content = include_template('main.php', ['categories' => $categories , 'lots' => $lots]);
$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
  'title' => $title,
  'user_name' => $user_name,
  'content' => $page_content,
  'categories' => $categories,
]);

print ($layout_content);

//$con = mysqli_connect("mysql", "root", "root", "yeticave");
//if (!$con) {
//  print("Ошибка подключения: " . mysqli_connect_error());
//}
//else {
//  mysqli_set_charset($con, "utf8");
//  echo mysqli_character_set_name($con);
//  $sql = "SELECT id, category FROM categories";
//  $result = mysqli_query($con, $sql);
//  if (!$result) {
//    $error = mysqli_error($con);
//    print("Ошибка MySQL: " . $error);
//  } else {
//    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
//  }
//
//  print("Соединение установлено");
//   выполнение запросов
//}

