<?php

require 'Registration.php';

$reg_process = new Registration();

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8"></meta>
		<title>Регистрация</title>
	</head>
	<body>
        <form method = "post">
            E-mail: <input type = "text" name = "email" size = "50"></input>
            <br></br>
            <br></br>
            Nickname: <input type = "text" name = "nickname"  size = "50"></input>
            <br></br>
            <br></br>
            password: <input type = "password" name = "password"  size = "50"></input>
            <br></br>
            <br></br>
            <input type = "submit"  value = "register"></input>
            <br></br>
            <br><?php $reg_process->printStatusMessage(); ?></br>
        </form>
	</body>
</html>
