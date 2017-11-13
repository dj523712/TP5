<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/8
 * Time: 10:49
 */
namespace app\backend\controller;

use app\backend\model\ZhihuTopics;
use GuzzleHttp\Client;

class SyncZhihu
{
    const GET_TOPIC_URL = 'https://www.zhihu.com/node/TopicsPlazzaListV2';


    public function syncTopics()
    {
        set_time_limit(0);
        $client = new Client();
        $response = $client->request('GET', 'https://www.zhihu.com/topics', ['verify' => false]);
        $content = (string)$response->getBody();
        preg_match_all('@<li class="zm-topic-cat-item" data-id="(\d+)"><a href="#([\x{4e00}-\x{9fa5}]*)">\\2</a></li>@iu', $content, $topicCat);
        $topicArray = array_combine($topicCat[1], $topicCat[2]);
        $topic = new ZhihuTopics();
        $lists = [];
        foreach ($topicArray as $key => $value)
        {
            array_push($lists, [
                'raw_id' => $key,
                'name' => $value,
                'status' => 1
            ]);
        }
        //存储顶级分类
        $topic->saveAll($lists);

        $subTopicArray = [];
        foreach ($topicCat[1] as $topicId) {
            $subTopicArray[$topicId] = [];
            $response = $client->request('POST', self::GET_TOPIC_URL, [
                'verify' => false,
                'multipart' => [
                    [
                        'name' => 'method',
                        'contents' => 'next'
                    ],
                    [
                        'name' => 'params',
                        'contents' => '{"topic_id": ' . $topicId . ',"offset":0,"hash_id":""}'
                    ]
                ]
            ]);
            $msg = json_decode((string)$response->getBody())->msg;
            foreach ($msg as $subTopic) {
                preg_match_all('@<a target="_blank" href="/topic/(\d+)">\n(.*?)\n<strong>(.*)</strong>\n</a>@iu', $subTopic,
                    $subTopicCat);
                $subTopicArray[$topicId] += array_combine($subTopicCat[1], $subTopicCat[3]);
            }
        }
        $subLists = [];
        foreach ($subTopicArray as $key => $value) {
            foreach ($value as $k => $v) {
                array_push($subLists, [
                    'raw_id' => $k,
                    'parent_id' => $key,
                    'name' => $v,
                    'status' => 1
                ]);
            }
        }
        //存储次顶分类
        $topic->saveAll($subLists);
    }
}
?>