<?php

namespace Edronov\Chat;

use Edronov\Chat\File as File;

class Identity
{
    protected $nickname_or_email - null;
    protected $password = null;

    
    public function __construct()
    {
        $this->nickname_or_email = $_POST['nickname_or_email'];
        $this->password = $_POST['password'];        
    }




    public function verify()
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

        $verification_query = <<<VERIFYUSER
SELECT id, nickname FROM Users 
    WHERE (nickname=? AND passwd=?)
    OR    (email=? AND passwd=?);
VERIFYUSER;
        
        $db_connection->prepare($verification_query);
        $verification_query->bind_param(
            "ssss",
            $this->$nickname_or_email,
            $this->password,
            $this->$nickname_or_email,
            $this->password
        );

        $user_id = null;
        $user_nickname = null;
        $verification_query->bind_result($user_id, $user_nickname);
        $verification_query->execute();

        if ($verification_query->num_rows == 1) {
            $verification_query->fetch();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nickname'] = $user_nickname;
            $db_connection->close();
            header("Location: http://ttbg.su/chat.php");
        } else {
            $_SESSION['login_message'] = "Ошибка входа: неверный пользователь или пароль";
        }
        
    }
}