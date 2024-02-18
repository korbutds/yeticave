<?php
require_once './helpers.php';
$is_auth = rand(0, 1);

$user_name = 'Korbut Dmitriy'; // укажите здесь ваше имя
$title = 'Main page';

$categories = [
  'boards' => 'Доски и лыжи',
  'attachment' => 'Крепления',
  'boots' => 'Ботинки',
  'clothing' => 'Одежда',
  'tools' => 'Инструменты',
  'other' => 'Разное',
];

$lots = [
  [
    'title' => '2014 Rossignol District Snowboard',
    'category' => $categories['boards'],
    'price' => 10999,
    'image' => 'img/lot-1.jpg',
    'timer' => '2024-02-13',
  ],
  [
    'title' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => $categories['boards'],
    'price' => 159999,
    'image' => 'img/lot-2.jpg',
    'timer' => '2024-02-25',
  ],
  [
    'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => $categories['attachment'],
    'price' => 8000,
    'image' => 'img/lot-3.jpg',
    'timer' => '2024-02-24',
  ],
  [
    'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => $categories['boots'],
    'price' => 10999,
    'image' => 'img/lot-4.jpg',
    'timer' => '2024-02-26',
  ],
  [
    'title' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => $categories['clothing'],
    'price' => 7500,
    'image' => 'img/lot-5.jpg',
    'timer' => '2024-02-25',
  ],
  [
    'title' => 'Маска Oakley Canopy',
    'category' => $categories['other'],
    'price' => 540,
    'image' => 'img/lot-6.jpg',
    'timer' => '2024-02-24',
  ],
];

function sum_formatting(int $num): string {
  $num = ceil($num);

  if ($num >= 1000) {
      $num = number_format($num, 0, '', ' ');
  }

  return $num . ' ₽';
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

$con = mysqli_connect("mysql", "root", "root", "yeticave");
if (!$con) {
  print("Ошибка подключения: " . mysqli_connect_error());
}
else {
  mysqli_set_charset($con, "utf8");
  echo mysqli_character_set_name($con);
  $sql = "SELECT id, category FROM categories";
  $result = mysqli_query($con, $sql);

  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
  var_dump($rows);

  foreach ($rows as $row) {
    print("Категория: " . $row['category']);
  }
  print("Соединение установлено");
  // выполнение запросов
}
