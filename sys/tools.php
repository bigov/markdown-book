<?php
//phpinfo();
//exit;

// Если получен запрос с новым текстом, то записать и вернуться к файлу
if (isset($_POST) and array_key_exists('mdtext', $_POST) and array_key_exists('filepathdir', $_POST))
{
    file_put_contents($_POST['filepathdir'], $_POST['mdtext']);
    header("Location: " . $_SERVER['SCRIPT_NAME']);
    exit;
}

// Если получен запрос на поиск
if (isset($_POST) and array_key_exists('needle', $_POST))
{
    $needle = $_POST['needle'];
    print($needle);

    // https://snipp.ru/php/search-files
    $md_files = recurse_files_list(WMDB, "*.md");
    echo "<PRE>";
    foreach($md_files as $filename)
    {
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $n = stripos($contents, $needle);
        if(is_int($n))
        {
            $base = substr($filename, strlen(WMDB));
            $base = str_replace("\\", "/", $base);
            print($n . ": ");
            $url = $base . '?backlighting=' . $needle;
            print("<a href=\"$url\">" . $filename . "</a>");
            print("\n");
        }
    }

    exit;
}

//require_once 'sys/php-markdown/Michelf/Markdown.inc.php';
require_once 'sys/php-markdown/Michelf/MarkdownExtra.inc.php';
require_once 'sys/pad.php';
require_once 'sys/tree.php';

use Michelf\MarkdownExtra;

function recurse_files_list($dir, $pattern)
{
    $files_list = glob($dir . DIRECTORY_SEPARATOR . $pattern);
    $folders_list = glob($dir . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR);

    foreach($folders_list as $f) $files_list = array_merge($files_list,
      recurse_files_list($f, $pattern));

    return $files_list;
}

function _DBG($v, $s = '')
{
    echo "\n<pre>\n";
    echo date("Y.m.d H:i:s") . "\n\n";
    if(!empty($s)) print($s);
    if(is_array($v)) print_r($v);
    else print($v);
    echo "\n</pre>\n\n";
}


function edit_text($PAD)
{
    $editor = file_get_contents('assets/editor.tpl');
    $page_content = file_get_contents($PAD->fpath_fs);
    return sprintf($editor, $page_content, $PAD->fpath_fs);
}


function print_html_page($PAD)
{
    $tpls = 'assets/';          // папка шаблонов
    $page_content = '';

    if (array_key_exists('QUERY_STRING', $_SERVER) and str_starts_with($_SERVER['QUERY_STRING'], 'edit'))
    {
      $page_content = edit_text($PAD);
    } else
    {
      $page_content = display_text($PAD);
    }

    print(file_get_contents($tpls . "page_header.tpl"));
    print($page_content);
    print(side_menu($PAD));

    $footer = file_get_contents($tpls . 'footer.tpl');
    $edit_link = '';
    if(is_null($PAD->err)) $edit_link = '<a href="?edit">edit</a>';

    print(sprintf($footer, $edit_link));
}


function display_text($PAD)
{
  $page_content = '';

  if(is_null($PAD->err))
  {
    if(is_file($PAD->fpath_fs))
    { // Если произошло обращение к существующему файлу, то обработать его
        $page_content = MarkdownExtra::defaultTransform(file_get_contents($PAD->fpath_fs));
        if(array_key_exists('backlighting', $_GET))
        {
          $txt = $_GET["backlighting"];
          $page_content = str_ireplace($txt, "<span class=\"backlighting\">$txt</span>", $page_content);
        }
    }
    elseif(is_file($PAD->fpath_fs . DIR_INDEX))
    { // Если получено обращение к директории, в которой есть индексный файло,
      // то перенаправить клиентский браузер на этот файл
      $location = $_SERVER['SCRIPT_NAME'];
      if(!str_ends_with($location, '/')) $location .= '/';
        header("Location: " . $location . DIR_INDEX);
    }
    else
    { // Если в директории индексного файла не найдено, то вывести список имеющихся файлов
      $page_content = "<h1>Список файлов</h1>";
      foreach($PAD->tree->ar_current as $i => $v)
        $page_content .= sprintf("<div class=\"files-list\"><a href=\"%s\">%s</a></div>\n", $v, $i);
    }
  } else
  { // если произошла ошибка, то сформировать сообщение о ней
    $page_content = '<H2>' . $PAD->err . '</H2>';
  }

  return $page_content;
}


/**
 * Формирование бокового меню навигации по базе данных
 */
function side_menu($PAD)
{
  $sp = "&nbsp;&nbsp;";
  $home_url = '/' . DIR_INDEX;

  $side_menu = "
</td><td width=\"200px\" valign=\"top\" style=\"padding: 1em 0 0 2em;\">


<div class=\"search\">
  <form action=\"\" method=\"post\">
    <input type=\"text\" name=\"needle\" placeholder=\"поиск\"/>
    <input type=\"submit\" value=\"search\" style=\"display:none;\"/>
  </form>
</div>


<div class=\"side-menu\"><a href=\"$home_url\"><h4>К началу</h4></a></div>\n";

  foreach($PAD->tree->ar_top as $k=>$v)
  {
    $side_menu .= sprintf("<div class=\"side-menu\"><a href=\"%s\">%s</a></div>\n", $v, $k);
  }

  foreach($PAD->tree->ar_step as $k=>$v)
  {
    $side_menu .= sprintf("<div class=\"side-menu\">%s<a href=\"%s\">%s</a></div>\n", $sp, $v, $k);
    $sp .= "&nbsp;&nbsp;";
  }

  foreach($PAD->tree->ar_current as $k=>$v)
  {
     $side_menu .= "<div class=\"side-menu\">$sp<a href=\"$v\">$k</a></div>\n";
  }

  foreach($PAD->tree->ar_bottom as $k=>$v)
  {
    $side_menu .= "<div class=\"side-menu\"><a href=\"$v\">$k</a></div>\n";
  }

  return $side_menu;
}
