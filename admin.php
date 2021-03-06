<?php
require_once('Redirect.php');
// Обрабатываем загруженный файл
if(isset($_FILES['userfile'])){
  $file = $_FILES['userfile'];
  $path = $file['name'];
  // Если файл JSON, то сохраняем его в папку с тестами
  if(pathinfo($file['name'])['extension'] === 'json'){
    if (move_uploaded_file($file['tmp_name'], "Tests/".$path))
    {
      // После успешной загрузки файла перенаправляем на список тестов
      redirect('Location: list.php');
    }
    else {
      echo "Произошла ошибка при загрузке файла";
    }
  }
  // иначе выдаем сообщение об ошибке
  else {
    echo "Загружен неверный файл";
  }
}
?>
<!-- Форма admin для загрузки новых тестов -->
<!DOCTYPE html>
<meta charset="utf-8">
<!-- Форма загрузки теста -->
<form method="post" enctype="multipart/form-data" name="upload_form" action="admin.php">
  <input type="file" name="userfile">
  <input type="submit" value="UPLOAD">
</form>
<br>
<!-- Ссылка для возврата к списку тестов -->
<a href="list.php">Перейти к списку тестов</a>
