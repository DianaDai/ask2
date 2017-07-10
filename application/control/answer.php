<?php

!defined('IN_ASK2') && exit('Access Denied');

class answercontrol extends base {

    function __construct(& $get, & $post) {
        parent::__construct($get, $post);
        $this->load('answer');
        $this->load('answer_comment');
        $this->load('question');
        $this->load('message');
        $this->load('doing');
        $this->load('email');
        $this->load('email_msg');
        $this->load('favorite');
    }

    /* 追问模块---追问 */

    function onappend() {
        $this->load("message");
        $qid = intval($this->get[2]) ? $this->get[2] : intval($this->post['qid']);
        $aid = intval($this->get[3]) ? $this->get[3] : intval($this->post['aid']);
        $question = $_ENV['question']->get($qid);
        $answer = $_ENV['answer']->get($aid);
        if (!$question || !$answer) {
            $this->message("回答内容不存在!");
            exit;
        }
        $viewurl = urlmap('question/view/' . $qid, 2);
        if (isset($this->post['submit'])) {
//        	if($this->user['grouptype']!=1){
//        				   if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()&&$this->setting['jingyan']<=0) {
//            $this->message($this->post['state']."验证码错误!", 'BACK');
//        }
//        				}
            $_ENV['answer']->append($answer['id'], $this->user['realname'], $this->user['uid'], $this->post['content']);
            if ($answer['authorid'] == $this->user['uid']) {//追答
              //通知给提问者
                $qurl =' <br> <a href="' . url('question/view/' . $qid, 1) . '">点击查看问题</a>';
                $msginfo =$_ENV['email_msg']->question_ask_ans($question['author'],$question['title'],$qurl);
                $_ENV['message']->add($this->user['realname'], $this->user['uid'], $question['authorid'], $msginfo['title'], $msginfo['content']);
                $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 7, $qid, $this->post['content']);

                $quser= $_ENV['user']->get_by_uid($question['authorid']);
        	
              if(isset($this->setting['notify_mail'])&&$this->setting['notify_mail']=='1'){
                  $_ENV['email']->sendmail($quser['email'],$msginfo['title'],$msginfo['content']);
              }
              //通知信息给关注着
              $userlist = $_ENV['favorite']->get_list_byqid_fav($qid);
              foreach ($userlist as $val)
              {
                  $msginfo = $_ENV['email_msg']->question_ask_with($val['realname'],$question['title'],$qurl); //追答了问题通知给关注着
                  
                  $this-> sendmsg($val,$msginfo['title'],$msginfo['content']);
              }
              
                $this->message('继续回答成功!', $viewurl);
            } else {
                //追问对回答者追问，通知回答者；通知相关的评论者
                $qurl ='<br> <a href="' . url('question/view/' . $qid, 1) . '">点击查看问题</a>';
                $msginfo =$_ENV['email_msg']->question_comment($answer['author'],$question['title'],$qurl);
             
                $_ENV['message']->add($this->user['realname'], $this->user['uid'], $answer['authorid'],$msginfo['title'],$msginfo['content']);
                $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 6, $qid, $this->post['content'], $answer['id'], $answer['authorid'], $answer['content']);
                $auser= $_ENV['user']->get_by_uid($answer['authorid']);
      
                if(isset($this->setting['notify_mail'])&&$this->setting['notify_mail']=='1'){
                  
                    $_ENV['email']->sendmail($auser['email'],$msginfo['title'],$msginfo['content']); //发送邮件通知
                }

                //准备通知关注着
                $userlist = $_ENV['favorite']->get_list_byqid_fav($qid);
                foreach ($userlist as $val)
                {
                    $msginfo = $_ENV['email_msg']->question_ask($val['realname'],$question['title'],$qurl);
                    
                   $this-> sendmsg($val,$msginfo['title'],$msginfo['content']);
                }
                $this->message('继续提问成功!', $viewurl);
            }
        }
        include template("appendanswer");
    }
 
     function sendmsg($touser,$subject,$content){
    
           $time =time();
           $msgfrom = $this->setting['site_name'] . '管理员';
           if ((1 & $touser['isnotify']) && $this->setting['notify_message']) {
            $this->db->query('INSERT INTO ' . DB_TABLEPRE . "message  SET `from`='" . $msgfrom . "' , `fromuid`=0 , `touid`='".$touser['uid']."'  , `subject`='" . $subject . "' , `time`=" . $time . " , `content`='" . $content . "'");
           }
           if ((2 & $touser['isnotify']) && $this->setting['notify_mail']) {
               $_ENV['email']->sendmail($touser['email'],$subject,$content);
          
        }
    }  
    
    
    
    
    function onajaxviewcomment() {
        $answerid = intval($this->get[2]);
        $commentlist = $_ENV['answer_comment']->get_by_aid($answerid, 0, 50);
        $commentstr = '<li class="loading">暂无评论 :)</li>';
        if ($commentlist) {
            $commentstr = "";
          
            foreach ($commentlist as $comment) {
            	  $admin_control = ($this->user['grouptype'] == 1) ? '<span class="span-line">|</span><a href="javascript:void(0)" onclick="deletecomment({commentid},{answerid});">删除</a>' : '';
                $viewurl = urlmap('user/space/' . $comment['authorid'], 2);
                $reply_control = ($this->user['uid'] != $comment['authorid']) ? '<span class="span-line">|</span><a href="javascript:void(0)" onclick="replycomment(' . $comment['authorid'] . ',' . $comment['aid'] . ');">回复</a>' : '';
                if ($admin_control) {
                    $admin_control = str_replace("{commentid}", $comment['id'], $admin_control);
                    $admin_control = str_replace("{answerid}", $comment['aid'], $admin_control);
                }
                $commentstr.='<li><div class="other-comment am-margin-top-sm"><a id="comment_author_' . $comment['authorid'] . '" href="' . $viewurl . '" title="' . $comment['author'] . '" target="_blank" class="pic"><img width="30" height="30" src="' . $comment['avatar'] . '"  onmouseover="pop_user_on(this, \'' . $comment['authorid'] . '\', \'\');"  onmouseout="pop_user_out();"></a><p  class="am-margin-0"><a href="' . $viewurl . '" title="' . $comment['author'] . '" target="_blank">' . $comment['author'] . '</a>：' . $comment['content'] . '</p></div><div class="replybtn"><span class="times">' . $comment['format_time'] . '</span>' . $reply_control . '' . $admin_control . '</div></li>';
            }
        }
        exit($commentstr);
    }

    function onaddcomment() {
        if (isset($this->post['content'])) {
            $content = htmlspecialchars($this->post['content']);
            $answerid = intval($this->post['answerid']);
            $replyauthorid = intval($this->post['replyauthor']);
            $answer = $_ENV['answer']->get($answerid);
               $question = $_ENV['question']->get($answer['qid']);
               if($question['status']==9){
               	exit('-2');
               }
            $_ENV['answer_comment']->add($answerid, $content, $this->user['uid'], $this->user['username']);
            if ($answer['authorid'] != $this->user['uid']) {
                $_ENV['message']->add($this->user['username'], $this->user['uid'], $answer['authorid'], '您的回答有了新评论', '您对于问题 "' . $answer['title'] . '" 的回答 "' . $answer['content'] . '" 有了新评论 "' . $content . '" <br> <a href="' . url('question/view/' . $answer['qid'], 1) . '">点击查看</a>');
            }
            if ($replyauthorid && $this->user['uid'] != $replyauthorid) {
                $_ENV['message']->add($this->user['username'], $this->user['uid'], $replyauthorid, '您的评论有了新回复', '您对于问题 "' . $answer['title'] . '" 的评论有了新回复"' . $content . '" <br> <a href="' . url('question/view/' . $answer['qid'], 1) . '">点击查看</a>');
            }
            $_ENV['doing']->add($this->user['uid'], $this->user['username'], 3, $answer['qid'], $content, $answer['id'], $answer['authorid'], $answer['content']);
            exit('1');
        }
    }

    function ondeletecomment() {
        if (isset($this->post['commentid'])) {
            $commentid = intval($this->post['commentid']);
            $answerid = intval($this->post['answerid']);
            $_ENV['answer_comment']->remove($commentid, $answerid);
            exit('1');
        }
    }

    function onajaxgetsupport() {
        $answerid = intval($this->get[2]);
        $answer = $_ENV['answer']->get($answerid);
        exit($answer['supports']);
    }

    function onajaxhassupport() {
        $answerid = intval($this->get[2]);
        $supports = $_ENV['answer']->get_support_by_sid_aid($this->user['sid'], $answerid);
        $ret = $supports ? '1' : '-1';
        exit($ret);
    }

    function onajaxaddsupport() {
        $answerid = intval($this->get[2]);
        $answer = $_ENV['answer']->get($answerid);
        $_ENV['answer']->add_support($this->user['sid'], $answerid, $answer['authorid']);
        $answer = $_ENV['answer']->get($answerid);
        if ($this->user['uid']) {
            $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 5, $answer['qid'], '', $answer['id'], $answer['authorid'], $answer['content']);
            $question =$_ENV['question']->get($answer['qid']);
            
            $weburl ='<br> <a href="' .url('question/view'.$question['id'] ). '">点击查看问题</a>';
            $msginfo = $_ENV['email_msg']->question_ok($answer['author'],$question['title'],$weburl);
            $touser =$_ENV['user']->get_by_uid($answer['authorid']);
            $this-> sendmsg($touser,$msginfo['title'],$msginfo['content']);
            
        }
        exit($answer['supports']);
    }

}

?>
