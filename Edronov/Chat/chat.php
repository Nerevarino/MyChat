<?php

namespace Edronov\Chat;

require 'Chat.php';

$chat_object = new Chat();

?>




<!DOCTYPE html>
<html>
    <head>
        <title>Мой чат</title>
        <style>@import url('style.css');</style>
    </head>
    <body>    
        <div id = "interface">      
            <a href = "http://ttbg.su/Edronov/Chat/logout.php">Выйти</a>
            <div id = "chatview">
                <?php $chat_object->printMessages(); ?>
            </div>
            <form id = "form" method = "post" action = "chat.php">
                <input id = "messageBox"  name = "message" type = "text"  size = "63" />
                <input id = "sendMessage" type = "submit" value = "Send"></input>
            </form>
        </div>
        <p><?php $chat_object->printUserWelcome(); ?></p>
    </body>
</html>
