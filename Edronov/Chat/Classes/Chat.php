<?php

namespace Edronov\Chat\Classes;				

use \mysqli as mysqli;         				

require 'PhpPage.php';                         //базовый класс


class Chat extends PhpPage                                 
{
    public function __construct()
    {
        session_start();
        if ($this->userLogged()) {                                  //Если пользователь залогинен
            if ($this->existPostData()) {                           //Отправил ли пользователь сообщение
                $this->postMessage();                               //принять и обработать сообщение
            } else {}
        } else {                                                    //Если пользователь не залогинен - перейти к логину
            header("Location: http://ttbg.su/login.php");
        }
    }

    public function getMessages()                                   //печать помещающихся в чат сообщений
    {
        $db_connection = new mysqli (                               //открываем соединение с базой данных
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {                                            //если нет связи с БД
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);  //пишем ошибку в лог-файл

        }

        //задаем текст запроса к БД для получения видимых сообщений
        //$query = getmessages.sql

        $get_messages = $db_connection->prepare($query);                                        //готовим запрос
        if ($db_connection->connect_errno) {                                                    //если ошибка
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);  //пишем в файл ошибок
            $db_connection->close();                                                            //закрываем БД
        }

        $nickname = array();                                            //здесь храним "ник-пользователя" из ответа БД
        $message = array();                                       //здесь храним "сообщение пользователя" из ответа БД

        $get_messages->bind_result($nickname, $message);               //привязываем переменные к ответу БД
        $get_messages->execute();                                                //выполняем запрос к БД
        $get_messages->store_result();                                     //размещает ответ БД в связанные переменные

        $messages_text = null;                                      //переменная для хранения текста видимых сообщений
        while ($get_messages->fetch()) {                                                //разбираем построчно ответ БД
           $messages_text = $messages_text . $nickname . ": ". $message .  "<br></br>";   
        }                                                                  //печатаем "имя пользователя: сообщение"
        $db_connection->close();                                                          //закрываем связь связь с БД
        return $messages_text;                                                    //возвращаем текст видимых сообщений
    }

    public function getUserWelcome()                     // получить строку "приветствия" залогиневшемуся пользователю
    {
        return "Hello, {$_SESSION['user_nickname']}!"; 
    }

    protected function userLogged()                                              //проверка, залогинен ли пользователь
    {
        return isset($_SESSION['user_id']);          
    }

    protected function existPostData()                             //проверка наличия нового сообщения от пользователя
    {
        return isset($_POST['message']);             
    }
    
    protected function postMessage()                                       //запись нового сообщения пользователя в БД
    {
        $user_id = $_SESSION['user_id'];                       //берем id пользователя из глобальной переменной сессии
        $messageText = $_POST['message'];               //берем сообщение пользователя из глобальной переменной $_POST

        $db_connection = new mysqli (                                                               //соединяемся с БД
            "localhost",                             
            "srv117239_msus",                        
            "msqlarino",                             
            "srv117239_msqlchat"                     
        );
        if ($db_connection->connect_errno) {                                             //Если ошибка соединения с БД
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);   //пишем ошибку в файл
        }

        //задаем текст запроса к БД для записи нового сообщения пользователя
        //$query = postmessage.sql

        $insert_new_message = $db_connection->prepare($query);                                   //готовим запрос к БД
        if ($db_connection->connect_errno) {                                  //при подготовке запроса возникла ошибка
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);   //пишем ошибку в файл
            $db_connection->close();                                                                    //закрываем БД
        }
        $insert_new_message->bind_param("is", $user_id, $messageText); //связать переменные с запросом
        $insert_new_message->execute();                                                             //выполнить запрос
        $db_connection->close();                                                                  //закрыть связь с БД
    }

    public function render()                                  //функция рендеринга html страницы (генерация html кода)
    {
        //chat.html
    }
}
