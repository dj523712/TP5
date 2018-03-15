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

class MirrorArticles extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'mirror_articles';

    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';
    protected $updateTime = '';

    public function articles()
    {
        return $this->belongsToMany('Articles', '\app\backend\model\ArticlesTags', 'tag_id', 'id');
    }
}