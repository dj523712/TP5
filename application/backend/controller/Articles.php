<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/29
 * Time: 11:37
 */
namespace app\backend\controller;


use app\backend\model\MirrorArticles;

class Articles {
    public function index()
    {
        $article = MirrorArticles::create([
            'title' => 'test',
            'title' => 'test',
            'title' => 'test',
            'title' => 'test',
            'title' => 'test',
            'title' => 'test',
        ])
    }
}