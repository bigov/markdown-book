<?php

function _DBG($v, $s = '')
{
    echo "\n<pre>\n";
    echo date("Y.m.d H:i:s") . "\n\n";
    if(!empty($s)) print($s);
    if(is_array($v)) print_r($v);
    else print($v);
    echo "\n</pre>\n\n";
}

