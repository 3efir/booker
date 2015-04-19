-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 19 2015 г., 23:59
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
-- Структура таблицы `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
`idApp` int(11) NOT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `idEmp` int(11) NOT NULL,
  `idRoom` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idParent` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`idApp`, `date`, `start`, `end`, `idEmp`, `idRoom`, `description`, `idParent`) VALUES
(1, '2015-04-20', '06:06:00', '07:07:00', 2, 1, '123', NULL),
(8, '2015-04-21', '06:30:00', '08:00:00', 2, 1, 'test', NULL),
(9, '2015-04-22', '13:00:00', '15:30:00', 2, 1, 'test2', NULL),
(19, '2015-04-23', '18:00:00', '20:00:00', 2, 1, 'recurring', NULL),
(20, '2015-04-30', '18:00:00', '20:00:00', 2, 1, 'recurring', 19),
(21, '2015-05-07', '18:00:00', '20:00:00', 2, 1, 'recurring', 19),
(22, '2015-05-14', '18:00:00', '20:00:00', 2, 1, 'recurring', 19),
(49, '2015-04-24', '14:00:00', '15:00:00', 2, 1, 'asda', NULL),
(50, '2015-05-24', '14:00:00', '15:00:00', 2, 1, 'asda', 49);

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `name`, `pass`, `email`, `isAdmin`) VALUES
(1, 'admin', '$2y$10$TAY0VaGZhdlB1mqKMIVYou5UfTsEZvmVSsYXK5wCaLMLi8mf9IAUy', 'admin@admin.ru', 1),
(2, 'vasya pupkin', '$2y$10$TAY0VaGZhdlB1mqKMIVYou5UfTsEZvmVSsYXK5wCaLMLi8mf9IAUy', 'vasya@mail.ru', 0);

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
-- Индексы таблицы `appointments`
--
ALTER TABLE `appointments`
 ADD PRIMARY KEY (`idApp`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
 ADD PRIMARY KEY (`idRoom`), ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `appointments`
--
ALTER TABLE `appointments`
MODIFY `idApp` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
MODIFY `idRoom` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
