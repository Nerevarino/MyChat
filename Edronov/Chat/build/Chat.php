<?php
/**
 * Created by PhpStorm.
 * User: evgeniy
 * Date: 17.02.18
 * Time: 0:24
 */
namespace Edronov\Chat\build;

use Edronov\Chat\build\Build as Build;

require 'Build.php';


$sql_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/sql/";
$html_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/html/";
$was = array('"getmessages.sql";', '"postmessage.sql";', '"chat.html";');
$become = array($sql_path . 'getmessages.sql', $sql_path . 'postmessage.sql', $html_path . 'chat.html');


$make = new Build();
$make->buildClass("Chat.php", $was, $become);