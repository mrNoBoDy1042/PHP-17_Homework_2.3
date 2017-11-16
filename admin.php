<?php
// Обрабатываем загруженный файл
if(isset($_FILES['userfile'])){
  $file = $_FILES['userfile'];
  $path = $file['name'];
  // Если файл JSON, то сохраняем его в папку с тестами
  if(substr($file['name'], -5) == '.json'){
    if (move_uploaded_file($file['tmp_name'], "Tests/".$path))
    {
      // После успешной загрузки файла перенаправляем на список тестов
      redirect('list.php');
    }
    else {
      echo "Произошла ошибка при загрузке файла";
    }
  }
  // иначе выдаем сообщение об ошибке
  else {
    redirect('admin.html');
  }
}


function redirect($page){
  header("Location: $page");
  exit;
}
 ?>
