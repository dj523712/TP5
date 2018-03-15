<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/10/26
 * Time: 15:40
 */
namespace app\backend\model;

use think\Log;
use think\Model;

class ArticlesTags extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'articles_tags';

    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';
    protected $updateTime = '';

}