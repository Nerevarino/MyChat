<?php

namespace Edronov\Chat\Classes;

require 'PhpPage.php';

class Logout extends PhpPage
{
    public function __construct()
    {
        session_start();
        if ($this->userLogged()) {                                                    //если пользователь был залогинен
            session_destroy();                                                       //разлогинить его (порвать сессию)
        } else {}                                             //если пользователь не был залогинен, то ничего не делаем
        header('Location: http://ttbg.su/login.php');                            //редирект на страницу логина
    }

    protected function userLogged()                                               //проверка, залогинен ли пользователь
    {
        return isset($_SESSION['user_id']);
    }

}
