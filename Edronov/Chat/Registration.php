<?php

namespace Edronov\Chat;

require 'File.php';

class Registration
{
    protected $status_message = "";


    protected $email = null;
    protected $nickname = null;
    protected $password = null;

    const ADD_USER_SUCCESS = 0;
    const USER_ALREADY_EXISTS = 1062;
    
    public function __construct()
    {
        session_start();
        if (!$this->userLogged()) {
            if ($this->existFormData()) {                
                $this->email = $_POST['email'];
                $this->nickname = $_POST['nickname'];
                $this->password = $_POST['password'];                
                $this->addUser();
            } else {
                $this->status_message  = "";
            }
        } else {
            header("Location: http://ttbg.su/chat.php");
        }
    }




    protected function existFormData()
    {
        return isset($_POST['email']) and isset($_POST['nickname']) and isset($_POST['password']);
    }




    protected function userLogged()
    {
        return isset($_SESSION['user_id']);
    }




    protected function addUser()
    {
        $db_connection = new mysqli (
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {
            $log_file = new File("db_error.log");
            $log_file->setText($db_connection->connect_error);
            $_SESSION['db_error'] = "Ошибка доступа к базе данных";
            header("Location: http://ttbg.su/db_error.php");
        }        
        $query = <<<NEWUSER
INSERT INTO
    Users(email, nickname, passwd)
VALUES
    (?, ?, ?)
;
NEWUSER;        
        $insert_user = $db_connection->prepare($query);
        $insert_user->bind_param("sss", $this->email, $this->nickname, $this->password);
        $insert_user->execute();
        switch ($db_connection->errno) {
            case ADD_USER_SUCCESS:
                $this->status_message = "Успешная регистрация";
                break;
            case USER_ALREADY_EXISTS:
                $this->status_message = "Ошибка регистрации: пользователь уже существует в системе";
                break;
            default:
                break;
        }
        $db_connection->close();       
    }




    protected function printStatusMessage()
    {
        echo $this->status_message;
    }
}
