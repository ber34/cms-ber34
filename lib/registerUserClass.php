<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));
class registerUserClass 
{
		  private $nameus;
		  private $passwordus;
		  private $email;
                  private $user;
                  public  $error;
                  private $log;  /// przypisanie połączenia z PDO przez konstruktor
                  private $db;
   
                
                public function __construct() 
		  { 
                     $this->db    = new databaseClass(); // PDO
                     $this->user  = new userClass(); // User
                     $this->log   = new logClass(); // logclass
		   ///parent::__construct(); 
                  }
				 
                  ############################ Rejestracja #####################################
	public function rejestracja($nameus, $passwordus, $email)
		{
		  try{
		$this->nameus     = $this->user->czyscpost($nameus);   /// validacja @ _ - . z class user
		$this->passwordus = $this->user->czyscpost(md5($passwordus));   /// validacja @ _ - .z class user
		$this->email      = $this->user->czyscpost($email);   /// validacja @ _ - . z class user
			         
                      if(!empty($this->nameus) && !empty($this->passwordus) && !empty($this->email))
                         {     
			   $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           $stmt = $this->db->prepare('SELECT `u_login` FROM `'.$this->db->dbprefix().'user` WHERE `u_login`=:nameus or `u_email`=:email');
			            if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                           $stmt->bindValue(':nameus', $this->nameus, PDO::PARAM_STR); 
			   $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                           $stmt->execute(); 	  
                     if($stmt->fetch() > 0)
					{
			  echo  $this->error = "<div style='color: red;'>User już istnieje</div>";
					}else{
 $stmt = $this->db->prepare('INSERT INTO `'.$this->db->dbprefix().'user` (`u_login`, `u_email`, `u_haslo`, `u_data`, `u_referer`, `u_sesion`, `u_ip`, `u_protokul`, `u_agent`) VALUES (
                                                                :nameus,
                                                                :email,
								:passwordus,
                                                                 NOW(),
								:u_referer,
                                                                :u_sesion,
								:u_ip,
								:u_protokul,
                                                                :u_agent)');  
                              if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                        $stmt->bindValue(':nameus', $this->nameus, PDO::PARAM_STR); 
                        $stmt->bindValue(':passwordus', $this->passwordus, PDO::PARAM_STR);
                        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR); 
			$stmt->bindValue(':u_referer', $this->referer(), PDO::PARAM_STR);
                        $stmt->bindValue(':u_sesion', 1, PDO::PARAM_INT);
			$stmt->bindValue(':u_ip', $this->user->ip(), PDO::PARAM_STR); 
			$stmt->bindValue(':u_protokul', $this->protokol(), PDO::PARAM_STR); 
                        $stmt->bindValue(':u_agent', $this->useragent(), PDO::PARAM_STR);
               $ilosc = $stmt->execute();
                        $stmt->closeCursor();	
                        if($ilosc > 0)
                        {
                             echo $this->error = '<div style="color: red;">Rejestracja dodano '.$ilosc.' rekord </div>';
                        }else{
                            echo $this->error = "<div style='color: red;'>Wystapil blad podczas Rejestracji! </div>";
                        }
		}	
                       }else{     
                            echo $this->error = "<div style='color: red;'> Wprowadź Dane </div>";
                                }
              return $this->error;
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
		      ############################ Z kąd #####################################
      protected function referer()
		{
		   if(!isset($refer))
                      {
                     $refer = $_SERVER['HTTP_REFERER'];
                      }else{
                     $refer = "Proxy";
                      }
	      return $refer;
		}
		     ############################ Protokół #####################################
       protected function protokol()
	 {
		if(!isset($protokol))
                {
                  $protokol = $_SERVER['SERVER_PROTOCOL'];
                }else{
                  $protokol = "N/A"; 
                }
		 return $protokol;
	}
        
     protected function useragent()
       { 
         if(!isset($agent))
           {
                $agent = $_SERVER['HTTP_USER_AGENT'];
           }
            return $agent;
       }
} 
   
