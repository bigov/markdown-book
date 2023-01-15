<?php
//phpinfo();
//exit();

// Загрузить значения глобальных констант
require_once 'sys/config.php';
require_once 'sys/tools.php';

// Обработать запросы на выполнение действий
require_once 'sys/post_actions.php';

require_once 'sys/php-markdown/Michelf/MarkdownExtra.inc.php';
require_once 'sys/tree.php';

$TREE = new mdb\tree();
print_html_page($TREE);

