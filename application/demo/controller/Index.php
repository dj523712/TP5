<?php
namespace app\demo\controller;

class Index
{
    public function index()
    {
        $name = 'β$狒狒他大爷xx';
        $preg = '/^[\w\_\a-zA-Z\x{4e00}-\x{9fa5}]{2,20}$/u';
        var_dump($name);
        var_dump($preg);
        var_dump(preg_match_all($preg,$name));
        exit;
    }
}
