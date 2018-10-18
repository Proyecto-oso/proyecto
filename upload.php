
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php

  // Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {

    if (isset($_POST["Sesion2"])) {
      $target_dir = "uploads/sesion2/";
      $newName = $_FILES["fileToUpload"]["name"];
      $target_file = $target_dir . $newName;
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      $newName = $_POST["image_id"] . ".".$imageFileType;
      $target_file = $target_dir . $newName;
    }

    if (isset($_POST["Sesion1"])) {
      $target_dir = "uploads/sesion1/";
      $newName = $_FILES["fileToUpload"]["name"];
      $target_file = $target_dir . $newName;
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      $newName = $_POST["image_id"] . ".".$imageFileType;
      $target_file = $target_dir . $newName;
    }



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
        echo "Sorry, your file is too large.";
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
        echo '<a href="sesion2.php" class="w3-btn w3-black">Regresar a la sesion 2</a>';
  // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.</br>";
            echo '<a href="sesion2.php" class="w3-btn w3-black">Regresar a la sesion 2</a>';
        } else {
            echo "Sorry, there was an error uploading your file.";
            echo '<a href="sesion2.php" class="w3-btn w3-black">Regresar a la sesion 2</a>';
        }
    }
} else {
    echo '
    <form action="upload.php" method="post" enctype="multipart/form-data">
    enter image id:
    <input type="text" name="image_id" id="image_id">
    <br/>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
  </form>
  ';

}


?>
