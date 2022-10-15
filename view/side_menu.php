<?php
/**
 * &#128448; - папка закрытая
 * &#128449; - папка открытая
 *
 *
 */

//print("&#128194;"); // желтая открытая папка
//echo "&#128193;";     // желтая папка
$sp = "&nbsp;&nbsp;";

$home_url = '/' . MD_DIR . '/' . $file_index;
echo "<div class=\"side-menu\"><a href=\"$home_url\">home</a></div>\n";

foreach($PAD->tree->ar_top as $k=>$v)
{
  echo "<div class=\"side-menu\"><a href=\"$v\">$k</a></div>\n";
}

foreach($PAD->tree->ar_step as $k=>$v)
{
    echo "<div class=\"side-menu\">$sp<a href=\"$v\">$k</a></div>\n";
   $sp .= "&nbsp;&nbsp;";
}

foreach($PAD->tree->ar_current as $k=>$v)
{
  echo "<div class=\"side-menu\">$sp<a href=\"$v\">$k</a></div>\n";
}

foreach($PAD->tree->ar_bottom as $k=>$v)
{
  echo "<div class=\"side-menu\"><a href=\"$v\">$k</a></div>\n";
}

