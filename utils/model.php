<?php

function get_categories_sql_query() {
  return <<<SQL
SELECT category, character_code as category_code FROM yeticave.categories
SQL;
}

function get_lots_sql_query() {
  return <<<SQL
SELECT title, date_creation, date_finish, step, image, category, character_code as category_code, start_price as price
FROM yeticave.lots l
LEFT JOIN yeticave.categories c
     ON l.category_id = c.id
ORDER BY date_creation DESC 
SQL;
}
