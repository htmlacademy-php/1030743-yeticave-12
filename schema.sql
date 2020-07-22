-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 07 2020 г., 20:18
-- Версия сервера: 5.7.25
-- Версия PHP: 7.3.9


CREATE DATABASE yeticave;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yeticave`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bet`
--

USE yeticave;

CREATE TABLE `bet` (
  `id` int(11) NOT NULL,
  `creation_date` timestamp NULL DEFAULT NULL,
  `bet_price` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lot_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text,
  `character_code` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lot`
--

CREATE TABLE `lot` (
  `id` int(11) NOT NULL,
  `creation_date` timestamp NULL DEFAULT NULL,
  `lot_name` varchar(100) DEFAULT NULL,
  `lot_description` varchar(100) DEFAULT NULL,
  `image` text,
  `start_price` decimal(60,0) DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `bet_step` int(11) DEFAULT NULL,
  `user_lot_add_id` int(11) DEFAULT NULL,
  `user_winner_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `name` text,
  `password` varchar(128) DEFAULT NULL,
  `user_contacts` text,
  `lot_id` int(11) DEFAULT NULL,
  `bet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bet`
--
ALTER TABLE `bet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `characte_code` (`character_code`);

--
-- Индексы таблицы `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lot_index` (`lot_description`),
  ADD KEY `lot_index_desription` (`lot_description`),
  ADD KEY `lot_index_name` (`lot_name`),
  ADD KEY `lot_name` (`lot_name`),
  ADD KEY `index_desc` (`lot_description`),
  ADD KEY `index_name` (`lot_name`),
  ADD KEY `idesc` (`lot_description`),
  ADD KEY `ind_desc` (`lot_description`),
  ADD KEY `ind_name` (`lot_name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `e_mail` (`email`),
  ADD UNIQUE KEY `pass` (`password`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bet`
--
ALTER TABLE `bet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lot`
--
ALTER TABLE `lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
