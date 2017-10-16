<?php 

//definitions
function setFileText($name,$text)
{
    $file=fopen($name,"w");
    fwrite($file,$text);
    fclose($file);
}

class FoundUserByEmail extends Exception {}
class FoundUserByNickname extends Exception {}
class UserNotFound extends Exception {}

class Login{
    protected $identification;
    protected $password;
    const  byEmail=1;
    const  byNickname=2;
    const  byNothing=3;

    protected $db_connection;
    protected $status_message;


    public function __construct($identification, $password)
    {
        $this->identification=$identification;
        $this->password=$password;
    }

    protected function findUserBy($query)
    {
        $query_result=$this->db_connection->query($query);
        $rows_count=$query_result->num_rows;
        if($rows_count==1){
            return 1;
        }else {return 0;}               
    }

    public function __invoke()
    {
        $this->db_connection = new mysqli
        (
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if($this->db_connection->connect_errno){
            setFileText("db_error.log", $this->db_connection->connect_error);
            header("Location: http://ttbg.su/dbfail.php");
        }
        
        $email_query=<<<FINDUSER
SELECT id FROM Users where(email="$this->identification");
FINDUSER;
        $nickname_query=<<<FINDUSER
SELECT id FROM Users where(nickname="$this->identification");
FINDUSER;
        
        switch(1){
            case 1:
              if(findUserBy($email_query)){
                 $this->status_message="Пользователь найден по email";
                 break;
              }
              if(findUserBy($nickname_query)){
                 $this->status_message="Пользователь найден по nickname";
                 break;
              }              
            default:
                $this->status_message="Ошибка входа: пользователь не найден"
                break;
        }

        $this->db_connection->close();
        return $this->status_message;        
    }

}
//definitions



//script
if(!isset($_SESSION)){
    if(isset($_POST['identification']) and isset($_POST['password'])){
        $login = new Login($_POST['identification'], $_POST['password']);
        $status_message=$login();
    }
    else{$status_message="";}
}
else{
    header('Location: http://ttbg.su/chat.php');
}
//script




?>





<!DOCTYPE html>
<html>
  <head>
    <title>Мой чат</title>
  </head>
  <body>
    <form method="post">
      Nickname or E-mail: <input type="text" name="identification" size="50"></input>
      <br></br>
      <br></br>
      Password: <input type="text" name="password"  size="50"></input>
      <br></br>
      <br></br>
      <input type="submit"  value="login"></input>
      <br></br>
      <br></br>
      <br><?php echo $status_message; ?></br>
    </form>
  </body>
</html>


