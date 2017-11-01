<?php
namespace app\index\controller;

use app\index\model\ZhihuTopics;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Promise\RejectionException;

class Index
{
    const GET_TOPIC_URL = 'https://www.zhihu.com/node/TopicsPlazzaListV2';

    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    public function hello()
    {
        return 'Hello World';
    }
    
    public function baidu()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://www.zhihu.com/topics', [
            'verify' => false
        ]);
        $content = (string)$response->getBody();
        preg_match_all('@<li class="zm-topic-cat-item" data-id="(\d+)"><a href="#([\x{4e00}-\x{9fa5}]*)">\\2</a></li>@iu', $content, $topicCat);
        $topicArray = array_combine($topicCat[1], $topicCat[2]);
        $topic = new ZhihuTopics();
        $lists = [];
        foreach ($topicArray as $key => $value) {
            array_push($lists, [
                'raw_id' => $key,
                'name' => $value,
                'status' => 1
            ]);
        }
        $topic->saveAll($lists);
        $subTopicArray = [];
        foreach ($topicCat[1] as $topicId) {
            $subTopicArray[$topicId] = [];
            $response = $client->request('POST', self::GET_TOPIC_URL, [
                'verify' => false,
                'multipart' => [
                    [
                        'name'     => 'method',
                        'contents' => 'next'
                    ],
                    [
                        'name'     => 'params',
                        'contents' => '{"topic_id": ' .$topicId . ',"offset":0,"hash_id":""}'
                    ]
                ]]);
            $msg = json_decode((string)$response->getBody())->msg;
            foreach ($msg as $subTopic) {
                preg_match_all('@<a target="_blank" href="/topic/(\d+)">\n(.*?)\n<strong>(.*)</strong>\n</a>@iu', $subTopic, $subTopicCat);
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
        $topic->saveAll($subLists);
        var_dump($subTopicArray);
        echo count($subTopicArray);
        exit;
    }



}
