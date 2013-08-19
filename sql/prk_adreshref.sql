--
-- Baza danych: `pdo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prk_adreshref`
--

CREATE TABLE IF NOT EXISTS `prk_adreshref` (
  `u_id` int(11) NOT NULL,
  `u_urlhref` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `prk_adreshref`
--

INSERT INTO `prk_adreshref` (`u_id`, `u_urlhref`) VALUES
(1, 'index.html'),
(2, 'fqu.html'),
(3, 'regulamin.html'),
(4, 'wyloguj.html'),
(5, 'publiczny.html'),
(6, 'zarejestrowani.html'),
(7, 'dlaprzyjaciol.html'),
(8, 'rejestracja.html'),
(9, 'przypomnijhaslo.html'),
(10, 'chat.html');
