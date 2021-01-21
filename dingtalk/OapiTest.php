<?php
namespace Oapi;
include "./vendor/autoload.php";
use Cool\DingTalking\DingTalkClient;
use Cool\DingTalking\DingTalkConstant;
use Cool\DingTalking\request\OapiMediaUploadRequest;
date_default_timezone_set('Asia/Shanghai');

class OapiTest{
    public function __construct()
    {

    }

    public function test()
    {
        echo DingTalkConstant::$CALL_TYPE_OAPI;die;
        $c = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_POST , DingTalkConstant::$FORMAT_JSON);
        $req = new OapiMediaUploadRequest;
        $req->setType("image");
        $req->setMedia(array('type'=>'application/octet-stream','filename'=>'image.png', 'content' => file_get_contents('/Users/test/image.png')));
        $resp=$c->execute($req, "******","https://oapi.dingtalk.com/media/upload");
        var_dump($resp);
    }
}

$a = new OapiTest();
$a->test();



?>