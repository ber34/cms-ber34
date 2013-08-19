--
-- Baza danych: `pdo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prk_chat`
--

CREATE TABLE IF NOT EXISTS `prk_chat` (
  `u_id` int(11) NOT NULL,
  `u_chat` varchar(255) NOT NULL,
  `u_text` varchar(255) NOT NULL,
  `u_user` varchar(255) NOT NULL,
  `u_czas` varchar(150) NOT NULL,
  `u_tajny` int(11) NOT NULL DEFAULT '0',
  `u_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
