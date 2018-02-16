<?php
/**
 * Created by PhpStorm.
 * User: evgeniy
 * Date: 17.02.18
 * Time: 0:04
 */
namespace Edronov\Chat\build;

use Edronov\Chat\build\Build as Build;

require 'Build.php';

$sql_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/sql/";
$html_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/html/";
$was = array('"login.sql";', '"login.html";');
$become = array($sql_path . 'login.sql',  $html_path . 'login.html');


$make = new Build();
$make->buildClass("Login.php", $was, $become);