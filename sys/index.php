<?php
//phpinfo();
//exit();

require_once 'sys/config.php';
require_once 'sys/tools.php';

//require_once 'sys/php-markdown/Michelf/Markdown.inc.php';
require_once 'sys/php-markdown/Michelf/MarkdownExtra.inc.php';
require_once 'sys/tree.php';

$TREE = new mdb\tree();
print_html_page($TREE);

