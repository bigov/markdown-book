<?php
//phpinfo();
//exit();

const MD_DIR = 'data';        // папка базы данных по-умолчанию
$file_index  = 'dirinfo.md';  // индекс по-умолчанию

$tpls = 'assets' . DIRECTORY_SEPARATOR;            // папка шаблонов
$page = 'page.tpl';
$footer = 'footer.tpl';

require_once 'sys/tools.php';

$PAD = new mdb\pad();

//print_html_page($PAD);


use Michelf\MarkdownExtra;
if(is_null($PAD->err))
{
  if(is_file($PAD->fpath_fs))
  {
    $page_content =
      MarkdownExtra::defaultTransform(file_get_contents($PAD->fpath_fs));
  }
  elseif(is_file($PAD->fpath_fs . $file_index))
  {
    $location = $_SERVER['SCRIPT_NAME'];
    if(!str_ends_with($location, '/')) $location .= '/';
      header("Location: " . $location . $file_index);
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
    $column_content = sprintf(file_get_contents($tpls . 'column_ed.tpl'), $PAD->fpath_fs);
    $page_content = file_get_contents($PAD->fpath_fs);
} else {
    $column_content = file_get_contents($tpls . 'column.tpl');
}

// Рендер HTML страницы в клиентский браузер

print (file_get_contents($tpls . $page));
print ($page_content);
print ($column_content);

require_once("view/side_menu.php");
print (file_get_contents($tpls . $footer));

