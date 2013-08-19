<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));

class chatClass
{
          public    $text; // dane z tablicy $_POST
          public    $user; // dane z tablicy $_POST
          public    $pokoj; // dane z tablicy $_POST
          public    $key; // dane z tablicy $_POST
          public    $chat; // 
          public    $chat_url; // 
          public    $trochetresci; // treść do zapisania w pliku
	  public    $name_user;
          private   $log;
          private   $db;      /// przypisanie połączenia z PDO 
          
      public function __construct() 
	  { 
              $this->db    = new databaseClass(); 
              $this->log   = new logClass(); // logclass
          }
          
       public function usun()
       {
          try{    
      
             $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $stmt = $this->db->query('SELECT * FROM `'.$this->db->dbprefix().'chat` ORDER BY `u_id` ASC');

                 if($stmt->rowCount()>50) // ilosc wpisow pow usuń
                 {
                    $del = $this->db->prepare('DELETE FROM `'.$this->db->dbprefix().'chat` ORDER BY `u_id` ASC LIMIT 5');
                     if (!$del)
                           {
                           $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                           }
                  ///$del->bindValue(':u_user', "admin", PDO::PARAM_STR);
                     /// $stmt->fetchAll();
                   return $del->execute(); 
                 }  
                      $stmt->closeCursor();
          }catch(PDOException $e){
                 $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }          
       }
          
      public function pisz($text, $user, $pokoj=null, $key=null)
          {	 
                  $this->text = $this->protect_chat($text);  
                   $this->user = $this->protect_chat($user); 
                    $this->pokoj = $this->protect_chat($pokoj); 
                     $this->key   = $this->protect_chat($key); 
        try{    
           $this->usun();  // usun wpisy
	         if($this->user == 'admin')
                   {
	              $kolor = '00FF00'; // kolor admina
	           }else{
	              $a = str_shuffle('ABCDEF1234567890');  
                      $kolor = substr($a,0,6);  // od zera do szesc
		   } 
		if(!empty($this->text)){
                  $format_time  = date("H:i:s");	
                 $this->trochetresci = "<div><strong style='color: #".$kolor.";'><b>".$this->user."
                 </b> </strong><em style='color: #0000ff;'> (".$format_time.") </em>
                 <br /><b style='color: red;'> ".$this->text." </b></div>";
                }
           if(isset($this->trochetresci)){
                   $stmt = $this->db->prepare('INSERT INTO `'.$this->db->dbprefix().'chat` (`u_chat`, `u_text`, `u_user`, `u_czas`, `u_tajny`, `u_key`) VALUES (
                                                                :u_chat,
                                                                :u_text,
								:u_user,
								:u_czas,
                                                                :u_tajny,
								:u_key)');  
                          if (!$stmt)
                               {
                                $this->log->log_user($this->db->errorInfo()); /// zapis logów do bazy danych 
                               }
                        $stmt->bindValue(':u_chat', "Public", PDO::PARAM_STR); 
                        $stmt->bindValue(':u_text', $this->trochetresci, PDO::PARAM_STR);
                        $stmt->bindValue(':u_user', "$this->user", PDO::PARAM_STR); 
			$stmt->bindValue(':u_czas', "$format_time", PDO::PARAM_STR);
                        $stmt->bindValue(':u_tajny', 1, PDO::PARAM_INT);
			$stmt->bindValue(':u_key', 12345, PDO::PARAM_INT); 
                        $stmt->execute();
                        $stmt->closeCursor();	
                 }

                 //$this->get_pisz(); /// zapisz dane 
                // $this->usun();  // usun co jakis wiersz
        }catch(PDOException $e){
                  $this->log->log_pdo($e);  /// logi z PDO 
              echo 'Połączenie nie mogło zostać utw.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                    $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious();
                    }
       return $this->trochetresci;             
   }

  public function protect_chat($p){
 
                       $p = trim(stripslashes(strip_tags($p)));
                       $p = htmlentities($p, ENT_QUOTES, "UTF-8");
                       $p = htmlspecialchars($p, ENT_NOQUOTES, 'UTF-8');
                       $p = nl2br($p);
                       $p = stripcslashes($p);  
                       $p = mb_strtolower($p,'UTF-8');
	$list2 = array("huj","chuj","chuja","chujem","chujowi","chujom","chujów","chujach","chujami","chuje","chujowy","chujowa","chujowe","chujowego","chujowej","chujowemu","chujowych","chujowym","chujowymi","chujowi","chujowo","cipa","cipy","cipę","cipęczke","cipie","cip","cipach","cipami","cipom","dojebać","dojebali","dojebaliście","dojebaliśmy","dojebano","dojebał","dojebała","dojebałam","dojebałaś","dojebałem","dojebałeś","dojebało","dojebały","dojebałyście","dojebałyśmy","dojebie","dojebać","dojebiecie","dojebcie","dojebiemy","dojebmy","dojeb","dojebiesz","dojebię","dojebaliby","dojebalibyście","dojebalibyśmy","dojebałby","dojebanoby","dojebałaby","dojebałabym","dojebałabyś","dojebałbym","dojebałbyś","dojebałoby","dojebałyby","dojebałybyście","dojebałybyśmy","dojebawszy","dopierdolić","dopierdolili","dopierdoliliście","dopierdoliliśmy","dopierdolono","dopierdolił","dopierdoliła","dopierdoliłam","dopierdoliłaś","dopierdoliłem","dopierdoliłeś","dopierdoliło","dopierdoliły","dopierdoliłyście","dopierdoliłyśmy","dopierdoli","dopierdolił","dopierdolicie","dopierdolcie","dopierdolimy","dopierdolmy","dopierdol","dopierdolisz","dopierdolę","dopierdoliliby","dopierdolilibyście","dopierdolilibyśmy","dopierdoliłby","dopierdoliłaby","dopierdoliłabym","dopierdoliłabyś","dopierdoliłbym","dopierdoliłbyś","dopierdoliłoby","dopierdoliłyby","dopierdoliłybyście","dopierdoliłybyśmy","dopierdoliwszy","dupa","dupie","dupy","dupie","dupę","dupach","dupom","dup","dupami","fuck","fucker","jebaniec","jebańca","jebańcem","jebańcu","jebańcy","jebańcach","jebańcami","jebańcom","jebańców","jebany","jebana","jebane","jebanego","jebanej","jebanemu","jebanych","jebanym","jebanymi","jebana","jebani","jebnięty","jebnięta","jebnięte","jebniętego","jebniętej","jebniętemu","jebniętych","jebniętym","jebniętymi","jebnięty","jebnięci","kurwa","kurwie","kurwy","kurwy","kurwę","kurew","kurwach","kurwami","kurwom","kurwiszon","kurwiszona","kurwiszonem","kurwiszonie","kurwiszonowi","kurwiszony","kurwiszonach","kurwiszonami","kurwiszonom","kurwiszonów","kurestwo","kurestwa","kurestwem","kurestwie","kurestwu","kurestwach","kurestwami","kurestwom","kurewski","kurewska","kurewskie","kurewskiego","kurewskiej","kurewskiemu","kurewskich","kurewskim","kurewskimi","kurewsky","kurewsko","kurewscy","kurewstwo","kurewstwa","kurewstwem","kurewstwie","kurewstwu","matkojebca","matkojebcy","matkojebcy","matkojebcę","matkojebcach","matkojebcami","matkojebcom","matkojebców","ochujać","ochujali","ochujaliście","ochujaliśmy","ochujał","ochujała","ochujałam","ochujałaś","ochujałem","ochujałeś","ochujało","ochujały","ochujałyście","ochujałyśmy","odpierdolić","odpierdolili","odpierdoliliście","odpierdoliliśmy","odpierdolono","odpierdolił","odpierdoliła","odpierdoliłam","odpierdoliłaś","odpierdoliłem","odpierdoliłeś","odpierdoliło","odpierdoliły","odpierdoliłyście","odpierdoliłyśmy","odpierdoli","odpierdolił","odpierdolicie","odpierdolcie","odpierdolimy","odpierdolmy","odpierdol","odpierdolisz","odpierdolę","odpierdoliliby","odpierdolilibyście","odpierdolilibysmy","odpierdoliłby","odpierdoliłaby","odpierdoliłabym","odpierdoliłabyś","odpierdoliłbym","odpierdoliłbyś","odpierdoliłoby","odpierdoliłyby","odpierdoliłybyście","odpierdoliłybyśmy","odpierdoliwszy","pierdolnicy","pierdolnica","pierdolnice","pierdolnicego","pierdolnicej","pierdolnicemu","pierdolnicych","pierdolnicym","pierdolnicymi","pierdolnic","pierdolony","pierdolona","pierdolone","pierdolonego","pierdolonej","pierdolonemu","pierdolonych","pierdolonym","pierdolonymi","pierdoloni","pierdoleni","pierdolić","pierdolili","pierdoliliście","pierdoliliśmy","pierdolił","pierdoliła","pierdoliłam","pierdoliłaś","pierdoliłem","pierdoliłeś","pierdoliło","pierdoliły","pierdoliłyście","pierdoliłyśmy","pita","pierdoli","pierdolni","pierdolicie","pierdolimy","pierdolisz","pierdolę","pierdol","pierdolcie","pierdolmy","pierdoliliby","pierdoliłby","pizda","pizdy","pizdzie","pizdni","pizdę","pizd","pizdach","pizdami","pizdom","piździe","piździelec","piździelca","piździelcem","piździelcowi","piździelcu","piździelcach","piździelcami","piździelcom","piździelców","piździelcy","podjebać","podjebali","podjebaliście","podjebaliśmy","podjebano","podjebał","podjebała","podjebałam","podjebałaś","podjebałem","podjebałeś","podjebało","podjebały","podjebałyście","podjebałyśmy","podjebie","podjebiń","podjebiecie","podjebcie","podjebiemy","podjebmy","podjeb","podjebiesz","podjebię","podjebaliby","podjebalibyście","podjebalibyśmy ","podjebałby","podjebałaby","podjebałabym","podjebałabyś","podjebałbym","podjebałbyś","podjebałoby","podjebałyby","podjebałybyście","podjebałybyśmy ","podjebawszy","podpierdalać","podpierdalali","podpierdalali¶cie","podpierdalaliśmy","podpierdalano","podpierdalając","podpierdalał","podpierdalała","podpierdalałam","podpierdalałaś","podpierdalałem","podpierdalałeś","podpierdalało","podpierdalały","podpierdalałyście ","podpierdalałyśmy","podpierdala","podpierdalają","podpierdalacie","podpierdalajcie","podpierdalamy","podpierdalajmy","podpierdalaj","podpierdalasz","podpierdalam","podpierdalaliby","podpierdalalibyście","podpierdalalibyśmy","podpierdalałby","podpierdalałaby","podpierdalałabym","podpierdalałabyś","podpierdalałbym","podpierdalałbyś","podpierdalałoby","podpierdalałyby","podpierdalałybyście","podpierdalałybyśmy","podpierdolić","podpierdolili","podpierdoliliście","podpierdoliliśmy","podpierdolono","podpierdolił","podpierdoliła","podpierdoliłam","podpierdoliłaś","podpierdoliłem","podpierdoliłeś","podpierdoliło","podpierdoliły","podpierdoliłyście","podpierdoliłyśmy","podpierdoli","podpierdolą","podpierdolicie","podpierdolcie","podpierdolimy","podpierdolmy","podpierdol","podpierdolisz","podpierdolę","podpierdoliliby","podpierdolilibyście","podpierdolilibyśmy","podpierdoliłby","podpierdolonoby","podpierdoliłaby","podpierdoliłabym","podpierdoliłabyś","podpierdoliłbym","podpierdoliłbyś","podpierdoliłoby","podpierdoliłyby","podpierdoliłybyście","podpierdoliłybyśmy","podpierdoliwszy","pojeb","pojeba","pojebem","pojebowi","pojeby","pojebach","pojebami","pojebom","pojebów","pojebaniec","pojebańca","pojebańcem","pojebańcowi","pojebańcu","pojebańcy","pojebańcach","pojebańcami","pojebańcom","pojebańców","pojebany","pojebana","pojebane","pojebanego","pojebanej","pojebanemu","pojebanych","pojebanym","pojebanymi","pojebaną","pojebani","pokurwiony","pokurwiona","pokurwione","pokurwionego","pokurwionej","pokurwionemu","pokurwionych","pokurwionym","pokurwionymi","pokurwioną","pokurwieni","popierdolić","popierdolili","popierdoliliście","popierdoliliśmy","popierdolił","popierdoliła","popierdoliłam","popierdoliłaś","popierdoliłem","popierdoliłeś","popierdoliło","popierdoliły","popierdoliłyście","popierdoliłyśmy","popierdoli","popierdolą","popierdolicie","popierdolimy","popierdolisz","popierdolę","popierdolony","popierdolona","popierdolone","popierdolonego","popierdolonej","popierdolonemu","popierdolonych","popierdolonym","popierdolonymi","popierdoloną","popierdoleni","przejebany","przejebana","przejebane","przejebanego","przejebanej","przejebanemu","przejebanych","przejebanym","przejebanymi","przejebaną","przepierdolić","przepierdolili","przepierdoliliście","przepierdoliliśmy","przepierdolono","przepierdolił","przepierdoliła","przepierdoliłam","przepierdoliłaś","przepierdoliłem","przepierdoliłeś","przepierdoliło","przepierdoliły","przepierdoliłyście","przepierdoliłyśmy","przepierdoli","przepierdolą","przepierdolicie","przepierdolimy","przepierdolisz","przepierdolę","przepierdoliliby","przepierdolilibyście","przepierdolilibyśmy","przepierdolonoby","przepierdoliłby","przepierdoliłaby","przepierdoliłabym","przepierdoliłabyś","przepierdoliłbym","przepierdoliłbyś","przepierdoliłoby","przepierdoliłyby","przepierdoliłybyście","przepierdoliłybyśmy","przypierdolić","przypierdolili","przypierdoliliście","przypierdoliliśmy","przypierdolono","przypierdolił","przypierdoliła","przypierdoliłam","przypierdoliłaś","przypierdoliłem","przypierdoliłeś","przypierdoliło","przypierdoliły","przypierdoliłyście","przypierdoliłyśmy","przypierdoli","przypierdolą","przypierdolicie","przypierdolcie","przypierdolimy","przypierdolmy","przypierdol","przypierdolisz","przypierdolę","przypierdoliliby","przypierdolilibyście","przypierdolilibyśmy","przypierdolonoby","przypierdoliłby","przypierdoliłaby","przypierdoliłabym","przypierdoliłabyś","przypierdoliłbym","przypierdoliłbyś","przypierdoliłoby","przypierdoliłyby","przypierdoliłybyście","przypierdoliłybyśmy","przypierdoliwszy","rozjebanie","rozjebania","rozjebaniem","rozjebaniu","rozjebać","rozjebali","rozjebaliście","rozjebaliśmy","rozjebano","rozjebał","rozjebała","rozjebałam","rozjebałaś","rozjebałem","rozjebałeś","rozjebało","rozjebały","rozjebałyście","rozjebałyśmy","rozjebie","rozjebią","rozjebiecie","rozjebcie","rozjebiesz","rozjebię","rozjebaliby","rozjebalibyście","rozjebalibyśmy","rozjebałby","rozjebanoby","rozjebałaby","rozjebałabym","rozjebałabyś","rozjebałbym","rozjebałbyś","rozjebałoby","rozjebałyby","rozjebałybyście","rozjebałybyśmy","rozjebawszy","rozjebany","rozjebana","rozjebane","rozjebanego","rozjebanej","rozjebanemu","rozjebanych","rozjebanym","rozjebanymi","rozjebaną","rozjebani","skurwiel","skurwiela","skurwielem","skurwielowi","skurwielu","skurwiele","skurwielach","skurwielami","skurwielom","skurwieli","skurwysyn","skurwysyna","skurwysynem","skurwysynowi","skurwysynie","skurwysynach","skurwysynami","skurwysynom","skurwysynów","skurwysynu","skurwysyński","skurwysyńska","skurwysyńskie","skurwysyńskiego","skurwysyńskiej","skurwysyńskiemu","skurwysyńskich","skurwysyńskim","skurwysyńskimi","skurwysyńską","skurwysyńsc ","skurwysyństwo","skurwysyństwa","skurwysyństwem","skurwysyństwie","skurwysyństwu","skurwysyństw","skurwysyństwach","skurwysyństwami","skurwysyństwom","spierdolić","spierdolili","spierdoliliście","spierdoliliśmy","spierdolono","spierdolił","spierdoliła","spierdoliłam","spierdoliłaś","spierdoliłem","spierdoliłeś","spierdoliło","spierdoliły","spierdoliłyście","spierdoliłyśmy","spierdoli","spierdolą","spierdolicie","spierdolimy","spierdolisz","spierdolę","spierdolcie","spierdol","spierdolmy","spierdalać","spierdalał","spierdalała","spierdalałam","spierdalałaś","spierdalałem","spierdalałeś","spierdalało","spierdalały","spierdalałyście","spierdalałyśmy","spierdala","spierdalaj","spierdalajcie","spierdalajmy","spierdalacie","spierdalamy","spierdalasz","wjebać","wjebali","wjebaliście","wjebaliśmy","wjebano","wjebał","wjebała","wjebałam","wjebałaś","wjebałem","wjebałeś","wjebało","wjebały","wjebałyście","wjebałyśmy","wjebie","wjebią","wjebiecie","wjebiemy","wjebiesz","wjebię","wjebaliby","wjebalibyście","wjebalibyśmy","wjebałby","wjebałaby","wjebałabym","wjebałabyś","wjebałbym","wjebałbyś","wjebałoby","wjebałyby","wjebałybyście","wjebałybyśmy","wjebawszy","wkurwiać","wkurwiali","wkurwialiście","wkurwialiśmy","wkurwiano","wkurwiając","wkurwiał","wkurwiała","wkurwiałam","wkurwiałaś","wkurwiałem","wkurwiałeś","wkurwiało","wkurwiały","wkurwiałyście","wkurwiałyśmy","wkurwia","wkurwiają","wkurwiacie","wkurwiajcie","wkurwiamy","wkurwiajmy","wkurwiaj","wkurwiasz","wkurwiam","wkurwialiby","wkurwialibyście","wkurwialibyśmy ","wkurwianoby","wkurwiałby","wkurwiałaby","wkurwiałabym","wkurwiałabyś","wkurwiałbym","wkurwiałbyś","wkurwiałoby","wkurwiałyby","wkurwiałybyście","wkurwiałybyśmy","wkurwiający","wkurwiająca","wkurwiajace","wkurwiającego","wkurwiającej","wkurwiającemu","wkurwiających","wkurwiającym","wkurwiającymi","wkurwiającą","wkurwić","wkurwili","wkurwiliście","wkurwiliśmy","wkurwiono","wkurwił","wkurwiła","wkurwiłam","wkurwiłaś","wkurwiłem","wkurwiłeś","wkurwiło","wkurwiły","wkurwiłyscie","wkurwiłyśmy","wkurwi","wkurwią","wkurwicie","wkurwimy","wkurwisz","wkurwię","wkurwiliby","wkurwilibyście","wkurwilibyśmy","wkurwiłby","wkurwiłaby","wkurwiłabym","wkurwiłabyą","wkurwiłbym","wkurwiłbyś","wkurwiłoby","wkurwiłybyście","wkurwiłybyśmy","wyjebać","wyjebali","wyjebaliście","wyjebaliśmy","wyjebano","wyjebał","wyjebała","wyjebałam","wyjebałaś","wyjebałem","wyjebałeś","wyjebało","wyjebały","wyjebałyście","wyjebałyśmy","wyjebie","wyjebią","wyjebiecie","wyjebcie","wyjebiemy","wyjebmy","wyjebiesz","wyjebię","wyjebałby","wyjebałaby","wyjebałabym","wyjebałabyś","wyjebałbym","wyjebałbyś","wyjebałoby","wyjebałyby","wypierdalać","wypierdalali","wypierdalaliście","wypierdalaliśmy","wypierdalano","wypierdalając","wypierdalał","wypierdalała","wypierdalałam","wypierdalałaś","wypierdalałem","wypierdalałeś","wypierdalało","wypierdalały","wypierdalałyście","wypierdalałyśmy","wypierdala","wypierdalają","wypierdalacie","wypierdalajcie","wypierdalamy","wypierdalajmy","wypierdalaj","wypierdalasz","wypierdalam","wypierdalałby","wypierdalałaby","wypierdolić","wypierdolili","wypierdoliliście","wypierdoliliśmy","wypierdolono","wypierdolił","wypierdoliła","wypierdoliłam","wypierdoliłaś","wypierdoliłem","wypierdoliłeś","wypierdoliło","wypierdoliły","wypierdoliłyście","wypierdoliłyśmy","wypierdoli","wypierdolą","wypierdolicie","wypierdolcie","wypierdolimy","wypierdolmy","wypierdol","wypierdolisz","wypierdolę","wypierdoliliby","wypierdolilibyście","wypierdolilibyśmy","wypierdoliłby","wypierdoliłaby","wypierdoliłabym","wypierdoliłabyś","wypierdoliłbym","wypierdoliłbyś","wypierdoliłoby","wypierdoliłyby","wypierdoliłybyście","wypierdoliłybyśmy","wypierdoliwszy","zajebać","zajebali","zajebaliście","zajebaliśmy","zajebano","zajebał","zajebała","zajebałam","zajebałaś","zajebałem","zajebałeś","zajebało","zajebały","zajebałyście","zajebałyśmy","zajebie","zajebią","zajebiecie","zajebcie","zajebiemy","zajebiesz","zajeb","zajebię","zajebaliby","zajebalibyście","zajebalibyśmy","zajebałby","zajebałaby","zajebałabym","zajebałąbyś","zajebałbym","zajebałbyś","zajebałoby","zajebałyby","zajebałybyście","zajebałybyśmy","zajebawszy","zakurwić","zakurwili","zakurwiliście","zakurwiliśmy","zakurwił","zakurwiła","zakurwiłam","zakurwiłaś","zakurwiono","zakurwiłem","zakurwiłeś","zakurwiło","zakurwiły","zakurwiłyscie","zakurwiłyśmy","zakurwi","zakurwią","zakurwicie","zakurwimy","zakurwisz","zakurwię","zakurwiliby","zakurwilibyście","zakurwilibyśmy","zakurwiłby","zakurwiłaby","zakurwiłabym","zakurwiłabyś","zakurwiłbym","zakurwiłbyś","zakurwiłoby","zakurwiłyby","zakurwiłybyście","zakurwiłybyśmy","zakurwiwszy","zapierdalać","zapierdalali","zapierdalaliście","zapierdalaliśmy","zapierdalano","zapierdalając","zapierdalał","zapierdalała","zapierdalałam","zapierdalałaś","zapierdalałem","zapierdalałeś","zapierdalało","zapierdalały","zapierdalałyście","zapierdalałyśmy","zapierdala","zapierdalają","zapierdalacie","zapierdalajcie","zapierdalamy","zapierdalajmy","zapierdalaj","zapierdalasz","zapierdalam","zapierdalaliby","zapierdalalibyście","zapierdalalibyśmy","zapierdalałby","zapierdalałaby","zapierdalałabym","zapierdalałabyś","zapierdalałbym","zapierdalałbyś","zapierdalałoby","zapierdalałyby","zapierdalałybyście","zapierdalałybyśmy","zapierdolić","zapierdolili","zapierdoliliście","zapierdoliliśmy","zapierdolono","zapierdolił","zapierdoliła","zapierdoliłam","zapierdoliłaś","zapierdoliłem","zapierdoliłeś","zapierdoliło","zapierdoliły","zapierdoliłyście","zapierdoliłyśmy","zapierdoli","zapierdolą","zapierdolicie","zapierdolcie","zapierdolimy","zapierdolisz","zapierdolę","zapierdoliliby","zapierdolilibyście","zapierdolilibśmy","zapierdoliłby","zapierdolonoby","zapierdoliłaby","zapierdoliłabym","zapierdoliłabyś","zapierdoliłbym","zapierdoliłbyś","zapierdoliłoby","zapierdoliłyby");
	$list1 = array("aryan","ass","asshole","bastard","bastards","bitch","bitches","bitching","bitchy","boob","boobie","booby","boobs","boobies","boobys","bullshit","bullshitter","bullshitters","bullshitting","chickenshit","chickenshits","clit","cock","cockhead","cocks","cocksuck","cocksucker","cocksucking","cum","cums","cumming","cunt","cuntree","cuntry","cunts","dipshit","dipshits","dumbfuck","dumbfucks","dumbshit","dumbshits","fag","fags","faggy","faggot","faggots","fuck","fucks","fukk","fukka","fucka","fucke","fucker","fuckers","fucked","fuckin","fucken","fucking","fuckup","fuckups","fuckhead","fuckhed","fuckheads","fuckface","golem","goniff","hebe","hebes","heb","kike","kikes","kunt","kuntree","kuntry","kunts","motherfuck","motherfucker","motherfuckers","motherfucking","motherfuckin","motherfucken","nazi","nigger","niggers","nigga","niggas","niggaz","niggah","niggahs","niggard","niggardly","penis","piss","porn","porno","pornography","pussy","schlimiel","schlimazel","shit","shits","shitty","shitting","shitface","shitfaced","shithead","shithed","shitheads","slut","sluts","slutty","tit","tits","titty","titties","vagina","vaginal","whore","whores","whoring"); 
	$slowa = array_merge($list1, $list2); /// podwójna tablica
        
         $bb = count($slowa); 
     for($i=0; $i<$bb; $i++){       
       $p =  str_replace($slowa[$i], 'CENZURA', $p); // cenzura
             }
   return $p;   
}

} 
   
