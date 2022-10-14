<?php namespace mdb;

class pad
{
    public string $fpath_url;       // url-адрес текущего файла
    public string $fpath_fs;        // путь к текущему файлу
    public string $dbpath_fs;       // путь в ФС к каталогу базы данных
    public string $query_str;       // текст запроса (после '?')
    public $err = null;             // ошибка обработки

    public array $top_dir_list_url; // список url папок верхнего уровня
    //public array $cur_dir_list;     // список папок текущего уровня
    public array $files_list;       // список файлов текущего уровня
    public $tree;

    public function __construct() {
        $S = DIRECTORY_SEPARATOR;
        $this->dbpath_fs = $_SERVER['DOCUMENT_ROOT'].$S.MD_DIR.$S;
        $this->fpath_url = $_SERVER['SCRIPT_NAME'];
        $this->init_query_str();
        $this->init_top_dir_list();
        $this->init_files_list();
    }

    /**
     * Заполнение переменной строки запроса
     */
    protected function init_query_str()
    {
        $this->query_str = "";
        if (array_key_exists('QUERY_STRING', $_SERVER))
            $this->query_str = $_SERVER['QUERY_STRING'];
    }

    /**
     * Заполнение массива каталогов верхнего уровня значениями URL
     */
    protected function init_top_dir_list()
    {
        $t = scandir($this->dbpath_fs);
        foreach($t as $v)
        {
          $fpath = $this->dbpath_fs . $v;
          if (!str_starts_with($v, '.') and is_dir($fpath))
              $this->top_dir_list_url[$v] = '/' . MD_DIR .'/'. $v;
        }
    }

    /**
     * Отделяет окончание строки по указанному маркеру
     */
    protected function cut_end(string $row, string $marker)
    {
        $result = "";
        $ap = explode($marker, $row);                // разделить строку
        $ap = array_slice($ap, 0, count($ap) - 1);   // удалить последний
        foreach ($ap as $p) $result .= $p . $marker; // собрать
        return $result;
    }

    /**
     * Заполнение массива файлов текущей папки
     */
    protected function init_files_list()
    {
        $this->files_list = array();

        // путь в локальной ФС к указанному в адресной строке файлу.
        // Обрабатываются только файлы с расширением `.md`. Все остальные
        // файлы отдаются браузеру автоматически без обработки.
        $this->fpath_fs  = $_SERVER['SCRIPT_FILENAME'];

        if (!str_starts_with($this->fpath_fs, $this->dbpath_fs))
        {
            // если .md файл по указанному пути не найден, то проверить -
            // может это папка, расположенная в каталоге базы данных
            if (str_starts_with($_SERVER['SCRIPT_NAME'], '/'. MD_DIR))
            {
              $this->fpath_fs = $_SERVER['DOCUMENT_ROOT'] .
                       str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['SCRIPT_NAME']);

              if(!str_ends_with($this->fpath_fs, DIRECTORY_SEPARATOR))
                  $this->fpath_fs .= DIRECTORY_SEPARATOR;
            }

            // если это и не папка, то сообщить об ошибке
            if(!is_dir($this->fpath_fs))
            {
              $this->err = "ERROR 404: document not found.";
              $this->fpath_fs = '';
              return;
            }
        }
        $this->tree = new tree($this->fpath_fs);
    }
}
