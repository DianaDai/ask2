<?php
!defined('IN_ASK2') && exit('Access Denied');

class wxgetcontrol extends base {
   
	var $whitelist;
    function wxgetcontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->whitelist="default";
    }
    function ondefault(){
    	   require './lib/simple_html_dom.php';
    	 // $url="http://mp.weixin.qq.com/s?__biz=MzI1NzE5NjIyOQ==&mid=2650473579&idx=1&sn=dbb4161f94ccd30ea2c8f7e396b238d9&chksm=f2148dc1c56304d7b06539656fab41480625cc512d02286d5206153a77396ec0931a1f237424&mpshare=1&scene=1&srcid=1113o0Zd5EpnRVpXxZPnZOyq&from=groupmessage&isappinstalled=0#wechat_redirect";
    	   $url='http://mp.weixin.qq.com/mp/newappmsgvote?action=show&__biz=MzI1NzE5NjIyOQ==&supervoteid=444838954&uin=&key=&pass_ticket=&wxtoken=&mid=2650473579&idx=1';
    	  $html = file_get_html($url);
    	    echo  $html;
    	    exit();
    }
    
    
    
}