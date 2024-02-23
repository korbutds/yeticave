<?php

function get_lots() {
  return 'SELECT title, category, start_price as price, image, date_creation as timer
          FROM yeticave.lots as lots 
          INNER JOIN yeticave.categories as categories 
          ON lots.category_id = categories.id
          WHERE date_creation < NOW()
          ORDER BY date_finish DESC;'
}
