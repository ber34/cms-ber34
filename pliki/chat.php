<?php
$user=rand(1,999999);
?>
        <section class="">				 
                      
     	   <div id="divchat"><br />
          <h2 class="username_chat">Chat Publiczny</h2>        
       <div align="center" class="username_chat"><?php echo $user; ?></div>  
             <div style="height: 370px;" id="chat_content"></div>
        <div class="message">          
         <form id="newconntentform" name="newconntentform" action="#" method="post" onsubmit="return false;">
         </form>   
        </div> 
     <script type="text/javascript">
 jQuery(function(){ 
    ///loadPost();
                        jQuery('#chat_content').corner("round 8px").parent().css('padding', '8px').corner("round 14px");
                        jQuery('#chat_content').corner();
						jQuery('#newconntent').corner();
						jQuery('#newconntentsubmitchat').corner();
                    
 });				
     </script>
    </div> </section>
