-- db ddl commands for creation
-- for db setup view the config.ini file in backend folder
-- host=127.0.0.1
-- name=62167_ivan_chuchulski
-- user=root
-- password=

CREATE DATABASE IF NOT EXISTS `web_schedule`;

USE `web_schedule`;

-- Таблица: user
-- Ключ: username
CREATE TABLE IF NOT EXISTS `user` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`username`)
);

-- Таблица: presentation
-- Ключ: id
CREATE TABLE IF NOT EXISTS `presentation` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `presenterName` VARCHAR(255) NOT NULL,
  `facultyNumber` VARCHAR(20) NOT NULL,
  `date` DATE NOT NULL,
  `place` VARCHAR(100) NOT NULL
);

-- Таблица: preference
-- Ключ: id
-- Външен ключ: username -> user(username)
-- Външен ключ: presentationId -> presentation(id)
CREATE TABLE IF NOT EXISTS `preference` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL,
  `presentationId` INT NOT NULL,
  `preferenceType` ENUM('attending', 'not_attending', 'maybe'),
  FOREIGN KEY (`username`) REFERENCES `user`(`username`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`presentationId`) REFERENCES `presentation`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
);