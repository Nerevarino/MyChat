<?php 

namespace Edronov\Chat\SideEffects;

use Edronov\Chat\Classes\Logout as Logout;

require '../Classes/Logout.php';

$logout_process = new Logout();                                       //создаем процесс разлогинивания пользователя
