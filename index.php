<?php
  session_start();
echo '<!doctype html>
<html lang="pl"><head>';
  $czas_start = (float)microtime();                        
   include_once (dirname(__FILE__) . '/'.basename('router.php'));
?>

</head><body>
<div class="gora">         
<?php
  try
   {  
	 if(!empty($_POST['login']))
		{
		  $userDane = $user->zaloguj($_POST['login'], $_POST['pass']);
		} 
	 if($session->sprawdzsesje() == true)
	    {            
	 ?>
  <header id="header">
     <div id="logo">
		<h3><a href="#">Logo naszej strony</a></h3>
	</div>
	 <nav id="menu">
	 <?php
		   include_once (dirname(__FILE__) . '/template/'.basename('menu.php'));	   
		 ?>
	  </nav>
	 <?php
	 				////<li><img id="loading" src="template/images/czytam.gif" alt="loading" /></li>
		?>
 </header> 
		     <?php
                 
			 if($user->admin() == true)
				{echo "Witaj Adminie<br/>";} 
                      
                   echo	"Witaj ". $user->user();	
                 ?>
                      <section style="margin-left:0px;">				 
                         <?php
				   include_once $url->url(); 
                                   ///$chat->usun();
                               
                                  //$kwota = ['50'=>'50', '10'=>'10', '79'=>'79', '20'=>'20'];
                                  //echo $user->kwota($kwota);    
                               function dziel($il, $to)
                                  {
                                   if(is_numeric($il) && is_numeric($il) && $il != 0)
                                   {
                                  if($to>$il && $il != 0)
                                      {
                                    $DD = $to%$il;
                                     $j=0;
                                   if($DD == 0)
                                       { 
                                          for ($i = $il; $i < $to+$il; $i=$i+$il) 
                                              {
                                                // $i;
                                                $j++;
                                              }
                                                echo "<br />Wynik dzielenia to ". $j ." i reszty".$DD;
                                        }else{
                                            for ($i = $il; $i < $to; $i=$i+$il) 
                                              {
                                                 //$i;
                                              $j++;
                                              }
                                                echo "<br />Wynik dzielenia to ". $j ." i reszty".$DD;
                                          }
                                     }else{
                                         echo "Pierwsza liczba musi być mniejsza od drugiej";
                                     }
                                   }else{
                                       echo "Pierwsza i druga wartość muszą być liczbami lub różne od zera";
                                   } 
                                   return;
                                  }
                                  
                                dziel(1,8);
                                
                 $lll = $log->log_info();
                 print_r($lll);
                                  ?>
		               </section>
	<?php
	 }else{ 
?>   
      <header>
	 <nav id="menu">
	     <div style="list-style: none;">
                <span><a href="<?php echo htmlentities(addslashes($url->adres(1)),ENT_QUOTES,'UTF-8'); ?>" target="">Start</a></span>
                <span><a href="<?php echo htmlentities(addslashes($url->adres(10)),ENT_QUOTES,'UTF-8'); ?>" target="">Chat Publiczny</a></span>
		<span><a href="<?php echo htmlentities(addslashes($url->adres(2)),ENT_QUOTES,'UTF-8'); ?>" target="">Faq</a></span>
                <span><a href="<?php echo htmlentities(addslashes($url->adres(3)),ENT_QUOTES,'UTF-8'); ?>" target="">Regulamin</a></span>
             </div>
	 </nav>
	  <div class="zaloguj">         
	<?php
	 include_once (dirname(__FILE__) . '/pliki/'.basename('zaloguj.php'));
		?>
	  </div>
	 </header>
       	<section class="content" id="">  
            <article class="body_srod">
            <?php
		  include_once $url->url();
            ?>
          </article>
	    </section> 
	<?php
	     }
	 ////echo "brak sesji";
   }
   catch(Exception $e)
   {
      echo 'Połączenie nie mogło zostać : ' . $e->getMessage();
   }
   ?>	
     <div style="clear: both; height: 1px;"></div>
   
     <section><div id="stopka_dol">      
	<?php
	      include_once (dirname(__FILE__) . '/template/'.basename('dol.php'));
	?>
         </div></section>
</body>
</html>
