CREATE DATABASE wst1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE wst1;

CREATE TABLE users(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	surname VARCHAR(255) NOT NULL,
	slug VARCHAR(255) NOT NULL,
 	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(64) NOT NULL,
	salt VARCHAR(32) NOT NULL,
	addr VARCHAR(255) NOT NULL,
	town VARCHAR(255) NOT NULL,
	country VARCHAR(255) NOT NULL,
	phone VARCHAR(255) NOT NULL,
	registered_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	deleted VARCHAR(255) NOT NULL,
	orders_id VARCHAR(255) NOT NULL UNIQUE
) Engine = InnoDB;

CREATE TABLE products(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	info VARCHAR(255) NOT NULL
) Engine = InnoDB;

CREATE TABLE articles(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	product VARCHAR(255) NOT NULL,
	title VARCHAR(255) NOT NULL,
	info VARCHAR(255) NOT NULL,
	price VARCHAR(255) NOT NULL,
	code VARCHAR(255) NOT NULL,
	page VARCHAR(255) NOT NULL
) Engine = InnoDB;

CREATE TABLE orders(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	id_user INT UNSIGNED NOT NULL,
	id_article VARCHAR(255) NOT NULL,
	quantity INT UNSIGNED NOT NULL,
	price VARCHAR(255) NOT NULL
) Engine = InnoDB;
