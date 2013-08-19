<?php
include_once basename('router.php');
	   
    if(@$_POST['key'] == @$_POST['key1'] && !empty($_POST['key']))
           {	
    $userRejestracja->rejestracja(@$_POST['register_login'], @$_POST['register_pass'], @$_POST['register_email']); 
           }else{ echo "Podaj prawidłowy kod.";}
      $key = rand(1000,9999);
?>
 <section align="center" class="rejest_yello1">
  <form action="#" method="post">
	<fieldset>
	   <legend style="color: red;">Rejestracja:</legend>
           <p class="submit_from">Login: <input class="msgInfo" name="register_login" type="text" placeholder="Login" required id="nazw"/></p>
           <p class="submit_from">Hasło: <input class="msgInfo" name="register_pass" type="password" placeholder="Hasło" required id="password"/></p>
	   <p class="submit_from">E-mail: <input class="msgInfo" name="register_email" type="email" placeholder="E-mail" title="aa@op.pl" required id="emailf"/></p>
           <p class="submit_from">Podaj Kod: <?php echo $key; ?><input class="msgInfo" name="key" type="text" placeholder="podaj kod" required id="kod"/></p>
           <input class="msgInfo" name="key1" type="hidden" value="<?php echo $key; ?>" />
       <p><input class="rejest_submit" name="" type="submit" value="Rejestruj" /></p>
	</fieldset>
  </form>
 </section>
