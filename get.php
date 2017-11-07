<?php

//script
session_start();
if(isset($_SESSION['user_id']))
{
    $db_connection = new mysqli
    (
        "localhost",
        "srv117239_msus",
        "msqlarino",
        "srv117239_msqlchat"
    );
    if($db_connection->connect_errno){
        setFileText("db_error.log", $db_connection->connect_error);
        header("Location: http://ttbg.su/dbfail.php");
    }

    $get_messages_query=<<<GETMESSAGES
SELECT nickname, text FROM Messages LEFT JOIN Users ON Users.id = Messages.user_id ORDER BY Messages.id DESC LIMIT 20;
GETMESSAGES;
    $get_messages=$db_connection->prepare($get_messages_query);
    if($db_connection->connect_errno){
        setFileText("db_error.log", $db_connection->connect_error);
        header("Location: http://ttbg.su/dbfail.php");
    }

    $id=array();
    $user_id=array();
    $message=array();

    $get_messages->bind_result($nickname, $message);
    $get_messages->execute();    
    //$get_messages->store_result();

    while($get_messages->fetch())
    {
        echo $nickname . ": ". $message .  "<br></br>";
    }
    echo $messages;
    $db_connection->close();    
}
else{        
    header('Location: http://ttbg.su/login.php');
}
//script

?>