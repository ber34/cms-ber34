--
-- Baza danych: `pdo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prk_user`
--


CREATE TABLE IF NOT EXISTS `prk_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_login` varchar(55) NOT NULL,
  `u_email` varchar(120) NOT NULL,
  `u_haslo` varchar(255) NOT NULL,
  `u_aktywny` int(11) NOT NULL DEFAULT '1',
  `u_data` varchar(20) NOT NULL,
  `u_referer` varchar(255) NOT NULL,
  `u_sesion` varchar(255) NOT NULL,
  `u_online` varchar(25) NOT NULL,
  `u_ip` varchar(255) NOT NULL,
  `u_protokul` varchar(55) NOT NULL,
  `u_admin` int(11) NOT NULL DEFAULT '0',
  `u_zalogowany` int(11) NOT NULL DEFAULT '0',
  `u_agent` varchar(255) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


