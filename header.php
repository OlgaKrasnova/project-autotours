<nav>
        <ul id="navbar">
                <li id="title"><img src="img/car.png" id="logo"></li>
                <li><a href="index.php">Главная</a></li>
                <li><a href="#">Новости</a></li>
                <li><a href="#">Каталог</a>
                  <ul>
                    <li><a href="catalog.php?direction=2">Прибалтика</a></li>
                    <li><a href="catalog.php?direction=3">Европа</a></li>
                    <li><a href="catalog.php?direction=4">Скандинавия</a></li>
                    <li><a href="catalog.php?direction=1">Россия</a></li>
                  </ul>
                </li>
                <li><a href="#">О нас</a></li>
              </ul>
              <div class="auth">
              <?php
               if (isset($_SESSION['id_FIO'])) {
                echo '<h4 style="color: white;"><a href="client/client.php?p=favor">'.$_SESSION['id_FIO'].'</a></h4>';
               } else {
                 echo '<a href="client/client.php?p=favor">Войти</a>
                 <a class="" href="registration.php">Регистрация</a>';
               }
              ?>
              </div>
              
              <button class="order-trip popup-open">Заказать</button>
            </nav>
    