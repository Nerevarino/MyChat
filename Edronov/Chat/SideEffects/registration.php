<?php

namespace Edronov\Chat\SideEffects;

use Edronov\Chat\Classes\Registration as Registration;

require '../Classes/Registration.php';

$reg_process = new Registration();                                                    //создаем процесс регистрации
$reg_process->render();                                                                         //печатаем страницу

