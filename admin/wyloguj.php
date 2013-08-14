<?php
 include_once (dirname(__DIR__) . '/'.basename('router.php')); 
  
     $session  = new Session();
       $user     = new User();
   //// $_GET['pdo'] ="wyloguj.html";
     ///echo $_SESSION['u_login'];
      echo "wyloguj";
      if($session->sprawdzsesje() == true)
	 {
           
	  $user->wyloguj();
	    ?>
	  <script>
	     alert("Zostałeś Wylogowany");
	   window.location.reload();
	  </script>
	<?php 
	  header('Location: index.php');
	  }
