<?php

namespace Edronov\Chat;

class Login
{

    protected $status_message = "";
    
    public function __construct($identification, $password)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            if (isset($_POST['nickname_or_email']) and isset($_POST['password'])) {
                $identity = new Identity();
                $this->status_message = $identity->verify();
            } else {
                $this->status_message  = "";
            }
        } else {
            header('Location: http://ttbg.su/chat.php');
        }        
        
    }


    public function printStatusMessage()
    {
        echo $this->status_message;
    }
}


