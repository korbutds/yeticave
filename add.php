<?php
include_once './utils/helpers.php';
include_once './utils/model.php';
include_once './utils/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fields = $_POST;
  $lot_image = $_FILES['lot'];

  if (isset($lot_image)) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $lot_image['tmp_name']);

    if ($file_type === 'image/jpeg') {
      $ext = '.jpg';
    } else if ($file_type === 'image/png') {
      $ext = '.png';
    }

    $file_name = uniqid() . $ext;
    $file_path = __DIR__ . '/uploads/img/';
    $file_url = '/uploads/img/' . $file_name;
    move_uploaded_file($lot_image['tmp_name'], $file_path . $file_name);
    $fields['image'] = $file_url;
    $sql = 'INSERT INTO yeticave.lots (title, category_id, lot_description, start_price, step, date_creation, date_finish, user_id, image) VALUES ( ?, ?, ?, ?, ?, NOW(), ?, 1, ?)';
    $stmt = db_get_prepare_stmt($con, $sql, $fields);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
      $lot_id = mysqli_insert_id($con);

      header('Location: lot.php?id=' . $lot_id);
    }
  }
}

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
