<?php
require 'pinyin.php';
$result = array();
if ($_FILES["wav"]["error"] > 0) {
    $result['success'] = 0;
    $result['msg'] = "Return Code: " . $_FILES["wav"]["error"];
} else {
    $dir = './audio/';
    $fileName = $_FILES["wav"]["name"].time().'.wav';
    if (file_exists($dir.$fileName)) {
        $result['success'] = 0;
        $result['msg'] = $_FILES["wav"]["name"] . " already exists. ";
    }else {
        move_uploaded_file($_FILES["wav"]["tmp_name"],
            $dir.$fileName);
        exec('sox '.$dir.$fileName.' -r 16000 '.$dir.'16'.$fileName);
        exec('iatdemo '.$dir.'16'.$fileName, $output, $return_var);
        foreach($output as $key=>$value) {
            if (mb_substr($value, 0, 3) == '===') {
                $result['success'] = 1;
                $result['character'] = $output[$key+1];
                $result['pinyin'] = pinyin($result['character'], 'utf8');
                $result['path'] = '/audio/'.$fileName;
                break;
            }
        }
    }
}
die(json_encode($result));
?>