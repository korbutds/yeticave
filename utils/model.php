<?php

function get_categories_sql_query() {
  return <<<SQL
SELECT id, category, character_code as category_code FROM yeticave.categories
SQL;
}

function get_lots_sql_query() {
  return <<<SQL
SELECT title, date_creation, date_finish, step, image, category, character_code as category_code, start_price as price, l.id as lot_id
FROM yeticave.lots l
LEFT JOIN yeticave.categories c
     ON l.category_id = c.id
ORDER BY date_creation DESC 
SQL;
}

function get_lot_info($lot) {
  return <<<SQL
    SELECT l.id as lot_id, date_creation, title, lot_description, image, date_finish, start_price, step, category 
    FROM yeticave.lots l
    LEFT JOIN yeticave.categories c
    ON l.category_id=c.id
    WHERE l.id=$lot;
SQL;
}
