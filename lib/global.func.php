<?php
   	 /**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}
/*daixy add 获取随机码*/
function getfourStr($len){
    $chars_array = array(
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
        "S", "T", "U", "V", "W", "X", "Y", "Z",
    );
    $charsLen = count($chars_array) - 1;

    $outputstr = "";
    for ($i=0; $i<$len; $i++)
    {
        $outputstr .= $chars_array[mt_rand(0, $charsLen)];
    }
    return $outputstr;
}
function sendsms($key,$mobile,$tpl_id,$tpl_value){
	$sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
 $message[]=array();
$smsConf = array(
    'key'   =>$key, //您申请的APPKEY
    'mobile'    => $mobile, //接受短信的用户手机号码
    'tpl_id'    => $tpl_id, //您申请的短信模板ID，根据实际情况修改
    'tpl_value' =>$tpl_value //您设置的模板变量，根据实际情况修改
);

$content = juhecurl($sendUrl,$smsConf,1); //请求发送短信

if($content){
    $result = json_decode($content,true);
    $error_code = $result['error_code'];
    if($error_code == 0){
    	$message['errorcode']=0;
        //状态为0，说明短信发送成功
      //  echo "短信发送成功,短信ID：".$result['result']['sid'];
        
        $message['msg']=$result['result']['sid'];
    }else{
        //状态非0，说明失败
        	$message['errorcode']=1;
        $msg = $result['reason'];
         $message['msg']=$msg;
        //echo "短信发送失败(".$error_code.")：".$msg;
    }
}else{
    //返回内容异常，以下可根据业务逻辑自行修改
   // echo "请求发送短信失败";
   $message['errorcode']=1;
       
         $message['msg']='请求发送短信失败';
}
	return $message;
}
/**
 * DZ在线中文分词
 * @param $title string 进行分词的标题
 * @param $content string 进行分词的内容
 * @param $encode string API返回的数据编码
 * @return  array 得到的关键词数组
 */
 function dz_segment($title = '', $content = '', $encode = 'utf-8'){
    if($title == ''){
        return false;
    }
    $title = rawurlencode(strip_tags($title));
    $content = strip_tags($content);
    if(strlen($content)>2400){ //在线分词服务有长度限制
        $content =  mb_substr($content, 0, 800, $encode);
    }
    $content = rawurlencode($content);
    $url = 'http://keyword.discuz.com/related_kw.html?title='.$title.'&content='.$content.'&ics='.$encode.'&ocs='.$encode;
    $xml_array=simplexml_load_file($url);                        //将XML中的数据,读取到数组对象中  
    $result = $xml_array->keyword->result;
    $data = array();
    foreach ($result->item as $key => $value) {
            array_push($data, (string)$value->kw);
    }
    if(count($data) > 0){
        return $data;
    }else{
        return false;
    }
 }
  function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
  }
 
/* 根据用户UID获得用户头像地址 */

function get_avatar_dir($uid) {
    global $setting;
    if ($setting['ucenter_open']) {
        return $setting['ucenter_url'] . '/avatar.php?uid=' . $uid . '&size=middle';
    } else {
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        $avatar_dir = "data/avatar/" . $dir1 . '/' . $dir2 . '/' . $dir3 . "/small_" . $uid;
        if (file_exists($avatar_dir . ".jpg"))
            return SITE_URL . $avatar_dir . ".jpg";
        if (file_exists($avatar_dir . ".jepg"))
            return SITE_URL . $avatar_dir . ".jepg";
        if (file_exists($avatar_dir . ".gif"))
            return SITE_URL . $avatar_dir . ".gif";
        if (file_exists($avatar_dir . ".png"))
            return SITE_URL . $avatar_dir . ".png";
    }
//显示系统默认头像
    return SITE_URL . '/static/css/default/avatar.gif';
}
/* 根据分类cid获得封面图地址 */

function get_cid_dir($cid,$type='big') {
 
       
        $cid = sprintf("%09d", $cid);
        $dir1 = substr($cid, 0, 3);
        $dir2 = substr($cid, 3, 2);
        $dir3 = substr($cid, 5, 2);
        $avatar_dir = "data/category/" . $dir1 . '/' . $dir2 . '/' . $dir3 . "/".$type."_" . $cid;
      
        if (file_exists($avatar_dir . ".jpg"))
            return SITE_URL . $avatar_dir . ".jpg";
        if (file_exists($avatar_dir . ".jepg"))
            return SITE_URL . $avatar_dir . ".jepg";
        if (file_exists($avatar_dir . ".gif"))
            return SITE_URL . $avatar_dir . ".gif";
        if (file_exists($avatar_dir . ".png"))
            return SITE_URL . $avatar_dir . ".png";
  
//显示系统默认分类图片地址
    return SITE_URL . '/static/images/defaulticon.jpg';
}
/* 伪静态和html纯静态可以同时存在 */

function url($var, $url = '') {
    global $setting;
    // exit($var);
    $location = '?' . $var . $setting['seo_suffix'];
    if ((false === strpos($var, 'admin_')) && $setting['seo_on']) {
        $location = $var . $setting['seo_suffix'];
    }
   
    $location = urlmap($location, 2);
    return SITE_URL . $location; //程序动态获取的，给question的model使用

}

/* url转换器，1为请求转换，就是把类似q-替换为question/view
  2为反向转换，就是把类似/question/view/替换为q-
 */

function urlmap($var, $direction = 1) {
	
    $url_routes = array(
    'buy_detail'=>'buy/buydetail/',
     'topictag-'=>'topic/search/',
        'tag-'=>'question/search/',
         'q='=>'question/search/',
        'new-' => 'new/default/',
   'tags-'=>'tags/default/',
        'q-' => 'question/view/',
        'c-' => 'category/view/',
        'l-' => 'category/list/',
        'r-' => 'category/recommend/',
        'u-' => 'user/space/',
        'ua-'=>'user/space_answer/',
     'uask-'=>'user/space_ask/',
      'article-'=>'topic/getone/',
     'cat-'=>'topic/catlist/',
    'ut-'=>'topic/userxinzhi/',
        'us-' => 'user/scorelist/',
    );

    (2 == $direction) && $url_routes = array_flip($url_routes);
    foreach ($url_routes as $mapkey => $route) {
        if (false !== strpos($var, $mapkey)) {
        	$url=str_replace($mapkey, $route, $var);
        	
            return $url;
        }
    }
  
    return $var;
}

/**
 * random
 * @param int $length
 * @return string $hash
 */
function random($length = 6, $type = 0) {
    $hash = '';
    $chararr = array(
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz',
        '0123456789',
        '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'
    );
    $chars = $chararr[$type];
    $max = strlen($chars) - 1;
    PHP_VERSION < '4.2.0' && mt_srand((double) microtime() * 1000000);
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

function cutstr($string, $length, $dot = '...') {
    if (strlen($string) <= $length) {
        return $string;
    }
    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
    $strcut = '';
    if(ASK2_CHARSET==null){
    	define('ASK2_CHARSET', 'utf-8');
    }
    if (strtolower(ASK2_CHARSET) == 'utf-8'||strtolower(ASK2_CHARSET) == 'utf-8') {
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for ($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
        }
    }
    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
    return $strcut . $dot;
}

function generate_key() {
    $random = random(20);
    $info = md5($_SERVER['SERVER_SOFTWARE'] . $_SERVER['SERVER_NAME'] . $_SERVER['SERVER_ADDR'] . $_SERVER['SERVER_PORT'] . $_SERVER['HTTP_USER_AGENT'] . time());
    $return = '';
    for ($i = 0; $i < 64; $i++) {
        $p = intval($i / 2);
        $return[$i] = $i % 2 ? $random[$p] : $info[$p];
    }
    return implode('', $return);
}

/**
 * getip
 * @return string
 */
function getip() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return $ip;
}

//百度推送
function baidusend($api,$array_urls){
	if($api==''){
		return "";
	}
	$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $array_urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
return $result;
}
//格式化前端IP显示
function formatip($ip, $type = 1) {
    if (strtolower($ip) == 'unknown') {
        return false;
    }
    if ($type == 1) {
        $ipaddr = substr($ip, 0, strrpos($ip, ".")) . ".*";
    }
    return $ipaddr;
}

function forcemkdir($path) {
    if (!file_exists($path)) {
        forcemkdir(dirname($path));
        mkdir($path, 0777);
    }
}

function cleardir($dir, $forceclear = false) {
    if (!is_dir($dir)) {
        return;
    }
    $directory = dir($dir);
    while ($entry = $directory->read()) {
        $filename = $dir . '/' . $entry;
        if (is_file($filename)) {
            @unlink($filename);
        } elseif (is_dir($filename) && $forceclear && $entry != '.' && $entry != '..') {
            chmod($filename, 0777);
            cleardir($filename, $forceclear);
            rmdir($filename);
        }
    }
    $directory->close();
}

function iswriteable($file) {
    $writeable = 0;
    if (is_dir($file)) {
        $dir = $file;
        if ($fp = @fopen("$dir/test.txt", 'w')) {
            @fclose($fp);
            @unlink("$dir/test.txt");
            $writeable = 1;
        }
    } else {
        if ($fp = @fopen($file, 'a+')) {
            @fclose($fp);
            $writeable = 1;
        }
    }
    return $writeable;
}
      //检查特殊字符函数
    function has_special_char($str){
    	
    	if(strlen($str)<3){
    		return false;
    	}
     if(preg_match("/[\',.@-_:。【】;*?~`!#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$str)){ 
       return true;
}else{
	return false;
}
    }
function readfromfile($filename) {
    if ($fp = @fopen($filename, 'rb')) {
        if (PHP_VERSION >= '4.3.0' && function_exists('file_get_contents')) {
            return file_get_contents($filename);
        } else {
            flock($fp, LOCK_EX);
            $data = fread($fp, filesize($filename));
            flock($fp, LOCK_UN);
            fclose($fp);
            return $data;
        }
    } else {
        return '';
    }
}

function writetofile($filename, &$data) {
    if ($fp = @fopen($filename, 'wb')) {
        if (PHP_VERSION >= '4.3.0' && function_exists('file_put_contents')) {
            return @file_put_contents($filename, $data);
        } else {
            flock($fp, LOCK_EX);
            $bytes = fwrite($fp, $data);
            flock($fp, LOCK_UN);
            fclose($fp);
            return $bytes;
        }
    } else {
        return 0;
    }
}

function extname($filename) {
    $pathinfo = pathinfo($filename);
    return strtolower($pathinfo['extension']);
}

function taddslashes($string, $force = 0) {
    if (!MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = taddslashes($val, $force);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}

/* XSS 检测 */

function checkattack($reqarr, $reqtype = 'post') {
    $filtertable = array(
        'get' => '\'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)',
        'post' => '\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)',
        'cookie' => '\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)'
    );
 

    foreach ($reqarr as $reqkey => $reqvalue) {
    	
    	if(is_array($reqvalue)){
    		
    		checkattack($reqvalue,$reqtype);
    	}
    	
        if (preg_match("/" . $filtertable[$reqtype] . "/is", $reqvalue) == 1 && !in_array($reqkey, array('content'))) {
            print('Illegal operation!');
            exit(-1);
        }
     
     
    }
      
  
  
}

function tstripslashes($string) {
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = tstripslashes($val);
        }
    } else {
        $string = stripslashes($string);
    }
    return $string;
}

function template($file, $tpldir = '') {
    global $setting;
//strstr($setting['wap_domain'], $_SERVER['HTTP_HOST'])
 if(is_mobile()|| $setting['wap_domain']==$_SERVER['HTTP_HOST']){
 	
    	$tpldir=$setting['tpl_wapdir'];
    	
    }
    $tpldir = ('' == $tpldir) ? $setting['tpl_dir'] : $tpldir;
    $tplfile = ASK2_APP_ROOT . '/view/' . $tpldir . '/' . $file . '.html';
    
    $objfile = ASK2_ROOT . '/data/view/' . $tpldir . '_' . $file . '.tpl.php';
    if ('default' != $tpldir && !is_file($tplfile)) {
    	
        $tplfile = ASK2_APP_ROOT . '/view/zui/' . $file . '.html';
        $objfile = ASK2_ROOT . '/data/view/zui_' . $file . '.tpl.php';
    }
    if (!file_exists($objfile) || (@filemtime($tplfile) > @filemtime($objfile))) {
        require_once ASK2_ROOT . '/lib/template.func.php';
        parse_template($tplfile, $objfile);
    }
    return $objfile;
}

function timeLength($time) {
    $length = '';
    if ($day = floor($time / (24 * 3600))) {
        $length .= $day . '天';
    }
    if ($hour = floor($time % (24 * 3600) / 3600)) {
        $length .= $hour . '小时';
    }
    if ($day == 0 && $hour == 0) {
        $length = floor($time / 60) . '分';
    }
    return $length;
}

/* 验证码生成 */

function makecode($code, $width = 80, $height = 28, $quality = 3) {
    $fontcfg = array('spacing' => 2);
    $fontfile = ASK2_STATIC_ROOT . '/css/default/ninab.ttf';
    $fontcolors = array(array(27, 78, 181), array(22, 163, 35), array(214, 36, 7), array(88, 127, 30), array(66, 133, 244), array(241, 147, 0), array(232, 0, 0), array(196, 146, 1));
    $im = imagecreatetruecolor($width * $quality, $height * $quality);
    $imbgcolor = imagecolorallocate($im, 255, 255, 255);
    imagefilledrectangle($im, 0, 0, $width * $quality, $height * $quality, $imbgcolor);

    $lettersMissing = 4 - strlen($code);
    $fontSizefactor = 0.9 + ($lettersMissing * 0.09);
    $x = 4 * $quality;
    $y = round(($height * 27 / 32) * $quality);
    $length = strlen($code);
     $degree = rand(8 * -1, 8);
      $fontsize = 22 * $quality * $fontSizefactor;
         
      //雪花
  for ($i=0;$i<10;$i++) {
   $color = imagecolorallocate($im,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
  // imagestring($im,mt_rand(1,5),mt_rand(0,$lwidth),mt_rand(0,$lwidth),'a',$color);
   imagettftext($im, $fontsize, $degree, $i*30, $y-$i*2, $color, $fontfile, mt_rand(1,9));
     
  }
    for ($i = 0; $i < $length; $i++) {
     
       $color = $fontcolors[mt_rand(0, sizeof($fontcolors) - 1)];
        $imbgcolor = imagecolorallocate($im, $color[0], $color[1], $color[2]);
       
        $letter = substr($code, $i, 1);
        $coords = imagettftext($im, $fontsize, $degree, $x, $y, $imbgcolor, $fontfile, $letter);
        $x += ($coords[2] - $x) + ($fontcfg['spacing'] * $quality);
    }
    $x1 = $width * $quality * .15;
    $x2 = $x;
    $y1 = rand($height * $quality * .40, $height * $quality * .65);
    $y2 = rand($height * $quality * .40, $height * $quality * .65);
    $lwidth = 0.5 * $quality;
    for ($i = $lwidth * -1; $i <= $lwidth; $i++) {
       // imageline($im, $x1, $y1 + $i, $x2, $y2 + $i, $imbgcolor);
       //  imageline($im, $x1+3, $y1 + $i, $x2+5, $y2 + $i, $imbgcolor);
          imageline($im, $x1+9, $y1 + $i, $x2+10, $y2 + $i, $imbgcolor);
    }

    $imResampled = imagecreatetruecolor($width, $height);
    imagecopyresampled($imResampled, $im, 0, 0, 0, 0, $width, $height, $width * $quality, $height * $quality);
    imagedestroy($im);
    $im = $imResampled;
    header("Content-type: image/jpeg");
    imagejpeg($im, null, 80);
    imagedestroy($im);
}

/* 通用php加解密函数 */

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    global $setting;
    $ckey_length = 4;
    $key = md5($key ? $key : $setting['auth_key']);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}
function encode($string = '', $skey = 'mishen') {
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key < $strCount && $strArr[$key].=$value;
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
 }
function decode($string = '', $skey = 'mishen') {
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    return base64_decode(join('', $strArr));
 }
 
/* 日期格式显示 */

function tdate($time, $type = 3, $friendly = 1) {
    global $setting;
    ($setting['time_friendly'] != 1) && $friendly = 0;
    $format[] = $type & 2 ? (!empty($setting['date_format']) ? $setting['date_format'] : 'Y-n-j') : '';
    $format[] = $type & 1 ? (!empty($setting['time_format']) ? $setting['time_format'] : 'H:i') : '';
    $timeoffset = $setting['time_offset'] * 3600 + $setting['time_diff'] * 60;
    $timestring = gmdate(implode(' ', $format), $time + $timeoffset);
    if ($friendly) {
        $time = time() - $time;
        if ($time <= 24 * 3600) {
            if ($time > 3600) {
                $timestring = intval($time / 3600) . '小时前';
            } elseif ($time > 60) {
                $timestring = intval($time / 60) . '分钟前';
            } elseif ($time > 0) {
                $timestring = $time . '秒前';
            } else {
                $timestring = '现在前';
            }
        }else if($time <= 72 * 3600){
          
                $timestring = intval($time / (24*3600)) . '天前';
            
        }
    }
   return str_replace('/','-' ,$timestring);
}

/* cookie设置和读取 */

function tcookie($var, $value = 0, $life = 0) {
    global $setting;
    $cookiepre = $setting['cookie_pre'] ? $setting['cookie_pre'] : 't_';
    if (0 === $value) {
        $ret = isset($_COOKIE[$cookiepre . $var]) ? $_COOKIE[$cookiepre . $var] : '';
        checkattack($var, 'cookie');
        return $ret;
    } else {
        $domain = $setting['cookie_domain'] ? $setting['cookie_domain'] : '';
        checkattack($var, 'cookie');
        setcookie($cookiepre . $var, $value, $life ? time() + $life : 0, '/', $domain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
    }
}

/* 日志记录 */

function runlog($file, $message, $halt = 0) {
    $nowurl = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
    $log = date($_SERVER['REQUEST_TIME'], 'Y-m-d H:i:s') . "\t" . $_SERVER['REMOTE_ADDR'] . "\t{$nowurl}\t" . str_replace(array("\r", "\n"), array(' ', ' '), trim($message)) . "\n";

    $yearmonth = gmdate('Ym', $_SERVER['REQUEST_TIME']);
    $logdir = ASK2_ROOT . '/data/logs/';
    if (!is_dir($logdir))
        mkdir($logdir, 0777);
    $logfile = $logdir . $yearmonth . '_' . $file . '.php';
    if (@filesize($logfile) > 2048000) {
        $dir = opendir($logdir);
        $length = strlen($file);
        $maxid = $id = 0;
        while ($entry = readdir($dir)) {
            if (strstr($entry, $yearmonth . '_' . $file)) {
                $id = intval(substr($entry, $length + 8, -4));
                $id > $maxid && $maxid = $id;
            }
        }
        closedir($dir);
        $logfilebak = $logdir . $yearmonth . '_' . $file . '_' . ($maxid + 1) . '.php';
        @rename($logfile, $logfilebak);
    }
    if ($fp = @fopen($logfile, 'a')) {
        @flock($fp, 2);
        fwrite($fp, "<?PHP exit;?>\t" . str_replace(array('<?', '?>', "\r", "\n"), '', $log) . "\n");
        fclose($fp);
    }
   
    if ($halt)
        exit();
}
/* wecenter翻页函数 */

function wepage($num, $perpage, $curpage, $operation, $ajax = 0) {
    global $setting;
    $multipage = '';
    $operation = urlmap($operation, 2);
    $mpurl="";
     if(strpos($operation, 'new-')!==false||strpos($operation, 'tags-')!==false){
     	$mpurl = SITE_URL . $setting['seo_prefix'] . $operation ;
     }else{
     	
     	$mpurl = SITE_URL . $setting['seo_prefix'] . $operation . '/';
     }
    
    ('admin' == substr($operation, 0, 5)) && ( $mpurl = 'index.php?' . $operation . '/');
   
    if ($num > $perpage) {
        $page = 8;
        $offset = 2;
        $pages = @ceil($num / $perpage);
        if ($page > $pages) {
            $from = 1;
            $to = $pages;
        } else {
            $from = $curpage - $offset;
            $to = $from + $page - 1;
            if ($from < 1) {
                $to = $curpage + 1 - $from;
                $from = 1;
                if ($to - $from < $page) {
                    $to = $page;
                }
            } elseif ($to > $pages) {
                $from = $pages - $page + 1;
                $to = $pages;
            }
        }
        if (!$ajax) {
            $multipage = ($curpage - $offset > 1 && $pages > $page ? '<li><a  class="n" href="' . $mpurl . '1' . $setting['seo_suffix'] . '" >首页</a></li>' . "\n" : '') ;
                
            if($curpage > 1){
            	if($curpage-1==1){
            		   $tmpurl=substr($mpurl, 0,strlen($mpurl)-1);
            		    $multipage=$multipage.	 '<li><a href="' . $tmpurl  . $setting['seo_suffix'] . '"  class="n">上一页</a></li>' . "\n";
            	}else{
            		 $multipage=$multipage.	 '<li><a href="' . $mpurl . ($curpage - 1) . $setting['seo_suffix'] . '"  class="n">上一页</a></li>' . "\n";
            	}
           
            }else{
            	 
            }
            
                   

            
                    
                    for ($i = $from; $i <= $to; $i++) {
                    	if($i==1){
                    	
    	$tmpurl=substr($mpurl, 0,strlen($mpurl)-1);
    
                    		
                    		$multipage .= $i == $curpage ? "<li class=\"active\"><a href=\"javascript:;\">$i</a></li>\n" :
                        '<li><a href="' . $tmpurl  . $setting['seo_suffix'] . '">' . $i . '</a></li>' . "\n";
                    	}else{
                    		$multipage .= $i == $curpage ? "<li class=\"active\"><a href=\"javascript:;\">$i</a></li>\n" :
                        '<li><a href="' . $mpurl . $i . $setting['seo_suffix'] . '">' . $i . '</a></li>' . "\n";
                    	}
                
            }
            $multipage .= ( $curpage < $pages ? '<li><a class="n" href="' . $mpurl . ($curpage + 1) . $setting['seo_suffix'] . '">下一页</a></li>' . "\n" : '') .
                    ($to < $pages ? '<li><a class="n" href="' . $mpurl . $pages . $setting['seo_suffix'] . '" >最后一页</a></li>' . "\n" : '');
        } else {
            $multipage = '';
            if ($curpage < $pages){
            	$multipage = '<li><a href="' . $mpurl . ($curpage + 1) . $setting['seo_suffix'] . '">查看更多</a></li>';
            }
                
        }
    }
   
    return $multipage;
}
/* 翻页函数 */

function page($num, $perpage, $curpage, $operation, $ajax = 0) {
    global $setting;
    $multipage = '';
    $operation = urlmap($operation, 2);
    $mpurl="";
     if(strpos($operation, 'new-')!==false||strpos($operation, 'tags-')!==false){
     	$mpurl = SITE_URL . $setting['seo_prefix'] . $operation ;
     }else{
     	
     	$mpurl = SITE_URL . $setting['seo_prefix'] . $operation . '/';
     }
    
    ('admin' == substr($operation, 0, 5)) && ( $mpurl = 'index.php?' . $operation . '/');
   
    if ($num > $perpage) {
        $page = 8;
        $offset = 2;
        $pages = @ceil($num / $perpage);
        if ($page > $pages) {
            $from = 1;
            $to = $pages;
        } else {
            $from = $curpage - $offset;
            $to = $from + $page - 1;
            if ($from < 1) {
                $to = $curpage + 1 - $from;
                $from = 1;
                if ($to - $from < $page) {
                    $to = $page;
                }
            } elseif ($to > $pages) {
                $from = $pages - $page + 1;
                $to = $pages;
            }
        }
        if (!$ajax) {
            $multipage = ($curpage - $offset > 1 && $pages > $page ? '<a  class="n" href="' . $mpurl . '1' . $setting['seo_suffix'] . '" >首页</a>' . "\n" : '') ;
                
            if($curpage > 1){
            	if($curpage-1==1){
            		   $tmpurl=substr($mpurl, 0,strlen($mpurl)-1);
            		    $multipage=$multipage.	 '<a href="' . $tmpurl  . $setting['seo_suffix'] . '"  class="n">上一页</a>' . "\n";
            	}else{
            		 $multipage=$multipage.	 '<a href="' . $mpurl . ($curpage - 1) . $setting['seo_suffix'] . '"  class="n">上一页</a>' . "\n";
            	}
           
            }else{
            	 
            }
            
                   

                 
                    
                    for ($i = $from; $i <= $to; $i++) {
                    	if($i==1){
                    	
    	$tmpurl=substr($mpurl, 0,strlen($mpurl)-1);
    
                    		
                    		$multipage .= $i == $curpage ? "<strong>$i</strong>\n" :
                        '<a href="' . $tmpurl  . $setting['seo_suffix'] . '">' . $i . '</a>' . "\n";
                    	}else{
                    		$multipage .= $i == $curpage ? "<strong>$i</strong>\n" :
                        '<a href="' . $mpurl . $i . $setting['seo_suffix'] . '">' . $i . '</a>' . "\n";
                    	}
                
            }
            $multipage .= ( $curpage < $pages ? '<a class="n" href="' . $mpurl . ($curpage + 1) . $setting['seo_suffix'] . '">下一页</a>' . "\n" : '') .
                    ($to < $pages ? '<a class="n" href="' . $mpurl . $pages . $setting['seo_suffix'] . '" >最后一页</a>' . "\n" : '');
        } else {
            $multipage = '';
            if ($curpage < $pages){
            	$multipage = '<a href="' . $mpurl . ($curpage + 1) . $setting['seo_suffix'] . '">查看更多</a>';
            }
                
        }
    }
   
    return $multipage;
}
/* 二维数组去重 */
function assoc_unique($arr, $key) {
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
    sort($arr); //sort函数对数组进行排序
    return $arr;
}
/* 替换关键词 */

function replacewords($content) {
	
    global $setting, $keyword;
    
  
    	 $articlecontent= $content;
  	 if($keyword!=null){
   $maxindex_keywords=$setting['maxindex_keywords'];
      $pagemaxindex_keywords=$setting['pagemaxindex_keywords'];
//       
//        

      $canreplace=true;
      $kindex=0;
      $urlarray=array();
//         
    	foreach ($keyword as $key=>$val){
    		if($canreplace==false){
    			break;
    		}
    		$word= $keyword[$key]['find'];
    
    		$wordurl="<a style='text-decoration:underline;color:blue;cursor:pointer;' href='".$keyword[$key]['replacement']."'>".$keyword[$key]['find']."</a>";
    	$repstrlen=strlen($word);
    	$rand=random(5);
    	
//    	
  	if($maxindex_keywords!=0){
for($i=0;$i<$maxindex_keywords;$i++){
if($pagemaxindex_keywords!=0){
////    	//如果超过设置的最大值就终止替换

	if($kindex>=$pagemaxindex_keywords){
    		$canreplace=false;
    		break;
   	}
 
   	}
   
	$s_start=strpos($articlecontent,$word);
//	
	if($s_start>0){
//		
   
	array_push($urlarray, array('word'=>$rand,'url'=>$wordurl));
	$keys = 'word';
//	

assoc_unique($urlarray, $keys);
//
		$keyword[$key]['num']=$keyword[$key]['find']+1;
			$firstcontent=substr($articlecontent, 0,$s_start);
//			
			$sec=substr($articlecontent, $s_start+$repstrlen);
//			
			if(trim($firstcontent)!=''){
//				
				$articlecontent=$firstcontent."{#replace_keyword$rand#}".$sec;
			}else{
				$articlecontent="{#replace_keyword$rand#}".$sec;
			}
//			
//			

		$kindex++;
	}
//
//	
//	
}
 	}else{
  		$articlecontent=str_replace($word, $wordurl, $articlecontent);
//    		
 	}
//
	}
    	if($maxindex_keywords!=0){
//    		

    	if(count($urlarray)>0){
    	
   	for($i=0;$i<count($urlarray);$i++){
    		$word=$urlarray[$i]['word'];
    		
    		$url=$urlarray[$i]['url'];
    		 $articlecontent=str_replace("{#replace_keyword$word#}", $url,$articlecontent);
    		 
    		 
////    		
   	}
    	}
    	}
//    	
  }
    	return $articlecontent;
}
/* 过滤关键词 */

function checkwords($content) {
    global $setting, $badword;
    $status = 0;
    $text = $content;
    if (!empty($badword)) {
        foreach ($badword as $word => $wordarray) {
            $replace = $wordarray['replacement'];
            $content = str_replace($word, $replace, $content, $matches);
            if ($matches > 0) {
                '{MOD}' == $replace && $status = 1;
                '{BANNED}' == $replace && $status = 2;
                if ($status > 0) {
                    $content = $text;
                    break;
                }
            }
        }
    }
//$content = str_replace(array("\r\n", "\r", "\n"), '<br />', htmlentities($content));
    return array($status, $content);
}
/* 过滤关键词---字符串 */

function checkwordsglobal($content) {
    global $setting, $badword;
    $status = 0;
    $text = $content;
    if (!empty($badword)) {
        foreach ($badword as $word => $wordarray) {
            $replace = $wordarray['replacement'];
            $content = str_replace($word, $replace, $content, $matches);
            if ($matches > 0) {
                '{MOD}' == $replace && $status = 1;
                '{BANNED}' == $replace && $status = 2;
                if ($status > 0) {
                    $content = $text;
                    break;
                }
            }
        }
    }
//$content = str_replace(array("\r\n", "\r", "\n"), '<br />', htmlentities($content));
    return $content;
}
/* http请求 */

function topen($url, $timeout = 15, $post = '', $cookie = '', $limit = 0, $ip = '', $block = TRUE) {
    $return = '';
   
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;
    if ($post) {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
//$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: ' . strlen($post) . "\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    } else {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
//$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if (!$fp) {
        return '';
    } else {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if (!$status['timed_out']) {
            while (!feof($fp)) {
                if (($header = @fgets($fp)) && ($header == "\r\n" || $header == "\n")) {
                    break;
                }
            }
            $stop = false;
            while (!feof($fp) && !$stop) {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if ($limit) {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

/* 发送邮件 */
function sendmail($touser, $subject, $message, $from = '') {
    global $setting;
    $toemail = $touser['email'];
    if (!$toemail || $toemail == 'null')
        return false;
    $tousername = $touser['username'];
    $message = <<<EOT
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>$subject</title>
		</head>
		<body>
		hi, $tousername<br>
            $subject<br>
            $message<br>
		这封邮件由系统自动发送，请不要回复。
		</body>
		</html>
EOT;
  require 'email.class.php';
   //******************** 配置信息 ********************************
	$smtpserver =$setting['mailserver'];// "smtp.163.com";//SMTP服务器
	$smtpserverport =$setting['mailport'];//SMTP服务器端口
	$smtpusermail = $setting['mailfrom'];//SMTP服务器的用户邮箱
	$smtpemailto = $toemail;//发送给谁
	$smtpuser = $setting['mailauth_username'];//SMTP服务器的用户帐号
	$smtppass = $setting['mailauth_password'];//SMTP服务器的用户密码
	$mailtitle = $subject;//邮件主题
	$mailcontent = $message;//邮件内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,false,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
            
}
/* 发送邮件 */
function sendmailto($toemail, $subject, $message,$tousername='', $from = '') {
    global $setting;
 
    if (!$toemail || $toemail == 'null')
        return false;
    
            if (!$tousername || $tousername == 'null'){
            	$tousername=$toemail;
            }
    $message = <<<EOT
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>$subject</title>
		</head>
		<body>
		hi, $tousername<br>
            $subject<br>
            $message<br>
		这封邮件由系统自动发送，请不要回复。
		</body>
		</html>
EOT;
  require 'email.class.php';
   //******************** 配置信息 ********************************
	$smtpserver =$setting['mailserver'];// "smtp.163.com";//SMTP服务器
	$smtpserverport =$setting['mailport'];//SMTP服务器端口
	$smtpusermail = $setting['mailfrom'];//SMTP服务器的用户邮箱
	$smtpemailto = $toemail;//发送给谁
	$smtpuser = $setting['mailauth_username'];//SMTP服务器的用户帐号
	$smtppass = $setting['mailauth_password'];//SMTP服务器的用户密码
	$mailtitle = $subject;//邮件主题
	$mailcontent = $message;//邮件内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,false,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
    return    $state;     
}

function sendmailbk($touser, $subject, $message, $from = '') {
    global $setting;
    $toemail = $touser['email'];
    if (!$toemail || $toemail == 'null')
        return false;
    $tousername = $touser['username'];
    $message = <<<EOT
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>$subject</title>
		</head>
		<body>
		hi, $tousername<br>
            $subject<br>
            $message<br>
		这封邮件由系统自动发送，请不要回复。
		</body>
		</html>
EOT;

    $maildelimiter = $setting['maildelimiter'] == 1 ? "\r\n" : ($setting['maildelimiter'] == 2 ? "\r" : "\n");
    $mailusername = isset($setting['mailusername']) ? $setting['mailusername'] : 1;
    $mailserver = $setting['mailserver'];
    $mailport = $setting['mailport'] ? $setting['mailport'] : 25;
    $mailsend = $setting['mailsend'] ? $setting['mailsend'] : 1;

    if ($mailsend == 3) {
        $email_from = empty($from) ? $setting['maildefault'] : $from;
    } else {
        $email_from = $from == '' ? '=?' . ASK2_CHARSET . '?B?' . base64_encode($setting['site_name']) . "?= <" . $setting['maildefault'] . ">" : (preg_match('/^(.+?) \<(.+?)\>$/', $from, $mats) ? '=?' . ASK2_CHARSET . '?B?' . base64_encode($mats[1]) . "?= <$mats[2]>" : $from);
    }
    $email_to = preg_match('/^(.+?) \<(.+?)\>$/', $toemail, $mats) ? ($mailusername ? '=?' . ASK2_CHARSET . '?B?' . base64_encode($mats[1]) . "?= <$mats[2]>" : $mats[2]) : $toemail;
    $email_subject = '=?' . ASK2_CHARSET . '?B?' . base64_encode(preg_replace("/[\r|\n]/", '', '[' . $setting['site_name'] . '] ' . $subject)) . '?=';
    $email_message = chunk_split(base64_encode(str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message))))));

    $headers = "From: $email_from{$maildelimiter}X-Priority: 3{$maildelimiter}X-Mailer: Tipask1.0 {$maildelimiter}MIME-Version: 1.0{$maildelimiter}Content-type: text/html; charset=" . ASK2_CHARSET . "{$maildelimiter}Content-Transfer-Encoding: base64{$maildelimiter}";

    if ($mailsend == 1) {
        if (function_exists('mail') && @mail($email_to, $email_subject, $email_message, $headers)) {
            return true;
        }
        return false;
    } elseif ($mailsend == 2) {
        if (!$fp = fsockopen($mailserver, $mailport, $errno, $errstr, 30)) {
            runlog('SMTP', "($mailserver:$mailport) CONNECT - Unable to connect to the SMTP server", 0);
            return false;
        }
        stream_set_blocking($fp, true);
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != '220') {
            runlog('SMTP', "($mailserver:$mailport) CONNECT - $lastmessage", 0);
            return false;
        }

        fputs($fp, ($setting['mailauth'] ? 'EHLO' : 'HELO') . " Tipask\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250) {
            runlog('SMTP', "($mailserver:$mailport) HELO/EHLO - $lastmessage", 0);
            return false;
        }
        while (1) {
            if (substr($lastmessage, 3, 1) != '-' || empty($lastmessage)) {
                break;
            }
            $lastmessage = fgets($fp, 512);
        }

        if ($setting['mailauth']) {
            fputs($fp, "AUTH LOGIN\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 334) {
                runlog('SMTP', "($mailserver:$mailport) AUTH LOGIN - $lastmessage", 0);
                return false;
            }

            fputs($fp, base64_encode($setting['mailauth_username']) . "\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 334) {
                runlog('SMTP', "($mailserver:$mailport) USERNAME - $lastmessage", 0);
                return false;
            }

            fputs($fp, base64_encode($setting['mailauth_password']) . "\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 235) {
                runlog('SMTP', "($mailserver:$mailport) PASSWORD - $lastmessage", 0);
                return false;
            }

            $email_from = $setting['maildefault'];
        }

        fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from) . ">\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250) {
            fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from) . ">\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 250) {
                runlog('SMTP', "($mailserver:$mailport) MAIL FROM - $lastmessage", 0);
                return false;
            }
        }

        fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $toemail) . ">\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250) {
            fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $toemail) . ">\r\n");
            $lastmessage = fgets($fp, 512);
            runlog('SMTP', "($mailserver:$mailport) RCPT TO - $lastmessage", 0);
            return false;
        }

        fputs($fp, "DATA\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 354) {
            runlog('SMTP', "($mailserver:$mailport) DATA - $lastmessage", 0);
            return false;
        }

        $headers .= 'Message-ID: <' . gmdate('YmdHs') . '.' . substr(md5($email_message . microtime()), 0, 6) . rand(100000, 999999) . '@' . $_SERVER['HTTP_HOST'] . ">{$maildelimiter}";

        fputs($fp, "Date: " . gmdate('r') . "\r\n");
        fputs($fp, "To: " . $email_to . "\r\n");
        fputs($fp, "Subject: " . $email_subject . "\r\n");
        fputs($fp, $headers . "\r\n");
        fputs($fp, "\r\n\r\n");
        fputs($fp, "$email_message\r\n.\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250) {
            runlog('SMTP', "($mailserver:$mailport) END - $lastmessage", 0);
        }
        fputs($fp, "QUIT\r\n");

        return true;
    } elseif ($mailsend == 3) {

        ini_set('SMTP', $mailserver);
        ini_set('smtp_port', $mailport);
        ini_set('sendmail_from', $email_from);
        if (function_exists('mail') && @mail($email_to, $email_subject, $email_message, $headers)) {
            return true;
        }
        return false;
    }
}

/* 取得一个字符串的拼音表示形式 */

function getpinyin($str, $ishead = 0, $isclose = 1) {
    if (!function_exists('gbk_to_pinyin')) {
        require_once(ASK2_ROOT . '/lib/iconv.func.php');
    }
    if (ASK2_CHARSET == 'utf-8') {
        $str = utf8_to_gbk($str);
    }
    return gbk_to_pinyin($str, $ishead, $isclose);
}

/* 得到一个分类的getcategorypath，一直到根分类 */

function getcategorypath($cid) {
    global $category;
    $item = $category[$cid];
    $dirpath = $item['dir'];
    while (true) {
        if (0 == $item['pid']) {
            break;
        } else {
            $item = $category[$item['pid']];
        }
        $dirpath = $item['dir'] . '/' . $dirpath;
    }
    return $dirpath;
}

/* 得到链接来源 */

function get_url_source($forward = "") {
    global $setting;
    $refer = $forward ? $forward : $_SERVER['HTTP_REFERER'];
    $start = $setting['seo_on'] ? strlen(SITE_URL) : strlen(SITE_URL) + 1;
    $refer = substr($refer, $start);
    return substr($refer, 0, strrpos($refer, "."));
}

/* 数组类型，是否是向量类型 */

function isVector(&$array) {
    $next = 0;
    foreach ($array as $k => $v) {
        if ($k !== $next)
            return false;
        $next++;
    }
    return true;
}

/* 自己定义tjson_encode */

function tjson_encode($value) {
    switch (gettype($value)) {
        case 'double':
        case 'integer':
            return $value > 0 ? $value : '"' . $value . '"';
        case 'boolean':
            return $value ? 'true' : 'false';
        case 'string':
            return '"' . str_replace(
                            array("\n", "\b", "\t", "\f", "\r"), array('\n', '\b', '\t', '\f', '\r'), addslashes($value)
                    ) . '"';
        case 'NULL':
            return 'null';
        case 'object':
            return '"Object ' . get_class($value) . '"';
        case 'array':
            if (isVector($value)) {
                if (!$value) {
                    return $value;
                }
                foreach ($value as $v) {
                    $result[] = tjson_encode($v);
                }
                return '[' . implode(',', $result) . ']';
            } else {
                $result = '{';
                foreach ($value as $k => $v) {
                    if ($result != '{')
                        $result .= ',';
                    $result .= tjson_encode($k) . ':' . tjson_encode($v);
                }
                return $result . '}';
            }
        default:
            return '"' . addslashes($value) . '"';
    }
}

/* 是否是外部url */

function is_outer($url) {
    $findstr = $domain = $_SERVER["HTTP_HOST"];
    $words = explode('.', $domain);
    if (count($words) > 2) {
        array_shift($words);
        $findstr = implode('.', $words);
    }
    return false === strpos($url, $findstr);
}
/* 是否是外部imgurl */

function is_imgouter($url) {
    $findstr = $domain = $_SERVER["HTTP_HOST"];
    $words = explode('.', $domain);
    if (count($words) > 2) {
        array_shift($words);
        $findstr = implode('.', $words);
    }
    return false === strpos($url, $findstr);
}
/* 处理外部url */

function change_outer($url) {
   return SITE_URL.'?redirect/change/'.urlencode( $url);
}

/* html中的是否包含外部url */

function has_outer($content) {
    $contain = false;
    if (!function_exists('file_get_html')) {
        require_once(ASK2_ROOT . '/lib/simple_html_dom.php');
    }
    $html = str_get_html($content);
    $ret = $html->find('a');
    foreach ($ret as $a) {
        if (is_outer($a->href)) {
            $contain = true;
            break;
        }
    }
    $html->clear();
    return $contain;
}

/* 过滤外部url */

function filter_outer($content) {
    if (!function_exists('file_get_html')) {
        require_once(ASK2_ROOT . '/lib/simple_html_dom.php');
    }
    $html = str_get_html($content);
    $ret = $html->find('a');
    foreach ($ret as $a) {
        if (is_outer($a->href)) {
            $a->outertext =$a->innertext;
       
        }
    }
    $content = $html->save();
    $html->clear();
    return $content;
}
  /* 过滤外部图片url */

function filter_imgouter($content) {
    if (!function_exists('file_get_html')) {
        require_once(ASK2_ROOT . '/lib/simple_html_dom.php');
    }
    $html = str_get_html($content);
    $ret = $html->find('img');
    foreach ($ret as $a) {
        if (is_imgouter($a->src)) {
            $a->outertext ='';
       
        }
    }
    $content = $html->save();
    $html->clear();
    return $content;
}
  
/* 内存是否够用 */

function is_mem_available($mem) {
    $limit = trim(ini_get('memory_limit'));
    if (empty($limit))
        return true;
    $unit = strtolower(substr($limit, -1));
    switch ($unit) {
        case 'g':
            $limit = substr($limit, 0, -1);
            $limit *= 1024 * 1024 * 1024;
            break;
        case 'm':
            $limit = substr($limit, 0, -1);
            $limit *= 1024 * 1024;
            break;
        case 'k':
            $limit = substr($limit, 0, -1);
            $limit *= 1024;
            break;
    }
    if (function_exists('memory_get_usage')) {
        $used = memory_get_usage();
    }
    if ($used + $mem > $limit) {
        return false;
    }
    return true;
}

//图片处理函数
/* 根据扩展名判断是否图片 */
function isimage($extname) {
    return in_array($extname, array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
}

function image_resize($src, $dst, $width, $height, $crop = 0) {
    if (!list($w, $h) = getimagesize($src))
        return "Unsupported picture type!";

    $type = strtolower(substr(strrchr($src, "."), 1));
    if ($type == 'jpeg')
        $type = 'jpg';
    switch ($type) {
        case 'bmp': $img = imagecreatefromwbmp($src);
            break;
        case 'gif': $img = imagecreatefromgif($src);
            break;
        case 'jpg': $img = imagecreatefromjpeg($src);
            break;
        case 'png': $img = imagecreatefrompng($src);
            break;
        default : return false;
    }
// resize
    if ($crop) {
        if ($w < $width or $h < $height) {
            rename($src, $dst);
            return true;
        }
        $ratio = max($width / $w, $height / $h);
        $h = $height / $ratio;
        $x = ($w - $width / $ratio) / 2;
        $w = $width / $ratio;
    } else {
        if ($w < $width and $h < $height) {
            rename($src, $dst);
            return true;
        }
        $ratio = min($width / $w, $height / $h);
        $width = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;
    }
    $new = imagecreatetruecolor($width, $height);
// preserve transparency
    if ($type == "gif" or $type == "png") {
        imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
        imagealphablending($new, false);
        imagesavealpha($new, true);
    }

    imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

    switch ($type) {
        case 'bmp': imagewbmp($new, $dst);
            break;
        case 'gif': imagegif($new, $dst);
            break;
        case 'jpg': imagejpeg($new, $dst);
            break;
        case 'png': imagepng($new, $dst);
            break;
    }
    return true;
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale) {
    list($imagewidth, $imageheight, $imageType) = getimagesize($image);
    $thumb_image_name = ASK2_ROOT . $thumb_image_name;
    $imageType = image_type_to_mime_type($imageType);
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
    switch ($imageType) {
        case "image/gif":
            $source = imagecreatefromgif($image);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            $source = imagecreatefromjpeg($image);
            break;
        case "image/png":
        case "image/x-png":
            $source = imagecreatefrompng($image);
            break;
    }
    imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
    switch ($imageType) {
        case "image/gif":
            imagegif($newImage, $thumb_image_name);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            imagejpeg($newImage, $thumb_image_name);
            break;
        case "image/png":
        case "image/x-png":
            imagepng($newImage, $thumb_image_name);
            break;
    }
    chmod($thumb_image_name, 0777);
    return $thumb_image_name;
}

/**
 * 获取内容中的第一张图
 * @param unknown_type $string
 * @return unknown|string
 */
function getfirstimg(&$string) {
    preg_match("/<img.+?src=[\\\\]?\"(.+?)[\\\\]?\"/i", $string, $imgs);
    if (isset($imgs[1])) {
        return $imgs[1];
    } else {
        return "";
    }
}
//获取图片数组
function getfirstimgs(&$string) {
    preg_match_all("/<img.+?src=[\\\\]?\"(.+?)[\\\\]?\"/i", $string, $imgs);
    if (isset($imgs[1])) {
        return $imgs;
    } else {
        return "";
    }
}

function getImageFile($url, $filename='', $dirName, $type=0)
{
    if($url == ''){return false;}
    //获取文件原文件名
    $defaultFileName = basename($url);
    //获取文件类型
    $suffix = substr(strrchr($url,'.'), 1);
  //  if(!in_array($suffix, $fileType)){
      //  return false;
   // }
    //设置保存后的文件名
  //  $filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;
          
    //获取远程文件资源
    if($type){
//        $ch = curl_init();
//        $timeout = 5;
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt ( $ch, CURLOPT_REFERER, 'http://www.baidu.com/'); 
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//        $file = curl_exec($ch);
//        curl_close($ch);
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt ( $ch, CURLOPT_REFERER, 'http://www.baidu.com'); 
$file = curl_exec ( $ch );
curl_close ( $ch );
    }else{
        ob_start();
        readfile($url);
        $file = ob_get_contents();
        ob_end_clean();
    }
    //设置文件保存路径
   // $dirName = $dirName.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d',time()).'/';
    if(!file_exists($dirName)){
        mkdir($dirName, 0777, true);
    }
    //保存文件
    $res = fopen($dirName.$filename,'a');
    fwrite($res,$file);
    fclose($res);
    return $dirName.$filename;
}

function array_per_fields($array, $field) {
    $values = array();
    foreach ($array as $val) {
        $values[] = $val[$field];
    }
    return $values;
}

function highlight($content, $words, $highlightcolor = 'red') {
    $wordlist = explode(" ", $words);
    foreach ($wordlist as $hightlightword) {
        if (strlen($content) < 1 || strlen($hightlightword) < 1) {
            return $content;
        }
        $content = preg_replace("/$hightlightword/is", "<font color=red>\\0</font>", $content);
    }
    return $content;
}

function get_remote_image($url, $savepath) {
    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
    $fp2 = @fopen($savepath, "a");
    fwrite($fp2, $img);
    fclose($fp2);
    return $savepath;
}
function is_mobile() {
    $is_mobile = false;
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}
?>