<?php

namespace Edronov\Chat\Classes;

require '../Classes/DBError.php';

$db_error_report = new DBError();                                              //создаем обЪект сообщения об ошибке
$db_error_report->render();                                                                     //печатаем страницу

