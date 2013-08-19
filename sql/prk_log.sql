--
-- Baza danych: `pdo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prk_log`
--

CREATE TABLE IF NOT EXISTS `prk_log` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_data` varchar(70) NOT NULL,
  `u_mesage` text NOT NULL,
  `u_user` varchar(200) NOT NULL,
  `u_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
