<?php
  header('Content-type:text/plain;charset=utf-8');
  
  if(isset($_POST['keyFile'])) {
    $fileInformation = apc_fetch('upload_'.$_POST['keyFile']);
    echo json_encode($fileInformation);
  }
  
  exit;
?>
