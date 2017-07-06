<?php

!defined('IN_ASK2') && exit('Access Denied');

class favoritecontrol extends base {
	var $whitelist;
    function favoritecontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load("favorite");
        $this->load('user');
        $this->load('topic');      
        $this->load('email_msg');
        $this->whitelist="topicadd,deletetopiclikes";
    }

    function ondefault() {
        $navtitle = '我的收藏';
        @$page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
        $favoritelist = $_ENV['favorite']->get_list($startindex, $pagesize);
        $total = $_ENV['favorite']->rownum_by_uid();
        $departstr = page($total, $pagesize, $page, "favorite/default"); //得到分页字符串
        include template('favorite');
    }

    function ondelete() {
        if (isset($this->post['submit'])) {
            $ids = $this->post['id'];
          
            $_ENV['favorite']->remove($ids);
            $this->message("收藏删除成功！", 'favorite/default');
        }
    }
   function ondeletetopiclikes() {
   	if($this->user['uid']==0){
    		 $this->message("游客禁止访问", "index");
    	}
        if (isset($this->post['submit'])) {
            $ids = $this->post['id'];
          
            $_ENV['favorite']->remove_topiclikes($ids);
            $this->message("收藏删除成功！", 'favorite/topic');
        }
    }
    function onadd() {
        $qid = intval($this->get[2]);
        $cid = intval($this->get[3]);
        $viewurl = urlmap('question/view/' . $qid, 2);
        $message = "该问题已经收藏，不能重复收藏！";
        $this->load("favorite");
        if (!$_ENV['favorite']->get_by_qid($qid)) {
            $_ENV['favorite']->add($qid);
            $message = '问题收藏成功!';
        }
        $this->message($message, $viewurl);
    }
    function ontopicadd() {
    	
    	if($this->user['uid']==0){
    		 $this->message("先登录在收藏", "user/login");
    	}
    	
        $tid = intval($this->get[2]);
        $cid = intval($this->get[3]);
        $viewurl = urlmap('topic/getone/' . $tid, 2);
        $message = "该文章已经收藏，不能重复收藏！";
     
        if (!$_ENV['favorite']->get_by_tid($tid)) {
            $_ENV['favorite']->addtopiclikes($tid);
            $topic = $_ENV['topic']->get($tid);
       
            $touser =$_ENV['user']->get_by_uid($topic['authorid']);
       
            $msginfo = $_ENV['email_msg']->topic_save($touser['realname'],$topic['title'],tdate(time(),3,0),$this->user['realname']);
           
             $this->send_msg_all($touser,$msginfo['title'],$msginfo['content']);
            $this->load("doing");
            
            $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 13, $tid, "收藏了文章");
            $message = '文章收藏成功!';
        }
        $this->message($message, $viewurl);
    }
    
        /*发送邮件和消息   给谁  主题，内容   */
    function sendmsg($touser,$subject,$content){
    
           $time = time();
           $msgfrom = $this->setting['site_name'] . '管理员';
           if ((1 & $touser['isnotify']) && $this->setting['notify_message']) {
            $this->db->query('INSERT INTO ' . DB_TABLEPRE . "message  SET `from`='" . $msgfrom . "' , `fromuid`=0 , `touid`='".$touser['uid']."'  , `subject`='" . $subject . "' , `time`=" . $time . " , `content`='" . $content . "'");
           }
           if ((2 & $touser['isnotify']) && $this->setting['notify_mail']) {
               $_ENV['email']->sendmail($touser['email'],$subject,$content);
          
        }
    }

}

?>