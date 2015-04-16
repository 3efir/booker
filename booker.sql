-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 17 2015 г., 00:07
-- Версия сервера: 5.6.21
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `booker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ampointments`
--

CREATE TABLE IF NOT EXISTS `ampointments` (
`idApp` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idEmp` int(11) NOT NULL,
  `idRoom` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idParent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `empoyees`
--

CREATE TABLE IF NOT EXISTS `empoyees` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `empoyees`
--

INSERT INTO `empoyees` (`id`, `name`, `pass`, `email`, `isAdmin`) VALUES
(1, 'admin', '$2y$10$TAY0VaGZhdlB1mqKMIVYou5UfTsEZvmVSsYXK5wCaLMLi8mf9IAUy', 'admin@admin.ru', 1),
(2, 'vasya pupkin', '$2y$10$TAY0VaGZhdlB1mqKMIVYou5UfTsEZvmVSsYXK5wCaLMLi8mf9IAUy', 'vasya@mail.ru', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parent`
--

INSERT INTO `parent` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE IF NOT EXISTS `room` (
`idRoom` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `room`
--

INSERT INTO `room` (`idRoom`, `name`) VALUES
(1, 'BoardRoom1'),
(2, 'BoardRoom2'),
(3, 'BoardRoom3');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ampointments`
--
ALTER TABLE `ampointments`
 ADD PRIMARY KEY (`idApp`);

--
-- Индексы таблицы `empoyees`
--
ALTER TABLE `empoyees`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `parent`
--
ALTER TABLE `parent`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
 ADD PRIMARY KEY (`idRoom`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ampointments`
--
ALTER TABLE `ampointments`
MODIFY `idApp` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `empoyees`
--
ALTER TABLE `empoyees`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `parent`
--
ALTER TABLE `parent`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
MODIFY `idRoom` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
