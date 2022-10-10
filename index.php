<?php
//phpinfo();
//exit();

const MD_DIR = 'data';        // папка базы данных по-умолчанию
$file_index  = 'dirinfo.md';  // индекс по-умолчанию
$tpls = 'assets/';            // папка шаблонов

if ($_SERVER['REQUEST_URI'] == '/')
{
  header("Location: /".MD_DIR."/$file_index");
  exit;
}

//require_once '.sys/php-markdown/Michelf/Markdown.inc.php';
require_once '.sys/php-markdown/Michelf/MarkdownExtra.inc.php';
require_once '.sys/pad.php';
require_once '.sys/tree.php';

use Michelf\MarkdownExtra;
$PAD = new mdb\pad();

// Если принят запрос с новым текстом, то записать и вернуться к файлу
if (isset($_POST) and array_key_exists('editor', $_POST))
{
    file_put_contents($PAD->fpath_fs, $_POST['editor']);
    header("Location: " . $_SERVER['SCRIPT_NAME']);
}

$header = 'header.tpl';
$column = 'column.tpl';
$footer = 'footer.tpl';

if(is_null($PAD->err))
{
    if(is_file($PAD->fpath_fs))
      $page_content = MarkdownExtra::defaultTransform(file_get_contents($PAD->fpath_fs));
    else
      $page_content = "<h2>Каталог базы данных</h2>";
}
else
{
    $page_content = '<H2>' . $PAD->err . '</H2>';
    $footer = 'footer_er.tpl';
}

if (array_key_exists('QUERY_STRING', $_SERVER) and str_starts_with($_SERVER['QUERY_STRING'], 'edit'))
{
    $header = 'header_ed.tpl';
    $column = 'column_ed.tpl';
    $page_content = file_get_contents($PAD->fpath_fs);
}

// Рендер HTML страницы в клиентский браузер

print (file_get_contents($tpls . $header));
print ($page_content);
print (file_get_contents($tpls . $column));

print ('<ul id="menu">');
print ("<li><a href='/".MD_DIR."/$file_index'>HOME</a></li>");
foreach ($PAD->top_dir_list_url as $title => $url)
{
    print ("<li><a href='$url/$file_index'>$title</a></li>");
}
print ("</ul>");

print ('<ul id="menu">');
foreach ($PAD->files_list as $title => $url)
{
    print ("<li><a href='$url'>$title</a></li>");
}
print ("</ul>");


print (file_get_contents($tpls . $footer));

