<?php namespace mdb;

class pad
{
   public string $query_str;       // текст запроса (после '?')

   public function __construct() {

       //Заполнение переменной строки запроса
       $this->query_str = "";
       if (array_key_exists('QUERY_STRING', $_SERVER))
           $this->query_str = $_SERVER['QUERY_STRING'];
   }
}
