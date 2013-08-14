class databaseClass extends PDO
{
    
          private $engine = 'mysql';
          private $host = 'localhost';
	  private $port = 3306;
          private $database = 'pdo';
          private $user = 'root';
          private $pass = 'bernardino1';
          private $dns;
          private $DbPrefix = 'prk_';
          private $file;
          public  $log;


   public function __construct()
    { 
     try{     
          if(!empty($this->database))
                 { 
                  $this->dns = $this->engine.':host='.$this->host.';port='.$this->port.';dbname='.$this->database.';';
                  parent::__construct($this->dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));  // bufor 1-50MB
                 }      
          }catch(PDOException $e){
            echo 'Połączenie nie mogło zostać utworzone.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
          }
    }
  public function dbprefix()
    {  
       return $this->DbPrefix;
    }     
}
