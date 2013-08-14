 include_once (dirname(__DIR__) . '/'.basename('router.php'));
  try{
       $chat->pisz(@$_POST['tresc'], @$_POST['user'], @$pokoj, @$key); 
       
       $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
       $stmt = $pdo->prepare('SELECT u_text, u_user, u_czas FROM `'.$pdo->dbprefix().'chat` ORDER BY `u_id` ASC');
       $stmt->execute(); 
       foreach ($stmt->fetchAll() as $d)
               {
                  echo $d['u_text'];   
               }
                $stmt->closeCursor();
      }catch(PDOException $e){
                  echo 'Połączenie w baza Chat pisz() nie mogło zostać utw.<br />'.$e->getMessage(); 
      }
