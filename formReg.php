<?php
    if(isset($_POST['send']))
        {
            $login = $_REQUEST['login'];
            $email=$_REQUEST['email'];
            $password=$_REQUEST['password'];
            include_once('data.php');
            try{
                $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $stmt = $pdo ->prepare("SELECT * FROM users where email=?");
                $stmt -> execute([$email]);
                $user = $stmt ->fetch();

                if ($user){
                    echo "USER IS EXIST!";
                    echo "<a href='index.php?page=formVhod'>Войти</a>";
                    exit;
                    }
                else{
                    $querry = $pdo ->prepare("INSERT INTO users(login, password, email) VALUES (?, ?, ?)");
                    $querry -> execute([$login, $password, $email]);
                    header('Location: index.php?page=formVhod');
                }
            }
            catch(PDOException $e)
            {
                die("умри 456 конекшн");
            }
        }
    
?>
<div class="reg-container">
    <label class="regLabel">Регистрация</label>
    <form action="formReg.php" method="post" class="reg-form">
        <label>Login</label>
        <input type="text" name="login" placeholder="Login" required>
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" required>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="send" value="Зарегистрироваться">
    </form>
</div>