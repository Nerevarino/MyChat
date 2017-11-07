<?php


//definitions

//definitions









//script
session_start();
if(isset($_SESSION['user_id']))
{

}
else{        
    header('Location: http://ttbg.su/login.php');
}
//script

?>




<!DOCTYPE html>
<html>
  <head>
    <title>Мой чат</title>
    <style>@import url('style.css');</style>
    <script type="text/javascript" src="myajax.js"></script>
    <script type="text/javascript" src="getmes.js"></script>
  </head>
  <body>    
    <div id="interface">      
      <a href="http://ttbg.su/logout.php">Выйти</a>
      <div id="chatview" >
        <script type="text/javascript">
          setInterval(getMessages,500);
        </script>
      </div>
      <div id="form">
        <input id="messageBox"  type="text"  size="63" />
        <button id="sendMessage" onclick="onSend();">Send</button>
      </div>
    </div>
    <p><?php echo "Hello, {$_SESSION['user_name']}!";?></p>
  </body>
</html>



// https://github.com/bagau/bchat/blob/master/websocket.php