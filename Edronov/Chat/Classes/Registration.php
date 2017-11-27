<?php

namespace Edronov\Chat\Classes;

use \mysqli as mysqli;

require 'File.php';                                                            //Класс-утилита для работы с файлами

class Registration
{
    protected $status_message = "";                                         //статус-сообщение страницы регистрации
    protected $email = null;
    protected $nickname = null;           
    protected $password = null;

    const ADD_USER_SUCCESS = 0;                                       //константа успешного выполнения запроса к БД
    const USER_ALREADY_EXISTS = 1062;//константа для случая, если пользователь с такими данными уже зарегистрирован
    
    public function __construct()
    {
        session_start();
        if (!$this->userLogged()) {                                            //если пользователь еще не залогинен
            if ($this->existFormData()) {                            //Если пришли от пользователя регистрац данные
                $this->email = $_POST['email'];                      //забрать данные
                $this->nickname = $_POST['nickname'];
                $this->password = $_POST['password'];                           
                $this->addUser();                                                           //добавить пользователя
            } else {                               //Если данных от пользователя нет (еще не вводил регистр данные)
                $this->status_message  = "";                 //Сделать изначальное статус-сообщение страницы пустым
            }
        } else {                                                                  //если пользователь уже залогинен
            header("Location: http://ttbg.su/SideEffects/chat.php");     //сделать редирект на страницу самого чата
        }
    }

    protected function existFormData()                    //проверка наличия регистрационных данных от пользователя
    {
        return isset($_POST['email']) and isset($_POST['nickname']) and isset($_POST['password']);
    }

    protected function userLogged()                                       //проверка, залогинен ли уже пользователь
    {
        return isset($_SESSION['user_id']);
    }

    protected function addUser()                                                   //добавление нового пользователя
    {
        $db_connection = new mysqli (                                                            //соединяемся с БД
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {                                  //если соединиться с базой не удалось
            $log_file = new File("../logs/db_error.log");                             //пишем в файл об этой ошибке
            $log_file->setText($db_connection->connect_error);
            $_SESSION['db_error'] = "Ошибка доступа к базе данных";
            header("Location: http://ttbg.su/SideEffects/db_error.php"); //редир на страницу с сообщением об ошибке
        }        
        $query = <<<NEWUSER                                 //Текст запроса к БД для добавления нового пользователя
INSERT INTO
    Users(email, nickname, passwd)
VALUES
    (?, ?, ?)
;
NEWUSER;
        $insert_user = $db_connection->prepare($query);                                   //создаем пре-запрос к БД
        $insert_user->bind_param("sss", $this->email, $this->nickname, $this->password);
        $insert_user->execute();
        switch ($insert_user->errno) {                                        //в зависимости от результата запроса
            case self::ADD_USER_SUCCESS:     //Если запрос благополучно выполнен сделать статус сообщение соответст
                $this->status_message = "Успешная регистрация";
                break;
            case self::USER_ALREADY_EXISTS:         //если пользователь уже существует - выдать сообщение об ошибке
                $this->status_message = "Ошибка регистрации: пользователь уже существует в системе";
                break;
            default:
                break;
        }
        $db_connection->close();       
    }

    public function printStatusMessage()                                                  //печать статус-сообщения
    {
        echo $this->status_message;
    }
}
