<?php namespace mdb;

class tree
{
    public $parent;
    public array $documents;
    public array $folders;


    public function __construct() {
        $this->parent = null;
        $this->documents = array();
        $this->folders = array();
    }
}

