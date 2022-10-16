<?php
//phpinfo();
//exit();

const MD_DIR = 'data';        // папка базы данных по-умолчанию
require_once 'sys/tools.php';
$PAD = new mdb\pad();
print_html_page($PAD);
