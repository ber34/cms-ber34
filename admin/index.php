<?php
   include_once (dirname(__DIR__) . '/'.basename('router.php'));  
?>
<!doctype html>
<html lang="pl">
    <head>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script> 
    <script type="text/javascript" src="template/js/jquery.js" ></script>
    <script type="text/javascript" src="template/js/admin_menu.js" ></script>
    </head>
 <body>
<?php
  if($session->sprawdzsesje() == true)
	 {
?>
      <header id="header">
       <nav id="menu">
<?php
 include_once (dirname(__FILE__) . '/'.basename('admin_menu.php'));	   
?>
       </nav>
     </header>   
                <section> index.html
 <?php
                            $user   = new User(); // User
			 if($user->admin() == true)
				{echo "Witaj Adminie<br/>";} 
                      $url_admin   = new Url(); // Adres
            include_once $url_admin->url_admin();  
?>
        </section>
<?php
      
	  }else{
              
             echo "panel logowania"; 
          }
   ?>
  
 </body>
</html>
