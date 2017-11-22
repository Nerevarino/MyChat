<?php

namespace Edronov\Chat;

use \mysqli as mysqli;


class Login
{

    protected $status_message = "";

    protected $nickname_or_email = null;
    protected $password = null;
    
    public function __construct()
    {
        session_start();
        if (!$this->userLogged()) {
            if ($this->existFormData()) {
                $this->nickname_or_email = $_POST['nickname_or_email'];
                $this->password = $_POST['password'];  
                $this->verify();
            } else {
                $this->status_message  = "";
            }
        } else {
            header('Location: http://ttbg.su/Edronov/Chat/chat.php');
        }        
        
    }




    protected function verify()
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

        $user_id = null;
        $user_nickname = null;
        $verification->bind_result($user_id, $user_nickname);
        $verification->execute();
        $verification->store_result();

        if ($verification->num_rows == 1) {
            $verification->fetch();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nickname'] = $user_nickname;
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/chat.php");
            // $this->status_message = "Вы успешно вошли!";
        } else {
            $db_connection->close();
            $this->status_message = "Ошибка входа: неверный пользователь или пароль";
        }        
    }




    protected function existFormData()
    {
        return isset($_POST['nickname_or_email']) and isset($_POST['password']);
    }




    protected function userLogged()
    {
        return isset($_SESSION['user_id']);
    }
    
    


    public function printStatusMessage()
    {
        echo $this->status_message;
    }
}
