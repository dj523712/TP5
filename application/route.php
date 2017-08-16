<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//hello模块
Route::rule('hello','Demo/index/index');

//web前段模块
Route::rule('web/:id','web/index/show');

//web前段模块
Route::rule('web/:id','web/index/show');

return [
    '__pattern__' => [
        'name' => '\w+',
        'id' => '\d+',
    ],
];

