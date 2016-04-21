-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2016 г., 19:46
-- Версия сервера: 5.6.29
-- Версия PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testzad3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--
-- Создание: Апр 21 2016 г., 15:32
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(100) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `text` text NOT NULL,
  `user_ip` varchar(35) DEFAULT NULL,
  `user_browser` varchar(100) DEFAULT NULL,
  `created_data` date DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `userName`, `email`, `text`, `user_ip`, `user_browser`, `created_data`, `url`) VALUES
(71, 'asdasd', 'screppi@gmail.com', 'assfasf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(72, 'asdasd', 'screppi@gmail.com', 'assfasf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(73, 'asdasd', 'screppi@gmail.com', 'assfasf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(74, 'asdasd', 'screppi@gmail.com', 'assfasf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(90, 'Vasil', 'fgrr@ggg.com', 'adasdasd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(92, 'Vasil', 'fgrr@ggg.com', 'adasdasd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(93, 'Vasil', 'fgrr@ggg.com', 'adasdasd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(94, 'Vasil', 'fgrr@ggg.com', 'adasdasd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Saf', '2016-04-21', 'testimage.jpg'),
(95, '', '', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '2016-04-21', ''),
(96, '', '', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '2016-04-21', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
