<?php

print("<ul>");

echo "<p>top";
foreach($PAD->tree->ar_top as $k=>$v)
{
  echo "<li><a href=\"$v\">$k</a></li>";
}

echo "<p>step";
foreach($PAD->tree->ar_step as $k=>$v)
{
  echo "<li class=\"l1\"><a href=\"$v\">$k</a></li>";
}

echo "<p>current";
if(count($PAD->tree->ar_current) > 0)
foreach($PAD->tree->ar_current as $k=>$v)
{
  echo "<li class=\"l2\"><a href=\"$v\">$k</a></li>";
}


echo "<p>bottom";
print_r($PAD->tree->ar_bottom);

print("</ul>");

