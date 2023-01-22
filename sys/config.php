<?php
define("DIR_INDEX", "index.md");  // directory index
define("FOLDER_TPLS", "assets");    // папка шаблонов
define("WMDB", str_replace( "\\", "/", $_ENV["WMDB"] ));    // Каталог WiKi
define("CONTENT_LOCATION", WMDB . $_SERVER['SCRIPT_NAME']); // Путь к файлу контента

define("ICO_DIR", "<span class=\"icon\" style=\"color: green;\">&#128447;</span>"); // Иконка папки
define("ICO_TXT", "<span class=\"icon\" style=\"font-weight: bold; color: green; margin-right: 0.1em;\">&#128441;</span>"); // Иконка текстового документа
define("ICO_PIC", "<span class=\"icon\" style=\"color: green;\">&#128445;</span>"); // Иконка изображения

define("ICO_EDIT",    "<span class=\"button\">&#128393;</span>"); // Иконка редактирования
define("ICO_NEW_DIR", "<span class=\"button\">&#128448;</span>"); // Иконка создать папку
define("ICO_NEW_DOC", "<span class=\"button\">&#128459;</span>"); // Иконка создать документ
define("ICO_DELETE",  "<span class=\"button\">&#128465;</span>"); // Иконка удалить

