<?php
//phpinfo();
//exit();

$folder_data = 'data';     // имя директории, в которой расположены данные
$file_index  = 'dir.md';   // индекс по-умолчанию

if ($_SERVER['REQUEST_URI'] == '/')
{
  header("Location: /$folder_data/$file_index");
  exit;
}

//require_once '.sys/php-markdown/Michelf/Markdown.inc.php';
require_once '.sys/php-markdown/Michelf/MarkdownExtra.inc.php';
use Michelf\MarkdownExtra;

require_once '.sys/pad.php';
require_once '.sys/tree.php';

$DS = '\\';
$WD = getcwd();
$coredir  = $WD . $DS . '.sys' . $DS;      // полный путь к файлам ядра

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
    $page_content = MarkdownExtra::defaultTransform(file_get_contents($PAD->fpath_fs));
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

print (file_get_contents($coredir . $header));
print ($page_content);
print (file_get_contents($coredir . $column));

print ('<ul id="menu">');
print ("<li><a href='/$folder_data/dir.md'>HOME</a></li>");
foreach ($PAD->top_dir_list_url as $title => $url)
{
    print ("<li><a href='$url/dir.md'>$title</a></li>");
}
print ("</ul>");

print ('<ul id="menu">');
foreach ($PAD->files_list as $title => $url)
{
    print ("<li><a href='$url'>$title</a></li>");
}
print ("</ul>");


print (file_get_contents($coredir . $footer));

