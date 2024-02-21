DROP DATABASE IF EXISTS yeticave;

CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(128) NOT NULL UNIQUE,
    password CHAR(12) NOT NULL,
    date_registration DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_name VARCHAR(128),
    contacts TEXT
);

CREATE TABLE categories (
   id INT AUTO_INCREMENT PRIMARY KEY,
   category VARCHAR(128) UNIQUE,
   character_code VARCHAR(128) UNIQUE
);

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(255),
    lot_description TEXT,
    image VARCHAR(255),
    start_price INT,
    date_finish DATE,
    step INT,
    user_id INT,
    winner_id INT,
    category_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_bet DATETIME DEFAULT CURRENT_TIMESTAMP,
    price_bet INT,
    user_id INT,
    lot_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);

INSERT INTO categories (character_code, category)
VALUES
    ('boards', 'Доски и лыжи'),
    ('attachment', 'Крепления'),
    ('boots', 'Ботинки'),
    ('clothing', 'Одежда'),
    ('tools', 'Инструменты'),
    ('other', 'Разное');

INSERT INTO users
(email, user_name, password, contacts)
VALUES
    ('hero34@mail.ru', 'Ярослав', 'secretpassw1', '89191202527'),
    ('asis174@mail.ru', 'Слава', 'secretpassw2', '83512254836');

INSERT INTO lots
(title, lot_description, image, start_price, date_finish, step, user_id, category_id)
VALUES
    ('2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке', 'img/lot-1.jpg', 10999, '2021-08-10', 500, 1, 1),
    ('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке', 'img/lot-2.jpg', 159999, '2021-08-11', 1000, 2, 1),
    ('Крепления Union Contact Pro 2015 года размер L/XL', 'Хорошие крепления, надежные и легкие', 'img/lot-3.jpg', 8000, '2021-08-12', 500, 2, 2),
    ('Ботинки для сноуборда DC Mutiny Charocal', 'Теплые и красивые ботинки', 'img/lot-4.jpg', 10999, '2021-08-13', 600, 1, 3),
    ('Куртка для сноуборда DC Mutiny Charocal', 'Легкая, теплая и прочная куртка', 'img/lot-5.jpg', 7500, '2021-08-14', 500, 1, 4),
    ('Маска Oakley Canopy', 'Желтые очки, все будет веселенькое', 'img/lot-6.jpg', 5400, '2021-08-15', 100, 1, 6);

INSERT INTO bets
(price_bet, user_id, lot_id)
VALUES
    (8500, 1, 4);
INSERT INTO bets
(price_bet, user_id, lot_id)
VALUES
    (9000, 1, 4);


SELECT category AS 'Категории' FROM categories;


SELECT lots.title, lots.start_price, lots.image, categories.category
FROM lots JOIN categories ON lots.category_id=categories.id;

SELECT lots.id, lots.date_creation, lots.title, lots.lot_description, lots.image, lots.start_price, lots.date_finish, lots.step, categories.category
FROM lots JOIN categories ON lots.category_id=categories.id
WHERE lots.id=4;

UPDATE lots
SET title='Ботинки для сноуборда обычные'
WHERE id=4;

SELECT bets.date_bet, bets.price_bet, lots.title, users.user_name
FROM bets
         JOIN lots ON bets.lot_id=lots.id
         JOIN users ON bets.user_id=users.id
WHERE lots.id=4
ORDER BY bets.date_bet DESC;