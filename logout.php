<?php 

session_start();
if(isset($_SESSION['user_id']))
{
    session_destroy();
}
else{}

header('Location: http://ttbg.su/login.php');


?>