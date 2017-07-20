<?php

!defined('IN_ASK2') && exit('Access Denied');

//0、未审核 1、待解决、2、已解决 4、悬赏的 9、 已关闭问题

class questioncontrol extends base
{

    private $serach_num = '';
    var $whitelist;

    function questioncontrol(& $get, & $post)
    {
        $this->base($get, $post);
        $this->load("question");
        $this->load("category");
        $this->load("answer");
        $this->load("expert");
        $this->load("tag");
        $this->load("topic_tag");
        $this->load("user");
        $this->load("userlog");
        $this->load("doing");
        $this->load("topic");
        $this->load("email"); 
        $this->load("email_msg");
        $this->load("favorite");
        $this->serach_num = isset($this->setting['search_shownum']) ? $this->setting['search_shownum'] : '5';
        $this->whitelist = "delete,deleteanswer";

    }


    /* 提交回答 */
    function onajaxanswer()
    {
        $message = array();
        //只允许专家回答问题
        if (isset($this->setting['allow_expert']) && $this->setting['allow_expert'] && !$this->user['expert']) {

            $message['message'] = '站点已设置为只允许专家回答问题，如有疑问请联系站长.';
            echo json_encode($message);
            exit();
        }
        if ($this->user['uid'] == 0) {


            $message['message'] = '游客先登录在回答！';
            echo json_encode($message);
            exit();
        }
        $qid = $this->post['qid'];

        $question = $_ENV['question']->get($qid);
        if (!$question) {


            $message['message'] = '提交回答失败,问题不存在!';
            echo json_encode($message);
            exit();
        }
        $useragent = $_SERVER['HTTP_USER_AGENT'];


//        if (!strstr($useragent, 'MicroMessenger') && isset($this->setting['code_ask']) && $this->setting['code_ask'] == '1' && $this->user['credit1'] < $this->setting['jingyan'] && $this->user['grouptype'] != 1) {
//            if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()) {
//
//                $message['message'] = "验证码错误!";
//                echo json_encode($message);
//                exit();
//            }
//        }

        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1 && $this->user['groupid'] != 1) {


                $message['message'] = "必须激活邮箱才能回复!";
                echo json_encode($message);
                exit();
            }
        }
        if ($this->user['uid'] == $question['authorid']) {


            $message['message'] = '提交回答失败，不能自问自答！';
            echo json_encode($message);
            exit();
        }
        //$this->setting['code_ask'] && $this->checkcode(); //检查验证码
        //$already = $_ENV['question']->already($qid, $this->user['uid']);

        //if ($already) {
        //    $message['message'] = '不能重复回答同一个问题，可以修改自己的回答！';
        //    echo json_encode($message);
        //    exit();

        //}
      
        if ($this->user['isblack'] == 1) {

            $message['message'] = "黑名单用户无法回答问题!";
            echo json_encode($message);
            exit();
        }

        $title = $this->post['title'];
        $chakanjine = doubleval($this->post['chakanjine']);
        $content = $this->post['content'];
        //检查审核和内容外部URL过滤
        $status = intval(2 != (2 & $this->setting['verify_question']));
        $allow = $this->setting['allow_outer'];
        if (3 != $allow && has_outer($content)) {


            if (0 == $allow) {
                $message['message'] = '内容包含外部链接，发布失败!';
                echo json_encode($message);
                exit();
            }
            1 == $allow && $status = 0;
            2 == $allow && $content = filter_outer($content);


        }
        //检查违禁词
        $contentarray = checkwords($content);
        1 == $contentarray[0] && $status = 0;


        if (2 == $contentarray[0]) {
            $message['message'] = '内容包含非法关键词，发布失败!';
            echo json_encode($message);
            exit();
        }
        $content = $contentarray[1];

        /* 检查提问数是否超过组设置 */
        if ($this->user['answerlimits'] && ($_ENV['userlog']->rownum_by_time('answer') >= $this->user['answerlimits'])) {


            $message['message'] = "你已超过每小时最大回答数" . $this->user['answerlimits'] . ',请稍后再试！';
            echo json_encode($message);
            exit();
        }


        $content_temp = str_replace('<p>', '', $content);
        $content_temp = str_replace('</p>', '', $content_temp);
        $content_temp = str_replace('&nbsp;', '', $content_temp);
        $content_temp = preg_replace("/\s+/", '', $content_temp);
        $content_temp = preg_replace('/s(?=s)/', '', $content_temp);
        $content_temp = trim($content_temp);
        if (trim($content_temp) == '') {

            $message['message'] = '回答不能为空！';
            echo json_encode($message);
            exit();
        }
        if ($this->user['groupid'] == 1) {
            $status = 2;
        }


        $_ENV['answer']->add($qid, $title, $content, $status, $chakanjine);
        //回答问题，添加积分
        $this->credit($this->user['uid'], $this->setting['credit1_answer'], $this->setting['credit2_answer']);
        //给提问者 关注着发送通知
        //$this->send($question['authorid'], $question['id'], 0);
      //  $viewurl = urlmap('question/view/' . $qid, 2);
        $qurl='<br> <a href="' . url('question/view/' . $qid, 1) . '">点击查看问题</a>';
        $touser =$_ENV['user']->get_by_uid($question['authorid']);
        $this->sendanswer($question,$touser,$qurl); 
        $_ENV['userlog']->add('answer');
        $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 2, $qid, $content);
        if (0 == $status) {

            $message['message'] = '提交回答成功！为了确保问答的质量，我们会对您的回答内容进行审核。请耐心等待......';
            echo json_encode($message);
            exit();

        } else {
            $message['emal'] = '1';
            $message['message'] = 'ok';
            echo json_encode($message);
            exit();

        }
    }

 

    
    /* 回答问题  通知给提问者  关注着    */
    function sendanswer($question ,$touser,$qurl ){

            //   通知提问题者
        $msginfo= $_ENV['email_msg']->question_answer($touser['realname'],$question['title'],$qurl);
           $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
            
            //通知关注着

           $userlist =$_ENV['favorite']->get_list_byqid_fav($question['id']);
            foreach ($userlist as $val)
            {
                $msginfo =$_ENV['email_msg']->question_answer_with($val['realname'], $question['title'],$qurl);
            	
                $this-> sendmsg($val,$msginfo['title'],$msginfo['content']);
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
    

    /* 提交问题 */

    function onadd()
    {

        $useragent = $_SERVER['HTTP_USER_AGENT'];

        $iswxbrower = false;
        if (strstr($useragent, 'MicroMessenger')) {
            $iswxbrower = true;
        }
        $navtitle = "提出问题";


        if (0 == $this->user['uid']) {
            $this->setting["ucenter_open"] && $this->message("UCenter开启后游客不能提问!", 'BACK');
        }
        $userinfo = $this->user;
        if($userinfo['identity']==3){
            $categoryjs = $_ENV['category']->get_jsforcustomer();
        }else {
            $categoryjs = $_ENV['category']->get_js();
        }
        //$categoryjs = $_ENV['category']->get_js();

        $askfromuid = intval($this->get['2']);
        if ($askfromuid) {


            $touser = $_ENV['user']->get_by_uid($askfromuid);


            if ($touser['uid'] == $this->user['uid']) {
                $this->message("不能对自己提问!", 'BACK');
            }
        } else {

            // $_SESSION["asksid"]= '==========='.getRandChar(56);
        }


        if (is_mobile()) {
            $catetree = $_ENV['category']->get_categrory_tree($_ENV['category']->get_list());
        }


        include template('ask');

    }

    function onajaxgetcat()
    {
        $msg = array();
        if (intval($this->post['category'])) {
            $cid = intval($this->post['category']);
            $cid1 = 0;
            $cid2 = 0;
            $cid3 = 0;

            $category = $this->cache->load('category');
            if ($category[$cid]['grade'] == 1) {
                $cid1 = $cid;
            } else if ($category[$cid]['grade'] == 2) {
                $cid2 = $cid;
                $cid1 = $category[$cid]['pid'];
            } else if ($category[$cid]['grade'] == 3) {
                $cid3 = $cid;
                $cid2 = $category[$cid]['pid'];
                $cid1 = $category[$cid2]['pid'];
            } else {
                $msg['message'] = 'error';
                echo json_encode($msg);
                exit();
            }

            $msg['message'] = 'ok';
            $msg['cid'] = $cid;
            $msg['cid1'] = $cid1;
            $msg['cid2'] = $cid2;
            $msg['cid3'] = $cid3;

            echo json_encode($msg);
            exit();

        }
    }
     
    function onajaxadd()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        $iswxbrower = false;
        if (strstr($useragent, 'MicroMessenger')) {
            $iswxbrower = true;
        }
        $message = array();
        if ($this->user['uid'] == 0) {


            $message['message'] = '游客先登录在回答！';
            echo json_encode($message);
            exit();
        }

        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {
                $viewhref = urlmap('user/editemail', 1);


                $message['message'] = "必须激活邮箱才能提问!";
                echo json_encode($message);
                exit();
            }
        }

//        if (!$iswxbrower) {
//            if (isset($this->setting['code_ask']) && $this->setting['code_ask'] == '1' && $this->user['credit1'] < $this->setting['jingyan']) {
//                if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()) {
//
//                    $message['message'] = "验证码错误!";
//                    echo json_encode($message);
//                    exit();
//                }
//            }
//        }


        if ($this->user['isblack'] == 1) {

            $message['message'] = "黑名单用户无法发布问题!";
            echo json_encode($message);
            exit();
        }


        $title = htmlspecialchars($this->post['title']);
        if ($title == '') {

            $message['message'] = "标题不能为空!";
            echo json_encode($message);
            exit();

        }
        $q = $_ENV['question']->get_by_title(htmlspecialchars($title));
        if ($q != null) {
            $viewurl = urlmap('question/view/' . $q['id'], 2);

            $mpurl = SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'];
            $message['url'] = "$mpurl";
            $message['message'] = "已有同样问题存在!";
            echo json_encode($message);
            exit();
        }
        //  $description = strip_tags($this->post['description']);
        $description = $this->post['description'];
        $cid1 = intval($this->post['cid1']);
        $cid2 = intval($this->post['cid2']);
        $cid3 = intval($this->post['cid3']);
        $cid = intval($this->post['cid']);
        $authoritycontrol = 0;
        if (isset($this->post['authoritycontrol'])) {
            $authoritycontrol = $this->post['authoritycontrol'];
        }

        $hidanswer = intval($this->post['hidanswer']) ? 1 : 0;
        $price = abs($this->post['givescore']);
        $jine = floatval($this->post['jine']);
        $askfromuid = intval($this->post['askfromuid']);
        $needpay = 0;
        $touser = $_ENV['user']->get_by_uid($askfromuid); //邀请回答

        if ($touser != null) {
            if ($touser['uid'] == $this->user['uid']) {


                $message['message'] = "不能对自己提问!";
                echo json_encode($message);
                exit();
            }
            $needpay = $touser['mypay'];
        }


        $offerscore = $price;
        ($hidanswer) && $offerscore += 10;
        if ($jine == 0.1) {
            $message['message'] = "太扣了，金额不能小于0.2元";
            echo json_encode($message);
            exit();
        }
        if ($jine > 200) {
            $message['message'] = "金额不能大于200";
            echo json_encode($message);
            exit();
        }
        $tmjine = ($jine + $needpay) * 100;
        if ($this->user['jine'] < $tmjine) {
            $message['message'] = "您在平台账户钱包金额不够，请充值在提问";
            echo json_encode($message);
            exit();
        }
        $shangjin = $jine;

        if ($hidanswer == 1) {
            if (intval($this->user['credit2']) < $offerscore) {

                $message['message'] = "匿名发布财富值不够!匿名时会多消耗10财富值";
                echo json_encode($message);
                exit();
            }
        } else {
            if (intval($this->user['credit2']) < $offerscore) {

                $message['message'] = "财富值不够!";
                echo json_encode($message);
                exit();
            }
        }
        //检查审核和内容外部URL过滤
        $status = intval(1 != (1 & $this->setting['verify_question']));
        $allow = $this->setting['allow_outer'];
        if (3 != $allow && has_outer($description)) {
            if (0 == $allow) {

                $message['message'] = "内容包含外部链接，发布失败!";
                echo json_encode($message);
                exit();
            }
            1 == $allow && $status = 0;
            2 == $allow && $description = filter_outer($description);
        }
        //检查标题违禁词
        $contentarray = checkwords($title);
        1 == $contentarray[0] && $status = 0;
        if (2 == $contentarray[0]) {


            $message['message'] = "问题包含非法关键词，发布失败!";
            echo json_encode($message);
            exit();
        }
        $title = $contentarray[1];

        //检查问题描述违禁词
        $descarray = checkwords($description);
        1 == $descarray[0] && $status = 0;
        if (2 == $descarray[0]) {

            $message['message'] = "问题描述包含非法关键词，发布失败!";
            echo json_encode($message);
            exit();
        }
        $description = $descarray[1];

        /* 检查提问数是否超过组设置 */
        if ($this->user['questionlimits'] && ($_ENV['userlog']->rownum_by_time('ask') >= $this->user['questionlimits'])) {

            $message['message'] = "你已超过每小时最大提问数" . $this->user['questionlimits'] . ',请稍后再试！';
            echo json_encode($message);
            exit();
        }

        if ($this->user['groupid'] == 1) {
            $status = 1;
        }
        $qid = $_ENV['question']->add($title, $description, $hidanswer, $price, $cid, $cid1, $cid2, $cid3, $status, $shangjin, $askfromuid, $authoritycontrol);


        $_ENV['user']->follow($qid, $this->user['uid'], $this->user['username']);

        if ($this->user['uid']) {
            $this->credit($this->user['uid'], 0, -$offerscore, 0, 'offer');
            $this->credit($this->user['uid'], $this->setting['credit1_ask'], $this->setting['credit2_ask']);
        }
        $viewurl = urlmap('question/view/' . $qid, 2);

        //如果ucenter开启，则postfeed
        if ($this->setting["ucenter_open"] && $this->setting["ucenter_ask"]) {
            $this->load('ucenter');
            $_ENV['ucenter']->ask_feed($qid, $title, $description);
        }
        $_ENV['userlog']->add('ask');
        $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 1, $qid, $description);


        if (0 == $status) { //这个status==0是什么意思？

            $message['url'] = SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'];
            $message['sh'] = 1;
            $message['message'] = 'ok';
            echo json_encode($message);
            exit();

        } else {
            $this->load("message");
            $this->load("user");

        }
        /* 如果是向别人提问，这个就是邀请回答 则需要发个消息给别人 */
        if ($askfromuid) {
            $this->load("message");

            $weburl='<br> <a href="' . SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'] . '">点击查看问题</a>';
            $msginfo = $_ENV['email_msg']->question_invite($touser['realname'],$this->user['username'],$title,$weburl)  ;
            $this->send_msg_all($touser,$msginfo['title'],$msginfo['content']);


        } else
        {

            //改相关分类专家私信
            $expert1 = $this->sendmessagetoexpert($cid);
          
            $expert2 = $this->sendmessagetoexpert($cid1);
         
            $expert3 = $this->sendmessagetoexpert($cid2);
           
            $expert4 = $this->sendmessagetoexpert($cid3);
           
            $result = array_merge($expert1, $expert2, $expert3, $expert4);
           
            
            $result = $this-> unique_arr($result);
            //$result = array_unique($result);
            
        
            foreach ($result as $key => $val) {

                if ($this->user['uid'] != $val['uid']){
                    $expert =$_ENV['user']->get_by_uid($val['uid']);
                    $categoryname=$_ENV['category']->get($val['cid']);
                    $weburl = ' <br> <a href="' . SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'] . '">'.' 点击查看</a>';
                    $msginfo = $_ENV['email_msg']->question_add($expert['realname'],$categoryname['name'],$title,$weburl); //获取领域专家消息
                    $this->send_msg_all($expert,$msginfo['title'],$msginfo['content']);
                    //$_ENV['message']->add($this->user['username'], $this->user['uid'], $val['uid'], $msginfo['title'], $msginfo['content']);
                    //if (isset($this->setting['notify_mail']) && $this->setting['notify_mail'] == '1' && $expert['active'] == 1) {
                    //    $_ENV['email']->sendmail($expert['email'], $msginfo['title'],$msginfo['content']);

                    //}
                    
                }

            }

        }
        
     
        $message['url'] = SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'];
        $message['message'] = "ok";
        echo json_encode($message);
        exit();


        
    }

    function unique_arr($array2D,$stkeep=false,$ndformat=true)
    {
        // 判断是否保留一级数组键 (一级数组键可以为非数字)
        if($stkeep) $stArr = array_keys($array2D);
        // 判断是否保留二级数组键 (所有二级数组键必须相同)
        if($ndformat) $ndArr = array_keys(end($array2D));
        //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
        foreach ($array2D as $v){
            $v = join(",",$v); 
            $temp[] = $v;
        }
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_unique($temp); 
        //再将拆开的数组重新组装
        foreach ($temp as $k => $v)
        {
            if($stkeep) $k = $stArr[$k];
            if($ndformat)
            {
                $tempArr = explode(",",$v); 
                foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
            }
            else $output[$k] = explode(",",$v); 
        }
        return $output;
    }
    
    function sendmessagetoexpert($cid)
    {
        $expertlist = $_ENV['expert']->getlist_by_cid($cid);

        return $expertlist;
    }

    /* 浏览问题 */

    function onview()
    {
        //先检查是否有权限查看

        $useragent = $_SERVER['HTTP_USER_AGENT'];


        $this->setting['stopcopy_on'] && $_ENV['question']->stopcopy(); //是否开启了防采集功能
        $qid = intval($this->get[2]); //接收qid参数

        //  echo 'get2:'.$this->get[2]."<br>";
        // echo 'get3:'.$this->get[3]."<br>";
        //  echo 'get4:'.$this->get[4]."<br>";
        //  exit();
        $_ENV['question']->add_views($qid); //更新问题浏览次数
        $question = $_ENV['question']->get($qid);
        if(!$_ENV['question']->checkisallowed($question)){
            $this->message('您没有权限查看此问题！');
        }
        $topiclist = $_ENV['topic']->get_bycatid($question['cid'], 0, 8);
        empty($question) && $this->message('问题已经被删除！');
        (0 == $question['status']) && $this->message('问题正在审核中,请耐心等待！');
        /* 问题过期处理 */
        if ($question['endtime'] < $this->time && ($question['status'] == 1 || $question['status'] == 4)) {
            $question['status'] = 9;
            $_ENV['question']->update_status($qid, 9);
            $this->send($question['authorid'], $question['id'], 2);
        }
        $asktime = tdate($question['time']);
        $endtime = timeLength($question['endtime'] - $this->time);
        $solvetime = tdate($question['endtime']);
        $supplylist = $_ENV['question']->get_supply($question['id']);


        $ordertype = 1;
        if (strpos($this->get[3], 'u') == false) {
            if (isset($this->get[3]) && $this->get[3] == 1) {
                $ordertype = 2;
                $ordertitle = '倒序查看回答';
            } else {

                $ordertype = 1;
                $ordertitle = '正序查看回答';
            }
        } else {

        }
        $seo_userinfo = "";
        $seo_answerinfo = "";
        if (strpos($this->get[3], 'u') !== false) {
            $uids = explode('u-', $this->get[3]);
            $aids = explode('a-', $this->get[4]);
            $user = $_ENV['user']->get_by_uid($uids[1]);
            $seo_userinfo = $user['username'] . "的回答";
            $this->load('answer');
            $seo_answerinfo = $_ENV['answer']->get($aids[1]);
            $seo_answerinfo['content'] = strip_tags($seo_answerinfo['content']);

        }
        //回答分页      
        @$page = 0;
        if (strpos($this->get[4], 'a') !== false) {
            @$page = 1;

        } else {
            @$page = max(1, intval($this->get[3]));
        }

        $pagesize = 3;// $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total("answer", " qid=$qid AND status>0 AND adopttime =0");
        $answerlistarray = $_ENV['answer']->list_by_qid($qid, $ordertype, $rownum, $startindex, $pagesize);
        $departstr = page($rownum, $pagesize, $page, "question/view/$qid");
        $answerlist = $answerlistarray[0];
        $already = $answerlistarray[1];
        $solvelist = $_ENV['question']->list_by_cfield_cvalue_status('cid', $question['cid'], 2);
        $nosolvelist = $_ENV['question']->list_by_cfield_cvalue_status('cid', $question['cid'], 1);

        
        $nav_ques = $_ENV['category']->get_navigation($question['cid'],true); //获取问题分类列表

        $quetemp =0;
        $count = count($nav_ques);
        for ($i = 0; $i < $count; $i++)
        {
            $quetemp.=$nav_ques[$i]['name'].'/';
        }
        $quetemp= substr($quetemp,1,strlen($quetemp)-1);
        $nav_ques=$quetemp;
        
        
        
        // $this->load('paylog');

        foreach ($answerlist as $k => $v) {

            $user = $_ENV['user']->get_by_uid($answerlist[$k]['authorid']);
            $answerlist[$k]['signature'] = $user['signature'];
            if ($answerlist[$k]['reward'] == 0) {
                $answerlist[$k]['canview'] = 1;
            } else {
                $one = $_ENV['paylog']->selectbyfromuid($this->user['uid'], $answerlist[$k]['id']);
                if ($one != null) {
                    $answerlist[$k]['canview'] = 1;
                } else {
                    $answerlist[$k]['canview'] = 0;
                }
            }

            //$answerlist[$k]['signature']
        }
        $navlist = $_ENV['category']->get_navigation($question['cid'], true);
        $expertlist = $_ENV['expert']->get_by_cid($question['cid']);
        $typearray = array('1' => 'nosolve', '2' => 'solve', '4' => 'nosolve', '6' => 'solve', '9' => 'close');
        $typedescarray = array('1' => '待解决', '2' => '已解决', '4' => '高悬赏', '6' => '已推荐', '9' => '已关闭');
        $navtitle = $question['title'];
        $dirction = $typearray[$question['status']];
        $bestanswer = $_ENV['answer']->get_best($qid);


        $categoryjs = $_ENV['category']->get_js();
        $taglist = $_ENV['tag']->get_by_qid($qid);
        $expertlist = $_ENV['expert']->get_by_cid($question['cid']);
        $is_followedauthor = $_ENV['user']->is_followed($question['authorid'], $this->user['uid']);
        $is_followed = $_ENV['question']->is_followed($qid, $this->user['uid']);
        $followerlist = $_ENV['question']->get_follower($qid);
        /* SEO */
        $curnavname = $navlist[count($navlist) - 1]['name'];
        if (!$bestanswer) {
            $bestanswer = array();
            $bestanswer['content'] = '';
        } else {
            $user = $_ENV['user']->get_by_uid($bestanswer['authorid']);
            $bestanswer['signature'] = $user['signature'];
        }

        //收藏的人
        $this->load("favorite");
        $favoritelist = $_ENV['favorite']->get_list_byqid($qid);


        if ($this->setting['seo_question_title']) {
            $seo_title = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_question_title']);
            $seo_title = str_replace("{wtbt}", $question['title'], $seo_title);
            $seo_title = str_replace("{wtzt}", $typedescarray[$question['status']], $seo_title);
            $seo_title = str_replace("{flmc}", $curnavname, $seo_title);
            if ($page != 1) {
                $seo_title = $seo_title . "-第" . $page . "页回答" . $seo_userinfo;
            } else {
                $seo_title = $seo_title . $seo_userinfo;
            }


        } else {
            if ($page != 1) {
                $navtitle = $navtitle . "-第" . $page . "页回答" . $seo_userinfo;
            } else {
                $navtitle = $navtitle . $seo_userinfo;
            }

        }
        if ($this->setting['seo_question_description']) {
            $seo_description = $seo_answerinfo['content'];
            $seo_description = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_question_description']);
            $seo_description = str_replace("{wtbt}", $question['title'], $seo_description);
            $seo_description = str_replace("{wtzt}", $typedescarray[$question['status']], $seo_description);
            $seo_description = str_replace("{flmc}", $curnavname, $seo_description);
            $seo_description = str_replace("{wtms}", strip_tags($question['description']), $seo_description);
            $seo_description = str_replace("{zjda}", strip_tags($bestanswer['content']), $seo_description);

            if (!$seo_answerinfo['content']) {
                $seo_description = $seo_description . "。最佳回答：" . strip_tags($bestanswer['content']);
            } else {
                $seo_description = $seo_description . "。最佳回答：" . $seo_answerinfo['content'];
            }
        } else {

            if (!$seo_answerinfo['content']) {
                $seo_description = strip_tags($bestanswer['content']);
            } else {
                $seo_description = $seo_answerinfo['content'];
            }

        }
        if ($this->setting['seo_question_keywords']) {
            $seo_keywords = $seo_answerinfo['content'];
            $seo_keywords = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_question_keywords']);
            $seo_keywords = str_replace("{wtbt}", $question['title'], $seo_keywords);
            $seo_keywords = str_replace("{wtzt}", $typedescarray[$question['status']], $seo_keywords);
            $seo_keywords = str_replace("{flmc}", $curnavname, $seo_keywords);
            $seo_keywords = str_replace("{wtbq}", implode(",", $taglist), $seo_keywords);
            $seo_keywords = str_replace("{description}", strip_tags($question['description']), $seo_keywords);
            $seo_keywords = str_replace("{zjda}", strip_tags($bestanswer['content']), $seo_keywords);
        } else {


            $seo_keywords = implode(",", $taglist);
        }

        $seo_description = str_replace('&nbsp;', '，', $seo_description);
        $bid = $bestanswer['id'];


        include template('solve');
    }


    function onanswer()
    {
        //只允许专家回答问题
//        if (isset($this->setting['allow_expert']) && $this->setting['allow_expert'] && !$this->user['expert']) {
//            $this->message('站点已设置为只允许专家回答问题，如有疑问请联系站长.');
//        }
//        $qid = $this->post['qid'];
//        $question = $_ENV['question']->get($qid);
//        if (!$question) {
//            $this->message('提交回答失败,问题不存在!');
//        }
//       	if(isset($this->setting['register_on'])&&$this->setting['register_on']=='1'){
//        				if($this->user['active']!=1&&$this->user['groupid']!=1){
//        				
//        					   $this->message("必须激活邮箱才能回复!",'question/view/' . $qid );
//        				}
//        			}
//    	if(isset($this->setting['code_ask'])&&$this->setting['code_ask']=='1'){
//        				   if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()) {
//            $this->message($this->post['state']."验证码错误!", 'BACK');
//        }
//        				}
//        if ($this->user['uid'] == $question['authorid']) {
//            $this->message('提交回答失败，不能自问自答！', 'question/view/' . $qid);
//        }
//        $this->setting['code_ask'] && $this->checkcode(); //检查验证码
//        $already = $_ENV['question']->already($qid, $this->user['uid']);
//        $already && $this->message('不能重复回答同一个问题，可以修改自己的回答！', 'question/view/' . $qid);
//        $title = $this->post['title'];
//        $content = $this->post['content'];
//        //检查审核和内容外部URL过滤
//        $status = intval(2 != (2 & $this->setting['verify_question']));
//        $allow = $this->setting['allow_outer'];
//        if (3 != $allow && has_outer($content)) {
//            0 == $allow && $this->message("内容包含外部链接，发布失败!", 'BACK');
//            1 == $allow && $status = 0;
//            2 == $allow && $content = filter_outer($content);
//        }
//        //检查违禁词
//        $contentarray = checkwords($content);
//        1 == $contentarray[0] && $status = 0;
//        2 == $contentarray[0] && $this->message("内容包含非法关键词，发布失败!", 'BACK');
//        $content = $contentarray[1];
//
//        /* 检查提问数是否超过组设置 */
//        ($this->user['answerlimits'] && ($_ENV['userlog']->rownum_by_time('answer') >= $this->user['answerlimits'])) &&
//                $this->message("你已超过每小时最大回答数" . $this->user['answerlimits'] . ',请稍后再试！', 'BACK');
//
//
//$content_temp=str_replace('<p>', '', $content);
//$content_temp=str_replace('</p>', '', $content_temp);
//$content_temp=str_replace('&nbsp;', '', $content_temp);
//$content_temp= preg_replace("/\s+/",'',$content_temp);
//$content_temp = preg_replace('/s(?=s)/', '', $content_temp);
//$content_temp=trim($content_temp);
//         if(trim($content_temp)==''){
//         	$this->message('回答不能为空！', 'BACK');
//         }
//         if($this->user['groupid']==1){
//         	$status=2;
//         }
//         	
//         	
//         
//        $_ENV['answer']->add($qid, $title, $content, $status);
//        //回答问题，添加积分
//        $this->credit($this->user['uid'], $this->setting['credit1_answer'], $this->setting['credit2_answer']);
//        //给提问者发送通知
//        $this->send($question['authorid'], $question['id'], 0);
//        //如果ucenter开启，则postfeed
//        if ($this->setting["ucenter_open"] && $this->setting["ucenter_answer"]) {
//            $this->load('ucenter');
//            $_ENV['ucenter']->answer_feed($question, $content);
//        }
//        $viewurl = urlmap('question/view/' . $qid, 2);
//        $_ENV['userlog']->add('answer');
//        $_ENV['doing']->add($this->user['uid'], $this->user['username'], 2, $qid, $content);
//        if (0 == $status) {
//            $this->message('提交回答成功！为了确保问答的质量，我们会对您的回答内容进行审核。请耐心等待......', 'BACK');
//        } else {
//        	$quser= $_ENV['user']->get_by_uid($question['authorid']);
//        	 global $setting;
//        	$mpurl = SITE_URL . $setting['seo_prefix'] . $viewurl.$setting['seo_suffix'];
//        	 //发送邮件通知
//            $subject = "问题有新回答！" ;
//            $message = $content.'<p>现在您可以点击<a swaped="true" target="_blank" href="' . $mpurl . '">查看最新回复</a>。</p>';
//                 if(isset($this->setting['notify_mail'])&&$this->setting['notify_mail']=='1'&&$quser['active']==1){
//                    sendmail($quser, $subject, $message);
//                 }
//            $this->message('提交回答成功！', $viewurl);
//        }
    }

    /* 采纳答案 */

    function onadopt()
    {
//        $qid = intval($this->post['qid']);
//        $aid = intval($this->post['aid']);
//        $comment = $this->post['content'];
//        $question = $_ENV['question']->get($qid);
//        $answer = $_ENV['answer']->get($aid);
//        $ret = $_ENV['answer']->adopt($qid, $answer);
//        if ($ret) {
//            $this->load("answer_comment");
//            $_ENV['answer_comment']->add($aid, $comment, $question['authorid'], $question['author']);
//            $this->credit($answer['authorid'], $this->setting['credit1_adopt'], intval($question['price'] + $this->setting['credit2_adopt']), 0, 'adopt');
//            $this->send($answer['authorid'], $question['id'], 1);
//            $viewurl = urlmap('question/view/' . $qid, 2);
//            $_ENV['doing']->add($question['authorid'], $question['author'], 8, $qid, $comment, $answer['id'], $answer['authorid'], $answer['content']);
//        }
//$quser= $_ENV['user']->get_by_uid($answer['authorid']);
//        	 global $setting;
//        	$mpurl = SITE_URL . $setting['seo_prefix'] . $viewurl.$setting['seo_suffix'];
//        	 //发送邮件通知
//            $subject = "你的问题被采纳(".$question['title'].")！" ;
//            $message = $comment.'<p>现在您可以点击<a swaped="true" target="_blank" href="' . $mpurl . '">查看详情</a>。</p>';
//             try{
//            if(isset($this->setting['notify_mail'])&&$this->setting['notify_mail']=='1'&&$$quser['active']==1){
//            sendmail($quser, $subject, $message);
//                 }
//             }catch (Exception $e){
//             	 $this->message('采纳答案成功！', $viewurl);
//             }
//            $this->message('采纳答案成功！', $viewurl);
    }

    function onajaxadopt()
    {
        $message = array();
        $qid = intval($this->post['qid']);
        $aid = intval($this->post['aid']);
        $comment = $this->post['content'];
        $question = $_ENV['question']->get($qid);
        $answer = $_ENV['answer']->get($aid);
        //判断问题是否被采纳过了
        if ($question['status'] == 2) {
            $message['message'] = '此问题已经采纳过了';
            echo json_encode($message);
            exit();
        }
        //判断这个回答是否被采纳过了
        if ($answer['adopttime'] > 0) {
            $message['message'] = '此回答已经采纳过了';
            echo json_encode($message);
            exit();
        }
        $ret = $_ENV['answer']->adopt($qid, $answer);

        $touid = $answer['authorid'];
        $quid = $question['authorid'];

        if ($ret) {
            $this->load("answer_comment");
            $_ENV['answer_comment']->add($aid, $comment, $question['authorid'], $question['author']);

            $this->credit($answer['authorid'], $this->setting['credit1_adopt'], intval($question['price'] + $this->setting['credit2_adopt']), 0, 'adopt');
            //通知提问者，问题已经被采纳
            $msginfo =$_ENV['email_msg']->question_adopt($question['author'],$question['title'],$answer['content']);
            $quser = $_ENV['user']->get_by_uid($quid);
            $this->sendmsg($quser,$msginfo['title'],$msginfo['content']);
            //$this->send($answer['authorid'], $question['id'], 1);
            $viewurl = urlmap('question/view/' . $qid, 2);
            global $setting;
          
            $_ENV['doing']->add($question['authorid'], $question['author'], 8, $qid, $comment, $answer['id'], $answer['authorid'], $answer['content']);
            $weburl = ' <br> <a href="' . SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'] . '">'.' 点击查看</a>';

            //通知关注着  问题已经被采纳
            $userlist = $_ENV['favorite']->get_list_byqid_fav($question['id']);
            foreach ($userlist as $val)
            {
                $msginfo = $_ENV['email_msg']->question_adopt_with($val['realname'],$question['title'],$weburl);
                $this->sendmsg($val,$msginfo['title'],$msginfo['content']);
            }
            //通知问题回答者
            
            $msginfo = $_ENV['email_msg']->question_adopt_ans($answer['author'],$question['title'] ,$weburl);
            $quser = $_ENV['user']->get_by_uid($answer['authorid']);
            $this->sendmsg($quser,$msginfo['title'],$msginfo['content']);
            
            
           
            
        }
     
        //global $setting;
       
        ////发送邮件通知
        //$subject = "你的问题被采纳(" . $question['title'] . ")！";
        //$emailmessage = $comment . '<p>现在您可以点击<a swaped="true" target="_blank" href="' . $mpurl . '">查看详情</a>。</p>';
        //try {
        //    if (isset($this->setting['notify_mail']) && $this->setting['notify_mail'] == '1' && $quser['active'] == 1) {
        //        sendmail($quser, $subject, $emailmessage);
        //    }
        //} catch (Exception $e) {
        //    $message['message'] = 'ok';
        //    echo json_encode($message);
        //    exit();

        //}
        $message['message'] = 'ok';
        echo json_encode($message);
        exit();
    }

    /* 结束问题，没有满意的回答，还可直接结束提问，关闭问题。 */

    function onclose()
    {
        $qid = intval($this->get[2]) ? intval($this->get[2]) : $this->post['qid'];
        //通知信息给作者和回答者
        $question = $_ENV['question']->get($qid);
        $touser =$_ENV['user']->get_by_uid($question['authorid']);
     
        $msginfo =$_ENV['email_msg']->question_close($question['author'],$question['title'],$this->user['realname'],tdate(time()));
        $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
        
        //$ansusers = $_ENV['answer']->getanser_user($question['id']); //去掉关闭问题通知评论者
        
        //foreach ($ansusers as $val)
        //{           
        //    $touser =$_ENV['user']->get_by_uid($val['authorid']);
        //    $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
        //}
        
        
        $_ENV['question']->update_status($qid, 9);
        $viewurl = urlmap('question/view/' . $qid, 2);
        $this->message('关闭问题成功！', $viewurl);
    }

    /* 补充提问细节 */

    function onsupply()
    {
        $qid = $this->get[2] ? $this->get[2] : $this->post['qid'];

        $question = $_ENV['question']->get($qid);
        if (!$question) {
            $this->message("问题不存在或已被删除!", "STOP");
        }
        if ($question['authorid'] != $this->user['uid'] || $this->user['uid'] == 0) {
            $this->message("非法操作!", "STOP");
            exit;
        }

        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {

                $this->message("必须激活邮箱才能补充!", 'question/view/' . $qid);
            }
        }
        $navlist = $_ENV['category']->get_navigation($question['cid'], true);
        if (isset($this->post['submit'])) {
//            if ($this->user['grouptype'] != 1) {
//                if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()) {
//                    $this->message($this->post['state'] . "验证码错误!", 'BACK');
//                }
//            }
            $content = $this->post['content'];
            //检查审核和内容外部URL过滤
            $status = intval(1 != (1 & $this->setting['verify_question']));
            $allow = $this->setting['allow_outer'];
            if (3 != $allow && has_outer($content)) {
                0 == $allow && $this->message("内容包含外部链接，发布失败!", 'BACK');
                1 == $allow && $status = 0;
                2 == $allow && $content = filter_outer($content);
            }
            //检查违禁词
            $contentarray = checkwords($content);
            1 == $contentarray[0] && $status = 0;
            2 == $contentarray[0] && $this->message("内容包含非法关键词，发布失败!", 'BACK');
            $content = $contentarray[1];

            $question = $_ENV['question']->get($qid);
            //问题最大补充数限制
            (count(unserialize($question['supply'])) >= $this->setting['apend_question_num']) && $this->message("您已超过问题最大补充次数" . $this->setting['apend_question_num'] . ",发布失败！", 'BACK');
            if ($this->user['groupid'] == 1) {
                $status = 1;
            }

            $_ENV['question']->add_supply($qid, $question['supply'], $content, $status); //添加问题补充
            $viewurl = urlmap('question/view/' . $qid, 2);
            if (0 == $status) {
                $this->message('补充问题成功！为了确保问答的质量，我们会对您的提问内容进行审核。请耐心等待......', 'BACK');
            } else {
                $this->message('补充问题成功！', $viewurl);
            }
        }
        include template("supply");
    }

    function onajaxsupply()
    {
        $message = array();
        $qid = $this->get[2] ? $this->get[2] : $this->post['qid'];

        $question = $_ENV['question']->get($qid);
        if (!$question) {


            $message['message'] = "问题不存在或已被删除!";
            echo json_encode($message);
            exit();

        }
        if ($question['authorid'] != $this->user['uid'] || $this->user['uid'] == 0) {

            $message['message'] = "非法操作!";
            echo json_encode($message);
            exit();
        }

        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {


                $message['message'] = "必须激活邮箱才能补充!";
                echo json_encode($message);
                exit();
            }
        }


//        if ($this->user['grouptype'] != 1) {
//            if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code() && $this->user['credit1'] < $this->setting['jingyan']) {
//
//
//                $message['message'] = "验证码错误!";
//                echo json_encode($message);
//                exit();
//            }
//        }
        $content = $this->post['content'];
        //检查审核和内容外部URL过滤
        $status = intval(1 != (1 & $this->setting['verify_question']));
        $allow = $this->setting['allow_outer'];
        if (3 != $allow && has_outer($content)) {
            if (0 == $allow) {

                $message['message'] = "内容包含外部链接，发布失败!";
                echo json_encode($message);
                exit();
            }
            1 == $allow && $status = 0;
            2 == $allow && $content = filter_outer($content);
        }
        //检查违禁词
        $contentarray = checkwords($content);
        1 == $contentarray[0] && $status = 0;
        if (2 == $contentarray[0]) {

            $message['message'] = "内容包含非法关键词，发布失败!";
            echo json_encode($message);
            exit();
        }
        $content = $contentarray[1];

        $question = $_ENV['question']->get($qid);
        //问题最大补充数限制
        if (count(unserialize($question['supply'])) >= $this->setting['apend_question_num']) {

            $message['message'] = "您已超过问题最大补充次数" . $this->setting['apend_question_num'] . ",发布失败！";


            echo json_encode($message);
            exit();

        }
        if ($this->user['groupid'] == 1) {
            $status = 1;
        }

        $_ENV['question']->add_supply($qid, $question['supply'], $content, $status); //添加问题补充
        $viewurl = urlmap('question/view/' . $qid, 2);
        if (0 == $status) {


            $message['url'] = SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'];
            $message['sh'] = 1;
            $message['message'] = 'ok';


            echo json_encode($message);
            exit();

        } else {


            $message['url'] = SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'];

            $message['message'] = 'ok';
            echo json_encode($message);
            exit();
        }


    }

    /* 追加悬赏 */

    function onaddscore()
    {
        $qid = intval($this->post['qid']);
        $score = abs($this->post['score']);
        if ($this->user['credit2'] < $score) {
            $this->message("财富值不足!", 'BACK');
        }
        $_ENV['question']->update_score($qid, $score);
        $this->credit($this->user['uid'], 0, -$score, 0, 'offer');
        $viewurl = urlmap('question/view/' . $qid, 2);
        $this->message('追加悬赏成功！', $viewurl);
    }

    /* 修改回答 */

    function oneditanswer()
    {
        $navtitle = '修改回答';
        $aid = $this->get[2] ? $this->get[2] : $this->post['aid'];
        $answer = $_ENV['answer']->get($aid);

        //判断当前用户是不是超级管理员
        $candone = false;
        if ($this->user['grouptype'] == 1) {
            $candone = true;
        } else {
            //判断当前用户是不是回答者本人

            if ($this->user['uid'] == $answer['authorid']) {
                $candone = true;
            }
        }

        if ($candone == false) {
            $this->message("非法操作,您的ip已被系统记录！", "STOP");
        }


        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {

                $this->message("必须激活邮箱才能修改回答!", 'question/view/' . $answer['qid']);
            }
        }

        (!$answer) && $this->message("回答不存在或已被删除！", "STOP");
        $question = $_ENV['question']->get($answer['qid']);
        $navlist = $_ENV['category']->get_navigation($question['cid'], true);

        include template("editanswer");
    }

    function onajaxeditanswer()
    {
        $message = array();
        $aid = $this->get[2] ? $this->get[2] : $this->post['aid'];
        $answer = $_ENV['answer']->get($aid);

        //判断当前用户是不是超级管理员
        $candone = false;
        if ($this->user['grouptype'] == 1) {
            $candone = true;
        } else {
            //判断当前用户是不是回答者本人

            if ($this->user['uid'] == $answer['authorid']) {
                $candone = true;
            }
        }

        if ($candone == false) {

            $message['message'] = "非法操作,您的ip已被系统记录！";
            echo json_encode($message);
            exit();
        }


        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {


                $message['message'] = "必须激活邮箱才能修改回答!";
                echo json_encode($message);
                exit();

            }
        }

        if (!$answer) {


            $message['message'] = "回答不存在或已被删除！";
            echo json_encode($message);
            exit();
        }
        $question = $_ENV['question']->get($answer['qid']);
        $navlist = $_ENV['category']->get_navigation($question['cid'], true);
        if (isset($this->post['submit'])) {
            /*if ($this->user['grouptype'] != 1) {
                if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code() && $this->user['credit1'] < $this->setting['jingyan']) {


                    $message['message'] = "验证码错误!";
                    echo json_encode($message);
                    exit();

                }
            }*/
            $content = $this->post['content'];
            $viewurl = urlmap('question/view/' . $question['id'], 2);

            //检查审核和内容外部URL过滤
            $status = intval(2 != (2 & $this->setting['verify_question']));
            $allow = $this->setting['allow_outer'];
            if (3 != $allow && has_outer($content)) {
                if (0 == $allow) {


                    $message['message'] = "内容包含外部链接，发布失败!";
                    echo json_encode($message);
                    exit();
                }
                1 == $allow && $status = 0;
                2 == $allow && $content = filter_outer($content);
            }
            //检查违禁词
            $contentarray = checkwords($content);
            1 == $contentarray[0] && $status = 0;
            if (2 == $contentarray[0]) {


                $message['message'] = "内容包含非法关键词，发布失败!";
                echo json_encode($message);
                exit();
            }
            $content = $contentarray[1];

            if ($this->user['groupid'] == 1) {
                $status = 2;
            }
            $_ENV['answer']->update_content($aid, $content, $status);
            $quser = $_ENV['user']->get_by_uid($question['authorid']);
            //编辑问题答案通知作者和评论者
            global $setting;
            $mpurl = SITE_URL . $setting['seo_prefix'] . $viewurl . $setting['seo_suffix'];
            $qurl='<br> <a href="' .$viewurl . '">点击查看问题</a>'; //站内url都使用这个
            $msginfo =$_ENV['email_msg']->question_edit_ans($answer['author'],$question['title'],$this->user['realname'],tdate(time()),$qurl);
            $this->sendmsg($quser,$msginfo['title'],$msginfo['content']);
            //$ansusers = $_ENV['answer']->getanser_user($question['id']); //去掉编辑答案通知评论者
            //foreach ($ansusers as $val)
            //{           
            //    $touser =$_ENV['user']->get_by_uid($val['authorid']);
            //    $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
            //}

            if (0 == $status) {
                $message['sh'] = 1;
            }

            $message['url'] = $mpurl;

            $message['message'] = 'ok';


            echo json_encode($message);
            exit();
        }

    }
    //搜索全部问题

    //搜索问题
    function searchquestion($word, $qstatus)
    {


        $questionlist = $_ENV['question']->search_title($word, $qstatus, 0, 0, $this->serach_num);

        $lis = '';


        foreach ($questionlist as $key => $val) {
            $title = $questionlist[$key]['title'];
            $suffix = '?';
            if ($this->setting['seo_on']) {
                $suffix = '';
            }
            $fix = $this->setting['seo_suffix'];
            $title = str_replace('<em>', '', strtolower($title));
            $title = str_replace('</em>', '', strtolower($title));
            $title = str_replace('&lt;font color=red&gt;', '', strtolower($title));
            $title = str_replace('&lt;/font&gt;', '', strtolower($title));
            $li = ' <li class="item qitem" data-index="' . $key . '"><a href="' . SITE_URL . $suffix . 'q-' . $questionlist[$key]['id'] . $fix . '" text="网页提问词语联想第' . $key . '条">' . strip_tags($title) . '</a> </li>';
            $lis = $lis . $li;
        }
        echo $lis;
        exit();
    }

    //搜索文章
    function searcharticle($word)
    {
        $topiclist = $_ENV['topic']->list_by_tag($word, 0, $this->serach_num);
        if ($topiclist == null) {


            $topiclist = $_ENV['topic']->get_bylikename($word, 0, $this->serach_num);
        }

        $lis = '';

        $suffix = '?';
        if ($this->setting['seo_on']) {
            $suffix = '';
        }
        $fix = $this->setting['seo_suffix'];

        foreach ($topiclist as $key => $val) {
            $title = $topiclist[$key]['title'];
            $imgurl = $topiclist[$key]['image'];


            $index = strpos($imgurl, 'http');
            if ($index != 0) {
                $imgurl = SITE_URL . $imgurl;
            }
            $title = str_replace('<em>', '', strtolower($title));
            $title = str_replace('</em>', '', strtolower($title));
            $title = str_replace('&lt;font color=red&gt;', '', strtolower($title));
            $title = str_replace('&lt;/font&gt;', '', strtolower($title));
            $li = ' <li class="item articleitem" data-index="' . $key . '">
          	  <a href="' . SITE_URL . $suffix . 'article-' . $topiclist[$key]['id'] . $fix . '" text="网页提问词语联想第' . $key . '条">'
                . '<div class="row"><div class="col-sm-3">
          	  <img class="img-rounded pull-left" width="80" height="50" src="' . $imgurl . '" />
          	  </div><div class="col-sm-9 "><p class="art-desc pull-left color-white">' . str_replace('&nbsp;', '', strip_tags($title)) . '</p>
          	 
          	  
          	  </div></div>' .
                '</a> </li>';
            $lis = $lis . $li;
        }
        echo $lis;
        exit();
    }

    //搜索标签
    function searchtag($word)
    {

        $taglist = $_ENV['tag']->list_by_tagname($word, 0, $this->serach_num);
        $lis = '';

        $suffix = '?';
        if ($this->setting['seo_on']) {
            $suffix = '';
        }
        $fix = $this->setting['seo_suffix'];
        if ($taglist) {
            $lis = '<li class="list-group-item bold nopadding">问题话题<hr><li>';
        }
        foreach ($taglist as $key => $val) {
            $title = $taglist[$key]['name'];
            $qcountarr = $taglist[$key]['count'];
            $qcount = $qcountarr['sum'];
            $title = str_replace('<em>', '', strtolower($title));
            $title = str_replace('</em>', '', strtolower($title));
            $title = str_replace('&lt;font color=red&gt;', '', strtolower($title));
            $title = str_replace('&lt;/font&gt;', '', strtolower($title));
            $li = ' <li class="item tagitem" data-index="' . $key . '"><a href="' . SITE_URL . $suffix . 'tag-' . $taglist[$key]['name'] . $fix . '" ><span class="label label-danger pull-left mar-l-05 mar-t-05">' . strip_tags($title) . '</span><span class="pull-right  mar-r-1 font-12">' . $qcount . '个讨论</span></a> </li>';
            $lis = $lis . $li;
        }


        $topictaglist = $_ENV['topic_tag']->list_by_tagname($word, 0, $this->serach_num);
        if ($topictaglist) {
            $lis = '<li class="list-group-item bold nopadding">文章话题<hr><li>';
        }
        foreach ($topictaglist as $key => $val) {
            $title = $topictaglist[$key]['name'];
            $qcountarr = $topictaglist[$key]['count'];
            $qcount = $qcountarr['sum'];
            $title = str_replace('<em>', '', strtolower($title));
            $title = str_replace('</em>', '', strtolower($title));
            $title = str_replace('&lt;font color=red&gt;', '', strtolower($title));
            $title = str_replace('&lt;/font&gt;', '', strtolower($title));
            $li = ' <li class="item tagitem" data-index="' . $key . '"><a href="' . SITE_URL . $suffix . 'tag-' . $topictaglist[$key]['name'] . $fix . '" ><span class="label label-danger pull-left mar-l-05 mar-t-05">' . strip_tags($title) . '</span><span class="pull-right  mar-r-1 font-12">' . $qcount . '个讨论</span></a> </li>';
            $lis = $lis . $li;
        }

        echo $lis;
        exit();

    }

    //搜索用户
    function searchuser($word)
    {


        $userlist = $_ENV['user']->list_by_search_condition(" username like '%$word%'", 0, $this->serach_num);

        $lis = '';

        $suffix = '?';
        if ($this->setting['seo_on']) {
            $suffix = '';
        }
        $fix = $this->setting['seo_suffix'];

        foreach ($userlist as $key => $val) {
            $username = $userlist[$key]['username'];
            $avatar = $userlist[$key]['avatar'];
            $uid = $userlist[$key]['uid'];
            $answers = $userlist[$key]['answers'];
            $followers = $userlist[$key]['followers'];

            $li = ' <li class="useritem" data-index="' . $key . '">
          	  <div class="row clear"><div class="col-sm-2"><img width="45" height="45" class="img-rounded" src="' . $avatar . '" alt="' . $username . '" /></div>
          	  <div class="col-sm-10">
          	  <a class="text-danger clear bold font-12" href="' . SITE_URL . $suffix . 'u-' . $uid . $fix . '">' . $username . '</a>
          	 
          	  <span class="text-danger mar-ly-05">回答( ' . $answers . ')</span><span class="text-danger mar-ly-05">关注(' . $followers . ')</span>
          	 
          	  </div>
          	  </div>
          	   </li>';
            $lis = $lis . $li;
        }
        echo $lis;
        exit();


    }

    /* 搜索页面 */
    function onsearchkey()
    {

        if ($this->post['word']) {
            if (is_mobile()) {
                header("Location:" . SITE_URL . '?q=' . urlencode($this->post['word']));

                exit();
            }
            $tagid = $this->post['tagid'];
            $qstatus = $status = $this->get[3] ? $this->get[3] : 1;
            (1 == $status) && ($qstatus = "1,2,6,9");
            (2 == $status) && ($qstatus = "2,6");
            $word = trim($this->post['word']) ? trim($this->post['word']) : urldecode($this->get[2]);
            $word = str_replace(array("\\", "'", " ", "/", "&"), "", $word);
            $word = strip_tags($word);
            $word = htmlspecialchars($word);
            $word = taddslashes($word, 1);
            switch ($tagid) {
                case '0':
                    $this->searchquestion($word, $qstatus);
                    break;
                case '1':
                    $this->searchquestion($word, $qstatus);
                    break;
                case '2':
                    $this->searcharticle($word);
                    break;
                case '3':
                    $this->searchtag($word);
                    break;
                case '4':
                    $this->searchuser($word);
                    break;
            }

        } else {
            include template("searchkey");
        }


    }

    /* 搜索问题 */

    function onsearch()
    {
        $hidefooter = 'hidefooter';
        $type = "question";
        $qstatus = $status = $this->get[3] ? $this->get[3] : 1;
        (1 == $status) && ($qstatus = "1,2,6,9");
        (2 == $status) && ($qstatus = "2,6");
        if ($this->post['word']) {
            header("Location:" . SITE_URL . '?q=' . urlencode($this->post['word']));

            exit();
        }


        $_word = isset($this->get[2]) ? urldecode($this->get[2]) : 'ask2';
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {

            if (function_exists("iconv") && $this->get[2] != null) {
                $_word = iconv("GB2312", "UTF-8//IGNORE", $this->get[2]);

            }
        }
        $word = trim($this->post['word']) ? trim($this->post['word']) : urldecode($_word);
        $word = str_replace(array("\\", "'", " ", "/", "&"), "", $word);
        $word = strip_tags($word);
        $word = htmlspecialchars($word);
        $word = taddslashes($word, 1);

        (!$word) && $this->message("搜索关键词不能为空!", 'BACK');
        if (strpos($this->get[1], 'tag') > 0) {
            $navtitle = $word;

        } else {
            $navtitle = $word;
        }
        $seo_keywords = $word;
        $cid = intval($this->get[4])?$this->get[4]:'all';
        if ($cid != 'all') {
            $category = $this->category[$cid]; //得到分类信息
            $cfield = 'cid' . $category['grade'];
        } else {
            $category = $this->category;
            $cfield = '';
            $category['pid'] = 0;
        }
        if ($cid != 'all') {
            $category=$_ENV['category']->get($cid);
        }
        
        
        @$page = max(1, intval($this->get[5]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        if (preg_match("/^tag:(.+)/", $word, $tagarr)) {
            $tag = $tagarr[1];
            $rownum = $_ENV['question']->rownum_by_tag($tag, $qstatus);
            $questionlist1 = $_ENV['question']->list_by_tag($tag, $qstatus, $startindex, $pagesize);
        } else {
            $questionlist1 = $_ENV['question']->search_title($word, $qstatus, 0, $startindex, $pagesize,$cfield,$cid);
            $rownum = $_ENV['question']->search_title_num($word, $qstatus,$cfield,$cid);
        }
        
        $sublist = $_ENV['category']->query_list_by_cid_pid($cid); //获取子分类 
        
        foreach ($sublist as $key => $val)
        {
            $relrownum= $_ENV['question']->search_title_num($word,$qstatus,'cid'.$val['grade'],$val['id']);
            $sublist[$key]['topics']=$relrownum;
        }
        
        
        
        //if(count($questionlist)==0){
//				$tagarr=dz_segment($word);
//			//	print_r($tagarr);
//				//exit();
//				if(count($tagarr)>0){
//					 $tag = $tagarr[0];
//					  $rownum = $_ENV['question']->rownum_by_tag($tag, $qstatus);
//					 $questionlist2=$_ENV['question']->list_by_tag($tag,$qstatus, $startindex, $pagesize);
//				}


        //}
        
        $questionlist = $questionlist1;//array_merge($questionlist1,$questionlist2); //应该保证搜索的数量和文章的数量一致；
        //$qrownum = count($questionlist);
        foreach ($questionlist as $key=>$value)
        {
            $quesrc=  $_ENV['category']->get_navigation($value['cid'],true);
            $quetemp =0;
            $count = count($quesrc);
            for ($i = 0; $i < $count; $i++)
            {
                $quetemp.=$quesrc[$i]['name'].'/';
            }
            $quetemp= substr($quetemp,1,strlen($quetemp)-1);
            
            $questionlist[$key]['srcs']=$quetemp;
        }

        if ($rownum == 0) {
            $seo_keywords = "";
            $navtitle = '暂无搜索相关信息';

        } else {

            $navtitle = "关于-$word-的相关搜索";
        }
        $related_words = $_ENV['question']->get_related_words();
        $hot_words = $_ENV['question']->get_hot_words();
        $corrected_words = $_ENV['question']->get_corrected_word($word);
        $departstr = page($rownum, $pagesize, $page, "question/search/$word/$status/$cid");
        include template('search');
    }

    /* 提问自动搜索已经解决的问题 */

    function onajaxsearch()
    {
        $title = $this->get[2];
        $questionlist = $_ENV['question']->search_title($title, 2, 1, 0, 5);
        include template('ajaxsearch');
    }

    /* 顶指定问题 */

    function onajaxgood()
    {
        $qid = $this->get[2];
        $tgood = tcookie('good_' . $qid);
        !empty($tgood) && exit('-1');
        $_ENV['question']->update_goods($qid);
        tcookie('good_' . $qid, $qid);
        exit('1');
    }

    function ondelete()
    {
        $question = $_ENV['question']->get($this->get[2]);

        //判断当前用户是不是超级管理员
        $candone = false;
        if ($this->user['grouptype'] == 1) {
            $candone = true;
        } else {
            //判断当前用户是不是回答者本人

            if ($this->user['uid'] == $question['authorid']) {
                $candone = true;
            }
        }

        if ($candone == false) {
            $this->message("非法操作,您的ip已被系统记录！", "STOP");
        }
        //通知信息给 提问和回答者
        $touser = $_ENV['user']->get_by_uid($question['authorid']);
        $msginfo = $_ENV['email_msg']->question_del($question['author'],$question['title'],$this->user['realname'],tdate(time()));
        $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
        
        //$ansusers = $_ENV['answer']->getanser_user($question['id']); //去掉删除问题通知回答者
        //foreach ($ansusers as $val)
        //{           
        //    $touser =$_ENV['user']->get_by_uid($val['authorid']);
        //    $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
        //}

        $this->credit($question['authorid'], 0, $question['price'], 0, 'back');
        $_ENV['question']->remove(intval($this->get[2]));
        //删除问题  要处理的内容有
        //获取问题的用户id；
        //更新改id的问题数量
        //更新回答该问题用户的回答数量
        //暂时不弄
        

 
        $this->message('问题删除成功！', urlmap('index/default'));
    }

    //问题推荐
    function onrecommend()
    {
        $qid = intval($this->get[2]);
        $_ENV['question']->change_recommend($qid, 6, 2);
        $viewurl = urlmap('question/view/' . $qid, 2);
        $this->message('问题推荐成功!', $viewurl);
    }

    //编辑问题
    function onedit()
    {
        $navtitle = '编辑问题';
        $qid = $this->get[2] ? $this->get[2] : $this->post['qid'];
        $question = $_ENV['question']->get($qid);
        if (!$question)
            $this->message("问题不存在或已被删除!", "STOP");
//        if ($this->user['grouptype'] != 1) {
//            if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()) {
//                $this->message($this->post['state'] . "验证码错误!", 'BACK');
//            }
//        }
        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {

                $this->message("必须激活邮箱才能编辑问题!", urlmap('question/view/' . $qid, 2));
            }
        }
        $navlist = $_ENV['category']->get_navigation($question['cid'], true);
        if (isset($this->post['submit'])) {
            echo "这个地方还会进来吗？";
            exit();
            $viewurl = urlmap('question/view/' . $qid, 2);
            $title = trim($this->post['title']);
            (!trim($title)) && $this->message('问题标题不能为空!', $viewurl);
            $authoritycontrol = 0;
            if (isset($this->post['authoritycontrol'])) {
                $authoritycontrol = $this->post['authoritycontrol'];
            }
            $_ENV['question']->update_content($qid, $title, $this->post['content'],$authoritycontrol);
            
            //编辑问题通知作者和回答者
            $msginfo =$_ENV['email_msg']->question_edit($question['author'],$question['title'],$this->user['username'],$this->time);
            $touser =$_ENV['user']->get_by_uid($question['authorid']);
            $this->sendmsg($touser,$msginfo['titile'],$msginfo['content']);
            
            $ansusers = $_ENV['answer']->getanser_user($question['qid']);
            
            foreach ($ansusers as $val)
            {           
                $touser =$_ENV['user']->get_by_uid($val['authorid']);
            	$this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
            }
            $this->message('问题编辑成功!', $viewurl);
        }
        $userinfo = $this->user;
        include template("editquestion");
    }

    function onajaxedit()
    {
        $message = array();
        $qid = $this->get[2] ? $this->get[2] : $this->post['qid'];
        $question = $_ENV['question']->get($qid);
        if (!$question) {
            $message['message'] = "问题不存在或已被删除!";
            echo json_encode($message);
            exit();
        }


//        if ($this->user['grouptype'] != 1) {
//            if (strtolower(trim($this->post['code'])) != $_ENV['user']->get_code()) {
//
//                $message['message'] = "验证码错误!";
//                echo json_encode($message);
//                exit();
//            }
//        }
        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            if ($this->user['active'] != 1) {


                $message['message'] = "必须激活邮箱才能编辑问题!";
                echo json_encode($message);
                exit();

            }
        }
        $navlist = $_ENV['category']->get_navigation($question['cid'], true);
        if (isset($this->post['submit'])) {
            
          
            $viewurl = urlmap('question/view/' . $qid, 2);
        
            $title = trim($this->post['title']);
            if (!trim($title)) {
                $message['message'] = '问题标题不能为空!';
                echo json_encode($message);
                exit();
            }
            $authoritycontrol = 0;
            if (isset($this->post['authoritycontrol'])) {
                $authoritycontrol = $this->post['authoritycontrol'];
            }
            $_ENV['question']->update_content($qid, $title, $this->post['content'],$authoritycontrol);
            $qurl=' <a href="' .$viewurl . '">点击查看问题</a>'; //站内url都使用这个
            //编辑问题通知作者 
            $msginfo =$_ENV['email_msg']->question_edit($question['author'],$question['title'],$this->user['realname'], tdate(time()),$qurl);
            $touser =$_ENV['user']->get_by_uid($question['authorid']);
            $this->sendmsg($touser,$msginfo['titile'],$msginfo['content']);
            
            //$userlist = $_ENV['answer']->getanser_user($question['id']); 去掉编辑问题通知作者
            //foreach ($userlist as $val)
            //{
            //    $this->sendmsg($val,$msginfo['title'],$msginfo['content']);
            //}
            global $setting;
            $message['url'] = SITE_URL . $setting['seo_prefix'] . $viewurl . $setting['seo_suffix'];
            $message['message'] = 'ok';
            echo json_encode($message);
            exit();

        }

    }

    //编辑标签
    function onedittag()
    {
        $tag = trim($this->post['qtags']);
        $qid = intval($this->post['qid']);
        $viewurl = urlmap("question/view/$qid", 2);
        $message = $tag ? "标签修改成功!" : "标签不能为空!";
        $taglist = explode(" ", $tag);
        $taglist && $_ENV['tag']->multi_add(array_unique($taglist), $qid);
        $this->message($message, $viewurl);
    }

    //移动分类
    function onmovecategory()
    {
        if (intval($this->post['category'])) {
            $cid = intval($this->post['category']);
            $cid1 = 0;
            $cid2 = 0;
            $cid3 = 0;
            $qid = $this->post['qid'];
            $viewurl = urlmap('question/view/' . $qid, 2);
            $category = $this->cache->load('category');
            if ($category[$cid]['grade'] == 1) {
                $cid1 = $cid;
            } else if ($category[$cid]['grade'] == 2) {
                $cid2 = $cid;
                $cid1 = $category[$cid]['pid'];
            } else if ($category[$cid]['grade'] == 3) {
                $cid3 = $cid;
                $cid2 = $category[$cid]['pid'];
                $cid1 = $category[$cid2]['pid'];
            } else {
                $this->message('分类不存在，请更下缓存!', $viewurl);
            }
            $_ENV['question']->update_category($qid, $cid, $cid1, $cid2, $cid3);
            $this->message('问题分类修改成功!', $viewurl);
        }
    }

    //设为未解决
    function onnosolve()
    {
        $qid = intval($this->get[2]);
        $viewurl = urlmap('question/view/' . $qid, 2);
        $_ENV['question']->change_to_nosolve($qid);
        $this->message('问题状态设置成功!', $viewurl);
    }

    //前台删除问题回答
    function ondeleteanswer()
    {
        if ($this->user['uid'] == 0) {
            $this->message("你还没登录!", 'user/login');
        }
        $qid = intval($this->get[3]);
        $aid = intval($this->get[2]);
        $viewurl = urlmap('question/view/' . $qid, 2);
        $answer = $_ENV['answer']->get($aid);
        if ($answer['authorid'] != $this->user['uid'] && $this->user['grouptype'] != 1) {
            $this->message("非法操作!", $viewurl);
        }
        $_ENV['answer']->remove_by_qid($aid, $qid);
        $this->message("回答删除成功!", $viewurl);
    }

    //前台审核回答
    function onverifyanswer()
    {
        $qid = intval($this->get[3]);
        $aid = intval($this->get[2]);
        $viewurl = urlmap('question/view/' . $qid, 2);
        $_ENV['answer']->change_to_verify($aid);
        $this->message("回答审核完成!", $viewurl);
    }

    //问题关注
    function onattentto()
    {
        $qid = intval($this->get[2]);
        if (!$qid) {
            $this->message("问题不存在!");
        }
        if ($this->user['uid'] == 0) {
            $this->message("游客不能收藏!");
        }
        $is_followed = $_ENV['question']->is_followed($qid, $this->user['uid']);
        if ($is_followed) {
            $_ENV['user']->unfollow($qid, $this->user['uid']);
            $_ENV['doing']->deletedoing($this->user['uid'], 4, $qid);
            $this->message("已取消收藏!");
        } else {
            $_ENV['user']->follow($qid, $this->user['uid'], $this->user['username']);
            $question = taddslashes($_ENV['question']->get($qid), 1);
            $msgfrom = $this->setting['site_name'] . '管理员';
            $username = addslashes($this->user['username']);
            $this->load("message");
            $viewurl = url('question/view/' . $qid, 1);
            
            $msginfo = $_ENV['email_msg']->question_atto($question['author'],$question['title'],$this->user['realname']);
            $touser =$_ENV['user']->get_by_uid($question['authorid']);
            $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
            //$_ENV['message']->add($msgfrom, 0, $question['authorid'], $username . "刚刚关注了您的问题", '<a target="_blank" href="' . url('user/space/' . $this->user['uid'], 1) . '">' . $username . '</a> 刚刚关注了您的问题' . $question['title'] . '"<br /> <a href="' . $viewurl . '">点击查看</a>');
            $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 4, $qid);

            $this->message("问题收藏成功!");
        }

    }
    
    
     function onattentto1()
    {
        $qid = intval($this->get[2]);
        if (!$qid) {
            $this->message("专题不存在!");
        }
        if ($this->user['uid'] == 0) {
            $this->message("游客不能收藏!");
        }
        $is_followed = $_ENV['question']->is_followed($qid, $this->user['uid']);
        if ($is_followed) {
            $this->message("已取消收藏!");
        } else {
        $this->message("专题收藏成功!");
        }

    }

    function onfollow()
    {
        $qid = intval($this->get[2]);
        $question = taddslashes($_ENV['question']->get($qid), 1);
        if (!$question) {
            $this->message("问题不存在!");
            exit;
        }
        $page = max(1, intval($this->get[3]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $followerlist = $_ENV['question']->get_follower($qid, $startindex, $pagesize);
        $rownum = $this->db->fetch_total('question_attention', " qid=$qid ");
        $departstr = page($rownum, $pagesize, $page, "question/follow/$qid");
        include template("question_follower");
    }

    function onajaxinvitationanswer(){
        $qid = $this->post['qid'];
        if (!$qid) {
            $this->message("问题不存在!");
        }
        if ($this->user['uid'] == 0) {
            $this->message("游客不能邀请回答问题!");
        }
        $question = $_ENV['question']->get_askname_byid($qid);
        if($question) {
            exit('exist');
        }else{
            exit('notexist');
        }
    }

    function onajaxinvite_tip(){
        $qid = $this->get[2];
        $question = $_ENV['question']->get_askname_byid($qid);
        $askname = $question['realname'];
        include template("invite_tip");
    }

    function onajaxinvite_form(){
        $qid = $this->get[2];
        include template("invite_form");
    }
    function onupdateinvite_askuid(){
        $qid = $this->post[2];
        $question = taddslashes($_ENV['question']->get($qid), 1);
        $askuid = $this->post[3];
        $_ENV['question']->updateaskuid($qid,$askuid);
        $askuser = $_ENV['user']->get_by_uid($askuid, 2);//被邀请的人
        $url =SITE_URL . 'index.php?q-'.$qid.'html';
        $title = 'E问待办：有人在E问上向你求助了，请您协助解答！';
        $message = '<p>尊敬的' . $askuser['realname'] . '您好！</p>';
        //邀请者是否和问题拥有者一样
        if($this->user['realname'] == $question['author']){
            $message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->user['realname'].'有邀请您回答他的求助：<br/>';
        }else{
            $message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->user['realname'].'有邀请您回答'.$question['author'].'的求助：<br/>';
        }
        $message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$question['title'].'，感谢您的协助！<br/>';
        $message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="'.$url.'">点此答复</a><br/>';
        $this->sendmsg($askuser,$title,$message);
        $this->message("邀请回答成功");
    }
}

?>