

CREATE DATABASE IF NOT EXISTS smart_market CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smart_market;

CREATE TABLE IF NOT EXISTS users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    nom      VARCHAR(100) NOT NULL,
    prenom   VARCHAR(100) NOT NULL,
    email    VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone    VARCHAR(20)  DEFAULT '',
    address  TEXT         DEFAULT NULL,
    created_at DATETIME   DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS categories (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(200) NOT NULL,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL DEFAULT 0,
    image       VARCHAR(500)  DEFAULT '',
    colors      VARCHAR(255)  DEFAULT '',
    stock       INT           DEFAULT 0,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    name       VARCHAR(100) NOT NULL DEFAULT '',
    phone      VARCHAR(20)  NOT NULL DEFAULT '',
    address    TEXT         NOT NULL,
    total      DECIMAL(10,2) NOT NULL DEFAULT 0,
    status     VARCHAR(20)   DEFAULT 'pending',
    created_at DATETIME      DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT           NOT NULL DEFAULT 1,
    price      DECIMAL(10,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS payments (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    order_id       INT NOT NULL,
    amount         DECIMAL(10,2) NOT NULL,
    status         VARCHAR(20)   DEFAULT 'pending',
    payment_method VARCHAR(50)   DEFAULT 'unknown',
    created_at     DATETIME      DEFAULT NOW(),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);
