<?php

function build_test($path){
  //если все условия соблюдены - обрабатываем файл с тестом
    echo "<meta charset=\"utf-8\">";
    $json = file_get_contents($path);
    $json = json_decode($json, true);
    $count_questions = count($json);
    ?>
  <!-- Вывод вопросов теста -->
    <h2>Тест <?echo $test?></h2>
    <form action="" method="POST">
      <fieldset>
        <legend>Введите ваше имя:</legend>
        <label><input type="text" name="username" /></label>
      </fieldset>
      <?php foreach ($json as $name => $question)
      {?>
        <!-- Выводим вопрос и список ответов -->
        <fieldset>
            <legend><?echo $question["question"]?></legend>
            <?foreach ($question['answers'] as $key => $answer)
            {?>
            <label>
              <input type="radio" name=<?echo "$name";?> value="<?echo $answer?>">
              <?echo $answer;?>
            </label>
          <?}?>
        </fieldset>
      <?} ?>
      <input type="submit" value="Отправить">
    </form>
    <!-- Ссылка для возврата к списку тестов -->
    <a href="list.php">Перейти к списку тестов</a><br>
<?
  check_answers($count_questions, $json);
}?>

<?function create_diploma($name, $points)
{
  $points = "5";
  $text = "Поздравляем, $name".PHP_EOL."Ваши баллы:".strval($points);
  $image = imagecreatetruecolor(250,250);
  $backcolor = imagecolorallocate($image, 255, 224, 221);
  $textcolor = imagecolorallocate($image, 129, 15, 90);

  $fontFile = __DIR__.'/assets/font.ttf';

  if (!file_exists($fontFile)){
    echo "Файл шрифта не найден";
    exit;
  }
  $imBox = imagecreatefrompng(__DIR__.'/assets/trophy.png');

  imagefill($image, 0, 0, $backcolor);
  imagecopy($image, $imBox, 50, 50, 0, 0, 120, 120);
  imagettftext($image, 18, 0, 15, 100, $textcolor, $fontFile, $text);
  //header('Content-Type: image/png');
  $cert = 'cert.png';
  imagepng($image, $cert);
  echo "<img src=$cert align=middle>";
  //unlink($cert);
  imagedestroy($image);
}


function check_answers($count_questions, $json)
{
  /* Обработка ответов */
  // Получаем переданные ответы
  $answers = $_REQUEST;
  // Убираем номер теста, оставляем только ответы на вопросы
  unset($answers['t']);

  if (isset($answers['username']))
  {
    $username = $answers['username'];
    unset($answers['username']);
  }
  // Если массив ответов не пуст, и число ответов равно числу вопросов
  // подсчитываем число верных ответов
  if (!empty($answers) && ($count_questions == count($answers)) && !empty($username))
  {
    $point = 0;
    // Проверяем ответы на каждый вопрос
    foreach ($answers as $question=>$answer)
    {
       if ($json[$question]['correct'] == $answer) $point += 1;
        // Говорим пользователю его результат
    }
    echo "$point<br>";
    create_diploma($username, $point);
  }
  // Если есть пустые поля - говорим об этом пользователю
  else
    {
      echo "<script>alert('Необходимо заполнить все поля')</script>";
    }
}
?>
