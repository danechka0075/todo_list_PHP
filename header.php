<?php
if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    $isLogin=isset($_SESSION['id_user']);
    $login=$isLogin?$_SESSION['login']:'';

?>
<header>
    <div class="header-container">
        <h1 class="h1Header">
            <a href="index.php">Todo List</a>
        </h1>
        <nav>
            <?php if ($isLogin): ?>
                <a href="index.php?page=profile">Профиль: <?= htmlspecialchars($login) ?></a>
                <a href="logout.php">Выход</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
