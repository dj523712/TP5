<?php
namespace app\web\model;

use DeviceDetector\DeviceDetector;
use think\Model;

class Visitors extends Model {
    // 设置当前模型对应的完整数据表名称
    protected $table = 'visitors';

    /**
     * 访客记录
     */
    public function visit()
    {
        $request = request();
        $detector = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
        $detector->parse();

        $detector->skipBotDetection();
        $data = [
            'user_agent' => $detector->getUserAgent(),
            'client_device' => $detector->getDeviceName(),
            'client_os' => $detector->getOs('name') . ' ' . $detector->getOs('version'),
            'browser' => $detector->getClient('name'),
            'browser_version' => $detector->getClient('version'),
            'user_id' => 0,
            'ip' => $request->ip(),
            'visit_time' => time()
        ];
        $this->save($data);
    }
}