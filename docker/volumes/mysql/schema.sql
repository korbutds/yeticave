CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL
);

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(128) NOT NULL,
    category_id INT DEFAULT NULL,
    price DECIMAL NOT NULL,
    image VARCHAR(128) NOT NULL,
    timer TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
   id INT AUTO_INCREMENT PRIMARY KEY,
   category VARCHAR(128) NOT NULL UNIQUE
);