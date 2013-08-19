<?php
include_once basename('router.php');

   //// $_GET['pdo'] ="wyloguj.html";
     ///echo $_SESSION['u_login'];

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
