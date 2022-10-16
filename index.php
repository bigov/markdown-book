<?php
//phpinfo();
//exit();

const MD_DIR = 'data';        // папка базы данных по-умолчанию
$file_index  = 'dirinfo.md';  // индекс по-умолчанию

$tpls = 'assets' . DIRECTORY_SEPARATOR;            // папка шаблонов
$page = 'page.tpl';
$column = 'column.tpl';
$footer = 'footer.tpl';

if ($_SERVER['REQUEST_URI'] == '/')
{
  header("Location: /".MD_DIR."/$file_index");
  exit;
}

require_once 'sys/tools.php';
//require_once 'sys/php-markdown/Michelf/Markdown.inc.php';
require_once 'sys/php-markdown/Michelf/MarkdownExtra.inc.php';
require_once 'sys/pad.php';
require_once 'sys/tree.php';

use Michelf\MarkdownExtra;
$PAD = new mdb\pad();

//print_html_page($PAD);

// Если получен запрос с новым текстом, то записать и вернуться к файлу
if (isset($_POST) and array_key_exists('editor', $_POST))
{
    file_put_contents($PAD->fpath_fs, $_POST['editor']);
    header("Location: " . $_SERVER['SCRIPT_NAME']);
}


if(is_null($PAD->err))
{
  if(is_file($PAD->fpath_fs))
  {
      $page_content =
          MarkdownExtra::defaultTransform(
              file_get_contents($PAD->fpath_fs)
          );
  }
  elseif(is_file($PAD->fpath_fs . $file_index))
  {
    header("Location: " . $_SERVER['SCRIPT_NAME'] . '/' . $file_index);
  }
  else
  {
    $page_content = "<h1>Список файлов</h1>";
    if(count($PAD->tree->ar_current)>0)
    {
      foreach($PAD->tree->ar_current as $i => $v)
      {
          $page_content .= "<div class=\"side-menu\"><a href=\"$v\">$i</a></div>\n";
      }
    }
  }
}
else
{
  $page_content = '<H2>' . $PAD->err . '</H2>';
  $footer = 'footer_er.tpl';
}


print (file_get_contents($tpls . "page_header.tpl"));


if (array_key_exists('QUERY_STRING', $_SERVER) and str_starts_with($_SERVER['QUERY_STRING'], 'edit'))
{
    $page = 'page_ed.tpl';
    $column = 'column_ed.tpl';
    $page_content = file_get_contents($PAD->fpath_fs);
}

// Рендер HTML страницы в клиентский браузер

print (file_get_contents($tpls . $page));
print ($page_content);
print (file_get_contents($tpls . $column));

require_once("view/side_menu.php");
print (file_get_contents($tpls . $footer));

