<?php
/**
 * Created by Digital-Solution web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

$this->title = 'Авторизация';
?>
<section>
    <div class="page window">
        <div class="page-header">
            <h1>Авторизация</h1>
        </div>
        <div class="page-body">
            <div class="login">
                <form action="" method="post">
                    <label>Ваш логин</label>
                    <input type="text" name="__username">
                    <label>Пароль:</label>
                    <input type="password" name="__password">
                    <label><input type="checkbox" name="_rememberMe" value="true" checked> Запомнить меня</label>
                    <button>Войти</button>
                </form>
            </div>
            <br>
            <br>
            <p class="p5 color-grey"><a class="color-grey" href="/signup">Регистрация</a><!-- • <a class="color-grey" href="/remember">Восстановление пароля</a>--></p>
        </div>
    </div>
</section>