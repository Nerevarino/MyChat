<?php


session_start();
if(isset($_SESSION['user_id']))
{

}
else{        
    header('Location: http://ttbg.su/login.php');
}


?>




<!DOCTYPE html>
<html>
  <head>
    <title>Мой чат</title>
    <style>@import url('style.css');</style>
  </head>
  <body>
    
    <div id="interface">
      <a href="http://ttbg.su/logout.php">Logout</a>
      <div id="chatview">
        <?php
          // foreach($visible_messages as $message){
          //     echo "<p>$message</p>\n";
          // }
        ?>
      </div>
      <form id="form" method="post" action="index.php">
        <input name="message_text" type="text" id="usermsg" size="63" />
        <input type="submit" name="enter" id="enter" value="Send" />
      </form>
    </div>
    <p><?php echo "Hello, ${_SESSION['user_name']}!"; session_destroy();?></p>
  </body>
</html>