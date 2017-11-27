<?php

namespace Edronov\Chat\Classes;

require 'PhpPage.php';

class Logout extends PhpPage
{
    public function __construct()
    {
        session_start();
        if ($this->userLogged()) {                            //Если пользователь был залогинен, то разлогинить его
            session_destroy();
        } else {}                                   //Если не был залогинен, то сделать редирект на страницу логина
        header('Location: http://ttbg.su/Edronov/Chat/SideEffects/login.php');             
    }

    protected function userLogged()                                           //проверка, залогинен ли пользователь
    {
        return isset($_SESSION['user_id']);
    }

    public function render()
    {
        
    }
}
