<?php
    if(isset($_POST['send']))
        {
            $login = $_REQUEST['login'];
            $email=$_REQUEST['email'];
            $password=$_REQUEST['password'];
            if (!preg_match('/^(?!.*\.\.)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,}$/', $email)) {
                header("Location: index.php?page=formReg&message=error-email");
                exit;   
            }
            include_once('data.php');
            try{
                $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $stmt = $pdo ->prepare("SELECT * FROM users where email=?");
                $stmt -> execute([$email]);
                $user = $stmt ->fetch();

                if ($user){
                    header("Location: index.php?page=formReg&message=email-exists");
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
    <?php
    $errors = ['error-email' => 'Некорректный email', 'email-exists' => 'Такой email уже существует'];

    if (isset($_GET['message']) && isset($errors[$_GET['message']])) {
        echo "<div class='error'>{$errors[$_GET['message']]}</div>";
    }
?>
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