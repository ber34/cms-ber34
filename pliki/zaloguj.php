<?php
                    ///$link3 = array( 'akcja' => 3);
					///$link4 = array( 'akcja' => 4);
					//$link3 = http_build_query($link3);
					///$link4 = http_build_query($link4);
?>
  <div class="loguj_yello" >
	<form action="index.php" method="post">
	<span>
        <label class="submit_from">Login:<input class="loguj_input" name="login" type="text" placeholder="Login" required id="nazw"></label>
        <label class="submit_from">Hasło:<input class="loguj_input" name="pass" type="password" required id="pass"></label>
        <label class="submit_from"><input class="loguj_submit" name="" type="submit" value="Zaloguj" /></label>
	 </span><br/>
     <mark class="submit_from_1"><a href="<?php echo htmlentities(addslashes($url->adres(7)),ENT_QUOTES,'UTF-8'); ?>" target=""><span>Rejestracja </span></a>| |
	 <a href="<?php echo htmlentities(addslashes($url->adres(8)),ENT_QUOTES,'UTF-8'); ?>" target=""><span> Przywróć hasło</span></a></mark>
	 </form>
  </div>
