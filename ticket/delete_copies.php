<?php
$files = glob('../copyhere/*'); // get all file names
foreach ($files as $file) { // iterate files
  if (is_file($file)) {
    switch ($file) {
      case "../copyhere/00001TEMP.JPG":
        break;
      case "../copyhere/00002TEMP.JPG":
        break;
      case "../copyhere/00003TEMP.JPG":
        break;
      case "../copyhere/00004TEMP.JPG":
        break;
      default:
        unlink($file); //delete file
        break;
    }
    //unlink($file); // delete file
  }
}

$tmpFiles = glob('../tmpCompress/*');
foreach ($tmpFiles as $tmp) { // iterate files
  if (is_file($tmp)) {
    unlink($tmp); //delete file
  }
}