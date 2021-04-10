<!-- Сначала вставляем всплывающий поп-ап, затем идет подвал -->
<?php
require_once 'connection.php'; // подключаем скрипт
                
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
if (isset($_POST["submit"]) && $_POST['submit']== 'Оставить') {
  $sql_res_prod=mysqli_query($link, 'INSERT INTO requests (`FIO`, `phone`, `status`, `purpose`, `id_user`) VALUES (
    "'.htmlspecialchars($_POST['FIO']).'",
    "'.htmlspecialchars($_POST['phone']).'",
    "1",
    "",
    "4")');
echo '
<div class="popup-fade" style="display:block;">
  <div class="popup">
      <a class="popup-close" href="#">Закрыть</a>
      <div id="success">
        <h3>Ваша заявка отправлена</h3>
        <p>В ближайшее время с вами свяжется наш специалист.</p>
      </div>';
} else {
echo '
<div class="popup-fade">
  <div class="popup">
    <a class="popup-close" href="#">Закрыть</a>
  <h3>Заказать звонок</h3>
  <form action="" method="POST" id="popup" name="popup">
    <label>Фамилия и имя</label><i> *</i><br><input type="text" name="FIO" required placeholder="Иван Иванов"><br>
    <label>Номер телефона</label><i> *</i><br><input type="tel" name="phone" required placeholder="+7 (916) 123-45-67" value="+7" minlength="12"><br>
    <label for="agree" style="font-size: 10px;">Я даю свое согласие на обработку персональных данных:</label><i> *</i>
    <input name="agree" type="checkbox" id="agree" required><br>
    <i>* Поля, отмеченные звездочкой, обязательны для заполнения</i><br><br>
    <button type="submit" name="submit" value="Оставить">Оставить заявку</button>
  </form>
';
}
?>
  </div>
</div>
    <footer>
    <p>
      Дипломная работа Куйчуевой Яны. Группа 4И1
      <a href="admin/admin.php?p=report">Вход для администратора</a>
    </p>
    </footer>
