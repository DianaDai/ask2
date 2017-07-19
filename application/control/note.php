<?php

!defined('IN_ASK2') && exit('Access Denied');

class notecontrol extends base {

    function notecontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load("note");
        $this->load("note_comment");
        $this->load('email_msg');
        $this->load('email');
        $this->load('user');
    }

    /* 前台查看公告列表 */

    function onlist() {
        if(!isset($this->setting['list_topdatanum'])){
            $notetoplist = $_ENV['note']->get_toplist(0,3);
        }else{
            $notetoplist = $_ENV['note']->get_toplist(0,$this->setting['list_topdatanum']);
        }
       $navtitle = "本站公告列表";
        $seo_description= "发布".$this->setting['site_name']."最新公告，包括问答升级，维护更新，修改，以及重大变更。";
        $seo_keywords= "公告";
        $page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total('note', ' 1=1');
        $notelist = $_ENV['note']->get_list($startindex, $pagesize);
        $departstr = page($rownum, $pagesize, $page, "note/list");
        include template('notelist');
    }

    /* 浏览公告 */

    function onview() {
        $navtitle = '查看公告';
        $page = max(1, intval($this->get[3]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total('note', ' 1=1');
        $note = $_ENV['note']->get($this->get[2]);
        $rownum = $this->db->fetch_total('note_comment', " noteid=" . $note['id']);
        $commentlist = $_ENV['note_comment']->get_by_noteid($note['id'], $startindex, $pagesize);
        $departstr = page($rownum, $pagesize, $page, "note/view/" . $note['id']);
        $_ENV['note']->update_views($note['id']);
        $seo_title = $note['title'].' - '.$navtitle.' - '.$this->setting['site_name'];
        $is_followedauthor = $_ENV['user']->is_followed($note['authorid'], $this->user['uid']);
        $seo_description = $seo_title;
        $seo_keywords = $note['title'];
        include template('note');
    }

    function onaddcomment() {
        if (isset($this->post['submit'])) {

//
//        				   if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()&&$this->user['credit1']<$this->setting['jingyan']) {
//            $this->message($this->post['state']."验证码错误!", 'BACK');
//        }
        	if($this->user['isblack']==1){
        $this->message('黑名单用户无法评论！', 'BACK');
        	}
        				
            $noteid = intval($this->post['noteid']);
            $_ENV['note_comment']->add($noteid, $this->post['content']);
            $_ENV['note']->update_comments($noteid);
            //通知公告作者
            $note = $_ENV['note']->get($noteid);
            $touser = $_ENV['user']->get_by_uid($note['authorid']);
            $viewurl = url('note/view/'.$noteid,2);
            $qurl='<br /> <a href="' .$viewurl . '">点击查看公告</a>'; //站内url都使用这个
            $msginfo =$_ENV['email_msg']->notice_comment($touser['realname'],$note['title'],$qurl);
            $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
            
            
            
            $this->message("评论添加成功!", "note/view/" . $noteid);
        }
    }
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
    function ondeletecomment() {
        $commentid = intval($this->get[3]);
        $noteid = intval($this->get[2]);
        $_ENV['note_comment']->remove($commentid, $noteid);
        $this->message("评论删除成功", "note/view/$noteid");
    }
    //取消首页置顶
    function oncancelindextop(){
        $id=intval($this->get[2]);
        $_ENV['note']->update_indextop(0,$id);
        //cleardir(ASK2_ROOT . '/data/cache'); //清除缓存文件
        $this->message("取消公告首页置顶成功!");
    }
    //首页置顶
    function onaddindextop(){
        $id=intval($this->get[2]);
        $_ENV['note']->update_indextop(1,$id);
        //cleardir(ASK2_ROOT . '/data/cache'); //清除缓存文件
        $this->message("公告首页置顶成功!");
    }
}

?>