<?php

use Michelf\MarkdownExtra;

// внесение изменений в Git репозиторий
function git_push(){
    $output=null;
    $retval=null;
    $git = '"' . $_ENV["GIT"] . '"' . ' -C "' . $_SERVER['DOCUMENT_ROOT'] . '" ';

    exec($git . 'add .', $output, $retval);
    exec($git . 'commit -am "auto fix"', $output, $retval);
    exec($git . 'push', $output, $retval);
}


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


function edit_text()
{
    $editor = file_get_contents(FOLDER_TPLS. "/editor.tpl");
    $page_content = file_get_contents(CONTENT_LOCATION);
    return sprintf($editor, $page_content, CONTENT_LOCATION);
}


function print_html_page($TREE)
{
  // Вывод в браузер стандартного заголовка страницы
  print(file_get_contents(FOLDER_TPLS. "/head_p1.tpl"));
  print("<style>" . file_get_contents(FOLDER_TPLS. "/wiki.css") . "</style>");
  print(file_get_contents(FOLDER_TPLS. "/head_p2.tpl"));

  $page_content = '';
  if (array_key_exists('QUERY_STRING', $_SERVER) and str_starts_with($_SERVER['QUERY_STRING'], 'edit'))
  {
    $page_content = edit_text();
  } else
  {
    $page_content = display_text($TREE);
  }

  if(defined('CONTENT_PREFIX')){
      $page_content = CONTENT_PREFIX . $page_content;
  }

  print($page_content);

  $create_folder_link = "";
  $create_doc_link = "";
  $delete_link = "?delete";
  $edit_link = "?edit";

  print(side_menu($TREE, $edit_link, $create_folder_link, $create_doc_link, $delete_link));

  $footer = file_get_contents(FOLDER_TPLS. "/footer.tpl");
  print($footer);
}


function display_text($TREE)
{
  $page_content = '';

  if(is_file(CONTENT_LOCATION))
  { // Если произошло обращение к существующему файлу, то обработать его
      $page_content = MarkdownExtra::defaultTransform(file_get_contents(CONTENT_LOCATION));
      if(array_key_exists('backlighting', $_GET))
      {
        $txt = $_GET["backlighting"];
        $page_content = str_ireplace($txt, "<span class=\"backlighting\">$txt</span>", $page_content);
      }
  }
  elseif(is_file(CONTENT_LOCATION . DIR_INDEX))
  { // Если получено обращение к директории, в которой есть индексный файло,
    // то перенаправить клиентский браузер на этот файл
    $location = $_SERVER['SCRIPT_NAME'];
    if(!str_ends_with($location, '/')) $location .= '/';
      header("Location: " . $location . DIR_INDEX);
  }
  else
  { // Если в директории индексного файла не найдено, то вывести список имеющихся файлов
    $page_content = "<h1>Список файлов</h1>";
    foreach($TREE->ar_current as $i => $v)
      $page_content .= sprintf("<div class=\"files-list\"><a href=\"%s\">%s</a></div>\n", $v, $i);
  }

  return $page_content;
}


/**
 * Формирование бокового меню навигации по базе данных
 */
function side_menu($TREE, $edit_link, $create_folder_link, $create_doc_link, $delete_link)
{
  $sp = "&nbsp;&nbsp;";
  $home_url = '/' . DIR_INDEX;

  $side_menu = "</td><td width=\"200px\" valign=\"top\" style=\"padding: 1em 0 0 2em;\">";
  $side_menu .= sprintf(
      file_get_contents(FOLDER_TPLS . "/mode_menu.tpl"),
      $edit_link, ICO_EDIT, $create_folder_link, ICO_NEW_DIR,
      $create_doc_link, ICO_NEW_DOC, $delete_link, ICO_DELETE
  );
  $side_menu .= "<div class=\"side-menu\"><a href=\"$home_url\"><h4>К началу</h4></a></div>\n";

  // Верхняя часть дерева меню
  foreach($TREE->ar_top as $k=>$v)
  {
    $side_menu .= sprintf("<div class=\"side-menu\"><a href=\"%s/\">%s</a></div>\n", $v, $k);
  }

  // Отображение иерархии вложенных папок
  foreach($TREE->ar_step as $k=>$v)
  {
    $side_menu .= sprintf("<div class=\"side-menu\">%s<a href=\"%s/\">%s</a></div>\n", $sp, $v, $k);
    $sp .= "&nbsp;&nbsp;";
  }

  // Список папок и файлов в текущем каталоге
  foreach($TREE->ar_current as $k=>$v)
  {
     $side_menu .= "<div class=\"side-menu\">$sp<a href=\"$v\">$k</a></div>\n";
  }

  // Нижняя часть верхнего уровня в иерархии папок
  foreach($TREE->ar_bottom as $k=>$v)
  {
    $side_menu .= "<div class=\"side-menu\"><a href=\"$v/\">$k</a></div>\n";
  }

  return $side_menu;
}
