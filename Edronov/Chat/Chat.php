<?php

namespace Edronov\Chat;

use \mysqli as mysqli;

require 'File.php';


class Chat
{

    
    public function __construct()
    {
        session_start();
        if ($this->userLogged()) {
            if ($this->postingMessage()) {
                $this->postMessage();
            } else {}
        } else {
            header("Location: http://ttbg.su/Edronov/Chat/login.php");
        }
    }



    
    public function printMessages()
    {
        $db_connection = new mysqli (
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {
            $log_file = new File("db_error.log");
            $log_file->setText("db_error.log", $db_connection->connect_error);
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/db_error.php");
        }
        $query = <<<GETMESSAGES
SELECT nickname, text FROM Messages LEFT JOIN Users ON Users.id = Messages.user_id ORDER BY Messages.id ASC LIMIT 20;
GETMESSAGES;

        $get_messages = $db_connection->prepare($query);
        if ($db_connection->connect_errno) {
            $log_file = new File("db_error.log");
            $log_file->setText("db_error.log", $db_connection->connect_error);
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/db_error.php");
        }

        $nickname = array();
        $message = array();

        $get_messages->bind_result($nickname, $message);
        $get_messages->execute();    
        $get_messages->store_result();

        while ($get_messages->fetch()) {
            echo $nickname . ": ". $message .  "<br></br>";
        }
        $db_connection->close();         
    }



    public function printUserWelcome()
    {
        echo "Hello, {$_SESSION['user_nickname']}!";
    }


    
    protected function userLogged()
    {
        return isset($_SESSION['user_id']);
    }




    protected function postingMessage()
    {
        return isset($_POST['message']);
    }
    


    protected function postMessage()
    {
        $user_id = $_SESSION['user_id'];
        $messageText = $_POST['message'];

        $db_connection = new mysqli (
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($db_connection->connect_errno) {
            $log_file = new File("db_error.log");
            $log_file->setText("db_error.log", $db_connection->connect_error);
            $db_connection->close();
            header("Location: http://ttbg.su/Edronov/Chat/db_error.php");
        }
        $query = <<<INSERTMESSAGE
INSERT INTO
    Messages(user_id, text)
VALUES
    (?, ?)
;
INSERTMESSAGE;
        $insert_new_message = $db_connection->prepare($query);
        if ($db_connection->connect_errno) {
            $log_file = new File("db_error.log");
            $log_file->setText("db_error.log", $db_connection->connect_error);
            $db_connection->close();
            header("Location: http://ttbg.su/chat.php");
        }
        $insert_new_message->bind_param("is", $user_id, $messageText);
        $insert_new_message->execute();
        $db_connection->close();          
    }
    
}
