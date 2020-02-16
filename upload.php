<?php
  header("Content-Type: application/json");

  $uploaded = array();

  if(!empty($_FILES['file']['name'][0])) {
   foreach($_FILES['file']['name'] as $position => $name) {
    if(move_uploaded_file($_FILES['file']['tmp_name'][$position], 'files/'.$name)) {
     $uploaded[] = array(
      'name' => $name,
      'file' => 'files/'.$name
     );
    }
   }
  }

  echo json_encode($uploaded);
?>