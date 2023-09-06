-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 06 Wrz 2023, 12:52
-- Wersja serwera: 10.5.19-MariaDB-10+deb11u2
-- Wersja PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `mkutypa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `apteczka_drugs`
--

CREATE TABLE `apteczka_drugs` (
  `drug_id` int(10) UNSIGNED NOT NULL,
  `drug_name` varchar(100) NOT NULL,
  `drug_date` date NOT NULL,
  `drug_count` int(10) UNSIGNED NOT NULL,
  `drug_cost` float NOT NULL,
  `drug_description` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `apteczka_drugs`
--

INSERT INTO `apteczka_drugs` (`drug_id`, `drug_name`, `drug_date`, `drug_count`, `drug_cost`, `drug_description`) VALUES
(73, 'Metypred ', '2023-09-05', 30, 32.1, '16 mg'),
(71, 'Magne B6', '2023-10-31', 50, 12.4, '100 mg'),
(70, 'Cholinex', '2023-09-30', 30, 13.71, '150 mg with sugar'),
(72, 'Braveran', '2069-06-09', 8, 26.99, '165 mg Lepidium meyenii, Tribulus terrestris L . 50 mg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `apteczka_users`
--

CREATE TABLE `apteczka_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `user_surname` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `user_email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `user_password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `user_bday` date NOT NULL,
  `user_img` varchar(255) NOT NULL DEFAULT 'def_profile.jpg',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `apteczka_users`
--

INSERT INTO `apteczka_users` (`user_id`, `user_name`, `user_surname`, `user_email`, `user_password_hash`, `user_bday`, `user_img`, `is_admin`) VALUES
(8, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$wyXHYPjma8YP1cWfSvsDuOJSfv3zo8voTMUogII8606bzydNWm3aq', '1947-05-05', 'admin.jpg', 1),
(21, 'user', '2', 'u2@gmail.com', '$2y$10$4lClxVu7Wyigmy0jtoW83eOeSlOpacqd0WuId1MKXnRkA2tdh.NOi', '2023-09-05', 'u2.jpg', 0),
(20, 'user', '1', 'u1@gmail.com', '$2y$10$jFENR2QJDr9yX7d61d4.ZOb/WVtVvOGIYkYshI1E6jWoRMwa0VUAK', '2023-09-04', 'u1.jpg', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `take_drug`
--

CREATE TABLE `take_drug` (
  `take_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `drug_id` int(10) UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED NOT NULL,
  `take_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `take_drug`
--

INSERT INTO `take_drug` (`take_id`, `user_id`, `drug_id`, `count`, `take_date`) VALUES
(81, 21, 70, 8, '2023-09-06'),
(80, 20, 69, 1, '2023-09-06'),
(79, 8, 66, 1, '2023-09-06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_drugs`
--

CREATE TABLE `user_drugs` (
  `id` int(10) UNSIGNED NOT NULL,
  `drug_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `date_exp` date NOT NULL,
  `purchase_date` date NOT NULL,
  `count` int(10) NOT NULL,
  `cost` float NOT NULL,
  `descr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `user_drugs`
--

INSERT INTO `user_drugs` (`id`, `drug_id`, `name`, `date_exp`, `purchase_date`, `count`, `cost`, `descr`, `user_id`) VALUES
(70, 70, 'Cholinex', '2023-09-30', '2023-09-06', 22, 13.71, '150 mg with sugar', 21),
(69, 72, 'Braveran', '2069-06-09', '2023-09-06', 7, 26.99, '165 mg Lepidium meyenii, Tribulus terrestris L . 50 mg', 20),
(68, 71, 'Magne B6', '2023-10-31', '2023-09-06', 50, 12.4, '100 mg', 20),
(66, 71, 'Magne B6', '2023-10-31', '2023-09-06', 49, 12.4, '100 mg', 8),
(67, 70, 'Cholinex', '2023-09-30', '2023-09-06', 30, 13.71, '150 mg with sugar', 8);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `apteczka_drugs`
--
ALTER TABLE `apteczka_drugs`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indeksy dla tabeli `apteczka_users`
--
ALTER TABLE `apteczka_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `take_drug`
--
ALTER TABLE `take_drug`
  ADD PRIMARY KEY (`take_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `drug_id` (`drug_id`);

--
-- Indeksy dla tabeli `user_drugs`
--
ALTER TABLE `user_drugs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `apteczka_drugs`
--
ALTER TABLE `apteczka_drugs`
  MODIFY `drug_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT dla tabeli `apteczka_users`
--
ALTER TABLE `apteczka_users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `take_drug`
--
ALTER TABLE `take_drug`
  MODIFY `take_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT dla tabeli `user_drugs`
--
ALTER TABLE `user_drugs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
