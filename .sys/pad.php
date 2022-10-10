<?php namespace mdb;

class pad
{
    const MDB_DIR = 'data';         // папка базы данных по-умолчанию
    const MDB_IDX = 'dir.md';       // имя индесного файла по-умолчанию

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

        $this->fpath_url = $_SERVER['SCRIPT_NAME'];
        $this->dbpath_fs = $_SERVER['DOCUMENT_ROOT'] . $S . self::MDB_DIR . $S;
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
              $this->top_dir_list_url[$v] = '/' . self::MDB_DIR .'/'. $v;
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
        $this->tree = new tree();

        // путь в локальной ФС к указанному в адресной строке файлу
        $this->fpath_fs  = $_SERVER['SCRIPT_FILENAME'];
        if (!str_starts_with($this->fpath_fs, $this->dbpath_fs))
        {
            $this->err = "Ошибка: запрошенный документ на найден";
            $this->fpath_fs = '';
            return;
        }

        $wu = $this->cut_end($this->fpath_url, '/');
        $wf = $this->cut_end($this->fpath_fs, DIRECTORY_SEPARATOR);
        $t = scandir($wf);

        foreach ($t as $v)
            if (is_file($wf . $v) and str_ends_with($v, '.md'))
               $this->files_list[$v] = $wu . $v;
    }
}
