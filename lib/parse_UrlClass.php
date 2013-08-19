<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));
class  parse_UrlClass
{
   private   $_url;
   private   $_url1;
   private   $akcja;
   private   $adres;
   private   $page;
   private   $log;  
   protected $l;

     public function __construct() 
		  { 
                      $this->db    = new databaseClass();   // połączenie z bazą
                      $this->log   = new logClass(); // logclass
                  }
public function url()
  {
   try{ 
       if(isset($_GET['akcja']))
         $this->akcja = base64_decode($this->skruc($_GET['akcja'])); /// adres
             
       if($this->akcja === NULL)
         {
          $this->akcja = "index.html"; 
         }
         if($this->akcja == "404")
             {
             header("location:".$_SERVER['PHP_SELF']);
             }
	   /*
             $lk = array('index.html'=>'home', 'wyloguj.html'=>'wyloguj.user', 'rejestracja.html'=>'rejestracja'
                        , 'przypomnijhaslo.html'=>'przypomnijhaslo', 'fqu.html'=>'fqu', 'regulamin.html'=>'regulamin'
                        , 'publiczny.html'=>'publiczny', 'zarejestrowani.html'=>'zarejestrowani'
                        , 'dlaprzyjaciol.html'=>'dlaprzyjaciol', 'chat.html'=>'chat'); // pierwsze to adres zwrócony przez get a drugi to nazwa pliku
          */
          $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                 $stmt = $this->db->prepare('SELECT u_adres, u_adrespage FROM `'.$this->db->dbprefix().'adres` WHERE u_adres=:u_adres');
                                    if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                 $stmt->bindParam(':u_adres', $this->akcja, PDO::PARAM_STR);
                 $stmt->execute();
             foreach($stmt as $row1)
                    { 	 
                      if($row1['u_adres'] == $this->akcja)
                        {
                               $this->page = $row1['u_adrespage'];
                        }else{
                               $this->page = '404';  
                        }          
	             } 

               if(file_exists('pliki/'.basename($this->page.'.php')))
	          {
                    return 'pliki/'.basename($this->page.'.php');
                  }else{
                    return 'pliki/'.basename('404.php');           
                  }
                  $stmt->closeCursor();     
           }catch(PDOException $e){
            $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }       
	}
 /*  
        public function actual_url()
	   {  
           //  $all_url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; /// tu jestem	
               
	if(strpos($_SERVER['REQUEST_URI'], $this->akcja)===false)
            { 
                 return false;
                     }else{
                 return true;
            }						
               } 
  */
  ###################################  czyści get adresu ###########################
    protected function skruc($url) 
	{
	                              $copl   = array('ą','ę','ć','ł','ń','ó','ś','ź','ż');
				      $CoPL1  = array('Ą','Ę','Ć','Ł','Ń','Ó','Ś','Ź','Ż');
				      $co     = array('a','e','c','l','n','o','s','z','z');
					
                                      $this->_url  = $url; 
				      $this->_url  = trim($this->_url);
                                      $this->_url  = str_replace($copl,$co,$this->_url); /// zamienia litery
				      $this->_url  = str_replace($CoPL1,$co,$this->_url); /// zamienia litery
				      $this->_url  = strtolower($this->_url); 
                                      $this->akcja  = explode("/", $this->_url);
                                foreach ($this->akcja as $key => $value) 
                                 {
                                           if($key > '0'){
                                            $this->_url='404';  
                                           }else{
                                            $this->_url;   
                                           }
                                  }
                                      
				      $this->_url  = preg_replace('/[^a-z0-9\.]+/si','',$this->_url);
                      
            return base64_encode($this->_url); /// dekoduj w pliku wykonawczym
       }
     protected function skrucadres($url1) 
	{
                        $this->_url1  = (int)$url1;
                        ///$this->_url1  = htmlentities(addslashes($this->_url1),ENT_QUOTES,'UTF-8');
			if(is_numeric($this->_url1))
                            {
                              $this->_url1;
                            }else{
                              $this->_url1=1;  
                            }
                       /// $this->_url1  = preg_replace('/[^0-9]+$/','',$this->_url1);
            return $this->_url1; /// dekoduj w pliku wykonawczym
         }
       ############################  przypisane do menu href= ###########################
    public function adres($adres) 
	{
         try{
           if(isset($adres))
             {
             $this->adres = $this->skrucadres($adres);
             }
             
             $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                  $stmt = $this->db->prepare('SELECT u_id,u_urlhref FROM `'.$this->db->dbprefix().'adreshref` WHERE u_id=:u_id');
                               if (!$stmt)
                                    {
                                    $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                                    }
                  $stmt->bindParam(':u_id', $this->adres, PDO::PARAM_STR);
                  $stmt->execute();
                
             foreach($stmt as $ro)
                    { 	 
                      if(isset($ro['u_urlhref']))
                        {
                         $this->l = $ro['u_urlhref'];
                        }         
	             }  
               /*$this->l = array('index.html', 'fqu.html', 'regulamin.html',
			'wyloguj.html', 'publiczny.html', 'zarejestrowani.html', 'dlaprzyjaciol.html',
                       'rejestracja.html', 'przypomnijhaslo.html', 'chat.html'); // 10 index , fqu , regulamin, wyloguj, publiczny, dla zalogowanych,  dlaprzyjaciół
                  */
                 return $this->l; // zwraca adres
            }catch(PDOException $e){
                $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }     
	}
 }	
