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
namespace Cool\DingTalking;
class CurlClient{

    protected $url;
    protected $query;
    protected $body;
    protected $method;
    protected $response;
    protected $post_file = false;

    public function __construct($url,$method,$query,$body)
    {
        $this->url = $url;
        $this->method = $method;
        $this->query = $query;
        $this->body = $body;
    }

    /**
     * 执行请求
     */
    public function execute()
    {
        switch ($this->method)
        {
            case "GET":
                $this->response = $this->curlGet();
                break;
            case "POST":
                $this->response = $this->curlPost();
                break;
            default:
                break;
        }
        return $this->response;
    }

    private  function curlGet()
    {
        $url = $this->url.'?'.http_build_query($this->query);
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    /**
     * POST 请求
     * @return string content
     */
    private function curlPost(){
        $url = $this->url.'?'.http_build_query($this->query);
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($this->body) || $this->post_file) {
            $strPOST = $this->body;
        } else{
            $strPOST = http_build_query($this->body);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    /**
     * @param $url
     * @return bool|mixed
     */
    public static function getXml($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        $xml = simplexml_load_string($sContent);
        if($xml){
            return $xml;
        }else{
            return false;
        }


    }


    private function getCurlFileMedia($file_path){
        if (class_exists('\CURLFile')) {// 这里用特性检测判断php版本
            $data =  new \CURLFile($file_path,"","");//>=5.5
        } else {
            $data =  '@' . $file_path;//<=5.5
        }
        return $data;

    }
    private function  curlFile($url,$data){
        // 兼容性写法参考示例
        $curl = curl_init();
        if (class_exists('\CURLFile')) {// 这里用特性检测判断php版本
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);

        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT,"TEST");
        $result = curl_exec($curl);
        //    $error = curl_error($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if(intval($status["http_code"])==200){
            return $result;
        }else{
            return false;
        }
    }


    /**
     * 生成安全JSON数据
     * @param array $array
     * @return string
     */
    private function jsonEncode($array)
    {
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), json_encode($array));
    }

    private function  curlDownload($url, $dir)
    {
        $ch = curl_init($url);
        $fp = fopen($dir, "wb");
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $res;
    }

    /**
     * post发送数据，带有header头
     */
    private function curlPostHeader($url,$header,$content)
    {
        $ch = curl_init();
        if(substr($url,0,5)=='https'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        $response = curl_exec($ch);
        if($error=curl_error($ch)){
            die($error);
        }
        curl_close($ch);
        //var_dump($response);
        return $response;
    }
}