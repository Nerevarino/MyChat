<?php


//definitions

//definitions









//script
session_start();
if(isset($_POST['phrase']))
{
    echo $_POST['phrase'];
}
else{        
    header('Location: http://ttbg.su/login.php');
}
//script

?>