<h2 class="autorize">Авторизация</h2>
<?php
if ($error){
    echo '<p class="error">';
    echo $error;
    echo '</p>';
}
?>
<?php
    if ($user->login){
        echo "<p>Вы вошли как " . $user->login . "</p>";
        echo '<a href="/index.php?controller=main&action=logout">Выход</a>';
    }else{
        echo "<p>Укажите логин и пароль:</p>";        
?>
        <form action="" method="post">
            <input type="text" class="autorize" name="login" value="<?php ?>"><br>
            <input type="password" class="autorize" name="password" value="<?php ?>"><br>
            <label for="remember">Запомнить меня</label><input type="checkbox" name="remember" checked><br>
            <input type="submit" name="submit" value="Войти">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        </form>
<?php
    }
?>
