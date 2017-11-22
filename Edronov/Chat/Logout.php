<?php

namespace Edronov\Chat;

class Logout
{
    public function __construct()
    {
        session_start();
        if ($this->userLogged()) {
            session_destroy();
        } else {}
        header('Location: http://ttbg.su/Edronov/Chat/login.php');            
    }




    protected function userLogged()
    {
        return isset($_SESSION['user_id']);
    }

            
}
