<?php

namespace Edronov\Chat\Classes;              

use \mysqli as mysqli;                        


class Login
{

    protected $status_message = "";
    protected $nickname_or_email = null;                          //Логин осуществляется по email-у /нику  и паролю
    protected $password = null;
    
    public function __construct()
    {
        session_start();
        if (!$this->userLogged()) {                                            //если пользователь еще не залогинен
            if ($this->existFormData()) {                     //если пользователь отправил идентификационные данные 
                $this->nickname_or_email = $_POST['nickname_or_email'];
                $this->password = $_POST['password'];  
                $this->verify();
            } else { //если нет, то просто грузим страницу, сообщение страницы пользователю пока пустое
                $this->status_message  = "";
            }
        } else {                     //Если пользователь уже залогинен, то сделать редирект на страницу самого чата
            header('Location: http://ttbg.su/Edronov/Chat/SideEffects/chat.php');
        }        
        
    }

    protected function verify()                                                          //авторизация пользователя
    {
        $db_connection = new mysqli (                                                            //связываемся с БД
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {                  //если связаться не удалось,то пишем об ошибке в файл
            $log_file = new File("../logs/db_error.log");
            $log_file->setText($db_connection->connect_error);
            $_SESSION['db_error'] = "Ошибка доступа к базе данных";
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/db_error.php"); //редирект на страницу ошибки
        }
        //создаем текст запроса к БД на проверку наличия пользователя с такими идентификационными данными
        $query = <<<VERIFYUSER
SELECT id, nickname FROM Users 
    WHERE (nickname=? AND passwd=?)
    OR    (email=? AND passwd=?);
VERIFYUSER;

        $verification = $db_connection->prepare($query);
        $verification->bind_param(
            "ssss",
            $this->nickname_or_email,
            $this->password,
            $this->nickname_or_email,
            $this->password
        );

        $user_id = null;                         //создаем переменные, в которые будем делать вывод строк ответа БД
        $user_nickname = null;
        $verification->bind_result($user_id, $user_nickname);             //связываем эти переменные с пре-запросом
        $verification->execute();                                          //выполняем запрос и сохраняем результат
        $verification->store_result();

        if ($verification->num_rows == 1) {                                  //если по запросу нашелся пользователь
            $verification->fetch();
            $_SESSION['user_id'] = $user_id;                   //записать в сессию id и ник пользователя
            $_SESSION['user_nickname'] = $user_nickname;
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/SideEffects/chat.php");//редирект на страницу самого чата
        } else {   //Если пользователь не найден по идентификационным данным - то написать на странице сообщение 
            $db_connection->close();
            $this->status_message = "Ошибка входа: неверный пользователь или пароль";
        }        
    }
    
    protected function existFormData()                        //Пришли ли от пользователя идентификационные данные?
    {
        return isset($_POST['nickname_or_email']) and isset($_POST['password']);
    }

    protected function userLogged()                                                //Залогинен ли уже пользователь?
    {
        return isset($_SESSION['user_id']);
    }
    
    public function printStatusMessage()                  //Печать на странице логина статус-сообщения пользователю
    {
        echo $this->status_message;
    }
}
