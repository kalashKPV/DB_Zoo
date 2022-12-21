-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 20 2022 г., 10:31
-- Версия сервера: 10.4.25-MariaDB
-- Версия PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zoo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `animal`
--

CREATE TABLE `animal` (
  `animalID` bigint(20) UNSIGNED NOT NULL,
  `kind` varchar(60) NOT NULL,
  `diet` varchar(60) NOT NULL,
  `employeeID` bigint(20) UNSIGNED NOT NULL,
  `sectionID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `animal`
--

INSERT INTO `animal` (`animalID`, `kind`, `diet`, `employeeID`, `sectionID`) VALUES
(1, 'Ведмідь бурий', 'м&#039;ясо, фрукти', 7, 1),
(2, 'Какаду рожевий', 'комахи, насіння', 10, 3),
(3, 'Варан комодський', 'м\'ясо, риба', 4, 2),
(4, 'Риба-клоун', 'водорості, Артемія', 9, 4),
(5, 'Лев', 'м\'ясо, фрукти', 8, 1),
(6, 'Папуга Ара', 'комахи, насіння', 3, 2),
(7, 'Панда', 'м\'ясо, фрукти, бамбук', 6, 1),
(8, 'Тритон', 'рибки, черві', 4, 2),
(9, 'Рибка Дорі', 'водорості', 9, 4),
(10, 'Тигр', 'м\'ясо, фрукти', 8, 1),
(12, 'Риба-клоун', 'водорості, Артемія', 10, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `custom`
--

CREATE TABLE `custom` (
  `customID` bigint(20) UNSIGNED NOT NULL,
  `souvenirID` bigint(20) UNSIGNED NOT NULL,
  `visitorID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `custom`
--

INSERT INTO `custom` (`customID`, `souvenirID`, `visitorID`) VALUES
(1, 1, 1),
(2, 4, 1),
(3, 2, 8),
(4, 3, 10),
(5, 4, 6),
(6, 6, 11),
(7, 5, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `employee`
--

CREATE TABLE `employee` (
  `employeeID` bigint(20) UNSIGNED NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `data_birth` date NOT NULL,
  `post` varchar(60) NOT NULL,
  `wage` int(11) NOT NULL,
  `experience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `employee`
--

INSERT INTO `employee` (`employeeID`, `lastName`, `firstName`, `data_birth`, `post`, `wage`, `experience`) VALUES
(1, 'Боженко', 'Олег', '1992-11-19', 'Касир', 8000, 5),
(2, 'Лук\'яненко', 'Ольга', '1997-03-13', 'Продавець', 8000, 7),
(3, 'Абрамець', 'Василь', '2001-06-20', 'Доглядаючий', 10000, 3),
(4, 'Балан', 'Олександра', '2002-09-23', 'Доглядаючий', 8000, 2),
(5, 'Балич', 'Віктор', '1985-07-12', 'Касир', 8500, 10),
(6, 'Базюк', 'Маргарита', '1997-08-27', 'Доглядаючий', 11000, 6),
(7, 'Кривденко', 'Надія', '1999-09-13', 'Продавець', 8100, 4),
(8, 'Коваль ', 'Андрій', '1996-11-05', 'Доглядаючий', 9500, 5),
(9, 'Олійник', 'Наталія', '2000-08-15', 'Доглядаючий', 8500, 2),
(10, 'Поліщук', 'Володимир', '2000-07-13', 'Доглядаючий', 8000, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `section`
--

CREATE TABLE `section` (
  `sectionID` bigint(20) UNSIGNED NOT NULL,
  `type_of_animals` varchar(60) NOT NULL,
  `number_of_species` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `section`
--

INSERT INTO `section` (`sectionID`, `type_of_animals`, `number_of_species`, `number`) VALUES
(1, 'Ссавці', 6, 15),
(2, 'Плазуни', 9, 23),
(3, 'Птахи', 10, 32),
(4, 'Риби', 15, 54);

-- --------------------------------------------------------

--
-- Структура таблицы `souvenir`
--

CREATE TABLE `souvenir` (
  `souvenirID` bigint(20) UNSIGNED NOT NULL,
  `sname` varchar(60) NOT NULL,
  `price` float NOT NULL,
  `employeeID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `souvenir`
--

INSERT INTO `souvenir` (`souvenirID`, `sname`, `price`, `employeeID`) VALUES
(1, 'Магніт', 29.99, 7),
(2, 'Плюшева іграшка Ведмедик', 109, 2),
(3, 'Плюшева іграшка Лев', 119.9, 2),
(4, 'Брелок', 8.5, 7),
(5, 'Браслет', 15, 7),
(6, 'Плюшева іграшка Тигр', 119, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE `ticket` (
  `ticketID` bigint(20) UNSIGNED NOT NULL,
  `time` datetime NOT NULL,
  `visitorID` bigint(20) UNSIGNED NOT NULL,
  `sectionID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `ticket`
--

INSERT INTO `ticket` (`ticketID`, `time`, `visitorID`, `sectionID`) VALUES
(1, '2022-11-05 11:01:00', 11, 2),
(2, '2022-11-03 11:00:00', 3, 2),
(3, '2022-11-04 11:30:00', 8, 4),
(4, '2022-11-05 11:30:00', 4, 4),
(5, '2022-11-05 12:10:00', 10, 1),
(6, '2022-11-05 12:10:00', 5, 1),
(7, '2022-11-05 13:30:00', 1, 3),
(8, '2022-11-05 13:30:00', 2, 3),
(9, '2022-11-04 13:00:00', 9, 1),
(10, '2022-11-05 13:00:00', 6, 1),
(11, '2022-11-05 10:30:00', 7, 2),
(13, '2022-11-05 10:59:00', 11, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `usertbl`
--

CREATE TABLE `usertbl` (
  `id` int(11) NOT NULL,
  `lastName` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `firstName` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_admin` enum('0','1','2') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `usertbl`
--

INSERT INTO `usertbl` (`id`, `lastName`, `firstName`, `email`, `username`, `password`, `is_admin`) VALUES
(3, '1', '', 'kpv2004f@gmail.com', 'pavlobd22', '123', '2'),
(58, '123', '', 'kpv2004f@gmail.com', '123', '123', '2'),
(57, '12', '', 'kpv2004f@gmail.com', '12', '12', '0'),
(59, 'Петренко', 'Павло', 'kpv2004f@gmail.com', 'pavlo', 'pavlo', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `visitor`
--

CREATE TABLE `visitor` (
  `visitorID` bigint(20) UNSIGNED NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `visitor`
--

INSERT INTO `visitor` (`visitorID`, `lastName`, `firstName`, `age`) VALUES
(1, 'Петренко', 'Павло', 19),
(2, 'Петренко', 'Євгеній ', 17),
(3, 'Антоненко', 'Григорій', 17),
(4, 'Даниленко', 'Василь', 24),
(5, 'Шевченко', 'Дмитро', 22),
(6, 'Грищенко', 'Олексій', 25),
(7, 'Сковорода', 'Андрій', 28),
(8, 'Микитюк', 'Анна', 8),
(9, 'Андрієнко', 'Олена', 10),
(10, 'Крутоголов', 'Олександр', 7),
(11, 'Антонова', 'Вікторія', 21);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `animal`
--
ALTER TABLE `animal`
  ADD UNIQUE KEY `animalID` (`animalID`),
  ADD KEY `employeeID` (`employeeID`,`sectionID`),
  ADD KEY `sectionID` (`sectionID`);

--
-- Индексы таблицы `custom`
--
ALTER TABLE `custom`
  ADD UNIQUE KEY `customID` (`customID`),
  ADD KEY `visitorID` (`visitorID`),
  ADD KEY `souvenirID` (`souvenirID`),
  ADD KEY `visitorID_2` (`visitorID`);

--
-- Индексы таблицы `employee`
--
ALTER TABLE `employee`
  ADD UNIQUE KEY `employeeID` (`employeeID`);

--
-- Индексы таблицы `section`
--
ALTER TABLE `section`
  ADD UNIQUE KEY `sectionID` (`sectionID`);

--
-- Индексы таблицы `souvenir`
--
ALTER TABLE `souvenir`
  ADD UNIQUE KEY `souvenirID` (`souvenirID`),
  ADD KEY `customID` (`employeeID`);

--
-- Индексы таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD UNIQUE KEY `ticketID` (`ticketID`),
  ADD KEY `visitorID` (`visitorID`,`sectionID`),
  ADD KEY `sectionID` (`sectionID`);

--
-- Индексы таблицы `usertbl`
--
ALTER TABLE `usertbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `visitor`
--
ALTER TABLE `visitor`
  ADD UNIQUE KEY `visitorID` (`visitorID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `animal`
--
ALTER TABLE `animal`
  MODIFY `animalID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `custom`
--
ALTER TABLE `custom`
  MODIFY `customID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `section`
--
ALTER TABLE `section`
  MODIFY `sectionID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `souvenir`
--
ALTER TABLE `souvenir`
  MODIFY `souvenirID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT для таблицы `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitorID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`sectionID`) REFERENCES `section` (`sectionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `custom`
--
ALTER TABLE `custom`
  ADD CONSTRAINT `custom_ibfk_1` FOREIGN KEY (`visitorID`) REFERENCES `visitor` (`visitorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `custom_ibfk_2` FOREIGN KEY (`souvenirID`) REFERENCES `souvenir` (`souvenirID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `souvenir`
--
ALTER TABLE `souvenir`
  ADD CONSTRAINT `souvenir_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`sectionID`) REFERENCES `section` (`sectionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`visitorID`) REFERENCES `visitor` (`visitorID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
