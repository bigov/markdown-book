<?php namespace mdb;

class tree
{
    public $parent;
    public array $documents;
    public array $folders;
    public array $tree_list;
    protected string $pathdir;

    public function __construct( string $fpath = '' )
    {
        $this->parent = null;
        $this->documents = array();
        $this->folders = array();
        $this->setup_current_pathdir($fpath);
        $this->setup_tree_list();
    }


    /**
     * Построение массива, содержащего дерево файлов
     */
    protected function setup_tree_list()
    {
        //$tree_list[]
        $l = scandir($this->pathdir);
        $dirs = array();
        $files = array();
        foreach ($l as $o)
        {
            if (!str_starts_with($o, '.'))
            {
              if(is_file($this->pathdir . $o)) $files[] = $o;
              else $dirs[] = $o;
            }
        }
        $tl = array();
        $tl[] = $dirs;
        $tl[] = $files;

        print_r($tl);
        exit;
    }


    /**
     * Выбрать каталог для поиска списка файлов
     */
    protected function setup_current_pathdir(string $fpath = '')
    {
        if ($fpath == '') $this->pathdir = $_SERVER['DOCUMENT_ROOT']
            . DIRECTORY_SEPARATOR . MD_DIR . DIRECTORY_SEPARATOR;
        else $this->pathdir = $fpath;

        if(is_file($this->pathdir))
            $this->pathdir = dirname($this->pathdir)
            . DIRECTORY_SEPARATOR;
    }
}

