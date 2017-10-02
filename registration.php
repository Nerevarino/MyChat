<?php

//definitions
class Registration{
    protected $email="";
    protected $nickname="";
    protected $database_connection;

    public function __construct($email, $nickname)
    {
        $this->email=$email;
        $this->nickname=$nickname;
    }
    
    public function __invoke()
    {
        $db_connection= new mysqli
          (
              "mysql-117239.srv.hoster.ru",
              "srv117239_msus",
              "msqlarino",
              "srv117239_msqlchat"
          );


        $db_connection->query
            (
                <<<EOT
CREATE TABLE IF NOT EXISTS Users 
  (
     id INT NOT NULL AUTO_INCREMENT,
     email VARCHAR(50) NOT NULL,
     nickname VARCHAR(30) NOT NULL,
     PRIMARY KEY (id)
  );
EOT
            );

        
        $db_connection->close();
    }
}
//definitions





//script
if(isset($_POST['email']) and isset($_POST['nickname'])){
    $registration= new Registration($_POST['email'], $_POST['nickname']);
    $registration();
    $status_message="Была попытка регистрации!";
}
else{
$status_message="";
}

//script




?>





















<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>Регистрация</title>
	</head>
	<body>
      <form method="post">
       E-mail: <input type="text" name="email" size="50"></input>
       <br></br>
       <br></br>
       Nickname: <input type="text" name="nickname"  size="50"></input>
       <br></br>
       <input type="submit"  value="register"></input>
    <br><?php echo $status_message; ?></br>
      </form>
	</body>
</html>
