<?php

namespace Edronov\Chat\Classes;

use \mysqli as mysqli;

require 'PhpPage.php';

class Registration extends PhpPage
{
    protected $status_message = "";                                             //статус-сообщение страницы регистрации
    protected $email = null;                                               //переменная для хранения email пользователя
    protected $nickname = null;                                             //переменная для хранения ника пользователя
    protected $password = null;                                           //переменная для хранения пароля пользователя

    const ADD_USER_SUCCESS = 0;                               //константа обозначающая успешное выполнения запроса к БД
    const USER_ALREADY_EXISTS = 1062; //константа обозначающая, что пользователь с такими ид.данными уже есть в системе
    
    public function __construct()
    {
        session_start();
        if (!$this->userLogged()) {                                                //если пользователь еще не залогинен
            if ($this->existFormData()) {                                //если пришли от пользователя регистрац данные
                $this->email = $_POST['email'];                          //записать данные в соответствующие переменные
                $this->nickname = $_POST['nickname'];
                $this->password = $_POST['password'];                           
                $this->addUser();                                       //попробовать добавить нового пользователя в БД
            } else {}                          //если пользователь еще не присылал данные регистрации, ничего не делаем
        } else {                                                                      //если пользователь уже залогинен
            header("Location: http://ttbg.su/chat.php");                      //сделать редирект на страницу чата
        }
    }

    protected function existFormData()                        //проверка наличия регистрационных данных от пользователя
    {
        return isset($_POST['email']) and isset($_POST['nickname']) and isset($_POST['password']);
    }

    protected function userLogged()                                           //проверка, залогинен ли уже пользователь
    {
        return isset($_SESSION['user_id']);
    }

    protected function addUser()                                               //попытка добавления нового пользователя
    {
        $db_connection = new mysqli (                                                                //соединяемся с БД
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {                                         //если соединиться с БД не удалось
            $this->errorToFile("../logs/db_error.log", $db_connection->connect_error);    //пишем ошибку в файл
        }

        //текст запроса к БД для добавления нового пользователя
        $query = $this->loadSqlRequest("registration.sql");
        $insert_user = $db_connection->prepare($query);       //готовим запрос к БД и связываем переменные с ответом БД
        $insert_user->bind_param("sss", $this->email, $this->nickname, $this->password);
        $insert_user->execute();                                                                //выполняем запрос к БД
        switch ($insert_user->errno) {                                            //в зависимости от результата запроса
            case self::ADD_USER_SUCCESS:                                     //если новый пользователь успешно добавлен
                $this->status_message = "Успешная регистрация";                      //устанавливаем сообщение страницы
                break;
            case self::USER_ALREADY_EXISTS:             //если пользователь уже существует - выдать сообщение об ошибке
                $this->status_message = "Ошибка регистрации: пользователь уже существует в системе";
                break;
            default:                                                                    //по умолчанию ничего не делаем
                break;
        }
        $db_connection->close();                                                            //закрываем соединение с БД
    }

    public function render()                                                    //печать страницы (генерация html кода)
    {
        echo $this->loadHtmlTemplate
        ("registration.html",
            array('status_message'),
            array("{$this->status_message}")
        );
    }
}
