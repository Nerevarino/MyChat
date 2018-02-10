<?php 

namespace Edronov\Chat\SideEffects;

use Edronov\Chat\Classes\Logout as Logout;

require 'Logout.php';

$logout_process = new Logout();                                           //создаем процесс разлогинивания пользователя
$logout_process->render();                                                                          //печатаем страницу