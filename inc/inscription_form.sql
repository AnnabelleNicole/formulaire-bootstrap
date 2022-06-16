SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

DROP DATABASE IF EXISTS `inscription_form`;
CREATE DATABASE `inscription_form`;
USE `inscription_form`;

CREATE TABLE `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `first_name` varchar(25) NOT NULL,
    `last_name` varchar(25) NOT NULL,
    `mail` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

