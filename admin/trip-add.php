<h1>Создание нового тура</h1>
<?php 
/* ----------------------------------------*/
require_once '../connection.php'; // подключаем скрипт
                
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
              echo '<form action="trip-add.php" method="POST" enctype="multipart/form-data" class="big-form">
                      <label for="title">Наименование тура:</label><br>
                        <input id="title-inpt" name="title" type="text" required><br>
                      <label for="id_direction">Направление:</label><br>
                        <select name="id_direction" required>
                          <option value="1" selected>Россия</option>
                          <option value="2">Прибалтика</option>
                          <option value="3">Центральная Европа</option>
                          <option value="4">Скандинавия</option>
                        </select><br>
                      <label for="description">Описание:</label><br>
                        <textarea name="description" rows="5" required id="desc-txt"></textarea><br>
                      <label for="length">Дальность поездки (км):</label><br>
                        <input name="length" type="number" required id="len-inpt"><br>
                      <label for="duration">Продолжительность поездки (дней):</label><br>
                        <input name="duration" type="number" required id="dur-inpt"><br>
                      <label for="cities">Маршрут поездки:</label><i>* Введите города в формате: `Москва`, `Петушки`</i><br>
                        <textarea name="cities" required></textarea><br>
                      <label for="id_performer">Исполнитель тура:</label><br>
                        <select name="id_performer" required>';
                       $sql_perf = mysqli_query($link, "SELECT * FROM performers");
                        while($row_perf = mysqli_fetch_array($sql_perf)) { 
                          print '<option value="'.$row_perf['id_performer'].'">'.$row_perf['name_performer'].'</option>';
                        }
                      print '</select><br>
                      <label for="image">Фотография тура:</label><br>
                        <input name="image" type="file" id="id_files" required><br>
                      <label for="popular">Флажок тура "Популярное!":</label>
                        <input name="popular" type="checkbox" id="chck-inpt"><br>
                  
                        <article style="text-align: center;">
                        <figure>
                          <img class="photo-land" id="preview" src="../img/default.png">
                          <span id="pop-card" hidden="true">Популярное!</span>
                          <figcaption>
                            <h4 id="title-card"></h4>
                            <p id="desc-card"></p>
                            <div class="info">Протяженность: <i id="len-card"></i> км</div>
                            <div class="info">Количество дней: <i id="dur-card"></i></div>
                            </figcaption>
                        </figure>
                      </article>

                      <button name="button" value="Сохранить">Сохранить</button>
                  </form>';
            
/* ----------------Создаем путь для загрузки картинки и добавления в БД ------------------------*/

$path = '../img/'; // Ваш путь к дериктории

// Придумать имя для фалов, 
// можно по имени директории или имени пользователя, который аплодит, 
// что бы потом можно было легко ориентироваться
$fileNamePattern = 'image';
//Получить количество уже существующих файлов
if ($handle = opendir($path)) { 
    $counter = 0;
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $counter++;
        }
    }
    closedir($handle);
    // получить новое имя
    $newFileName  = $fileNamePattern.'-'.$counter;
}


 $file = "img/".$_FILES['image']['name'];
 $ext = end(explode('.', $file));
 $filename = "img/".$newFileName.".".$ext;
 $f2 = "../".$filename."";
 move_uploaded_file($_FILES['image']['tmp_name'], $f2);
 

// если были переданы данные для добавления в БД
if( isset($_POST['button']) && $_POST['button']== 'Сохранить')
{

if ($_POST['popular'] == 'on') $pop = 1; else $pop = 0;
$sql_res_prod=mysqli_query($link, 'INSERT INTO tours (`title`, `description`, `length`, `duration`, `image`, `popular`, `id_direction`, `id_performer`, `cities`) VALUES (
     "'.htmlspecialchars($_POST['title']).'",
     "'.htmlspecialchars($_POST['description']).'",
     "'.htmlspecialchars($_POST['length']).'",
     "'.htmlspecialchars($_POST['duration']).'",
     "'.htmlspecialchars($filename).'",
     "'.htmlspecialchars($pop).'",
     "'.htmlspecialchars($_POST['id_direction']).'",
     "'.htmlspecialchars($_POST['id_performer']).'",
     "'.htmlspecialchars($_POST['cities']).'")');

// если при выполнении запроса произошла ошибка – выводим сообщение
if( mysqli_errno($link) )
echo '<script> alert("Что-то пошло не так! Ошибка: '.mysqli_error($link).'"); window.location = "admin.php?p=add"</script>';
else // если все прошло нормально – выводим сообщение
echo '<script> alert("Тур успешно добавлен в каталог!"); window.location = "admin.php"</script>';

}
?>