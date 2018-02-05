<?php

namespace Edronov\Chat\Classes;				

use \mysqli as mysqli;         				

require 'PhpPage.php';                         //базовый класс


class Chat extends PhpPage                                 
{
    public function __construct()
    {
        session_start();
        if ($this->userLogged()) {
            if ($this->existPostData()) {
                $this->postMessage();
            } else {
            }
        } else {                         //Если пользователь еще не залогинен - сделать редирект на страницу логина 
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/login.php");
        }
    }

    public function getMessages()         //печать существующих и видимых (по размерам окна чата) сообщений чата 
    {
        $db_connection = new mysqli (       //соединяемся с БД
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) { //если при соединении с БД произошла ошибка - то пишем об этом в файл
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/db_error.php");//редир на стр с сообщ о ошиб
        }
        //задаем текст запроса к БД для получения видимых сообщений
        $query = <<<GETMESSAGES
SELECT nickname, text FROM Messages LEFT JOIN Users ON Users.id = Messages.user_id ORDER BY Messages.id ASC LIMIT 20;
GETMESSAGES;

        $get_messages = $db_connection->prepare($query);      //создаем пре-запрос к базе используя текст запроса
        if ($db_connection->connect_errno) {                  //если при создании пре-запроса возникла ошибка
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/db_error.php"); //редир на стр с сообщ о ошибк
        }

        $nickname = array();      //создаем переменную, куда будем выводить столбец "ник-пользователя" из ответа БД
        $message = array();       //создаем переменную, куда будем выводить столбец "сообщение пользов" из ответа БД

        $get_messages->bind_result($nickname, $message);
        $get_messages->execute();
        $get_messages->store_result();

        $messages_text = null;                                //переменная, содержащая весь текст видимых сообщений
        while ($get_messages->fetch()) {                      //разбираем построчно ответ БД
           $messages_text = $messages_text . $nickname . ": ". $message .  "<br></br>";   
        }                                                                  //печатаем "имя пользователя: сообщение"
        $db_connection->close();
        return $messages_text;
    }

    public function getUserWelcome()                        //"приветствие" залогиневшемуся пользователю
    {
        return "Hello, {$_SESSION['user_nickname']}!"; 
    }

    protected function userLogged()                  //проверка, залогинен ли пользователь
    {
        return isset($_SESSION['user_id']);          
    }

    protected function existPostData()               //проверка наличия входных данных от пользователя
    {
        return isset($_POST['message']);             
    }
    
    protected function postMessage()                 //запись новго сообщения в БД
    {
        $user_id = $_SESSION['user_id'];             //берем id пользователя из глобальной переменной сессии
        $messageText = $_POST['message'];            //берем сообщение пользователя из глобальной переменной $_POST

        $db_connection = new mysqli (                
            "localhost",                             
            "srv117239_msus",                        
            "msqlarino",                             
            "srv117239_msqlchat"                     
        );
        if ($db_connection->connect_errno) {                   //Если при соединении с БД произошла ошибка 
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/db_error.php"); //редир на стр с сообщ о ошибк
        }
        //задаем текст запроса к БД для записи нового сообщения пользователя
        $query = <<<INSERTMESSAGE
INSERT INTO
    Messages(user_id, text)
VALUES
    (?, ?)
;
INSERTMESSAGE;
        $insert_new_message = $db_connection->prepare($query);//создаем пре-запрос к базе используя текст запроса
        if ($db_connection->connect_errno) {                  //если при создании пре-запроса возникла ошибка
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);
            $db_connection->close();                                            
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/chat.php");   //редир на стр с сообщ о ошибк
        }
        $insert_new_message->bind_param("is", $user_id, $messageText); 
        $insert_new_message->execute();                                
        $db_connection->close();                                       
    }

    public function render()
    {
        echo <<<PAGE
<!DOCTYPE html>
<html>
    <head>
        <title>Мой чат</title>
        <style>@import url('../Design/style.css');</style>
    </head>
    <body>    
        <div id = "interface">      
            <a href = "http://ttbg.su/Edronov/Chat/SideEffects/logout.php">Выйти</a>
            <div id = "chatview">
                {$this->getMessages()}
            </div>
            <form id = "form" method = "post" action = "chat.php">
                <input id = "messageBox"  name = "message" type = "text"  size = "63" />
                <input id = "sendMessage" type = "submit" value = "Send"></input>
            </form>
        </div>
        <p> {$this->getUserWelcome()} </p>
    </body>
</html>
PAGE;
    }
}
