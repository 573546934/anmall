<?php

/*全局函数方法*/

function addLog($data = [])
{
    \App\Models\Log::create($data);
}
function getIp(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "无法获取！";
    }
    return $cip;
}
function getIpAd()
{
    $url ='http://ip.taobao.com/service/getIpInfo.php?ip=' ;
    $ip = getIp();
    $path = $url . $ip;
    $res = file_get_contents($path);
    $res = json_decode($res);
    $str = 'ip:'.$ip.'地址:'.$res->data->region.$res->data->city;
    return $str;
}
//三维数组转换二维数组
function arrayToArr($array){
    $arr = [];
    foreach ($array as $v){
        $arr[$v['date']] = $v['value'];
    }
    return $arr;
}
//三维数组转换二维数组 订单用
function arrayToArr2($array){
    $arr = [];
    foreach ($array as $v){
        $arr[$v['date']] = ['num'=>$v['num'],'money'=>(float) $v['money']];
    }
    return $arr;
}

function base64_image_content($base64_image_content,$path)
{
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        $new_file = $path . "/" . date('Ymd', time()) . "/";
        if (!file_exists($new_file)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $new_file = $new_file . time() . ".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            return '/' . $new_file;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 计算两点地理坐标之间的距离
 * @param  Decimal $longitude1 起点经度
 * @param  Decimal $latitude1  起点纬度
 * @param  Decimal $longitude2 终点经度
 * @param  Decimal $latitude2  终点纬度
 * @param  Int     $unit       单位 1:米 2:公里
 * @param  Int     $decimal    精度 保留小数位数
 * @return Decimal
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);
    /*
     * // 起点坐标
        $longitude1 = 114.227133;
        $latitude1 = 30.794391;

// 终点坐标
        $longitude2 = 114.199838;
        $latitude2 = 30.768914;

        $distance = getDistance($longitude1, $latitude1, $longitude2, $latitude2, 1);
        echo $distance.'m'; // 2342.38m

        $distance = getDistance($longitude1, $latitude1, $longitude2, $latitude2, 2);
        echo $distance.'km'; // 2.34km

*/

}

//---------------参数加密开始---------------------------------
/**
 * 获取私钥
 * @return bool|resource
 */
function getPrivateKey()
{
    $content = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDONF8NNIFA5RfIFZYYMQYzbgpakBUNwyY58X0Hyyk3Lq+qSftx
88BjWKHYOKfbPMyNiUasrLJjtY+qHEaIGDQ+U0GLkG/M25z2Ff/vFIfjO9ABme1a
ZKSW9guJ9XijzIMmmO0agNpPElv063QuHK5P8U2i3a7KVIgVunbNTr1tfwIDAQAB
AoGBAII5xvHDAAIo7Jz7LQB4LY9bZoSNTA6V+VVMsoaygoQMIvqroHX118GmHwg7
t56YxiJ42L6CjmK0LlfjZZPbnVnAxFmNjTunBWm5g85GQVSNmX2dNiT1Bw2JNfGI
c49dHFvDUVpYOBg2/fKT+y8ggXFOFK/hZOagjryIXIRW/9vBAkEA7WytmdwCyGWL
FIYlDLxli1f9PQ2QeogeonGyCmfGRXNc/YPmOzoniSPTK5KappXSk7GNUxlGgPIq
uVXWR+SIoQJBAN5WZVofn54/Vi46i+/JS+FU7uO5zeP5tKMSZRl91nD9BCPJwe2x
nmpV4RPMJ+u8KG7lvoCgj8YE6UJzV267oh8CQEMmwdMKjx7u2W9soX4AqxfGQzHJ
bFu7tC5tydV3lHSANITfkXae9B+tqkRgqq0DIxPy2+3s8Cv4Um0pAfpDgQECQCOO
q5zTK+LR/EVeZZzOk40Q2TegMnZALAxcV8DQ6Cefvza+AH60BkK5Q0q4PrYrnEfI
BERr6TJg/LD840G5Tj8CQQC+GEuReKp6rWU1I3HM8Uak+sfVBh8iooYucTKnyufi
rmz2gL1H4xzSBPYTa9/T6xJg2hRJCpwvXXV8g5yJXoD7
-----END RSA PRIVATE KEY-----';
    return openssl_pkey_get_private($content);
}

/**
 * 获取公钥
 * @return bool|resource
 */
function getPublicKey()
{
    $content = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDONF8NNIFA5RfIFZYYMQYzbgpa
kBUNwyY58X0Hyyk3Lq+qSftx88BjWKHYOKfbPMyNiUasrLJjtY+qHEaIGDQ+U0GL
kG/M25z2Ff/vFIfjO9ABme1aZKSW9guJ9XijzIMmmO0agNpPElv063QuHK5P8U2i
3a7KVIgVunbNTr1tfwIDAQAB
-----END PUBLIC KEY-----';
    return openssl_pkey_get_public($content);
}

/**
 * 私钥加密
 * @param string $data
 * @return null|string
 */
function privEncrypt($data = '')
{
    if (!is_string($data)) {
        return null;
    }
    return openssl_private_encrypt($data,$encrypted,getPrivateKey()) ? base64_encode($encrypted) : null;
}

/**
 * 公钥加密
 * @param string $data
 * @return null|string
 */
function publicEncrypt($data = '')
{
    if (!is_string($data)) {
        return null;
    }
    return openssl_public_encrypt($data,$encrypted,getPublicKey()) ? base64_encode($encrypted) : null;
}

/**
 * 私钥解密
 * @param string $encrypted
 * @return null
 */
function privDecrypt($encrypted = '')
{
    if (!is_string($encrypted)) {
        return null;
    }
    return (openssl_private_decrypt(base64_decode($encrypted), $decrypted,getPrivateKey())) ? $decrypted : null;
}

/**
 * 公钥解密
 * @param string $encrypted
 * @return null
 */
function publicDecrypt($encrypted = '')
{
    if (!is_string($encrypted)) {
        return null;
    }
    return (openssl_public_decrypt(base64_decode($encrypted), $decrypted,getPublicKey())) ? $decrypted : null;
}
//-----------参数加密结束-----------------------------
/**
 * 小数转百分号
 * */
function strToNum($num1,$num2)
{
    $num = $num1-$num2;
    if($num2 == 0){
        $str = $num*100;
    }else {
        $str = round($num / $num2 * 100, 2);
    }
    $str1=$str."%";
    return $str;
}

//拼接图片url
function getImage($image)
{
    return '/'.$image->save_path.'/'.$image->save_name;
}
function bindImages($data,$name='thumb')
{
    if($data['data']){
        foreach ($data['data'] as $k=>$v){
            if (!empty($v[$name])){
                $data['data'][$k][$name]['url'] = getImage($v[$name]);
            }
        }
    }
    return $data;
}
