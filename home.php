<?php
if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    $isLogin=isset($_SESSION['id_user']);
    ?>
<?php if ($isLogin): ?>
    <?php header('Location: index.php?page=tasks');exit;?>
<?php else: ?>
    <div class="home">
    <div class="welcome-section">
        <h1>Добро пожаловать в Todo List</h1>
        <p class="welcome-text">
            Простое и удобное приложение для управления задачами. 
            Создавайте списки, отмечайте выполненное и всегда оставайтесь организованным.
        </p>
        <div class="features-preview">
            <div class="feature-item">
                📝 <span>Создавайте задачи</span>
            </div>
            <div class="feature-item">
                ✅ <span>Отмечайте готовое</span>
            </div>
            <div class="feature-item">
                📱 <span>Работает на всех устройствах</span>
            </div>
        </div>
    </div>
    
    <div class="home-buttons">
        <a href="index.php?page=formVhod" class="home-btn primary">Войти в аккаунт</a>
        <a href="index.php?page=formReg" class="home-btn secondary">Создать аккаунт</a>
    </div>
</div>
<?php endif?>