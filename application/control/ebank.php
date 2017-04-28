<?php

!defined('IN_ASK2') && exit('Access Denied');

class ebankcontrol extends base {

	var $whitelist='';
    function ebankcontrol(& $get, & $post) {
        parent::__construct($get, $post);
        $this->whitelist="aliapytransfer,weixintransfer";
        $this->load('ebank');
    }

    /* 支付宝回调 */

    function onaliapyback() {
        if (!$this->setting['recharge_open']) {
            $this->message("充值服务已关闭，如有问题，请联系管理员!", "STOP");
        }
     
        if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
        	   
            //$credit2 = $_GET['total_fee'] * $this->setting['recharge_rate'];
         // if(!isset($_SESSION)){ session_start(); }
//         if(isset($_SESSION['type'])){
//         	 $type=json_decode($_SESSION['type'],true);
//         	          $content=$type['content'];
//         	           $touid=$type['touid'];
//        	    	 $this->credit($this->user['uid'], 0, $credit2, 0, $content);
//        	    	   $this->db->query("INSERT INTO " . DB_TABLEPRE . "userbank(fromuid,touid,operation,money,time) VALUES ({$this->user['uid']},$touid,'$content',{$_GET['total_fee']},{$this->time}) ");
//        	    	 $this->message("打赏成功",  $_SESSION['backurl']);
//        	    }else{
//        	    	 $this->credit($this->user['uid'], 0, $credit2, 0, "支付宝充值");
//        	    	 $this->message("充值成功", "user/score");
//        	    }

            $cash_fee=doubleval($_GET['total_fee'])*100;
            $uid=$this->user['uid'];
            $time_end=time();
        	    $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `jine`=jine+'$cash_fee' WHERE `uid`=$uid");
             $subject='使用支付宝进行了平台账户充值';
              $message='具体请查看个人中心--我的银行，可以查看平台账号钱包剩余金额和打赏记录';
        	    $this->db->query('INSERT INTO ' . DB_TABLEPRE . "message  SET `from`='系统管理员' , `fromuid`=1 , `touid`=$uid  , `subject`='" . $subject . "' , `time`=" . time() . " , `content`='" . $message . "'");   	
		      $this->db->query("INSERT INTO ".DB_TABLEPRE."paylog SET type='chongzhi',typeid=0,money=".$_GET['total_fee'].",openid='',fromuid=0,touid=$uid,`time`=$time_end");
                 $this->message("充值成功", "user/recharge");
            
        } else {
            $this->message("服务器繁忙，请稍后再试!", 'STOP');
        }
    }

    /* 微信*/
    function onweixintransfer(){
    	  if (isset($this->post['submit'])) {
            $recharge_money = floatval($this->post['money']);
            
    	  }
           if (!$this->setting['recharge_open']) {
                exit("0");
            }
            if ($recharge_money <= 0 || $recharge_money > 20000) {
               exit("1");
                exit;
            }
            
            	 $type=htmlspecialchars($this->post['type']);
    	 	    $typevalue=0;
    	 	  $touser=$this->user['uid'];
    	 	  
    	 	  $t1=$type;
    	  $t2=$typevalue;
    	   $t3=$touser;
    	    $t4=$recharge_money;
    	    
    	    $t5=rand(111111111, 999999999);
    	require_once ASK2_ROOT."/lib/wxpay/lib/WxPay.Api.php";
     require_once    ASK2_ROOT."/lib/wxpay/WxPay.NativePay.php";
      require_once  ASK2_ROOT.'/lib/wxpay/log.php';
      $notify = new NativePay();
              $url1 = $notify->GetPrePayUrl($t1."_".$t2."_".$t3."_".$t4."_".$t5);
              echo urlencode($url1);
              
    }
    /* 支付宝转账 */

    function onaliapytransfer() {
    	
        if (isset($this->post['alipaysubmit'])) {
            $recharge_money = intval($this->post['money']);
              
      //  if(!isset($_SESSION)){ session_start(); }
      
     
       
      
       
            if ($this->user['uid']==0) {
                $this->message("您无权执行该操作!", "STOP");
                exit;
            }
            if (!$this->setting['recharge_open']) {
                $this->message("充值服务已关闭，如有问题，请联系管理员!", "STOP");
            }
            if ($recharge_money <= 0 || $recharge_money > 20000) {
                $this->message("输入充值金额不正确!充值金额必须为整数，且单次充值不超过20000元!", "BACK");
                exit;
            }
         
         $_ENV['ebank']->aliapytransfer($recharge_money);
//      
//         if(isset($_SESSION['type'])){
//         	//$this->user['ebanktype']='dashang';
//         	//$this->user['backurl']=$_SERVER["HTTP_REFERER"];
//         	
//        	  $type=json_decode($_SESSION['type'],true);
//        	   $_ENV['ebank']->aliapytransfer($recharge_money,$type['content']);
//        }else{
//        	//$this->user['ebanktype']='chongzhi';
//        	
//        	 $_ENV['ebank']->aliapytransfer($recharge_money);
//        }
        
           
        }
       
    }

}

?>