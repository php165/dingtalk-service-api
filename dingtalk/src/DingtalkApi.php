<?php
// +----------------------------------------------------------------------
// | CoolCms [ DEVELOPMENT IS SO SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.coolcms.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: Myj <815081410@qq.com>
// +----------------------------------------------------------------------
namespace DingTalk;
use DingTalk\request\OapiGettokenRequest;
use DingTalk\curl\CurlTrait;
class DingtalkApi{
    use OapiGettokenRequest;
    use CurlTrait;

    public function __construct($appKey,$appSecret)
    {
        $this->setAppkey($appKey);
        $this->setAppsecret($appSecret);
    }
    /**
     * 获取access_token
     */
    public function getAccessToken()
    {
        var_dump($this->apiParas);die;
    }
}

$res = new DingtalkApi('','');
$res ->getAccessToken();