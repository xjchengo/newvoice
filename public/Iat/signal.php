<?php
if (isset($_GET['wind'])) {
    $wind = intval($_GET['wind']);
} else {
    $wind = 0;
}
if (isset($_GET['shake'])) {
    $shake = intval($_GET['shake']);
} else {
    $shake = 0;
}
echo $wind."\n".$shake;