<?php
exec('iatdemo ./audio/16blob1402298877.wav', $output, $return_var);
// exec('ls', $output, $return_var);
var_dump($output);
var_dump($return_var);