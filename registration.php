<?php

//definitions
function setFileText($name,$text)
{
    $file=fopen($name,"w");
    fwrite($file,$text);
    fclose($file);
}






class Registration{
    protected $email="";
    protected $nickname="";
    protected $password="";

    public function __construct($email, $nickname, $password)
    {
        $this->email=$email;
        $this->nickname=$nickname;
        $this->password=$password;
    }
    
    public function __invoke()
    {
        if($this->password!=$_POST['confirm_password']){
            return "Ошибка регистрации: Указанные пароли не совпадают";
        }
        
        $insert_new_user=<<<NEWUSER
INSERT INTO
    Users(email,nickname,passwd)
VALUES
    ("$this->email","$this->nickname","$this->password")
;
NEWUSER;
        $db_connection = new mysqli
        (
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if($db_connection->connect_errno){
            setFileText("db_error.log", $db_connection->connect_error);
            header("Location: http://ttbg.su/dbfail.php");
        }
        $db_connection->query($insert_new_user);
        switch($db_connection->errno){
            case 0:  //нет ошибок
                $status_message="Успешная регистрация";
                break;
            case 1062:  //введенные данные уже существуют
                $status_message="Ошибка регистрации: указанные e-mail или nickname уже существует в системе";
                break;
            default:
                break;
        }
        $db_connection->close();
        return $status_message;
    }
}
//definitions





//script
if(isset($_POST['email']) and isset($_POST['nickname']) and isset($_POST['password'])){
    $register = new Registration($_POST['email'], $_POST['nickname'], $_POST['password']);
    $status_message=$register();
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
       <br></br>
       password: <input type="text" name="password"  size="50"></input>
       <br></br>
       <br></br>
       confirm password: <input type="text" name="confirm_password"  size="50"></input>
       <br></br>
       <input type="submit"  value="register"></input>
       <br></br>
       <br><?php echo $status_message; ?></br>
      </form>
	</body>
</html>
