<?php
//phpinfo();
//exit();

const MD_DIR = 'data';        // папка базы данных по-умолчанию
require_once $_SERVER['DOCUMENT_ROOT'] . '/sys/tools.php';
$PAD = new mdb\pad();
print_html_page($PAD);
