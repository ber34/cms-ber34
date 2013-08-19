<?php
include_once (dirname(__DIR__) . '/'.basename('router.php'));

	 if($session->sprawdzsesje() == true)
	    {
         // $trochetre = $chat->get_pisz();   onsubmit="return false;"
?>
        <section class="">				           
 	   <div id="divchat"><div id="loading"></div>
          <h2 class="username_chat">Chat Zarejestrowani</h2>        
       <div align="center"  class="username_chat"><?php echo $user->user(); ?></div>  
             <div id="chat_content"></div>
              <div id="chat"></div>
        <div class="message">          
         <form id="newconntentform" name="newconntentform" action="#" method="post"  onsubmit="return false;">
           <div class="left">
         <textarea name="newconntent" id="newconntent"></textarea>
          <input type="hidden" id="user_chat" name="user" value="<?php echo $user->user(); ?>" />  
          <input type="hidden" id="key" name="youkey" value=""/>   
            </div>
            <div class="right">
              <input type="submit" name="submit" onclick="loadPost()" id="newconntentsubmitchat" value="wyślij" />
            </div> 
         </form>   
        </div> 
   
  <script type="text/javascript">
                 
                   ////  jQuery(document).ready(function() {  });
                      //// setInterval(function(){   }, 5000);
                          load();
                      
                     var k = Math.round(Math.floor(Math.random()*9999));
                         document.cookie=k;
                         jQuery("#key")[0].value = k;
                         
                          
                                       /// document.getElementById('key').value = key();
                      
                      ////jQuery('input[name="youkey"]').val();
                       
     </script>
    </div> </section>
<?php
            }
