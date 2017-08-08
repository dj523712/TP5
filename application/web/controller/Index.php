<?php
namespace app\web\controller;

use app\web\model\Visitors;
use DeviceDetector\DeviceDetector;
use think\Controller;
use think\Model;
use think\View;

class Index extends Controller
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

    public function show($id)
    {
        $visitor = new Visitors();
        $visitor->visit();
        $view = new View();
        return $view->fetch('show' . $id);
    }
}
