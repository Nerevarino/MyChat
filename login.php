<?php 

function setFileText($name, $text)
{
    $file = fopen($name, "w");
    fwrite($file, $text);
    fclose($file);
}



class Login
{
    protected $identification;
    protected $password;

    protected $db_connection;
    protected $user_id;
    protected $user_name;
    protected $user_password;

    protected $status_message;


    public function __construct($identification, $password)
    {
        $this->identification = $identification;
        $this->password = $password;
    }

    protected function findUserBy($query)
    {
        $query->execute();
        $query->store_result();
        if ($query->num_rows == 1) {
            $query->fetch();
            return 1;
        } 
        else { return 0; }          
    }

    public function __invoke()
    {
        $this->db_connection = new mysqli (
            "localhost",
            "srv117239_msus",
            "msqlarino",
            "srv117239_msqlchat"
        );
        if ($this->db_connection->connect_errno) {
            setFileText("db_error.log", $this->db_connection->connect_error);
            header("Location: http://ttbg.su/dbfail.php");
        }
        
        $query_text = <<<FINDUSER
SELECT id,nickname,passwd FROM Users where(email = ?);
FINDUSER;
        $email_query = $this->db_connection->prepare($query_text);
        $email_query->bind_param("s", $this->identification);
        $email_query->bind_result($this->user_id, $this->user_name, $this->user_password);

        $query_text = <<<FINDUSER
SELECT id,nickname,passwd FROM Users where(nickname=?);
FINDUSER;
        $nickname_query = $this->db_connection->prepare($query_text);
        $nickname_query->bind_param("s", $this->identification);
        $nickname_query->bind_result($this->user_id, $this->user_name, $this->user_password);
        
        if ($this->findUserBy($email_query)) {
            if ($this->user_password == $this->password) {
                $_SESSION['user_id'] = $this->user_id;
                $_SESSION['user_name'] = $this->user_name;
                header("Location: http://ttbg.su/chat.php");
            } else {
                $this->status_message = "Ошибка входа: Неверный пароль";
            }
        } elseif ($this->findUserBy($nickname_query)) {
            if ($this->user_password == $this->password) {
                $_SESSION['user_id'] = $this->user_id;
                $_SESSION['user_name'] = $this->user_name;
                header("Location: http://ttbg.su/chat.php");                
            } else {
                $this->status_message = "Ошибка входа: Неверный пароль";
            }
        } else {
            $this->status_message = "Ошибка входа: пользователь не найден";
        }

        $this->db_connection->close();
        return $this->status_message;        
    }

}










session_start();
$status_message="";
if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['identification']) and isset($_POST['password'])) {
        $login = new Login($_POST['identification'], $_POST['password']);
        $status_message = $login();
    } else {}
} else {
    header('Location: http://ttbg.su/chat.php');
}

?>





<!DOCTYPE html>
<html>
    <head>
        <title>Мой чат</title>
    </head>
    <body>
        <form method = "post">
            Nickname or E-mail: <input type = "text" name = "identification" size = "50"></input>
            <br></br>
            <br></br>
            Password: <input type = "password" name = "password"  size = "50"></input>
            <br></br>
            <br></br>
            <input type = "submit"  value = "Войти"></input>
            <a href = "http://ttbg.su/registration.php">Зарегистрироваться</a>
            <br></br>
            <br></br>
            <br><?php echo $status_message; ?></br>
        </form>
    </body>
</html>


