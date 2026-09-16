CREATE DATABASE IF NOT EXISTS my_guitar_shop;
USE my_guitar_shop;

CREATE TABLE IF NOT EXISTS categories (
    categoryID INT NOT NULL AUTO_INCREMENT,
    categoryName VARCHAR(255) NOT NULL,
    PRIMARY KEY (categoryID),
    UNIQUE KEY uq_categories_name (categoryName)
);