<?php

namespace Edronov\Chat\SideEffects;

use Edronov\Chat\Classes\Chat as Chat;

require '../Classes/Chat.php';

$chat_object = new Chat();                                                                    //создаем обЪект чата
$chat_object->render();                                                                         //печатаем страницу

