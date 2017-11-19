<!-- Форма list для вывода списка доступных тестов -->
<h1>Список доступных тестов:</h1>
<?php
// Находим все JSON файлы в папке Tests
foreach (glob("Tests/*.json") as $file) {
  // Получаем имя файла
  $file = basename($file,".json");
  //Создаем ссылку для прохождения этого теста
  echo "<a href=\"test.php?t=$file\">$file</a><br>";
  }?>
<a href="admin.php">Загрузить тест</a>
