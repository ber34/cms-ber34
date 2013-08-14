function load()
 { 
    scrolldol();
          setInterval(function(){
            jQuery("#chat_content").load("bazachat/baza_czat.php").show(); 
          }, 10000);

            jQuery("#chat_content").load("bazachat/baza_czat.php").show();        
         window.clearInterval(bb);     
 }

function scrolldol()
 {	
        setInterval(function(){
            jQuery("#chat_content").scrollTop(9999)
        }, 200);
}
     
function loadPost(){
                  jQuery("#newconntent").click(function(){
                         document.newconntentform.newconntent.value = '';
                        });
              
   ////jQuery("#newconntentsubmitchat").click(function(){  }); 
                tresc     = jQuery( 'textarea[name="newconntent"]' ).val();
                user      = jQuery( 'input[name="user"]' ).val();
                youkey    = jQuery( 'input[name="youkey"]' ).val();
                //// var  k   = Math.round(Math.floor(Math.random()*9999));
                  document.cookie=k; /// zabezpieczenie przed ponownym wysłaniem form
               if (youkey)
                  {
                   // document.cookie=k;
                 var c = document.cookie;
                  }
               if (c)
                  {
                 var n  = c.split(";",1);
                  }  

    jQuery.ajax({
	    type: "POST",
            url: 'bazachat/baza_czat.php',
		data: { tresc: tresc, user: user, youkey: youkey}, // Dane przesyłane $_POST
                        cache: false,
       beforeSend:function()
       {
    jQuery('#loading').html('<div class="loading"><img src="/images/loading.gif" alt="Loading..." /></div>');
       },    
       success: function(data)
	{
          jQuery('#loading').empty();
         ////jQuery("#chat_content").html(data).show();
                //// window.clearInterval(tt);
     document.newconntentform.newconntent.value = '';     
     //// window.location.reload();
       },
    complete : function(data) {
      
            if(n == youkey)
     {  
       bb = setInterval(function(){ 
	jQuery("#chat_content").load("bazachat/baza_czat.php").show();
       }, 1000);   ////  setInterval   setTimeout
     }
         load();
            jQuery('#loading').hide();  
    },            
  error: function(data) {
    alert("ERROR: "+data)
  }        
             });
     return false;
           }
