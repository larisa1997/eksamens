-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 07 2016 г., 20:49
-- Версия сервера: 5.6.17
-- Версия PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kases_aparati`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com_date` text NOT NULL,
  `com_user` text NOT NULL,
  `com_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `com_date`, `com_user`, `com_text`) VALUES
(30, '14:23 - 05.12.2016', 'Admin', 'test 1'),
(32, '14:23 - 05.12.2016', 'Admin', 'test 3'),
(39, '20:33 - 07.12.2016', 'Larisa', 'aaa'),
(38, '17:04 - 06.12.2016', 'Vasya', 'asd');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `status` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `status`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Admin', 'admin'),
(4, 'user', '5f4dcc3b5aa765d61d8327deb882cf99', 'Larisa', 'user'),
(5, '123', '202cb962ac59075b964b07152d234b70', 'Vasya', 'user'),
(6, 'karina', 'a37b2a637d2541a600d707648460397e', 'Karina', 'user'),
(7, 'adnris', 'd6270c0e7dea8b3fc5b3d02f4ff30b8f', 'Andris', 'user'),
(8, 'asd', '7815696ecbf1c96e6894b779456d330e', 'aaa', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
