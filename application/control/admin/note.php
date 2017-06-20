<?php

!defined('IN_ASK2') && exit('Access Denied');

class admin_notecontrol extends base {

    function admin_notecontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load('note');
    }

    function ondefault($message = '') {
        if (empty($message))
            unset($message);
        @$page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $notelist = $_ENV['note']->get_list($startindex, $pagesize);
        $rownum = $this->db->fetch_total("note", "1=1");
        $departstr = page($rownum, $pagesize, $page, "admin_note/default");
        include template('notelist', 'admin');
    }

    function onadd() {
        if (isset($this->post['submit'])) {
            $title = $this->post['title'];
            $url = $this->post['url'];
            $content = $this->post['content'];
            $nid= $_ENV['note']->add($title, $url, $content);
            $this->load('user');
            $this->load('email');
            $followerlist= $_ENV['user']->get_follower($this->user['uid']);
            $viewurl = url('note/view/'.$nid,2);
            global $setting;
            $mpurl = SITE_URL . $setting['seo_prefix'] . $viewurl . $setting['seo_suffix'];
            $qurl='<br /> <a href="' .$mpurl . '">点击查看公告</a>'; //站内url都使用这个
            foreach ($followerlist as $fol)
            {
            	$msginfo =$_ENV['email_msg']->notice_info($fol['info']['username'],$title,$qurl);
            }

            $this->ondefault('公告添加成功！');
        } else {
            include template('addnote', 'admin');
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
    
    
    
    
    
    
    
    

    function onedit() {
        if (isset($this->post['submit'])) {
            $id = $this->post['id'];
            $title = $this->post['title'];
            $url = $this->post['url'];
            $content = $this->post['content'];
            $_ENV['note']->update($id, $title, $url, $content);
            $this->ondefault('公告编辑成功！');
        } else {
            $note = $_ENV['note']->get($this->get[2]);
            include template('editnote', 'admin');
        }
    }

    function onremove() {
        $message = '没有选择公告！';
        if (isset($this->post['delete'])) {
            $ids = implode(",", $this->post['delete']);
            $_ENV['note']->remove_by_id($ids);
            $message = '公告刪除成功！';
        }
        $this->ondefault($message);
    }

}

?>