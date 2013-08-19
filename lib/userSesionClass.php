<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));
class userSesionClass
      {
             private $sesion_id; // id sesji
             private $isSesion = false; // czy jest sesja
             private $log;  /// przypisanie połączenia z PDO przez konstruktor
             private $db;      /// przypisanie połączenia z PDO przez konstruktor
             
        public function __construct() 
	  { 
            $this->db   = new databaseClass(); 
            $this->log  = new logClass(); // logclass
               ############################ Sprawdź Sesję #####################################
                             //// $this->braksesji();
            if($this->sprawdzsesje() == true)
                    {
                      $this->czas_sesji();
                    }else{
                         ///$this->braksesji();
                         ///session_destroy();
                         session_unset();
                    }
              // parent::__construct();        
          }
		
          public function przypiszsesje($user)
          {         
                       $_SESSION['u_login']      = $this->koduj($user);
                       $_SESSION['session_id']   =  sha1(session_id());
                       $_SESSION['start_sesion'] = date("Y-m-d H:i:s");
		     
                       /// $_SESSION['u_login'] = base64_encode($this->u_login); /// zakoduj logi zalogowanego
			//$_SESSION['u_login'] = base64_encode($de['u_login']);  // zakoduj logi zalogowanego
			//$_SESSION['u_email'] = base64_encode($de['u_email']); // zakoduj
			//// $u_login = base64_decode($_SESSION['u_login']); // odkoduj
			//// $u_email = base64_decode($_SESSION['u_email']); // odkoduj 
                       ///$_SESSION['ip']   = $_SERVER['REMOTE_ADDR'];
                       return;
          }

          private function sesja()
		 {  
                    try{
                        ############### SESJA ###############################
		if($this->idsesion() && isset($_SESSION['u_login'])) /// isset () nie zwraca TRUE dla kluczy tablicy, która odpowiada wartości NULL
                   {
                   $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
 
               $stmt = $this->db->prepare('SELECT u_sesion FROM `'. $this->db->dbprefix().'user` WHERE u_login=:u_login and u_sesion=:u_sesion');
                                if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                               $stmt->bindValue(':u_login', $this->dekoduj($_SESSION['u_login']), PDO::PARAM_STR);
			       $stmt->bindValue(':u_sesion', $this->idsesion(), PDO::PARAM_INT);
	                     /// @$stmt->bindValue(':u_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);  and `u_ip`=:u_ip'
			$stmt->execute();
                        $ddd = $stmt->fetchAll();
               foreach($ddd as $row)
                 {    			 
		   
		   if($row['u_sesion'] != '1' && isset($row['u_sesion']))  /// isset () nie zwraca TRUE dla kluczy tablicy, która odpowiada wartości NULL
		     {
				 $this->isSesion = true;
                                 ///$_SESSION['isSesion']=$this->isSesion;
                              /// echo  $this->isSesion = $_SESSION['isSesion'];
		            }else{
                                 $this->isSesion = false;
		     }
	        }
	     }
             }catch(PDOException $e){
                 $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();   
                     
                     $this->isSesion = false;
                  }  
               return $this->isSesion;      
         } 
         
      public function idsesion()
           {
          if(isset($_SESSION['session_id']))
            {
              ///print_r($_SESSION['session_id']);
              ///print_r($_SESSION['u_login']);
              //if (array_key_exists('session_id', $_SESSION['session_id'])) 
                //{
                   $this->sesion_id = $_SESSION['session_id'];
                //}
            }
               return $this->sesion_id;   
           }
           
      protected function koduj($koduj)
           {
             return base64_encode($koduj);  
           }
      protected function dekoduj($koduj)
           {
             return base64_decode($koduj);  
           }
           
     public function sprawdzsesje()
          {
             return $this->sesja();
          }
          
      public function braksesji()
             {
               try{
                   if(empty($_SESSION['u_login']))
                          {
                               $teraz         = date("Y-m-d H:i:s");
                              /// $cz1        = date($this->czas_sesji);
                               ///$basedate1  = strtotime($cz1);
                               ///$date11     = strtotime("2 hours", $basedate1);
                               //$dwie        = date("Y-m-d H:i:s", $date11);  zrobić table date i poruwnać do 2 godziny      
                        ############### Brak SESJI ################ 
               $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
               $stmt =  $this->db->prepare('UPDATE `'. $this->db->dbprefix().'user` SET u_sesion=:u_sesion, `u_aktywny`=:u_aktywny, u_zalogowany=:u_zalogowany WHERE u_online<:u_online');
                             if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
              ///$stmt->bindValue(':u_login', $this->dekoduj($_SESSION['u_login']), PDO::PARAM_STR);
        $stmt->bindValue(':u_sesion', '1', PDO::PARAM_INT); 
        $stmt->bindParam(':u_online', $teraz, PDO::PARAM_STR);
       $stmt->bindValue(':u_aktywny', '0', PDO::PARAM_INT);
        $stmt->bindValue(':u_zalogowany', '0', PDO::PARAM_INT);
	$stmt->execute(); 
        echo "tyu";
           $stmt->closeCursor();   
                }
             }catch(PDOException $e){
               $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                  }      
             /// zapis do bazy danych czyszczący sesję i zalogowanie.
             }

    private function czas_sesji()
         {
           try{
                               $cz        = date($_SESSION['start_sesion']);
                               $basedate  = strtotime($cz);
                               $date1     = strtotime("1 hours", $basedate);
                               $this->czas_za_godzine = date("Y-m-d H:i:s", $date1);
                               
                   if(date("Y-m-d H:i:s") > $this->czas_za_godzine && $this->idsesion())
                       {
                         $_SESSION['start_sesion'] = date("Y-m-d H:i:s");
                        session_regenerate_id(); 
                    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $stmt =  $this->db->prepare('UPDATE `'. $this->db->dbprefix().'user` SET u_sesion=:u_sesion, u_online=:u_online, u_zalogowany=:u_zalogowany WHERE u_login=:u_login');
		                if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                    $stmt->bindValue(':u_online', $_SESSION['start_sesion'], PDO::PARAM_STR);
                    $stmt->bindValue(':u_sesion', $this->idsesion(), PDO::PARAM_INT);
                    $stmt->bindValue(':u_zalogowany', 1, PDO::PARAM_INT);
                    $stmt->bindValue(':u_login', $this->dekoduj($_SESSION['u_login']), PDO::PARAM_STR);
	           return $stmt->execute();
                    $stmt->closeCursor();  
                         }
           }catch(PDOException $e){
        $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }
         }/* */
 }             
