<?php
require_once("./utils/helpers.php");
require_once("./utils/functions.php");
require_once("./utils/data.php");
require_once("./utils/init.php");
require_once("./utils/models.php");


$categories = get_categories($con);

$sql = get_query_list_lots ('2021-07-15');

$res = mysqli_query($con, $sql);
if ($res) {
  $goods = get_arrow($res);
} else {
  $error = mysqli_error($con);
}

$page_content = include_template("main.php", [
  "categories" => $categories,
  "goods" => $goods
]);
$layout_content = include_template("layout.php", [
  "content" => $page_content,
  "categories" => $categories,
  "title" => "Главная",
  "is_auth" => $is_auth,
  "user_name" => $user_name
]);

print($layout_content);

