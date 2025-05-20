-- db ddl commands for creation
-- for db setup view the config.ini file in backend folder
-- host=127.0.0.1
-- name=62167_ivan_chuchulski
-- user=root
-- password=

CREATE DATABASE IF NOT EXISTS `web_schedule`;

USE `web_schedule`;

-- Таблица: user
CREATE TABLE IF NOT EXISTS `user` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`username`)
);