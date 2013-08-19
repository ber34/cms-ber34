<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));
class userClass
{
                  private $name; // dane z tablicy $_POST
                  private $password; // dane z tablicy $_POST
                  private $name_user; /// kto zalogowany
                  private $sesion; /// przypisanie classy sesji
		  public  $error; // czy poprawna
		  private $post; // czyść post
                  private $post1 = array(); // czyść post
                  private $db;  /// przypisanie połączenia z PDO przez konstruktor
                  private $log;  /// przypisanie połączenia z PDO przez konstruktor
                
           public function __construct() 
		  { 
		     //parent::__construct();
                      $this->db               = new databaseClass();  // połączenie z bazą
                      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $this->sesion           = new userSesionClass(); // session
                      $this->log              = new logClass(); // logclass
                  }

	       ############################ Zaloguj #####################################
     public function zaloguj($name, $password)
	   {       
	     try{
                $this->name     = $this->czyscpost($name);
		$this->password = $this->czyscpost(md5($password));
          if(isset($this->name))
		  {
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
       $stmt = $this->db->prepare('SELECT u_login, u_haslo, u_email  FROM `'.$this->db->dbprefix().'user` WHERE `u_login`=:username && `u_haslo`=:password'); // && `u_aktywny`=:u_aktywny && u_zalogowany=:u_zalogowany
	                   if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }  
        //PDO::PARAM_STR - Dla ciągu tekstów
        //PDO::PARAM_INT - Dla liczby całkowitej

	   $stmt->bindValue(':username', $this->name, PDO::PARAM_STR);
	   $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
	   //$stmt->bindValue(':u_aktywny', '1', PDO::PARAM_INT);
           //$stmt->bindValue(':u_zalogowany', '0', PDO::PARAM_INT);
	   
               $stmt->execute(); 
               $de = $stmt->fetch();

	    if(!empty($de['u_login'])) 
               {
                ///session_unset();
                 ////session_destroy(); 
                                /// echo $_SESSION['u_login'];
                                /// echo $_SESSION['session_id'];
                  $this->sesion->przypiszsesje($de['u_login']); /// przypisanie sesji 
                  	
                   $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                   $stmt = $this->db->prepare('UPDATE `'.$this->db->dbprefix().'user` SET u_sesion=:u_sesion, u_online=NOW(), u_ip=:u_ip, `u_aktywny`=:u_aktywny, u_zalogowany=:u_zalogowany WHERE `u_login`=:username and `u_haslo`=:password');
			  if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                   
                        $stmt->bindValue(':username', $this->name, PDO::PARAM_INT);
	                $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
			$stmt->bindValue(':u_sesion', $this->sesion->idsesion(), PDO::PARAM_STR); /// przypisanie sesji do bazy danych
                        $stmt->bindValue(':u_ip', $this->ip(), PDO::PARAM_INT);
                        $stmt->bindValue(':u_aktywny', '1', PDO::PARAM_INT);
                        $stmt->bindValue(':u_zalogowany', '1', PDO::PARAM_INT);
			$stmt->execute();
			 }else{
                             
                   if($this->name != $de['u_login'] and $this->password != $de['u_haslo'])
                     {
			    echo $this->error = '<hr/><div align="center"><p>Błędne Login lub hasło!</p></div><hr/>';
                         
                     }else{      
                            echo $this->error = '<hr/><div align="center"><p>Przepraszamy, podany rekord nie istnieje lub został zablokowany!</p></div><hr/>'; /// 
                           }
                     }
		          $stmt->closeCursor();
                	}	
			 }catch(PDOException $e){
                                $this->log->log_pdo($e);  /// logi z PDO           
                    echo 'Połączenie loguj nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }
                   if(!empty($this->error))
                     {
                        $this->log->log_user($this->error, $this->ip(), $this->name); /// logi z User
                     }
           	    return  $this->error;					
                 }
              
			   ############################ Sprawdź Admin #####################################
                public function admin()
		    {
			  try{
			   $ad = false;  
                 $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $stmt = $this->db->prepare('SELECT u_admin  FROM `'.$this->db->dbprefix().'user` WHERE `u_login`=:username && `u_admin`=:u_admin');
	                 if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                   //PDO::PARAM_STR - Dla ciągu tekstów
                  //PDO::PARAM_INT - Dla liczby całkowitej
	                $stmt->bindValue(':username',  $this->user(), PDO::PARAM_STR);
	                $stmt->bindValue(':u_admin', 1, PDO::PARAM_INT);
                        $stmt->execute();
		foreach($stmt as $row)
                    { 
			if($row['u_admin'] == 1)
                           	{$ad = true;}else{$ad = false;}
		    }
			$stmt->closeCursor();
			  return $ad;
					 }catch(PDOException $e){
                            $this->log->log_pdo($e);  /// logi z PDO                
                     echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    } 
			if(!empty($this->error))
                     {
                        $this->log->log_user($this->error, $this->ip(), $this->name); /// logi z User
                     }
			} 

				   ############################ Sprawdź User #####################################
	    public function user()
	      {
		 try{

                 $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $stmt = $this->db->prepare('SELECT u_login FROM `'.$this->db->dbprefix().'user` WHERE `u_sesion`=:u_sesion');
	              if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                  //PDO::PARAM_STR - Dla ciągu tekstów
                  //PDO::PARAM_INT - Dla liczby całkowitej
	                 $stmt->bindValue(':u_sesion', $this->sesion->idsesion(), PDO::PARAM_STR);
                         $stmt->execute();
		foreach($stmt as $row)
                    { 
			if(isset($row['u_login']))
                           	{$this->name_user = $row['u_login'];}
		    }
			$stmt->closeCursor();
			  return $this->name_user;	
		    }catch(PDOException $e){
                        $this->log->log_pdo($e);  /// logi z PDO  
                     echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    } 
			if(!empty($this->error))
                     {
                        $this->log->log_user($this->error, $this->ip(), $this->name); /// logi z User
                     }
			}        	
	  ############################ Czy proxy ip #####################################
          public function ip()
	   {
                   if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) // wartość superglobalnych
		       {
                          $ip     = $_SERVER["HTTP_X_FORWARDED_FOR"];  /// ip potencjalnie niebezpieczny
                          $tt     = $_SERVER["REMOTE_ADDR"]." proxy"; /// ip proxy
	           }else{
                          $tt = $_SERVER['REMOTE_ADDR'];
	                }
             /*     
               if( isset(getenv( 'HTTP_X_FORWARDED_FOR' )) ) // wartość zmiennej środowiskowej
                   {
                          $ip     = getenv( 'HTTP_X_FORWARDED_FOR' );  /// ip potencjalnie niebezpieczny
                          $tt_g   = getenv( 'REMOTE_ADDR' )." proksy"; /// ip proxy
                   } else {
                          $tt_g = getenv( 'REMOTE_ADDR' );
                          }     
               */
			   return $tt; // ." ".$tt_g
	   } 		  
               ############################# czyść post ################################
               public function czyscpost($post)
		    {
			  $this->post = $post;
                          $this->post = trim($this->post);
                          $this->post = strip_tags($this->post);
                          $this->post = htmlspecialchars($this->post);
                          $this->post = htmlentities($this->post, ENT_QUOTES,'UTF-8');
                          $this->post = stripslashes($this->post); 
                          $this->post = stripcslashes($this->post); 
                       preg_match('/^[a-zA-ZąęćłńóśźżĄĆĘŁŃÓŚŹŻ0-9\@\_\-\.]+$/', $this->post, $this->post1); 
				  return $this->post1[0];
            }		 
		
         public function kwota($kwota)
	   {
               arsort($kwota);
             foreach ($kwota as  $klucz => $value) 
                 {
                 return  $kwota1 = $value;
                 }
           }   
            
        public function wyloguj()
		 { 
                   try{
                         $this->user  = $this->user();
                        if(!empty($this->user)){   
                              // session_destroy(); 
                   $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                   $stmt = $this->db->prepare('UPDATE `'.$this->db->dbprefix().'user` SET `u_sesion`=:u_sesion, u_ip=:u_ip, `u_aktywny`=:u_aktywny ,u_zalogowany=:u_zalogowany WHERE `u_login`=:username');
		              if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                   $stmt->bindValue(':username', $this->user(), PDO::PARAM_STR);
                   $stmt->bindValue(':u_ip', $this->ip(), PDO::PARAM_STR);
		   $stmt->bindValue(':u_sesion', '1', PDO::PARAM_INT);
                   $stmt->bindValue(':u_aktywny', '0', PDO::PARAM_INT);
                   $stmt->bindValue(':u_zalogowany', '0', PDO::PARAM_INT);
			$stmt->execute();                                                
			echo  $this->error = '<hr/><div align="center"><p>Zostałeś Wylogowany!</p></div><hr/>';;
                          /// unset($_SESSION);
                          session_unset(); 
                          session_destroy(); 
                        }
                          }catch(PDOException $e){
                            $this->log->log_pdo($e);  /// logi z PDO    
                     echo 'Połączenie wyloguj nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }
                    if(!empty($this->error))
                     {
                        $this->log->log_user($this->error, $this->ip(), $this->name); /// logi z User
                     }
		  return $this->error;
                        }  
} 
   
