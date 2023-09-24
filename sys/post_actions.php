<?php

// Если получен запрос с новым текстом, то записать и вернуться к файлу
if (isset($_POST) and array_key_exists('mdtext', $_POST) and array_key_exists('filepathdir', $_POST))
{
	if(!$_POST['cancel'])
	{
    	file_put_contents($_POST['filepathdir'], $_POST['mdtext']);
    	git_push();
 	}

    header("Location: " . $_SERVER['SCRIPT_NAME']);
    exit;
}

// Удаление указанного файла
if (isset($_POST) and array_key_exists('DeleteFile', $_POST) and array_key_exists('filepathdir', $_POST))
{
    unlink($_POST['filepathdir']);
    git_push();

    // Найти позицию последнего вхождения подстроки "/" в строке адреса
    $n = strrpos($_SERVER['SCRIPT_NAME'], "/");
    // Взять часть строки адреса без последнего элемента
    $redirect = substr($_SERVER['SCRIPT_NAME'], 0, $n);
    header("Location: " . $redirect . "/");
    exit;
}

// Отображение запроса подтверждения на удаление файла
if (isset($_GET) and array_key_exists('delete', $_GET))
{
    DEFINE("CONTENT_PREFIX", sprintf(file_get_contents(FOLDER_TPLS. "/ask_delete_file.tpl"), CONTENT_LOCATION ));
}

// Если получен запрос на поиск
if (isset($_POST) and array_key_exists('needle', $_POST))
{
    $needle = $_POST['needle'];
    print($needle);

    $md_files = recurse_files_list(WMDB, "*.md");
    echo "<PRE>";
    foreach($md_files as $filename)
    {
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $n = mb_stripos($contents, $needle);
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

