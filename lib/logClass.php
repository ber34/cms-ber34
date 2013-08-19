<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));
class logClass
{
   /// const DATATIME = 'Y-m-d H:i:s';
   private $error_user;
   private $error_pdo;
   private $error_cos;
   private $ip;
   private $name_user;
   private $time;
   private $post;
   private $file;
   private $db;
   public  $error; // czy poprawna
   public  $log;

   public function __construct() 
	{ 
            $this->db   = new databaseClass();   // połączenie z bazą
        }
                  
      public function log_pdo($pdo="null") 
	{
         try{
          
           if(!empty($pdo))
             {
               $this->error_pdo = $pdo;  // error z połączenia pdo
             }else{
               $this->error_pdo = "brak wiadomosci";  
             }
            $this->ip = $this->ip();
           if(!empty($this->ip))
             {
              $this->ip = $this->ip();   // error z połączenia user
             }else{
              $this->ip = "brak ip";
             } 
             
              $this->time  = date("Y-m-d H:i:s");
              $stmt = $this->db->prepare('INSERT INTO `'.$this->db->dbprefix().'log` (`u_data`, `u_mesage`, `u_user`, `u_ip`) VALUES (
                                                                :u_data,
								:u_mesage,
								:u_user,
                                                                :u_ip)');  

                       	$stmt->bindValue(':u_data', $this->time, PDO::PARAM_STR);
                        $stmt->bindValue(':u_mesage', $this->error_pdo, PDO::PARAM_STR); 
                        $stmt->bindValue(':u_user', $this->name_user, PDO::PARAM_INT);
			$stmt->bindValue(':u_ip', $this->ip, PDO::PARAM_INT); 
                        $stmt->execute();
                        $stmt->closeCursor();
         }catch(PDOException $e){
                                $this->log_file($e);  /// logi do pliku          
                    echo 'Połączenie loguj nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }  
        } 
    public function log_user($user_error="null", $ip="null", $name_user="null") 
       {
        try{
           if(!empty($user_error))
             {
              $this->error_user = $user_error;   // error z połączenia user
             }else{
               $this->error_user = "brak wiadomosci";  
             }
            $this->ip = $this->ip();
           if(!empty($this->ip))
             {
              $this->ip = $this->ip();   // error z połączenia user
             }else{
              $this->ip = "brak ip";
             }
           if(!empty($name_user))
             {
              $this->name_user = $name_user;   // error z połączenia user
             }else{
              $this->name_user = "brak usera";
             }  
                 $this->time  = date("Y-m-d H:i:s");
              $stmt = $this->db->prepare('INSERT INTO `'.$this->db->dbprefix().'log` (`u_data`, `u_mesage`, `u_user`, `u_ip`) VALUES (
                                                                :u_data,
								:u_mesage,
								:u_user,
                                                                :u_ip)');  

                       	$stmt->bindValue(':u_data', $this->time, PDO::PARAM_STR);
                        $stmt->bindValue(':u_mesage', $this->error_user, PDO::PARAM_STR); 
                        $stmt->bindValue(':u_user', $this->name_user, PDO::PARAM_INT);
			$stmt->bindValue(':u_ip', $this->ip, PDO::PARAM_INT); 
                        $stmt->execute();
                        $stmt->closeCursor();
              }catch(PDOException $e){
                                $this->log_file($e);  /// logi do pliku          
                    echo 'Połączenie loguj nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }
        }
            
    public function ip()
	   {
                   if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) // wartość superglobalnych
		       {
                          ///$ip     = $_SERVER["HTTP_X_FORWARDED_FOR"];  /// ip potencjalnie niebezpieczny
                          $this->ip     = $_SERVER["REMOTE_ADDR"]." proxy"; /// ip proxy
	           }else{
                          $this->ip     = $_SERVER['REMOTE_ADDR'];
	                }  
                return $this->ip;        
           }
           
       public function log_file($cos="null")   /// logowanie do pliku tam gdzie nie można uzyskać połączenia z bazą 
	{ 
             $this->time  = date("Y-m-d H:i:s");
           if(!empty($cos))
             {
              $this->error_cos = $cos;   // error z połączenia 
             }else{
              $this->error_cos = "brak bledy";
             }
             
          $this->ip = $this->ip();
           if(!empty($this->ip))
             {
              $this->ip = $this->ip();   // ip log error
             }else{
              $this->ip = "brak ip";
             } 
             
            $this->file = basename('test.txt');
           if(!file_exists($this->file)){  // Jeżeli nie istnieje
                $this->log = 'Wiadomosc '. $this->error_cos ." ".$this->time. " " .$this->ip.'<br />';
                file_put_contents($this->file, utf8_encode($this->file), FILE_APPEND); // zapis
           }else{
            if(is_writable($this->file)){ // sprawdz czy istnieje i czy jest do zapisu
                $this->log = 'Wiadomosc '. $this->error_cos ." ".$this->time. " " .$this->ip.'<br />';
                file_put_contents($this->file, utf8_encode($this->log), FILE_APPEND); // zapis

           }else{
                  $this->error = 'Cannot open ' . $this->file . ' for writing <br />';
                  $this->error = "Please Create & CHMOD 0777";
           } 
          }
           if(!empty($this->error))
                     {
                      $this->log_user($this->error, $this->ip); /// logi z User do bazy danych
                     }
          
         
    	///if (strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false)
    ///file_put_contents("bots.txt", "Googlebot | Wyszukiwanie ciڧu: {$_GET['s']} | ".date("d.m.Y\,\ H:i")); // $_GET['s'], to wyszukiwany ciڧ znak
              
        } 
public function log_read()   /// czytaj plok log 
	{ 
             $this->file = basename('test.txt'); 
          if(is_file($this->file)) // sprawdz czy istnieje 
             {  
               $this->file = file_get_contents($this->file); /// odczyt  
               while(!feof($this->file))
                {
                $li = fgets($this->file,4096);
                return $li."<br />";
                }  
             }
            //$tresc = implode("/n", $this->file);  
           // return $tresc[0];
        }
        
public function log_info()   /// info log plik
    {
       $this->file = basename('test.txt'); 
          if(is_file($this->file)) // sprawdz czy istnieje 
             {
                  $this->file = stat($this->file);
               $size=$this->file['size']/1024;
                //  print_r($file);
                 $arr = array();
                 $arr[] =  "size ".$size." kb";
                 $arr[] =  "Data ostatniegi Dostępu ".date("Y-m-d H:i:s",$this->file['atime']);
                 $arr[] =  "Data ostatniegj Modyfikacji ".date("Y-m-d H:i:s",$this->file['mtime']);
                 $arr[] =  "Data ostatniegj Zmiany ".date("Y-m-d H:i:s",$this->file['ctime']);
             }
         return  $arr; 
    }     
}  /// zapis do pliku tej klasy
