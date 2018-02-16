<?php
/**
 * Created by PhpStorm.
 * User: evgeniy
 * Date: 17.02.18
 * Time: 0:18
 */
namespace Edronov\Chat\build;

use Edronov\Chat\build\Build as Build;

require 'Build.php';


$sql_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/sql/";
$html_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/html/";
$was = array('"registration.sql";', '"registration.html";');
$become = array($sql_path . 'registration.sql',  $html_path . 'registration.html');


$make = new Build();
$make->buildClass("Registration.php", $was, $become);