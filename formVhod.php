<?php

if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }

    if(isset($_REQUEST['send']))
        {
            $email=$_REQUEST['email'];
            $password=$_REQUEST['password'];
            print "<p>".$email."</p>";
            include_once('data.php');
            try{
                $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $stmt = $pdo ->prepare("SELECT * FROM users where email=? AND password=?");
                $stmt -> execute([$email, $password]);
                $user = $stmt ->fetch();
                if ($user){
                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['login'] = $user['login'];
                    header('Location: index.php?page=tasks');
                }
                else{
                    header('Location: index.php?page=formVhod&message=error-profile');
                    exit;
                }
            }
            catch(PDOException $e)
            {
                die("умри дб конекшн");
            }
        }
?>
<?php
    $errors = ['error-profile' => 'Такого пользователя не существует'];

    if (isset($_GET['message']) && isset($errors[$_GET['message']])) {
        echo "<div class='error'>{$errors[$_GET['message']]}</div>";
    }
?>
<form action="formVhod.php" method="post" class="login-form">
    <h2>Вход</h2>
    <input type="text" name="email" placeholder="email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="send" value="Войти">
    <p>У вас еще нет аккаунта? <a href="index.php?page=formReg">Зарегистрируйтесь здесь</a></p>
</form>
