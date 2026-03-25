<?php

include_once('data.php');

if (session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['id_user']) or !isset($_SESSION['login'])){
    header('Location: index.php?page=formVhod');
    exit;
}

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $stmt = $pdo -> prepare("
    SELECT login, email
    FROM users
    WHERE id_user = ?
    ");
    $stmt->execute([$_SESSION['id_user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        die("Умри узер конекш");
    }
}
catch(PDOException $e){
    die("умри дб конекш");
}
?>
<form class="profileContainer" action="profile.php" method="post">
    <h1>Профиль</h1>
    <p class="profileRow"><label class="profileLabel">Логин: </label><?= htmlspecialchars($user['login']) ?></p>
    <p class="profileRow"><label class="profileLabel">Email: </label><?= htmlspecialchars($user['email']) ?></p>
    <a href="index.php?page=tasks" class="back-link">Вернуться к задачам</a>
</form>
