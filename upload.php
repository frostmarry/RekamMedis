<?php
include "auth/connect.php";

if (isset($_POST['submit'])) {
  $pasien = "1";
  $penyakit = "1";
  $biaya = "20000";

  if (count($_FILES['upload']['name']) > 0) {
    //Loop through each file
    for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
      //Get the temp file path
      $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

      //Make sure we have a filepath
      if ($tmpFilePath != "") {

        //save the url and the file
        $filePath = "assets/img/uploads/" . date('d-m-Y-H-i-s') . '-' . $_FILES['upload']['name'][$i];

        //Upload the file into the temp dir
        if (move_uploaded_file($tmpFilePath, $filePath)) {

          $split = count($_FILES['upload']['tmp_name']);
          $sql = mysqli_query($conn, "INSERT INTO foto_rotgen (id_pasien, id_penyakit, biaya, directory) VALUES ('$pasien', '$penyakit','$biaya', '$filePath')");
          //insert into db 
          //use $shortname for the filename
          //use $filePath for the relative url to the file

        }
      }
    }
  }

  echo $split." Gambar";
}
?>

<form action="" enctype="multipart/form-data" method="post">

  <div>
    <label for='upload'>Add Attachments:</label>
    <input id='upload' name="upload[]" type="file" multiple="multiple" />
  </div>

  <p><input type="submit" name="submit" value="Submit"></p>

</form>