<?php
use Cool\DingTalking\DingTalkClient;
use Cool\DingTalking\DingTalkConstant;
use Cool\DingTalking\request\OapiMediaUploadRequest;
use Cool\DingTalking\request\OapiGettokenRequest;
use Cool\DingTalking\CurlClient;
date_default_timezone_set('Asia/Shanghai');
require '../vendor/autoload.php';
class OapiTest{
    public function test()
    {
        $c = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_POST , DingTalkConstant::$FORMAT_JSON);
        $req = new OapiMediaUploadRequest;
        $req->setType("image");
        $req->setMedia(array('type'=>'application/octet-stream','filename'=>'image.png', 'content' => file_get_contents('/1.jpg')));
        $resp=$c->execute($req, "******","https://oapi.dingtalk.com/media/upload");
        var_dump($resp);
    }

    //获取token
    public function getAccessToken()
    {
        $c = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_GET , DingTalkConstant::$FORMAT_JSON);
        $req = new OapiGettokenRequest;
        $req->setAppkey('this is your appKey');
        $req->setAppsecret('this is your appSecret');
        $resp = $c->execute($req, $access_token = null, "https://oapi.dingtalk.com/gettoken");
        var_dump($resp);
    }

    //获取部门用户基础信息
    public function userlistsimple()
    {
        $url = 'https://oapi.dingtalk.com/topapi/user/listsimple';
        $method = "POST";
        $query = ['access_token'=>'feead140fc0236918197a67e900bb7e8'];
        $body = [
            'dept_id' => 1,
            'cursor' => 0,
            'size' => 10,
        ];
        $curlClient = new CurlClient($url,$method,$query,$body);
        $res = $curlClient->execute();
        var_dump($res);
    }

    //获取token
    public function getToken()
    {
        $url = 'https://oapi.dingtalk.com/gettoken';
        $method = "GET";
        $query = [
            'appkey'=>'dingckdokvgq3w7y91il',
            'appsecret'=>'A4Ic2Inj6WlG9TYlLTR8wwKToVuSaID9MkKnRZktwA9xrV-MTHT9HdvNOUXTC5Fe',
        ];
        $body = null;
        $curlClient = new CurlClient($url,$method,$query,$body);
        $res = $curlClient->execute();
        var_dump($res);
    }
}

$a = new OapiTest();
//获取token
//$a->getToken();
//获取用户组数据
$a->userlistsimple();


?>