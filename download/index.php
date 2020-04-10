<!DOCTYPE html>
<html>
<head>
  <title>Download any videos/audio from any website in HD</title>
</head>
<body>

<?php

$str = $_SERVER['REQUEST_URI'];
$yt = file_get_contents('https://dlmyvid.000webhostapp.com/@download/?url='.$_GET['url'].'');
echo $yt;
?>

</body>
</html>
