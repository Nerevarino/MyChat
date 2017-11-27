<?php

session_start();
if (isset($_SESSION['db_error'])) {                                             //Если была зарегистрирована ошибка
    unset($_SESSION['db_error']);                                                      //убираем регистрацию ошибки
    header("Location: http://ttbg.su/Edronov/Chat/SideEffects/login.php");            //редирект на страницу ошибки
} else {                       //если ошибка не была зарегистрирована, то просто делаем редирект на страницу логина
    header("Location: http://ttbg.su/Edronov/Chat/SideEffects/login.php");
}

?>








<!DOCTYPE html>
<html>
    <head>
		<meta charset = "utf-8"></meta>
		<title>Ошибка базы данных</title>
	</head>
	<body>
        <?php                                                       <!-- вывод сообщения об ошибке пользователю -->
            echo <<<EOT
<p>Ошибка соединения с базой данных: {$_SESSION['db_error']}</p>
<p>Обратитесь к администратору сайта.</p>
EOT;
        ?>
	</body>
</html>
