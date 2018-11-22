
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style media="screen">
  .container{
    text-align: center;
  }
  .btn{
    margin: 10px;
  }
  .link{
    font-size: 50px;
    color: red;
  }
</style>
<?php

  // Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    if (isset($_POST["Sesion4"])) {
      $target_dir = "uploads/sesion4/";
    }
    if (isset($_POST["Sesion3"])) {
      $target_dir = "uploads/sesion3/";
    }
    if (isset($_POST["Sesion5"])) {
      $target_dir = "uploads/sesion5/";
    }
    if (isset($_POST["Sesion6"])) {
      $target_dir = "uploads/sesion6/";
    }

    if (isset($_POST["Sesion8"])) {
      $target_dir = "uploads/sesion8/";
    }

    if (isset($_POST["Sesion2"])) {
      $target_dir = "uploads/sesion2/";
    }
    if (isset($_POST["Sesion1"])) {
      $target_dir = "uploads/sesion1/";
    }
    $newName = $_FILES["fileToUpload"]["name"];
    $target_file = $target_dir . $newName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $newName = $_POST["image_id"] . ".".$imageFileType;
    $target_file = $target_dir . $newName;
    $redirect = $_POST['redirect'];



    #if ($check !== false) {
    #    echo "File is an image - " . $check["mime"] . ".";
    #    $uploadOk = 1;
    #} else {
    #    echo "File is not an image.";
    #    $uploadOk = 0;
    #}
     // Check if file already exists
    #if (file_exists($target_file)) {
    #    echo "Sorry, file already exists.";
    #    $uploadOk = 0;
    #}

    // Check file size se revisa si es mayor a 500KB
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        ?>
        <h1>El archivo es demasiado grande, el tamaño maximo es de 5 mb, te recomendamos comprimir el archvio mediante la siguiente pagina:</h1>
        <a class="link" href="https://www.ilovepdf.com/es/comprimir_pdf" >https://www.ilovepdf.com/es/comprimir_pdf</a>
        <?php
        echo "</br>";
        $uploadOk = 0;
    }

  // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf") {  
        echo "Solo se permiten archivos de formato JPG, JPEG, PNG & PDF .</br>";
        $uploadOk = 0;
    }

  // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "El archivo no se ha podido subir, verifique que ha sido seleccionado o que esta en el formato correcto.</br>";
        echo '<a href="'.$redirect.'.php" class="w3-btn w3-black">Regresar a la sesion</a>';
  // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo '<div class="container">';
            echo "<h1>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.</h1></br>";
            if ($imageFileType =="pdf") {
              // code...
              echo "<h1>Puedes revisar el pdf en la opcion ver archivo de cada estudiante.</h1></br>";
            }else {
              // code...
              echo '<img src="'.$target_file.'" alt="imagen " style="width:500px;height:600px;"></br>';
            }
            echo '<a href="'.$redirect.'.php" class="w3-btn w3-black btn" >Regresar a la sesion</a>';
          echo '</div>';
        } else {
            echo "Sorry, there was an error uploading your file.";
            echo '<a href="'.$redirect.'.php" class="w3-btn w3-black">Regresar a la sesion</a>';
        }
    }
} else {
    echo '
    <form action="upload.php" method="post" enctype="multipart/form-data">
    enter image id:
    <input type="text" name="image_id" id="image_id">
    <br/>
    Selecciona el archivo:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Subir archivo" name="submit">
  </form>
  ';

}


?>
