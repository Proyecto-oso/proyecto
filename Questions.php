<?php
include_once("header.php");
if (!isset($_SESSION)) {
  session_start();
}
?>
</head>
<body>
  <h1>

  <?php
  $QuestionNumber = $_POST["Questions"];

  //read de number of questions an read all
  for ($i = 1; $i <= $QuestionNumber; $i++) {

    $str = "question_" . $i;
    $options = "";
    $answer_pos = $_POST["Answer_" . $i];
    $answer = "";
    //printe the current Question
    $enunciado = $_POST[$str];
    echo 'enunciado: ' . $enunciado . "</br>";
    $OptionsNumber = $_POST["Options_" . $i];
    //print current Options and save de actual answer position
    for ($j = 1; $j <= $OptionsNumber; $j++) {
      $str2 = "option_" . $i . "_" . $j;
      if($j==$OptionsNumber){
        $options .= $_POST[$str2];
      }else{
        $options .= $_POST[$str2] . ";";
      }
      
      if ($answer_pos == $j) {
        $answer = $_POST[$str2];
      }
    }

    echo 'opciones :' . $options . "<br/>";
    echo "Answer is " . $answer . "<br/>";

    $stmt = $dbh->prepare('INSERT INTO `test` (`nombre`) VALUES (?);');
    $stmt->execute([$_POST['nombre_prueba']]);
    $stmt1 = $dbh->prepare('SELECT * FROM `test` WHERE `nombre`=?;');
    $stmt1->execute([$_POST['nombre_prueba']]);
    $test = $stmt1->fetch();
    $stmt = $dbh->prepare('INSERT INTO `preguntas`(`enunciado`, `opciones`, `respuesta`, `id_test`) VALUES (?,?,?,?);')->execute([$enunciado,$options,$answer,$test['id']]);
  }

  ?>


</h1>

</body>
<?php
include_once("footer.php");
?>
