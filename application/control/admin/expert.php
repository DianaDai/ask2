<?php

!defined('IN_ASK2') && exit('Access Denied');

class admin_expertcontrol extends base {

    function admin_expertcontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load('expert');
        $this->load('user');
        $this->load('category');
        $this->load('email');
        $this->load('email_msg');
    }

    function ondefault($msg = '') {
        @$page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $expertlist = $_ENV['expert']->get_list(0, $startindex, $pagesize);
        $giftnum = $this->db->fetch_total('user'," expert=1");
        $departstr = page($giftnum, $pagesize, $page, "admin_expert/default");
        $categoryjs = $_ENV['category']->get_js();
        $msg && $message = $msg;
        include template('expertlist', 'admin');
    }

    function onadd() {
        $type = 'correctmsg';
        $message = '';
        $cids = explode(" ", trim($this->post['goodatcategory']));
        $cids = array_unique($cids);
        $username = $this->post['username'];
        if (count($cids) > 5 || count($cids) < 1) {
            $type = 'errormsg';
            $message .= "<br />擅长分类不能超过5个不能小于1个";
        }
        $user = $_ENV['user']->get_by_username(trim($username));
        if (!$user) {
            $type = 'errormsg';
            $message = $user['uid']."抱歉，用户名 [$username] 不存在";
        }
        if ($user['expert']) {
            $type = 'errormsg';
            $message = "用户" . $user['username'] . '已经是专家了，不能重复设置！';
        }
        //添加专家
        if ('correctmsg' == $type) {
           
            $_ENV['expert']->add($user['uid'], $cids);
            //添加专家通知信息
            foreach ($cids as $cid)
            {
            	$follwers =$_ENV['category']->get_fol_sendmsg($cid);
                $lymc =$_ENV['category']->get($cid);
                foreach ($follwers as $fol)
                {
                    $msginfo =$_ENV['email_msg']->speacial_pro($fol['username'],$lymc['name'],$user['username'],url);
                    $this->sendmsg($fol,$msginfo['title'],$msginfo['content']);
                }
                //通知专家自己
                $msginfo= $_ENV['email_msg']->sepeacial_uppro($user['username'],$lymc['name']);
                $this->sendmsg($user,$msginfo['title'],$msginfo['content']);
            }
            
        }
        $this->ondefault($message, $type);
    }

    function onremove() {
        if (count($this->post['delete'])) {
            $_ENV['expert']->remove(implode(',', $this->post['delete']));
            $type = 'correctmsg';
            $message = "删除成功！";
            $this->ondefault($message);
        }
    }

    function onajaxgetname() {
        if (isset($this->post['cid']) && intval($this->post['cid'])) {
            $categorylist = $_ENV['category']->get_navigation($this->post['cid'], true);
            $categorystr = '';
            foreach ($categorylist as $category) {
                $categorystr .=$category['name'] . ' > ';
            }
            echo substr($categorystr, 0, -2);
        }
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