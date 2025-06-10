<?php
$dir_name = "copyhere/";
$images = glob($dir_name."*.JPG");
$allImages = array();

foreach($images as $image) {
  // $image = str_replace('copyhere/', ' ', $image);
  array_push($allImages, $image);
}

echo json_encode($allImages);