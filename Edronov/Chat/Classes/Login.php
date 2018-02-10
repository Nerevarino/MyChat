<?php

namespace Edronov\Chat\Classes;              

use \mysqli as mysqli;

require 'PhpPage.php';                                                                              //базовый класс


class Login extends PhpPage
{

    protected $status_message = "";
    protected $nickname_or_email = null;                          //Логин осуществляется по email-у /нику  и паролю
    protected $password = null;
    
    public function __construct()
    {
        session_start();
        if (!$this->userLogged()) {                                                //если пользователь еще не залогинен
            if ($this->existFormData()) {                         //если пользователь отправил идентификационные данные
                $this->nickname_or_email = $_POST['nickname_or_email'];          //записываем пользователя в переменную
                $this->password = $_POST['password'];                                  //записываем пароль в переменную
                $this->verify();                                        //проверяем идентификатор пользователя и пароль
            } else {}                                            //если нет данных от пользователя, то ничего не делаем
        } else {                                        //Если пользователь уже залогинен
            header('Location: http://ttbg.su/chat.php');                              //редирект на страницу чата
        }        
        
    }

    protected function verify()                                                              //авторизация пользователя
    {
        $db_connection = new mysqli (                                                            //связываемся с БД
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {                                              //если ошибка соединения с БД
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);    //пишем ошибку в файл
        }

        //создаем текст запроса к БД на проверку наличия пользователя с такими идентификационными данными
        $query = <<<VERIFYUSER
SELECT id, nickname FROM Users 
    WHERE (nickname=? AND passwd=?)
    OR    (email=? AND passwd=?);
VERIFYUSER;

        $verification = $db_connection->prepare($query);                                          //готовим запрос к БД
        $verification->bind_param(                             //связываем переменные с данными пользователя с запросом
            "ssss",
            $this->nickname_or_email,
            $this->password,
            $this->nickname_or_email,
            $this->password
        );

        $user_id = null;                                             //создаем переменные, в которые передадим ответ БД
        $user_nickname = null;
        $verification->bind_result($user_id, $user_nickname);          //связываем эти переменные с запросом
        $verification->execute();                                                                    //выполняем запрос
        $verification->store_result();                                     //размещаем результат в связанных переменных

        if ($verification->num_rows == 1) {                                      //если по запросу нашелся пользователь
            $verification->fetch();
            $_SESSION['user_id'] = $user_id;                                        //записать в сессию id пользователя
            $_SESSION['user_nickname'] = $user_nickname;                           //записать в сессию ник пользователя
            $db_connection->close();                                                             //закрываем связь с БД
            header("Location: http://ttbg.su/chat.php");                              //редирект на страницу чата
        } else {                                              //если пользователь не найден по идентификационным данным
            $db_connection->close();                                                             //закрываем связь с БД
            $this->status_message = "Ошибка входа: неверный пользователь или пароль"; //сообщение страницы пользователю
        }        
    }
    
    protected function existFormData()                            //Пришли ли от пользователя идентификационные данные?
    {
        return isset($_POST['nickname_or_email']) and isset($_POST['password']);
    }

    protected function userLogged()                                                    //Залогинен ли уже пользователь?
    {
        return isset($_SESSION['user_id']);
    }

    public function render()                                                    //печать страницы (получение html кода)
    {
        echo <<<PAGE
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
            <a href = "http://ttbg.su/registration.php">Зарегистрироваться</a>
            <br></br>
            <br></br>
            <br> {$this->status_message} </br>
        </form>
    </body>
</html>
PAGE;
    }
}
