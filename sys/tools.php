<?php

// Любые обращения за пределы папки MD_DIR "пресекаются"
if(!str_starts_with($_SERVER['REQUEST_URI'], '/' . MD_DIR))
{
    header("Location: /".MD_DIR."/$file_index");
    exit;
}

// Если получен запрос с новым текстом, то записать и вернуться к файлу
if (isset($_POST) and array_key_exists('mdtext', $_POST) and array_key_exists('filepathdir', $_POST))
{
    file_put_contents($_POST['filepathdir'], $_POST['mdtext']);
    header("Location: " . $_SERVER['SCRIPT_NAME']);
    exit;
}

//require_once 'sys/php-markdown/Michelf/Markdown.inc.php';
require_once 'sys/php-markdown/Michelf/MarkdownExtra.inc.php';
require_once 'sys/pad.php';
require_once 'sys/tree.php';

function _DBG($v, $s = '')
{
    echo "\n<pre>\n";
    echo date("Y.m.d H:i:s") . "\n\n";
    if(!empty($s)) print($s);
    if(is_array($v)) print_r($v);
    else print($v);
    echo "\n</pre>\n\n";
}

