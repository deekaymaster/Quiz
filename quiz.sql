-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Cze 2021, 23:31
-- Wersja serwera: 10.4.18-MariaDB
-- Wersja PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dawid.kogut.projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pytania`
--

CREATE TABLE `pytania` (
  `id` int(11) NOT NULL,
  `pytanie` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `a` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `b` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `c` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `d` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `odpowiedz` varchar(1) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `correctAnswers` int(11) NOT NULL,
  `incorrectAnswers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `pytania`
--

INSERT INTO `pytania` (`id`, `pytanie`, `a`, `b`, `c`, `d`, `odpowiedz`, `correctAnswers`, `incorrectAnswers`) VALUES
(1, 'Suma liczb binarnych 1010+111 zapisana w systemie dziesiętnym wyniesie', '16', '17', '18', '19', 'B', 4, 98),
(2, 'Jednostka obliczeń zmiennoprzecinkowych to', 'FPU', 'ALU', 'RPU', 'AND', 'A', 89, 13),
(3, 'Przydzielaniem czasu procesora do poszczególnych zadań zajmuje się', 'chipset', 'pamięć RAM', 'cache procesora', 'system operacyjny', 'D', 3, 98),
(4, 'Aby zweryfikować poprawność składni kodu CSS można użyć', 'debbugera', 'walidatora', 'konsolidatora', 'optymalizatora', 'B', 1, 98),
(5, 'Po instalacji z domyślnymi uprawnieniami system Windows XP nie obsługuje systemu plików', 'EXT', 'NTFS', 'FAT16', 'FAT32', 'A', 90, 10),
(6, 'Która podanych nazw nie jest rodzajem GUI?', 'KDE', 'GNOME', 'Luna', 'BSD', 'D', 2, 100),
(7, 'Selektor klasy w kaskadowych arkuszach stylów należy zdefiniować za pomocą symbolu', '.(kropka)', ':(dwukropek)', '#', '*', 'A', 3, 98),
(8, 'Liczba 0x142, zapisana w kodzie skryptu JavaScript, ma postać', 'dziesiętną', 'dwójkową', 'ósemkową', 'szesnastkową', 'D', 3, 96),
(9, ' Który z systemów nie należy do dystrybucji Linux?', 'Debian', 'Red Hat', 'DOS', 'Ubuntu', 'C', 1, 100),
(10, 'Urządzenie służące do rozgałęzienia sygnału w sieci to:', 'terminal', 'hub', 'serwer', 'host', 'B', 0, 100),
(11, 'Jakich cyfr używa do zapisu system dwójkowy?', '0 i 1', 'od 0 do 9', '0 i 9', 'od 0 do 10', 'A', 0, 63),
(12, 'Program komputerowy służący do zarządzania strukturą plików i katalogów, to', 'system plików', 'edytor tekstów', 'menedżer plików', 'menedżer urządzeń', 'C', 0, 61),
(13, 'Bitmapa jest obrazem:', 'rastrowym', 'analogowym', 'wektorowym', 'interakcyjnym', 'A', 0, 62),
(14, 'Arkusz kalkulacyjny Excel zawiera:', '128 wierszy', '1 560 500 wierszy', '550 wierszy', '65 536 wierszy', 'D', 0, 64),
(15, 'Programem typu wirus, którego głównym celem jest rozprzestrzenianie się w sieci komputerowej, jest', 'robak', 'trojan', 'backdoor', 'keylogger', 'A', 62, 0),
(16, 'Które konto nie jest kontem wbudowanym w system Windows XP', 'gość', 'admin', 'pomocnik', 'administrator', 'B', 0, 61),
(17, 'Okresowych kopii zapasowych dysków serwera nie można tworzyć na wymiennych nośnikach typu', 'karty SD', 'karty MMC', 'płyty CD-RW', 'płyty DVD-ROM', 'D', 0, 64),
(18, 'W języku HTML, aby scalić w pionie dwie sąsiednie komórki w kolumnie tabeli, należy zastosować atrybut:', 'colspan', 'rowspan', 'cellpadding', 'cellspacing', 'B', 0, 63),
(19, ' W CSS symbolem jednostki miary, wyrażonej w punktach edytorskich, jest:', 'em', 'px', 'pt', 'in', 'C', 0, 62),
(20, 'Recykling można określić jako', 'odzysk', 'produkcję', 'segregację', 'oszczędność', 'A', 60, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id_usera` int(10) NOT NULL,
  `login` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `correctCount` int(11) NOT NULL,
  `incorrectCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id_usera`, `login`, `password`, `name`, `surname`, `email`, `correctCount`, `incorrectCount`) VALUES
(29, 'bajtek', '65791d4c6fb2ba9c2c90b59e59aa4cf5345b3220', 'Bajtek', 'Bajciński', 'bajtek@wp.pl', 28, 112),
(36, 'komar', '43c373b314243cab648eaba42713d305fe4fe8b8', 'Komar', 'Komarzynski', 'komar@wp.pl', 6, 34),
(37, 'kakaowiec', 'a75a9ec169db5c0bf6c4148518f80f8c71aa6b4c', 'Kakauko', 'Kakaukowe', 'czekolada@o2.pl', 60, 20),
(38, 'Bananowiec', 'daa6405c96ada8127d3398cafe8a460aa23430fb', 'Banan', 'Żółty', 'banananek@wp.pl', 16, 24),
(39, 'wafelek', 'd0becddcc564c76a21e35d9ab6155ec513ea46ce', 'Wafel', 'Cukrowy', 'wafelek@cukiernia.com', 120, 80),
(40, 'mucha', 'bc39c85bf6555d01cac414bafce67e778052dd45', 'Mucha', 'Tsetse', 'muszka@douszka.pl', 220, 100),
(41, 'sheldon', 'de5e64281b7d99e81f2fa9a02a098ad930dd3c17', 'Sheldon', 'Cooper', 'sheldoncooper@tsh.us', 55, 25),
(42, 'gianni', '020d19d2b0eaf19492bf7ae50ee5f8f4c8890cd9', 'Tomasz', 'Hajto', 'gianni@zegarek.pl', 13, 7),
(43, 'TaniArmani', 'bf02547498d15771c568f18a22898e81873c9d12', 'Giorgio', 'Armani', 'taniarmani@gmail.com', 99, 101),
(44, 'powiatowy', '64f6b4a6ed150ff780fc5090603623a7214c49d9', 'Jakub', 'Powiatowy', 'jpowiatowy@o2.pl', 72, 28),
(45, 'jozinZbazin', '36564b7cfbf74814960ec8f607e18d64bf9ebb7b', 'Jozin', 'Zbazin', 'mocalemseplizi@moravu.cz', 500, 200),
(46, 'RB9', '0813dd897c9b47fee4203d8110442c5efed2760a', 'Roberto', 'Lewando', 'rlewy@interia.pl', 89, 51),
(47, 'brzeczyszczykiewicz', '1e8a4778699f028ef4760b8f1bef8e31e8faf346', 'Grzegorz', 'Brzęczyszczykiewicz', 'gbrz@powiatlekowody.pl', 51, 29),
(48, 'szarik1969', '26ca39f1226e72f4558dcd580a6c03c370b1ef23', 'Marusia', 'Ogoniok', 'rudy@stodwa.pl', 33, 7),
(49, 'miesnyjez', 'a915dbce5707bc1d3ef88d7f444ee52d6dcce58a', 'Mięsny', 'Jeż', 'tygo@zjesz.pl', 19, 21),
(50, 'admin', '7dd12f3a9afa0282a575b8ef99dea2a0c1becb51', 'admin', 'admin', 'root@quiz.com', 4, 16),
(51, 'user1', '1fad2e43de9d6b4d8b0711f499b7b1b445170b6a', 'user1', 'user1', 'user1@wowo.pl', 0, 0),
(52, 'user2', '02786db0e65e76bd8043031f6a6292cbc763d010', 'user2', 'user2', 'user2@user2.pl', 0, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pytania`
--
ALTER TABLE `pytania`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_usera`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `pytania`
--
ALTER TABLE `pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id_usera` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
