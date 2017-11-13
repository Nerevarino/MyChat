<?php

if ($GLOBALS['db_error'] != "") {
    header("Location: http://ttbg.su/login.php");
} else {}

?>








<!DOCTYPE html>
<html>
    <head>
		<meta charset = "utf-8"></meta>
		<title>Ошибка базы данных</title>
	</head>
	<body>
        <?php
            echo <<<EOT
<p>Ошибка соединения с базой данных: {$GLOBALS['db_error']}</p>
<p>Обратитесь к администратору сайта.</p>
EOT;
        ?>
	</body>
</html>
