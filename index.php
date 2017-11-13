<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: http://ttbg.su/login.php');
} else {
    header('Location: http://ttbg.su/chat.php');
}
