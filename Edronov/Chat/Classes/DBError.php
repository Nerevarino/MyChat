<?php

namespace Edronov\Chat\Classes;

require 'PhpPage.php';

class DBError extends PhpPage
{
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['db_error'])) {                                     //Если была зарегистрирована ошибка
            unset($_SESSION['db_error']);                                              //убираем регистрацию ошибки
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/login.php");    //редирект на страницу ошибки
        } else {               //если ошибка не была зарегистрирована, то просто делаем редирект на страницу логина
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/login.php");
        }
    }
    
    public function render()
    {
       echo <<<PAGE
<!DOCTYPE html>
<html>
    <head>
		<meta charset = "utf-8"></meta>
		<title>Ошибка базы данных</title>
	</head>
	<body>
        <p>Ошибка соединения с базой данных: {$_SESSION['db_error']}</p>
        <p>Обратитесь к администратору сайта.</p>
	</body>
</html>           
PAGE;
    }
}
