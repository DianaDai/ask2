<?php

!defined('IN_ASK2') && exit('Access Denied');
class dashangmodel {

    var $db;
    var $base;


    function dashangmodel(&$base) {
      
          $this->base = $base;
        $this->db = $base->db;
    }

    function get_list($start = 0, $limit = 10,$begintime=0,$endtime=0) {
        $mdlist = array();

         $query='';
         if($begintime>0){
         	 $query = $this->db->query("SELECT * FROM `".DB_TABLEPRE ."weixin_notify`  WHERE  time_end>=$begintime and time_end <=$endtime ORDER BY `time_end` DESC limit $start,$limit");
         	
         }else{
         	 $query = $this->db->query("SELECT * FROM `".DB_TABLEPRE ."weixin_notify` ORDER BY `time_end` DESC limit $start,$limit");
         	
         }
       
     
             while($md=$this->db->fetch_array($query)) {
      
            $md['format_time'] = tdate($md['time_end']);
            $md['cash_fee']=$md['cash_fee']/100;
            
            $arr=split('_',  $md['attach']);
            
         
            $type=$arr[0];
             $md['type']=$type;
             $dashangren=$this->f_get($md['openid']);
             $md['nickname']=$dashangren['nickname'];
              $md['headimgurl']=$dashangren['headimgurl'];
            switch ($type){
            	case 'aid':
            		 $md['type']="打赏回答";
            		$md['model']=$this->getanswer($arr[1]);
            		break;
            			case 'qid':
            					 $md['type']="打赏提问";
            		break;
            			case 'chongzhi':
            					 $md['type']="用户充值";
            		break;
            			case 'tid':
            					 $md['type']="打赏文章";
            				$md['model']=$this->gettopic($arr[1]);
            		break;
            		
            }
            
            switch (    $md['trade_trye']){
            	case "NATIVE":
            		$md['laiyuan']="扫码支付";
            		break;
            		case "JSAPI":
            			$md['laiyuan']="微信浏览器请求";
            		break;
            }
           
             $mdlist[] = $md;
        }
    
     
        return $mdlist;
    }
   /* 根据aid获取一个答案的内容，暂时无用 */

    function getanswer($id) {
        $answer= $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "answer WHERE id='$id'");
        
         if ($answer) {
          
             $answer['title']=checkwordsglobal( $answer['title']);
              $answer['content']=checkwordsglobal( $answer['content']);
        }
        return $answer;
    }
function f_get($openid) {
         $model =  $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "weixin_follower where openid='$openid' limit 0,1");
        
       
        return $model;
    }

    function gettopic($id) {
         $topic =  $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "topic WHERE id='$id'");
        
        if ($topic) {
            $topic['viewtime'] = tdate($topic['viewtime']);
            $topic['title'] = checkwordsglobal($topic['title']);
             
        }
        return $topic;
    }


}

?>
