-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2021 г., 01:36
-- Версия сервера: 5.7.29-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rent`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auto`
--

CREATE TABLE `auto` (
  `id_auto` int(11) NOT NULL,
  `marka` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `cost_per_day` int(11) NOT NULL,
  `deposit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auto`
--

INSERT INTO `auto` (`id_auto`, `marka`, `type`, `year`, `cost_per_day`, `deposit`) VALUES
(1, 'Hyundai Solaris', 'Седан', 2017, 1200, 5000),
(2, 'Renault Megan', 'Хэтчбек', 2019, 2000, 7000),
(3, 'Skoda Rapid', 'Седан', 2005, 700, 3000),
(4, 'Volkswagen Golf ', 'Хэтчбек', 2020, 2300, 8000),
(5, 'Lada заряженная лайба', 'Купе', 1998, 2500, 10000);

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `fio_client` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pass_data` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id_client`, `fio_client`, `phone`, `address`, `pass_data`) VALUES
(1, 'Ярышев Антон Сергеевич', 89215816816, 'Кудрово', 4001567297),
(2, 'Карасева Валерия Александровна', 87655966843, 'Невский пр. 79', 4007567911),
(3, 'Пушкин Александр Сергеевич', 89216666661, 'Пушкин', 4000000000),
(7, 'Лагутенко Илья Мумийтролевич', 89234567429, 'Москва', 4001475068),
(8, 'кто-то', 89999999999, 'Центр', 101111000);

-- --------------------------------------------------------

--
-- Структура таблицы `prokat`
--

CREATE TABLE `prokat` (
  `id_prokat` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_auto` int(11) NOT NULL,
  `date_rent` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prokat`
--

INSERT INTO `prokat` (`id_prokat`, `id_client`, `id_auto`, `date_rent`, `date_end`) VALUES
(7, 2, 2, '2021-05-01', '2021-06-01'),
(8, 3, 3, '2021-05-02', '2021-06-02'),
(9, 1, 1, '2021-05-03', '2021-06-03'),
(11, 7, 4, '2021-05-06', '2021-05-09'),
(12, 8, 5, '2021-04-28', '2021-05-22'),
(13, 3, 1, '2021-04-29', '2021-06-05');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `status`) VALUES
(1, 'user01', '81dc9bdb52d04dc20036dbd8313ed055', 10),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `v_prokate`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `v_prokate` (
`id_prokat` int(11)
,`id_client` int(11)
,`fio_client` varchar(255)
,`id_auto` int(11)
,`marka` varchar(255)
,`date_rent` date
,`date_end` date
);

-- --------------------------------------------------------

--
-- Структура для представления `v_prokate`
--
DROP TABLE IF EXISTS `v_prokate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_prokate`  AS SELECT `prokat`.`id_prokat` AS `id_prokat`, `client`.`id_client` AS `id_client`, `client`.`fio_client` AS `fio_client`, `auto`.`id_auto` AS `id_auto`, `auto`.`marka` AS `marka`, `prokat`.`date_rent` AS `date_rent`, `prokat`.`date_end` AS `date_end` FROM ((`client` join `auto`) join `prokat`) WHERE ((`prokat`.`id_client` = `client`.`id_client`) AND (`prokat`.`id_auto` = `auto`.`id_auto`)) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`id_auto`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Индексы таблицы `prokat`
--
ALTER TABLE `prokat`
  ADD PRIMARY KEY (`id_prokat`),
  ADD KEY `id_auto` (`id_auto`),
  ADD KEY `id_client` (`id_client`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `auto`
--
ALTER TABLE `auto`
  MODIFY `id_auto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `prokat`
--
ALTER TABLE `prokat`
  MODIFY `id_prokat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `prokat`
--
ALTER TABLE `prokat`
  ADD CONSTRAINT `prokat_ibfk_1` FOREIGN KEY (`id_auto`) REFERENCES `auto` (`id_auto`),
  ADD CONSTRAINT `prokat_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
