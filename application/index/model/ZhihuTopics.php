<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/10/26
 * Time: 15:40
 */
namespace app\index\model;

use think\Model;

class ZhihuTopics extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'zhihu_topics';

    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';
    protected $updateTime = '';

    protected static function init()
    {
        ZhihuTopics::beforeInsert(function ($topic) {
            if ($oddTopic = ZhihuTopics::get(['raw_id' => $topic->raw_id])) {
                if (isset($topic->parent_id)) {
                    if ($oddTopic->name != $topic->name) {
                        ZhihuTopics::update(['status' => 0], ['id' => $oddTopic->id]);
                    } elseif ($oddTopic->parent_id == $topic->parent_id) {
                        return false;
                    }
                } elseif ($oddTopic->name == $topic->name) {
                    return false;
                }
            }
        });
    }
}