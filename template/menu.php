<?php
  /// $params = array( 'akcja' => 1, 'two' => 2 ); dwopoziomowe
   // $link    = http_build_query($link);
?>
                
	  <div>
                <span><a href="<?php echo htmlentities(addslashes($url->adres(1)),ENT_QUOTES,'UTF-8'); ?>" target="">Profil</a></span>
		<span><a href="<?php echo htmlentities(addslashes($url->adres(6)),ENT_QUOTES,'UTF-8'); ?>" target="">Dla zarejestrowanych</a></span>
                <span><a href="<?php echo htmlentities(addslashes($url->adres(4)),ENT_QUOTES,'UTF-8'); ?>" target="">Wyloguj</a></span>
           </div>
