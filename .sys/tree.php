<?php namespace mdb;

class tree
{
    protected string $pathdir;
    protected string $data_dir;
    public array $ar_top;
    public array $ar_step;
    public array $ar_current;
    public array $ar_bottom;

    public function __construct( string $fpath = '' )
    {
        $this->ar_top = array();
        $this->ar_step = array();
        $this->ar_current = array();
        $this->ar_bottom = array();

        $this->setup_current_pathdir($fpath);
        $this->setup_tree_list();
        $this->setup_step_list();
        $this->setup_top_list();
    }

    /**
     * построение списков директорий верхнего уровня
     */
    protected function setup_top_list()
    {
        $l = scandir($this->data_dir);
        $dirs = array();   // список всех папок верхнего уровня
        $base = '/' . MD_DIR . '/';

        foreach($l as $o)
        {
            if(!str_starts_with($o, '.'))
            {
              if(is_dir($this->data_dir . $o)) $dirs[$o] = $base . $o;
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
            $this->ar_top[$id] =$e;
            if($e == $s) $n = 1;
            $n -= 1;
          }
          $this->ar_bottom = $dirs;
        }
    }

    /**
     * Построение списка директорий к текущему каталогу
     */
    protected function setup_step_list()
    {
        $data_dir = $_SERVER['DOCUMENT_ROOT'] 
                  . DIRECTORY_SEPARATOR 
                  . MD_DIR . DIRECTORY_SEPARATOR;

        $st = substr($this->pathdir, strlen($data_dir), -1);
        $lst = explode(DIRECTORY_SEPARATOR, $st);
        $base = '/' . MD_DIR . '/';
        foreach($lst as $l)
        {
            $this->ar_step[$l] = $base . $l;
            $base .= $l . '/';
        }

        if(empty($this->ar_step[0])) array_shift($this->ar_step);
        $this->data_dir = $data_dir;
    }


    /**
     * Построение списка директорий и файлов текущего каталога
     */
    protected function setup_tree_list()
    {
        $l = scandir($this->pathdir);
        $dirs = array();
        $files = array();
        foreach($l as $o)
        {
            if(!str_starts_with($o, '.'))
            {
              if(is_file($this->pathdir . $o)) $files[] = $o;
              else $dirs[] = $o;
            }
        }
        $this->ar_current = array_merge($dirs, $files);
    }


    /**
     * Выбрать каталог для поиска списка файлов
     */
    protected function setup_current_pathdir(string $fpath = '')
    {
        if($fpath == '') $this->pathdir = $_SERVER['DOCUMENT_ROOT']
            . DIRECTORY_SEPARATOR . MD_DIR . DIRECTORY_SEPARATOR;
        else $this->pathdir = $fpath;

        if(is_file($this->pathdir))
            $this->pathdir = dirname($this->pathdir)
            . DIRECTORY_SEPARATOR;
    }
}

