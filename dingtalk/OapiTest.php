<?php
use Cool\DingTalking\DingTalkClient;
use Cool\DingTalking\DingTalkConstant;
use Cool\DingTalking\request\OapiMediaUploadRequest;
use Cool\DingTalking\request\OapiGettokenRequest;
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
        $req->setAppkey('dingckdokvgq3w7y91il');
        $req->setAppsecret('A4Ic2Inj6WlG9TYlLTR8wwKToVuSaID9MkKnRZktwA9xrV-MTHT9HdvNOUXTC5Fe');
        $resp = $c->execute($req, $access_token = null, "https://oapi.dingtalk.com/gettoken");
        var_dump($resp);
    }
}

$a = new OapiTest();
$a->getAccessToken();



?>