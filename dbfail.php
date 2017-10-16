<?php
//definitions
function print_db_error()
{
    echo <<<EOT
<p>Ошибка соединения с базой данных: {$GLOBALS['db_error']}</p>
<p>Обратитесь к администратору сайта.</p>
EOT;
}
//definitions


//script
if($GLOBALS['db_error']!=""){
    header("Location: http://ttbg.su/login.php");
}else{}
//script
?>








<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>Ошибка базы данных</title>
	</head>
	<body>
        <?php print_db_error(); ?>
	</body>
</html>