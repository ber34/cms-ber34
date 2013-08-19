--
-- Baza danych: `pdo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prk_adres`
--

CREATE TABLE IF NOT EXISTS `prk_adres` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_adres` text NOT NULL,
  `u_adrespage` text NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Zrzut danych tabeli `prk_adres`
--

INSERT INTO `prk_adres` (`u_id`, `u_adres`, `u_adrespage`) VALUES
(1, 'index.html', 'home'),
(2, 'wyloguj.html', 'wyloguj.user'),
(3, 'rejestracja.html', 'rejestracja'),
(4, 'przypomnijhaslo.html', 'przypomnijhaslo'),
(5, 'fqu.html', 'fqu'),
(6, 'regulamin.html', 'regulamin'),
(7, 'publiczny.html', 'publiczny'),
(8, 'zarejestrowani.html', 'zarejestrowani'),
(9, 'dlaprzyjaciol.html', 'dlaprzyjaciol'),
(10, 'chat.html', 'chat');
