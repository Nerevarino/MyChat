<?php 

namespace Edronov\Chat\SideEffects;

use Edronov\Chat\Classes\Login as Login;

require '../Classes/Login.php';

$login_process = new Login();                                                               //создаем процесс входа
$login_process->render();                                                                       //печатаем страницу
