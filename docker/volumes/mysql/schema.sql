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
)