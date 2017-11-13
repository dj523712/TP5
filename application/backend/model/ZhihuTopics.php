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
            if ($oddTopic = isset($topic->parent_id) ? ZhihuTopics::get(['raw_id' => $topic->raw_id, 'parent_id' => $topic->parent_id, 'status' => 1]) :
                ZhihuTopics::get(['raw_id' => $topic->raw_id, 'status' => 1])) {
                if ($oddTopic->name == $topic->name) {
                    if ($oddTopic->parent_id == 0) {
                        return false;
                    } elseif ($oddTopic->parent_id == $topic->parent_id) {
                        return false;
                    } else {
                        Log::error($topic);
                    }
                } else {
                    ZhihuTopics::update(['status' => 0], ['id' => $oddTopic->id]);
                }
            }
        });
    }
}