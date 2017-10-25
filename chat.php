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
    <script type="text/javascript">
          function ajaxRequest()
          {
            try // Браузер не относится к семейству IE?
            {
              var request = new XMLHttpRequest();
            }
            catch(e1)
            {
              try // Это IE 6+?
              {
                request = new ActiveXObject("Msxml2.XMLHTTP");
              }
              catch(e2)
              {
                try // Это IE 5?
                {
                  request = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch(e3) // Данный браузер не поддерживает AJAX
                {
                  request = false;
                }
              }
            }
            return request;
          }

          
    </script>
  </head>
  <body>
    
    <div id="interface">
      <a href="http://ttbg.su/logout.php">Выйти</a>
      <div id="chatview"/>
      <input id="messageText" type="text" size="63" />
      <input id="sendMessage" type="submit"  value="Отправить" />
    </div>
    <p><?php echo "Hello, {$_SESSION['user_name']}!";?></p>
  </body>
</html>
