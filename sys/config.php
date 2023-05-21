<?php
define("DIR_INDEX", "index.md");  // directory index
define("FOLDER_TPLS", "assets");    // папка шаблонов

function embed_image($f, $w=16, $h=16)
{
    $fname = FOLDER_TPLS . "/" . $f;
    return "<img width=\"$w\" height=\"$h\" " .
        "alt=\"Embedded Image\" src=\"data:image/png;base64," .
        base64_encode(file_get_contents($fname)) . "\"/>";
}

//phpinfo();exit();
//define("WMDB", str_replace( "\\", "/", $_ENV["WMDB"] ));    // Каталог WiKi
define("WMDB", $_SERVER['DOCUMENT_ROOT']);

define("CONTENT_LOCATION", $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME']); // Путь к файлу контента

define("ICO_DIR", embed_image("folder.png"));
define("ICO_TXT", embed_image("document.png"));
define("ICO_PIC", embed_image("file.png"));

define("ICO_EDIT",    embed_image("icon-edit-24.png",  24, 24)); // Иконка редактирования
define("ICO_NEW_DIR", embed_image("icon-folder-24.png",24, 24)); // Иконка создать папку
define("ICO_NEW_DOC", embed_image("icon-file-24.png",  24, 24)); // Иконка создать документ
define("ICO_DELETE",  embed_image("icon-trash-24.png", 24, 24)); // Иконка удалить

