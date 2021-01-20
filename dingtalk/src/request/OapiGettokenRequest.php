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
namespace DingTalk\request;
trait OapiGettokenRequest
{
    /**
     * 应用的唯一标识key
     **/
    private $appkey;

    /**
     * 应用的密钥
     **/
    private $appsecret;

    /**
     * 企业的corpid
     **/
    private $corpid;

    /**
     * 企业的密钥
     **/
    private $corpsecret;

    private $apiParas = array();

    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;
        $this->apiParas["appkey"] = $appkey;
    }

    public function getAppkey()
    {
        return $this->appkey;
    }

    public function setAppsecret($appsecret)
    {
        $this->appsecret = $appsecret;
        $this->apiParas["appsecret"] = $appsecret;
    }

    public function getAppsecret()
    {
        return $this->appsecret;
    }

    public function setCorpid($corpid)
    {
        $this->corpid = $corpid;
        $this->apiParas["corpid"] = $corpid;
    }

    public function getCorpid()
    {
        return $this->corpid;
    }

    public function setCorpsecret($corpsecret)
    {
        $this->corpsecret = $corpsecret;
        $this->apiParas["corpsecret"] = $corpsecret;
    }

    public function getCorpsecret()
    {
        return $this->corpsecret;
    }

    public function getApiMethodName()
    {
        return "dingtalk.oapi.gettoken";
    }

    public function getApiParas()
    {
        return $this->apiParas;
    }

    public function check()
    {

    }

    public function putOtherTextParam($key, $value) {
        $this->apiParas[$key] = $value;
        $this->$key = $value;
    }
}