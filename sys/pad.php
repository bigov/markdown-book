<?php namespace mdb;

class pad
{
    public string $fpath_fs;        // путь к текущему файлу
    public string $query_str;       // текст запроса (после '?')
    public $err = null;             // ошибка обработки

    public array $top_dir_list_url; // список url папок верхнего уровня
    public $tree;

    public function __construct() {
        $this->fpath_fs = WMDB . $_SERVER['SCRIPT_NAME'];
        $this->init_query_str();
        $this->init_top_dir_list();
        $this->tree = new tree($this->fpath_fs);
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
        $t = scandir(WMDB);
        foreach($t as $v)
        {
          $fpath = WMDB . '/' . $v;
          if (!str_starts_with($v, '.') and is_dir($fpath))
              $this->top_dir_list_url[$v] = '/'. $v;
        }
    }
}
