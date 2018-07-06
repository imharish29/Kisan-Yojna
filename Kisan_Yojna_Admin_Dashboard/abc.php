<?php

  require 'include/dbcon.php';
  require 'include/fun.php';

  if (isset($_POST['submit'])) {
    //echo $_POST['abc'];
  }else {
    header("Location: index.php");
  }

  $abc = $_POST['abc'];

  $state = $_POST['lan'];
  $menu = $_POST['menu'];
  $title = $_POST['title'];
  $des = $_POST['des'];

  // echo $abc;
  // echo '<--------------------->';
  // $a = $state.'_'.$menu.'_'.$title.'_'.$des;
  // echo $a;

  $target_dir = "banner/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
     if($check !== false) {
         echo "File is an image - " . $check["mime"] . ".";
         $uploadOk = 1;
     } else {
         echo "File is not an image.";
         $uploadOk = 0;
     }
  }
  // Check if file already exists
  if (file_exists($target_file)) {
     echo "Sorry, file already exists.";
     $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
     echo "Sorry, your file is too large.";
     $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
     $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
     echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
     } else {
         echo "Sorry, there was an error uploading your file.";
     }
  }

  $sql = "INSERT INTO `ky_info`(`state`,`menu`,`title`,`webinfo`,`img`,`des`) VALUES ('$state','$menu','$title','$abc','$target_file','$des')";
  if ($conn->query($sql) === TRUE)
  {

      header("Location: index.php?path=add?m=success");
  }
  else
  {
      $a= "Error: " . $sql . "<br>" . $conn->error;
      //alert($a);
      header("Location: index.php?path=add?m=fail?e=".$a);
  }
  $conn->close();
  //




 ?>
