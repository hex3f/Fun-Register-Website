<?php

ini_set("display_errors", "on");

require_once dirname(__DIR__) . '/api_sdk/vendor/autoload.php';
require '../api/encryption.php';

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

// 加载区域结点配置
Config::load();

/**
 * Class SmsDemo
 *
 * 这是短信服务API产品的DEMO程序，直接执行此文件即可体验短信服务产品API功能
 * (只需要将AK替换成开通了云通信-短信服务产品功能的AK即可)
 * 备注:Demo工程编码采用UTF-8
 */
class SmsDemo
{

    static $acsClient = null;

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient($accessKeyId, $accessKeySecret) {
        //产品名称:云通信短信服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if(static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public static function sendSms($phone, $regCode, $SignName, $TemplateCode, $accessKeyId, $accessKeySecret) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($phone);

        $request->setSignName($SignName);
        $request->setTemplateCode($TemplateCode);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "code"=>$regCode,
            "product"=>"dsd"
        ), JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        $request->setOutId("yourOutId");

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        $request->setSmsUpExtendCode("1234567");

        // 发起访问请求
        $acsResponse = static::getAcsClient($accessKeyId, $accessKeySecret)->getAcsResponse($request);

        return $acsResponse;
    }


    /**
     * 短信发送记录查询
     * @return stdClass
     */
    public static function querySendDetails() {

        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，短信接收号码
        $request->setPhoneNumber("18850322821");

        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate("20170718");

        // 必填，分页大小
        $request->setPageSize(10);

        // 必填，当前页码
        $request->setCurrentPage(1);

        // 选填，短信发送流水号
        $request->setBizId("yourBizId");

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }

}

/* object to array */
function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = object_array($value);  
             }  
     }  
     return $array;  
}
/* 生成随机code */
function make_password( $length )
{
    // 密码字符集，可任意添加你需要的字符
    $chars = array('A', 'B', 'C', 'D', 
    'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 
    'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z');
	/*
    $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 
    'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's', 
    't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D', 
    'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 
    'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z', 
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	*/
    // 在 $chars 中随机取 $length 个数组元素键名
    $keys = array_rand($chars, $length); 
    $password = '';
    for($i = 0; $i < $length; $i++)
    {
        // 将 $length 个数组元素连接成字符串
        $password .= $chars[$keys[$i]];
    }
    return $password;
}
/* 发送短信 参数说明：开放发送短信服务、电话号码、签名名称、模板CODE、accessKeyId、accessKeySecret */
function sendsmsto_phone($open_sms_send, $phoneNmber, $code, $SignName, $TemplateCode, $accessKeyId, $accessKeySecret){
	if($open_sms_send){
		set_time_limit(0);
		header('Content-Type: text/plain; charset=utf-8');
		$response = SmsDemo::sendSms($phoneNmber, $code, $SignName, $TemplateCode, $accessKeyId, $accessKeySecret);
		$smsdata = object_array($response);
		
		// 调试
		//print($code);
		//print_r($response);
		//echo $smsdata['Message'];
		//echo $smsdata['Code'];
		//print_r($smsdata);
		
		if($smsdata['Message'] == "OK" || $smsdata['Code'] == "OK"){
			echo "发送成功";
		}else if($smsdata['Message'] == "触发分钟级流控Permits:1" && $smsdata['Code'] == "isv.BUSINESS_LIMIT_CONTROL"){
			echo "一分钟内只能发一条短信";
		}else if($smsdata['Message'] == "触发小时级流控Permits:5" && $smsdata['Code'] == "isv.BUSINESS_LIMIT_CONTROL"){
			echo "一小时内只能发五条短信";
		}else if($smsdata['Message'] == "触发天级流控Permits:10" && $smsdata['Code'] == "isv.BUSINESS_LIMIT_CONTROL"){
			echo "发送次数过多，已异常处理";
		}
	}else{
		echo "发信系统已关闭";
	}
}

function rand_send($phoneNmber,$choice){
	if($choice == "MD5"){
		goto md5_;
	}else if($choice == "CAESARPASSWORD"){
		goto caesar_;
	}else{
		$date = array();
		$code = make_password(10);			//生成十位数的随机字母
		$rand_choiceMethod = rand(0, 1);	//生成随机数 0、1 说明有两种概率

		if($rand_choiceMethod == 0){
			md5_:$codeEncryption = code_md5($code);
			$data[0] = "MD5";
			$data[1] = $codeEncryption;
			$data[2] = $code;
			return $data;
		}else if($rand_choiceMethod == 1){
			caesar_:$count = str_split($phoneNmber,10);
			$codeEncryption = code_caesar($code,$count[1]);
			$data[0] = "CAESARPASSWORD";
			$data[1] = $codeEncryption;
			$data[2] = $code;
			return $data;
		}else{
			$data[0] = "ERROR";
			$data[1] = $code;
			$data[2] = $code;
			return $data;
		}
	}
}
