<?php 

namespace Edronov\Chat;

require 'Login.php';

$login_process = new Login();

?>





<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8"></meta>
        <title>Мой чат</title>
    </head>
    <body>
        <form method = "post">
            Nickname or E-mail: <input type = "text" name = "nickname_or_email" size = "50"></input>
            <br></br>
            <br></br>
            Password: <input type = "password" name = "password"  size = "50"></input>
            <br></br>
            <br></br>
            <input type = "submit"  value = "Войти"></input>
            <a href = "http://ttbg.su/Edronov/Chat/registration.php">Зарегистрироваться</a>
            <br></br>
            <br></br>
            <br><?php $login_process->printStatusMessage(); ?></br>
        </form>
    </body>
</html>
