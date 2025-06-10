<?php
$filename = $_POST['src'];
if (file_exists($filename)) {
    echo true;
} else {
    echo false;
}
?>