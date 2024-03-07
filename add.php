<?php
include_once './utils/helpers.php';
include_once './utils/model.php';
include_once './utils/init.php';


if (!$con) {
  die('No connection');
}

$sql = get_categories_sql_query();
$categories_req = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($categories_req, MYSQLI_ASSOC);
$cats_ids = array_column($categories, 'id');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
  $rules = [
    'category' => function ($value) use ($cats_ids) {
      return validate_category($value, $cats_ids);
    },
    'lot-rate' => function ($value) {
      return validate_price($value);
    },
    'lot-step' => function ($value) {
      return validate_step($value);
    },
    'lot-data' => function ($value) {
      return is_date_valid($value);
    }
  ];

  $fields = [
    'lot-name' => FILTER_UNSAFE_RAW,
    'category' => FILTER_UNSAFE_RAW,
    'message' => FILTER_UNSAFE_RAW,
    'lot-rate' => FILTER_UNSAFE_RAW,
    'lot-step' => FILTER_UNSAFE_RAW,
    'lot-date' => FILTER_UNSAFE_RAW,
  ];
  $lot = filter_input_array(INPUT_POST, $fields, true);

  foreach ($lot as $key => $value) {
    if (isset($rules[$key])) {
      $rule = $rules[$key];
      $errors[$key] = $rule($value);
    }

    if (in_array($key, $required_fields) && empty($value)) {
      $errors[$key] = "Поле нужно заполнить";
    }
  }

  $errors = array_filter($errors);

  $lot_image = $_FILES['lot'];

  if (!empty($lot_image['tmp_name'])) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $lot_image['tmp_name']);

    if ($file_type !== 'image/jpeg' && $file_type !== 'image/png') {
      $errors['image'] = 'Загрузи картинку в формате jpeg или png';
    } else {
      $ext = '.jpg';
      if ($file_type === 'image/png') {
        $ext = '.png';
      }

      $file_name = uniqid() . $ext;
      $file_path = __DIR__ . '/uploads/img/';
      $file_url = '/uploads/img/' . $file_name;
      move_uploaded_file($lot_image['tmp_name'], $file_path . $file_name);
      $lot['image'] = $file_url;
      $sql = 'INSERT INTO yeticave.lots (title, category_id, lot_description, start_price, step, date_creation, date_finish, user_id, image) VALUES ( ?, ?, ?, ?, ?, NOW(), ?, 1, ?)';
      $stmt = db_get_prepare_stmt($con, $sql, $lot);
      $res = mysqli_stmt_execute($stmt);

      if ($res) {
        $lot_id = mysqli_insert_id($con);
        header('Location: lot.php?id=' . $lot_id);
      }
    }
  } else {
    $errors['image'] = 'Необходимо загрузить изображение';
  }
} else {
  $content = include_template('add_lot.php', [
    'categories' => $categories,
  ]);
}

if (count($errors)) {
  $content = include_template('add_lot.php', [
    'categories' => $categories,
    'errors' => $errors,
  ]);
}

$is_auth = rand(0, 1);

$user_name = 'Korbut Dmitriy';
$title = 'Main page';
$head = '<link href="/css/flatpickr.min.css" rel="stylesheet" />';

$sql = get_categories_sql_query();
$categories_req = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($categories_req, MYSQLI_ASSOC);

$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
  'title' => $title,
  'user_name' => $user_name,
  'content' => $content,
  'categories' => $categories,
  'head' => $head,
]);

print($layout_content);
