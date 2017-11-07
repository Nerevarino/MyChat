<?php


//definitions

//definitions









//script
session_start();
if(isset($_POST['message']))
{
    $user_id=$_SESSION['user_id'];
    $messageText=$_POST['message'];

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

    $insert_message_query=<<<INSERTMESSAGE
INSERT INTO
    Messages(user_id,text)
VALUES
    (?,?)
;
INSERTMESSAGE;
    $insert_new_message= $db_connection->prepare($insert_message_query);
    if($db_connection->connect_errno){
        setFileText("db_error.log", $db_connection->connect_error);
        header("Location: http://ttbg.su/dbfail.php");
    }
    $insert_new_message->bind_param("is", $user_id, $messageText);
    $insert_new_message->execute();
    $db_connection->close();
}
else{        
    header('Location: http://ttbg.su/login.php');
}
//script

?>