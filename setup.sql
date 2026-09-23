CREATE DATABASE IF NOT EXISTS my_guitar_shop;
USE my_guitar_shop;

CREATE TABLE IF NOT EXISTS categories (
    categoryID INT NOT NULL AUTO_INCREMENT,
    categoryName VARCHAR(255) NOT NULL,
    PRIMARY KEY (categoryID),
    UNIQUE KEY uq_categories_name (categoryName)
);

CREATE TABLE IF NOT EXISTS products (
    productID INT NOT NULL AUTO_INCREMENT,
    categoryID INT NOT NULL,
    productCode VARCHAR(10) NOT NULL,
    productName VARCHAR(255) NOT NULL,
    listPrice DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (productID),
    UNIQUE KEY uq_products_code (productCode),
    KEY idx_products_category (categoryID),
    CONSTRAINT fk_products_categories FOREIGN KEY (categoryID) REFERENCES categories(categoryID)
);