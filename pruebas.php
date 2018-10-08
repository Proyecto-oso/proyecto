<?php
include_once("header.php");
if (!isset($_SESSION)) {
  session_start();
}
?>

<style media="screen">
  body{
    text-align: center;
  }
  .input{

  }
</style>
  </head>
<div>


  Seleccione el número de preguntas

  <select id="mySelect" class="Selection">
  <?php
  for ($i = 0; $i <= 3; $i++) {
    if ($i == 0) {
      echo '<option selected></option>';
      continue;
    }
    echo '<option>' . $i . '</option>';

  }
  ?>
  </select>

  <form class="inputs" action="Questions.php" method="post">

  </form>


  <form action="upload.php" method="post" enctype="multipart/form-data">
    enter image id:
    <input type="text" name="image_id" id="image_id">
    <br/>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
  </form>

  <p id="test">This is some <b>bold</b> text in a paragraph.</p>

  <button id="btn1" class="btn" >Show Text</button>
  <button id="btn2" class="btn">Show HTML</button>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
    $(".Selection").click(function(){

      //Questions views

      var x = document.getElementById("mySelect").value;
      var numberOfQuestions =  document.getElementById("mySelect").value;
      var $container = $(".inputs");
      $container.html('<input type="text" name="nombre_prueba" placeholder="Nombre de la prueba" class= "input">');
      $container.append('<input type="hidden" name="Questions" id="Questions" value="" /><br/>')
      for (var i=1; i<=numberOfQuestions; i++) {
        $container.append('<input type="text" name="question_'+i+'" placeholder="pregunta '+i+'" class= "input"> Numero de opciones:');
        $container.append('<select id="mySelect_'+i+'" class="Options" ><option selected></option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option></select>');
        $container.append('<div id="options_'+i+'"></hr></div>')
      }
      $container.append('<input type="submit" value="Send Questions" name="submit">')
      document.getElementById('Questions').value = numberOfQuestions;

      // Options views

      $(".Options").click(function(){
        var id = this.id;
        id = parseInt(id. charAt( id. length-1 ));
        var index = "#options_"+id;
        var numberOfOptions = document.getElementById(this.id).value;
        var $container = $(index);
        $container.html("")
        $container.append('<input type="hidden" name="Options_'+id+'" id="Options_'+id+'" value="" /><br/>')
        $container.append('<input type="hidden" name="Answer_'+id+'" id="Answer_'+id+'" value="" /><br/>')
        for (var i = 1; i <= numberOfOptions; i++) {
          $container.append('opcion '+i+': <input type="text" name="option_'+id+'_'+i+'" placeholder="opcion '+i+'" class= "input"><br/> ');
        }


        //Select correct answer


        var AnsTag = 'Opción correcta:<select id="AnsTag_'+id+'" class="ans_select">';
        for (var i = 1; i <= numberOfOptions; i++) {
          if(i==1){
            AnsTag += '<option selected></option>';
          }
          AnsTag += '<option>'+i+'</option>';
          //$ansContainer.append('<option>'+i+'</option>');
        }
        AnsTag+= '</select>';


        $container.append(AnsTag);


        $(".ans_select").click(function(){
          var ans_id = this.id;
          ans_id = parseInt(ans_id. charAt( ans_id. length-1 ));
          var CorrectAnswer = document.getElementById(this.id).value;
          //$container.append('<h1> pst'+ CorrectAnswer+'</h1>');
          document.getElementById('Answer_'+id).value = CorrectAnswer;
        });

        document.getElementById('Options_'+id).value = numberOfOptions;

      });
    })

    $(".btn").click(function(){
      alert("Text: " + this.id);
    });
  });


  </script>
  </div>
<?php
include_once("footer.php");
?>














<!--

-->
