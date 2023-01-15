<?php namespace mdb;

class tree
{
    protected string $pathdir;  // путь в файловой системе к текущему файлу/папке
    protected string $base_url;  // часть URL от корня к текущему каталогу
    public array $ar_top;
    public array $ar_step;
    public array $ar_current;
    public array $ar_bottom;

    public function __construct()
    {
        $this->ar_top = array();
        $this->ar_step = array();
        $this->ar_current = array();
        $this->ar_bottom = array();

        $this->setup_current_pathdir(CONTENT_LOCATION);
        $this->setup_step_list();
        $this->setup_tree_list();
        $this->setup_top_list();
    }

    /**
     * построение списков директорий верхнего уровня
     */
    protected function setup_top_list()
    {
        $l = scandir(WMDB);
        $dirs = array();   // список папок верхнего уровня
        $base = '/';

        // построить массив папок верхнего уровня с адресами от корня сайта
        foreach($l as $o)
        {
            if(!str_starts_with($o, '.'))
            {
              if(is_dir(WMDB . '/' . $o)) $dirs[ICO_DIR.$o] = $base.$o;
            }
        }

        if(count($this->ar_step) > 0)
        {
          $n = count($dirs);
          $s = array_shift($this->ar_step);
          while($n > 0)
          {
            $id = array_key_first($dirs);
            $e = array_shift($dirs);
            $this->ar_top["$id "] = $e;
            if($e == $s) $n = 1;
            $n -= 1;
          }
          $this->ar_bottom = $dirs;
        }
    }

    /**
     * Построение списка директорий от верхней к текущему каталогу
     */
    protected function setup_step_list()
    {
        $st = substr($this->pathdir, strlen(WMDB), -1);
        $lst = explode('/', $st);
        if(empty($lst[0])) array_shift($lst);
        $this->base_url = '/';
        foreach($lst as $l)
        {
            $this->ar_step[ICO_DIR . $l] = $this->base_url . $l;
            $this->base_url .= $l . '/';
        }
    }


    /**
     * Построение списка директорий и файлов текущего каталога
     */
    protected function setup_tree_list()
    {
        $dirs = array();
        $files = array();
        $l = array();

        if(is_dir($this->pathdir))
          $l = scandir($this->pathdir);
        else
          return;

        foreach($l as $o)
        {
            if(!str_starts_with($o, '.'))
            {
                if(is_file($this->pathdir . $o))
                {
                    if(mb_eregi("(\.pdf$)|(\.jpg$)|(\.gif$)|(\.png$)", $o))
                       $p = ICO_PIC;
                    else
                       $p = ICO_TXT;
                    $files[$p . $o] = $this->base_url . $o;
                }
                else
                {
                    $dirs[ICO_DIR.$o] = $this->base_url . $o;
                }
            }
        }
        $this->ar_current = array_merge($dirs, $files);
    }


    /**
     * Выбрать каталог для поиска списка файлов
     */
    protected function setup_current_pathdir(string $fpath)
    {
        if($fpath == '') $this->pathdir = WMDB . '/';
        else $this->pathdir = $fpath;

        if(is_file($this->pathdir))
            $this->pathdir = dirname($this->pathdir) . '/';
        else $this->pathdir .= '/';
    }
}

