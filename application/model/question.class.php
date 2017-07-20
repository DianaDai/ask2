<?php

!defined('IN_ASK2') && exit('Access Denied');

class questionmodel
{

    var $db;
    var $base;
    var $search;
    var $index;
    var $statustable = array(
        'all' => ' AND status<>0 ',
        '0' => ' AND status=0',
        '1' => ' AND status=1',
        '2' => ' AND status=2',
        '6' => ' AND status=6',
        '4' => ' AND status=1 AND price>0',
        '9' => ' AND status=9'
    );
    var $ordertable = array(
        'all' => 'AND status!=0 ORDER BY time DESC',
        '0' => ' AND status=0  ORDER BY shangjin DESC,hasvoice DESC, time DESC',
        '1' => ' AND status=1  ORDER BY shangjin DESC,hasvoice DESC, time DESC',
        '2' => ' AND status=2  ORDER BY  time DESC',
        '6' => ' AND status=6  ORDER BY shangjin DESC,hasvoice DESC, time DESC',
        '4' => ' AND status=1 AND price>0 ORDER BY shangjin DESC,hasvoice DESC, price DESC,time DESC',
        '9' => ' AND status=9  ORDER BY shangjin DESC,hasvoice DESC,time DESC'
    );

    function questionmodel(&$base)
    {
        $this->base = $base;
        $this->db = $base->db;
        if ($this->base->setting['xunsearch_open']) {
            require_once $this->base->setting['xunsearch_sdk_file'];

            $xs = new XS('question');

            $this->search = $xs->search;


            $this->index = $xs->index;


        }
    }

    //设为已解决
    function change_to_solve($qids)
    {
        $overdue_days = intval($this->base->setting['overdue_days']);
        $endtime = $this->base->time + $overdue_days * 86400;
        $adoptime = $this->base->time;
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set status=2, `endtime`=$endtime WHERE (status=6 OR status=1 OR status=9) AND answers>0 AND `id` in ($qids)");
        $this->db->query("UPDATE `" . DB_TABLEPRE . "answer` SET `adopttime`=$adoptime WHERE `qid` in ($qids)");
        if ($this->base->setting['xunsearch_open']) {
            foreach ($qids as $qid) {
                $question = array();
                $question['status'] = 2;
                $doc = new XSDocument;
                $doc->setFields($question);
                $this->index->update($doc);
            }
        }
    }

    /* 获取问题信息 */

    function get($id)
    {
        $question = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "question WHERE id='$id'");
        if ($question) {
            $question['format_time'] = tdate($question['time']);
            $question['ip'] = formatip($question['ip']);
            if ($question['askuid'] > 0) {
                $question['askuser'] = $this->get_by_uid($question['askuid']);
            }
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['author_avartar'] = get_avatar_dir($question['authorid']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['description'] = checkwordsglobal($question['description']);
        }
        return $question;
    }


    function get_by_title($title)
    {
        return $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "question WHERE `title`='$title'");
    }

    function get_by_uid($uid)
    {
        $user = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user WHERE uid='$uid'");
        $user['avatar'] = get_avatar_dir($uid);
        return $user;
    }

    function get_by_titleanddesc($title, $desc)
    {
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            return $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "question WHERE `title`='$title' and `description`='$desc' AND `authoritycontrol` = 2");
        } else {
            return $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "question WHERE `title`='$title' and `description`='$desc'");
        }
        //return $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "question WHERE `title`='$title' and `description`='$desc'");
    }

    function get_list($start = 0, $limit = 10)
    {
        $questionlist = array();
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE authoritycontrol=2 AND limit $start , $limit");
        } else {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE 1=1 limit $start , $limit");
        }
        //$query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE 1=1 limit $start , $limit");
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['description'] = checkwordsglobal($question['description']);
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    /* 获取问题标签 */

    function get_words($str, $spword = ' ', $strlen = 300)
    {
        $result = '';
        return $result;
    }

    /* 前台问题搜索 */

    function list_by_condition($condition, $start = 0, $limit = 10)
    {
        $questionlist = array();
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE authoritycontrol = 2 AND $condition order by time desc limit $start , $limit");
        } else {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE $condition order by time desc limit $start , $limit");
        }
        //$query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE $condition order by time desc limit $start , $limit");
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['description'] = checkwordsglobal($question['description']);
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    function get_hots($start, $limit)
    {
        $questionlist = array();
        $timestart = $this->base->time - 7 * 24 * 3600;
        $timeend = $this->base->time;
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "question WHERE `authoritycontrol` = 2 AND status in (1,2) AND  `time`>$timestart AND `time`<$timeend  ORDER BY answers DESC,views DESC, `time` DESC LIMIT $start,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "question WHERE status in (1,2) AND  `time`>$timestart AND `time`<$timeend  ORDER BY answers DESC,views DESC, `time` DESC LIMIT $start,$limit");
        }
        //$query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "question WHERE status in (1,2) AND  `time`>$timestart AND `time`<$timeend  ORDER BY answers DESC,views DESC, `time` DESC LIMIT $start,$limit");
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['description'] = checkwordsglobal($question['description']);
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    /* 后台问题数目 */

    function rownum_by_search($title = '', $author = '', $datestart = '', $dateend = '', $status = '', $cid = 0)
    {
        $condition = " 1=1 ";
        $title && ($condition .= " AND `title` like '%$title%' ");
        $author && ($condition .= " AND `author`='$author'");
        $datestart && ($condition .= " AND `time`>= " . strtotime($datestart));
        $dateend && ($condition .= " AND `time`<= " . strtotime($dateend));
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $condition .= " AND `authoritycontrol`=2 ";
        }
        if ($cid) {
            $category = $this->base->category[$cid];
            $condition .= " AND `cid" . $category['grade'] . "`= $cid ";
        }
        isset($this->statustable[$status]) && $condition .= $this->statustable[$status];
        return $this->db->fetch_total('question', $condition);
    }

    /* 后台问题搜索 */

    function list_by_search($title = '', $author = '', $datestart = '', $dateend = '', $status = '', $cid = 0, $start = 0, $limit = 10)
    {
        $sql = "SELECT * FROM `" . DB_TABLEPRE . "question` WHERE 1=1 ";
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $sql .= " AND `authoritycontrol`=2 ";
        }
        $title && ($sql .= " AND `title` like '%$title%' ");
        $author && ($sql .= " AND `author`='$author'");
        $datestart && ($sql .= " AND `time` >= " . strtotime($datestart));
        $dateend && ($sql .= " AND `time` <= " . strtotime($dateend));
        if ($cid) {
            $category = $this->base->category[$cid];
            $sql .= " AND `cid" . $category['grade'] . "`= $cid ";
        }
        isset($this->statustable[$status]) && $sql .= $this->statustable[$status];
        $sql .= " ORDER BY `time` DESC LIMIT $start,$limit";
        $questionlist = array();
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['description'] = checkwordsglobal($question['description']);
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    //通过标签获取同类问题
    function list_by_tag($name, $status = '1,2,6', $start = 0, $limit = 20)
    {
        $questionlist = array();
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` AS q," . DB_TABLEPRE . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.authoritycontrol =2 AND q.status IN ($status) ORDER BY q.answers DESC,q.time DESC LIMIT $start,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` AS q," . DB_TABLEPRE . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.status IN ($status) ORDER BY q.answers DESC,q.time DESC LIMIT $start,$limit");
        }
        //$query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` AS q," . DB_TABLEPRE . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.status IN ($status) ORDER BY q.answers DESC,q.time DESC LIMIT $start,$limit");
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);


            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['image'] = getfirstimg($question['description']);
            $question['description'] = cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...');
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    function rownum_by_tag($name, $status = '1,2,6')
    {
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` AS q," . DB_TABLEPRE . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.authoritycontrol =2 AND q.status IN ($status) ORDER BY q.answers DESC");
        } else {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` AS q," . DB_TABLEPRE . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.status IN ($status) ORDER BY q.answers DESC");
        }
        //$query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` AS q," . DB_TABLEPRE . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.status IN ($status) ORDER BY q.answers DESC");
        return $this->db->num_rows($query);
    }

    /* 删除问题和问题的回答 */

    function remove($qids)
    {
        //删除问题悬赏现金退回用户钱包
        $this->removetuoguan($qids);
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "question` WHERE `id` IN ($qids)");
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "question_tag` WHERE `qid` IN ($qids)");
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "doing` WHERE `questionid` IN ($qids)");
        $this->remove_supply_by_qid($qids);
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "answer_comment ` WHERE `aid` IN (SELECT id FROM " . DB_TABLEPRE . "answer WHERE `qid` IN($qids))");
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "answer_support ` WHERE `aid` IN (SELECT id FROM " . DB_TABLEPRE . "answer WHERE `qid` IN($qids))");
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "answer` WHERE `qid` IN ($qids)");
        //删除问题和回答后，用户信息的也同步更新
       
        if ($this->base->setting['xunsearch_open']) {
            $this->index->del(explode(",", $qids));
        }
    }

    function removetuoguan($qids)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "question` WHERE `id` IN ($qids)");
        while ($question = $this->db->fetch_array($query)) {
            $qid = $question['id'];
            $authorid = $question['authorid'];

            //是否有提问悬赏现金托管
            $model = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user_depositmoney WHERE  type='qid' and typeid=$qid and fromuid=$authorid and state=0");
            if ($model) {
                $fromuid = $model['fromuid'];
                $money = $model['needpay'] * 100;
                $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid");
                $time = time();
                $needpay = $model['needpay'];
                $this->db->query("INSERT INTO " . DB_TABLEPRE . "paylog SET type='thqid',typeid=$qid,money=$needpay,openid='',fromuid=0,touid=$fromuid,`time`=$time");
                $this->db->query("DELETE FROM `" . DB_TABLEPRE . "user_depositmoney` WHERE fromuid=$fromuid and type='qid' and typeid=$qid");
            }

            //是否有对专家付费提问
            $model1 = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user_depositmoney WHERE  type='eqid' and typeid=$qid and fromuid=$authorid and state=0");
            if ($model1) {
                $fromuid = $model1['fromuid'];
                $money = $model1['needpay'] * 100;
                $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid");
                $time = time();
                $needpay = $model1['needpay'];
                $this->db->query("INSERT INTO " . DB_TABLEPRE . "paylog SET type='theqid',typeid=$qid,money=$needpay,openid='',fromuid=0,touid=$fromuid,`time`=$time");
                $this->db->query("DELETE FROM `" . DB_TABLEPRE . "user_depositmoney` WHERE fromuid=$fromuid and type='eqid' and typeid=$qid");

            }


        }


    }
    /*问题列表追问未回答的信息*/

    function rownum_by_asknosove_list($cfield='cid1',$cvalue =0){
        $condition ="  where  qus.id = ans.qid AND ans.askflag=2   AND qus.status =1 and qus.answers >0 "; //未解决的问题并且问题有回答
        if ($this->base->user['identity']==2&&$this->base->user['username']!='admin')
        {
        	$condition.=" AND qus.authoritycontrol=2 ";
        }
        ($cfield&&$cvalue!='all')&& $condition.=" AND qus.$cfield=$cvalue";
        $sql = "select count(*) num FROM ".DB_TABLEPRE."question qus , ".DB_TABLEPRE."answer ans".$condition;
        return $this->db->result_first($sql);
    
    }
    /*获取问题追问未回答列表*/
    function list_by_asknosove_list($cfield='cid1',$cvalue=0,$start =0 ,$limit =10){
        $questionlist = array();
        $sql = "SELECT qus.* , ans.author as answer_name  FROM ".DB_TABLEPRE."question as qus, ".DB_TABLEPRE."answer as ans where  qus.id = ans.qid and ans.askflag =2 and qus.status=1 and qus.answers>0 ";
        if ($this->base->user['identity']==2 && $this->base->user['username'] != 'admin')
        {
        	$sql.= " AND qus.authoritycontrol=2 ";
        }
       ($cfield && $cvalue != 'all') && ($sql .= " AND qus.$cfield=$cvalue ");
       $sql.= " order by qus.time desc  ";
       $sql.=" LIMIT $start ,$limit";
 
       $query = $this->db->query($sql);
       while ($question = $this->db->fetch_array($query))
       {
         
           $question['category_name'] = $this->base->category[$question['cid']]['name'];
           $question['sortime'] = $question['time'];//用于排序
           $question['format_time'] = tdate($question['time']);
           $question['avatar'] = get_avatar_dir($question['authorid']);
           $question['url'] = url('question/view/' . $question['id'], $question['url']);
           $question['title'] = checkwordsglobal($question['title']);
           $question['image'] = getfirstimg($question['description']);
           $question['description'] = cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...');
           $question['tags'] = $this->get_by_qid($question['id']);
           if ($question['askuid'] > 0) {
               $question['askuser'] = $this->get_by_uid($question['askuid']);
           }
           $questionlist[] = $question;
       	
       }
       
       return $questionlist;
       
        
    }
    
    
    
    
    /*问题列表未回答的信息*/
    
    function rownum_by_nosove_list($cfield ='cid1',$cvalue =0){
        $condition =" 1=1 AND answers = 0 and status = 1 ";
        if ($this->base->user['identity']==2&&$this->base->user['username']!='admin')//用户是顾问则只查询 authoritycontrol = 2
        {
        	$condition .=" AND authoritycontrol=2 ";
        }
        ($cfield&&$cvalue!='all')&& $condition.=" AND $cfield=$cvalue";
        return $this->db->fetch_total('question',$condition);
        
    }
    /* 查询未回答的用户数量*/
    function list_by_nosove_list($cfield='cid1',$cvalue=0,$start=0,$limit=10){
        $questionlist = array();
        $sql= "SELECT * FROM ".DB_TABLEPRE."question where 1=1 AND answers =0 and status =1 ";
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] == 2 && $this->base->user['username'] != 'admin') {
            $sql .= " AND authoritycontrol=2 ";
        }
        ($cfield && $cvalue != 'all') && ($sql .= " AND $cfield=$cvalue ");
        $sql.="order by time desc ";
        $sql.=" LIMIT $start ,$limit";
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query))
        {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['sortime'] = $question['time'];//用于排序
            $question['format_time'] = tdate($question['time']);
            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['image'] = getfirstimg($question['description']);
            $question['description'] = cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...');
            $question['tags'] = $this->get_by_qid($question['id']);
            if ($question['askuid'] > 0) {
                $question['askuser'] = $this->get_by_uid($question['askuid']);
            }


            $questionlist[] = $question;
        }
        return $questionlist;
        
    }
    
    
    
    

    /* 问题列表记录数目 */

    function rownum_by_cfield_cvalue_status($cfield = 'cid1', $cvalue = 0, $status = 0)
    {
        $condition = " 1=1 ";
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $condition .= " AND authoritycontrol=2 ";
        }
        ($cfield && $cvalue != 'all') && $condition .= " AND $cfield=$cvalue ";


        isset($this->statustable[$status]) && $condition .= $this->statustable[$status];
        return $this->db->fetch_total('question', $condition);
    }

    /* 问题列表，根据指定的分类名称，和分类id，以及status来查询 */

    function list_by_cfield_cvalue_status($cfield = 'cid1', $cvalue = 0, $status = 0, $start = 0, $limit = 10)
    {
        $questionlist = array();
        $sql = "SELECT * FROM " . DB_TABLEPRE . "question WHERE 1=1 ";
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $sql .= " AND authoritycontrol=2 ";
        }

        ($cfield && $cvalue != 'all') && ($sql .= " AND $cfield=$cvalue ");

        isset($this->ordertable[$status]) && $sql .= $this->ordertable[$status];
        $sql .= " LIMIT $start,$limit";
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['sortime'] = $question['time'];//用于排序
            $question['format_time'] = tdate($question['time']);
            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['image'] = getfirstimg($question['description']);
            $question['description'] = cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...');
            $question['tags'] = $this->get_by_qid($question['id']);
            if ($question['askuid'] > 0) {
                $question['askuser'] = $this->get_by_uid($question['askuid']);
            }


            $questionlist[] = $question;
        }
        return $questionlist;
    }

    /* 问题列表，现金悬赏 */

    function list_by_shangjin($start = 0, $limit = 10)
    {
        $questionlist = array();
        $sql = "SELECT * FROM " . DB_TABLEPRE . "question WHERE 1=1 and  shangjin>0";
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $sql .= " AND authoritycontrol=2 ";
        }


        $sql .= " order by time desc LIMIT $start,$limit";
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['tags'] = $this->get_by_qid($question['id']);
            if ($question['askuid'] > 0) {
                $question['askuser'] = $this->get_by_uid($question['askuid']);
            }

            $question['description'] = checkwordsglobal($question['description']);
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    /* 问题列表，语音回答 */

    function list_by_yuyin($start = 0, $limit = 10)
    {
        $questionlist = array();
        $sql = "SELECT * FROM " . DB_TABLEPRE . "question WHERE 1=1 and  hasvoice>0";

        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $sql .= " AND authoritycontrol=2 ";
        }

        $sql .= " order by time desc LIMIT $start,$limit";
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['tags'] = $this->get_by_qid($question['id']);
            if ($question['askuid'] > 0) {
                $question['askuser'] = $this->get_by_uid($question['askuid']);
            }

            $question['description'] = checkwordsglobal($question['description']);
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    /* 标签 */
    function get_by_qid($qid)
    {
        $taglist = array();
        $query = $this->db->query("SELECT DISTINCT name FROM `" . DB_TABLEPRE . "question_tag` WHERE qid=$qid ORDER BY `time` ASC LIMIT 0,10");
        while ($tag = $this->db->fetch_array($query)) {
            $taglist[] = $tag['name'];
        }
        return $taglist;
    }

    /* 我的所有提问，用户中心 */

    function list_by_uid($uid, $status, $start = 0, $limit = 10)
    {
        $questionlist = array();
        $sql = 'SELECT * FROM ' . DB_TABLEPRE . 'question WHERE `authorid` = ' . $uid;
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['uid'] != $uid && $this->base->user['username'] != 'admin') {
            $sql .= " AND `authoritycontrol`=2 ";
        }

        $sql .= $this->statustable[$status] . " ORDER BY `time` DESC LIMIT $start , $limit";
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            if (intval($question['endtime'])) {
                $question['format_endtime'] = tdate($question['endtime']);
            }

            $question['format_time'] = tdate($question['time']);
            $question['url'] = url('question/view/' . $question['id'], $question['url']);
            $question['title'] = checkwordsglobal($question['title']);
            $question['image'] = getfirstimg($question['description']);
            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['description'] = cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...');
            $questionlist[] = $question;
        }
        return $questionlist;
    }

    /* 插入问题到question表 */

    function add($title, $description, $hidanswer, $price, $cid, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 0, $shangjin = 0, $askfromuid = 0, $authoritycontrol = 0)
    {
        $overdue_days = intval($this->base->setting['overdue_days']);
        $creattime = $this->base->time;
        $endtime = $this->base->time + $overdue_days * 86400;
        $uid = $this->base->user['uid'];
        $username = $uid ? $this->base->user['realname'] : $this->base->user['ip'];
        (!strip_tags($description, '<img>')) && $description = '';
        /* 分词索引 */
        $this->db->query("INSERT INTO " . DB_TABLEPRE . "question SET cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',askuid='$askfromuid',authorid='$uid',authoritycontrol = '$authoritycontrol',shangjin='$shangjin',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',status='$status',ip='{$this->base->ip}'");
        $qid = $this->db->insert_id();
        if ($this->base->setting['xunsearch_open'] && $qid) {
            $question = array();
            $question['id'] = $qid;
            $question['cid'] = $cid;
            $question['cid1'] = $cid1;
            $question['cid2'] = $cid2;
            $question['cid3'] = $cid3;
            $question['author'] = $username;
            $question['authorid'] = $uid;
            $question['authoritycontrol'] = $authoritycontrol;
            $question['answers'] = 0;
            $question['price'] = $price;
            $question['attentions'] = 1;
            $question['shangjin'] = $shangjin;
            $question['status'] = $status;
            $question['time'] = $creattime;
            $question['title'] = checkwordsglobal($title);
            $question['description'] = checkwordsglobal($description);
            $doc = new XSDocument;
            $doc->setFields($question);
            $this->index->add($doc);
        }
        $cid1 = intval($cid1);
        $cid2 = intval($cid2);
        $cid3 = intval($cid3);
        $this->db->query("UPDATE " . DB_TABLEPRE . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) ");
        $uid && $this->db->query("UPDATE " . DB_TABLEPRE . "user SET questions=questions+1 WHERE  uid =$uid");
        return $qid;
    }

    //没发现哪里用到
    function addapp($uid1, $username1, $title, $description, $hidanswer, $price, $cid, $devicename = '网站', $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 0)
    {
        $overdue_days = intval($this->base->setting['overdue_days']);
        $creattime = $this->base->time;
        $endtime = $this->base->time + $overdue_days * 86400;
        $uid = $uid1;// $this->base->user['uid'];
        $username = $username1;// $uid ? $this->base->user['username'] : $this->base->user['ip'];
        (!strip_tags($description, '<img>')) && $description = '';
        /* 分词索引 */
        $this->db->query("INSERT INTO " . DB_TABLEPRE . "question SET cid='$cid',devicename='$devicename',cid1='$cid1',cid2='$cid2',cid3='$cid3',authorid='$uid',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',status='$status',ip='{$this->base->ip}'");
        $qid = $this->db->insert_id();
        if ($this->base->setting['xunsearch_open'] && $qid) {
            $question = array();
            $question['id'] = $qid;
            $question['cid'] = $cid;
            $question['cid1'] = $cid1;
            $question['cid2'] = $cid2;
            $question['cid3'] = $cid3;
            $question['author'] = $username;
            $question['devicename'] = $devicename;
            $question['authorid'] = $uid;
            $question['answers'] = 0;
            $question['price'] = $price;
            $question['attentions'] = 1;
            $question['shangjin'] = 0;
            $question['status'] = $status;
            $question['time'] = $creattime;
            $question['title'] = $title;
            $question['description'] = $description;
            $doc = new XSDocument;
            $doc->setFields($question);
            $this->index->add($doc);
        }
        $cid1 = intval($cid1);
        $cid2 = intval($cid2);
        $cid3 = intval($cid3);
        $this->db->query("UPDATE " . DB_TABLEPRE . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) ");
        $uid && $this->db->query("UPDATE " . DB_TABLEPRE . "user SET questions=questions+1 WHERE  uid =$uid");
        return $qid;
    }

    /* 插入问题到question表  主要是后台管理设置*/
    function add_seo($title, $uid1, $username1, $description, $hidanswer, $price, $cid, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 0, $view = 10, $mtime = 1409637582)
    {
        $overdue_days = intval($this->base->setting['overdue_days']);
        $creattime = $mtime;//$this->base->time;
        $endtime = $mtime + $overdue_days * 86400;// $this->base->time + $overdue_days * 86400;
        $uid = $uid1;// $this->base->user['uid'];
        $username = $uid ? $username1 : $this->base->user['ip'];
        //(!strip_tags($description, '<img>')) && $description = '';
        //  echo "INSERT INTO " . DB_TABLEPRE . "question SET cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',authorid='$uid',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',views='$view',status='$status',ip='{$this->base->ip}'";
        /* 分词索引 */
        $this->db->query("INSERT INTO " . DB_TABLEPRE . "question SET cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',authorid='$uid',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',views='$view',status='$status',ip='{$this->base->ip}'");
        $qid = $this->db->insert_id();
        if ($this->base->setting['xunsearch_open'] && $qid) {
            $question = array();
            $question['id'] = $qid;
            $question['cid'] = $cid;
            $question['cid1'] = $cid1;
            $question['cid2'] = $cid2;
            $question['cid3'] = $cid3;
            $question['author'] = $username;
            $question['authorid'] = $uid;
            $question['answers'] = 0;
            $question['price'] = $price;
            $question['attentions'] = 1;
            $question['shangjin'] = 0;
            $question['status'] = $status;
            $question['time'] = $creattime;
            $question['title'] = $title;
            $question['description'] = $description;
            $doc = new XSDocument;
            $doc->setFields($question);
            $this->index->add($doc);
        }
        $cid1 = intval($cid1);
        $cid2 = intval($cid2);
        $cid3 = intval($cid3);
        $this->db->query("UPDATE " . DB_TABLEPRE . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) ");
        $uid && $this->db->query("UPDATE " . DB_TABLEPRE . "user SET questions=questions+1 WHERE  uid =$uid");
        return $qid;
    }
    /* 后台管理设置*/
    function update($id, $title, $description, $hidanswer, $price, $status, $cid, $cid1 = 0, $cid2 = 0, $cid3 = 0, $time = 0)
    {
        $overdue_days = intval($this->base->setting['overdue_days']);
        $asktime = strtotime($time);
        $endtime = $asktime + $overdue_days * 86400;
        $this->db->query("UPDATE  `" . DB_TABLEPRE . "question` SET cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',title='$title',description='$description',price='$price',`status`=$status , `time`= $asktime,endtime='$endtime',hidden='$hidanswer'  WHERE `id` = $id");
        if ($this->base->setting['xunsearch_open']) {
            $question = array();
            $question['id'] = $id;
            $question['cid'] = $cid;
            $question['cid1'] = $cid1;
            $question['cid2'] = $cid2;
            $question['cid3'] = $cid3;
            $question['status'] = $status;
            $question['price'] = $price;


            $question['title'] = $title;
            $question['description'] = $description;
            $doc = new XSDocument;
            $doc->setFields($question);
            $this->index->update($doc);
        }
    }

    /* 更新问题状态 */

    function update_status($qid, $status = 9)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set status=$status  WHERE `id` = $qid");
    }

    /* 添加问题补充 */

    function add_supply($qid, $supply, $content, $status = 1)
    {
        $this->db->query("INSERT " . DB_TABLEPRE . "question_supply(`id`,`qid`,`content`,`time`) VALUES (null,$qid,'$content',{$this->base->time})");
    }

    function get_supply($qid)
    {
        $supplies = array();
        $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "question_supply WHERE `qid`=$qid ORDER BY `time` ASC");
        while ($supply = $this->db->fetch_array($query)) {
            $supply['format_time'] = tdate($supply['time']);
            $supplies[] = $supply;
        }
        return $supplies;
    }

    function remove_supply_by_qid($qids)
    {
        if (is_array($qids)) {
            $qids = implode(",", $qids);
        }
        $this->db->query("DELETE FROM " . DB_TABLEPRE . "question_supply WHERE `qid` IN ($qids)");
    }

    //添加问题感言
    function add_comment($qids, $comment)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` SET comment='$comment' WHERE `id`=$qid");
    }

    //添加查看次数
    function add_views($qid)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` SET views=views+1 WHERE `id`=$qid");
    }

    /* 更新问题顶 */

    function update_goods($qid)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set goods=goods+1  WHERE `id` =$qid");
    }

    /* 追加问题悬赏 */

    function update_score($qid, $score)
    {
        if ($score >= 20) {
            $overdue_days = intval($this->base->setting['overdue_days']);
            $endtime = $this->base->time + $overdue_days * 86400;
            $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set price=price+$score ,time={$this->base->time},endtime='$endtime'  WHERE `id` =$qid");
        } else {
            $threeday = 24 * 3600 * 3;
            $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set price=price+$score ,endtime=endtime+$threeday  WHERE `id` =$qid");
        }
    }

    /* 某人是否已经回答过某问题 */

    function already($qid, $uid)
    {
        $already = $this->db->fetch_first("SELECT qid,authorid FROM `" . DB_TABLEPRE . "answer`  WHERE `qid` =$qid and authorid=$uid");
        return is_array($already);
    }

    //问题审核
    function change_to_verify($qids)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set status=1 WHERE status=0 AND `id` in ($qids)");
    }

    //编辑问题标题
    function renametitle($qid, $title)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` SET `title`='$title' WHERE `id`=$qid");
        $this->db->query("UPDATE `" . DB_TABLEPRE . "answer` SET `title`='$title' WHERE `qid`=$qid");
        if ($this->base->setting['xunsearch_open']) {
            $question = array();
            $question['id'] = $qid;
            $question['title'] = $title;
            $doc = new XSDocument;
            $doc->setFields($question);
            $this->index->update($doc);
        }
    }

    //编辑问题内容
    function update_content($qid, $title, $content, $authoritycontrol = 0)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` SET `title`='$title',authoritycontrol = '$authoritycontrol',`description`='$content' WHERE `id`=$qid");
        $this->db->query("UPDATE `" . DB_TABLEPRE . "answer` SET `title`='$title' WHERE `qid`=$qid");
        if ($this->base->setting['xunsearch_open']) {
            $question = array();
            $question['id'] = $qid;
            $question['title'] = $title;
            $question['authoritycontrol'] = $authoritycontrol;
            $question['description'] = $content;
            $doc = new XSDocument;
            $doc->setFields($question);
            $this->index->update($doc);
        }
    }

    /* 是否关注问题 */

    function is_followed($qid, $uid)
    {
        return $this->db->result_first("SELECT COUNT(*) FROM " . DB_TABLEPRE . "question_attention WHERE qid=$qid AND followerid=$uid");
    }

    /* 获取问题管理者列表信息 */

    function get_follower($qid, $start = 0, $limit = 16)
    {
        $followerlist = array();
        $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "question_attention WHERE qid=$qid ORDER BY `time` DESC LIMIT $start,$limit");
        while ($follower = $this->db->fetch_array($query)) {
            $follower['avatar'] = get_avatar_dir($follower['followerid']);
            $follower['format_time'] = tdate($follower['time']);
            $followerlist[] = $follower;
        }
        return $followerlist;
    }

    //编辑问题分类
    function update_category($qids, $cid, $cid1, $cid2, $cid3)
    {
        //分类移动简单做法， 先把原来分类 问题先减掉；
        //统一加上所属分类的数量
        //这样就不用考虑 分类变化的问题，也比较通用
        $oldques = $this->db->fetch_first("SELECT  cid1 ,cid2 ,cid3  from ".DB_TABLEPRE."question where `id` =$qids"); //难道能移动多个问题分类嘛？
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` SET `cid`=$cid,`cid1`=$cid1,`cid2`=$cid2,`cid3`=$cid3 WHERE `id`in ($qids)");
        $this->db->query("UPDATE ".DB_TABLEPRE."category SET questions=questions-1 WHERE  id IN (".$oldques['cid1'].",".$oldques['cid2'].",".$oldques['cid3'].")");
        $this->db->query("UPDATE ".DB_TABLEPRE."category SET questions =questions+1 WHERE id in($cid1,$cid2,$cid3)");
            
        if ($this->base->setting['xunsearch_open']) {
            foreach ($qids as $qid) {
                $question = array();
                $question['id'] = $qid;
                $question['cid'] = $cid;
                $question['cid1'] = $cid1;
                $question['cid2'] = $cid2;
                $question['cid3'] = $cid3;
                $doc = new XSDocument;
                $doc->setFields($question);
                $this->index->update($doc);
            }
        }
    }

    //设为待解决
    function change_to_nosolve($qids)
    {
        $overdue_days = intval($this->base->setting['overdue_days']);
        $endtime = $this->base->time + $overdue_days * 86400;
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` set status=1, `endtime`=$endtime WHERE (status=6 OR status=2 OR status=9) AND `id` in ($qids)");
        $this->db->query("UPDATE `" . DB_TABLEPRE . "answer` SET `adopttime`=0 WHERE `qid` in ($qids)");
        if ($this->base->setting['xunsearch_open']) {
            foreach ($qids as $qid) {
                $question = array();
                $question['status'] = 1;
                $doc = new XSDocument;
                $doc->setFields($question);
                $this->index->update($doc);
            }
        }
    }

    //问题推荐
    function change_recommend($qids, $status1, $status2)
    {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "question` SET `status`=$status1 WHERE `status`=$status2 AND `id` in ($qids)");
    }

    //根据标题搜索问题的结果数
    //修改成根据分类来获取结果数
    function search_title_num($title, $status = '1,2,6',$cfield='cid1',$cid)
    {
        $questionnum = 0;
        if ($this->base->setting['xunsearch_open']) {
            $questionnum = $this->search->getLastCount();
        } else {
            $condition = " STATUS IN ($status) AND title LIKE '%$title%' ";
            ($cfield&&$cid!='all')&&$condition.=" AND $cfield = $cid ";
            
            //用户是顾问则只查询 authoritycontrol = 2
            if ($this->base->user['identity'] == 2) {
                $condition .= " AND authoritycontrol=2 ";
            }else if($this->base->user['identity']==0&&$this->base->user['username']!='admin'){ //未认证的用户
                $condition.= " AND  authoritycontrol=0 ";
            }
            $questionnum = $this->db->fetch_total('question', $condition);
        }
        return $questionnum;
    }

    //根据标题搜索问题
    // 修改成根据分类来搜索问题
    function search_title($title, $status = '1,2,6', $addbestanswer = 0, $start = 0, $limit = 20 ,$cfield='cid1',$cid)
    {
        $questionlist = array();
        if ($this->base->setting['xunsearch_open']) {
            $statusarr = explode(",", $status);
            $size = count($statusarr);
            $to = $statusarr[$size - 1];
            $from = $statusarr[0];
            $result = $this->search->setQuery($title)->addRange('status', $from, $to)->setLimit($limit, $start)->search();
            foreach ($result as $doc) {
                //用户是顾问则只查询 authoritycontrol = 2
                if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin' ) {
                    if($doc->authoritycontrol ==2) {
                        $question = array();
                        $question['id'] = $doc->id;
                        $question['cid'] = $doc->cid;
                        $question['category_name'] = $this->base->category[$question['cid']]['name'];
                        $question['cid1'] = $doc->cid1;
                        $question['cid2'] = $doc->cid2;
                        $question['cid3'] = $doc->cid3;
                        $question['author'] = $doc->author;
                        $question['authorid'] = $doc->authorid;
                        $question['authoravatar'] = get_avatar_dir($doc->authorid);
                        $question['answers'] = $doc->answers;
                        $question['status'] = $doc->status;
                        $question['format_time'] = tdate($doc->time);
                        $question['title'] = $this->search->highlight($doc->title);

                        $question['avatar'] = get_avatar_dir($question['authorid']);
                        $question['description'] = $this->search->highlight(cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...'));

                        $questionlist[] = $question;
                    }
                }else{
                    $question = array();
                    $question['id'] = $doc->id;
                    $question['cid'] = $doc->cid;
                    $question['category_name'] = $this->base->category[$question['cid']]['name'];
                    $question['cid1'] = $doc->cid1;
                    $question['cid2'] = $doc->cid2;
                    $question['cid3'] = $doc->cid3;
                    $question['author'] = $doc->author;
                    $question['authorid'] = $doc->authorid;
                    $question['authoravatar'] = get_avatar_dir($doc->authorid);
                    $question['answers'] = $doc->answers;
                    $question['status'] = $doc->status;
                    $question['format_time'] = tdate($doc->time);
                    $question['title'] = $this->search->highlight($doc->title);

                    $question['avatar'] = get_avatar_dir($question['authorid']);
                    $question['description'] = $this->search->highlight(cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...'));

                    $questionlist[] = $question;
                }
            }
            if (count($questionlist) == 0) {
                $questionlist = $this->get_question_bytitle($title, $status, $addbestanswer, $start, $limit);
            }


        } else {

            $sql = "SELECT * FROM " . DB_TABLEPRE . "question WHERE STATUS IN ($status) AND title LIKE '%$title%' ";
            ($cfield&&$cid!='all')&& $sql.=" AND $cfield=$cid ";
            
            //用户是顾问则只查询 authoritycontrol = 2
            if ($this->base->user['identity'] ==2) {
                $sql .= " AND authoritycontrol=2 ";
            }else if($this->base->user['identity']==0&&$this->base->user['username']!='admin'){ //未登录的用户
            
                $sql.="  AND authoritycontrol=0 ";
            }
            $sql .= " LIMIT $start,$limit";
            $query = $this->db->query($sql);
            while ($question = $this->db->fetch_array($query)) {
                $question['category_name'] = $this->base->category[$question['cid']]['name'];
                $question['format_time'] = tdate($question['time']);
                $question['authoravatar'] = get_avatar_dir($question['authorid']);
                $addbestanswer && $question['bestanswer'] = $this->db->result_first("SELECT content FROM `" . DB_TABLEPRE . "answer` WHERE qid=" . $question['id'] . " AND adopttime>0 ");
                $question['description'] = strip_tags($question['description']);
                $question['title'] = highlight($question['title'], $title);
                $question['avatar'] = get_avatar_dir($question['authorid']);
                $question['description'] = highlight(cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...'), $title);
                $questionlist[] = $question;
            }
        }
        return $questionlist;
    }

    function get_question_bytitle($title, $status = '1,2,6', $addbestanswer = 0, $start = 0, $limit = 20)
    {
        $questionlist = array();
        $sql = "SELECT * FROM " . DB_TABLEPRE . "question WHERE STATUS IN ($status) AND title LIKE '%$title%' ";
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity'] != 1 && $this->base->user['username'] != 'admin') {
            $sql .= " AND authoritycontrol=2 ";
        }
        $sql .= " LIMIT $start,$limit";
        $query = $this->db->query($sql);
        while ($question = $this->db->fetch_array($query)) {
            $question['category_name'] = $this->base->category[$question['cid']]['name'];
            $question['format_time'] = tdate($question['time']);
            $addbestanswer && $question['bestanswer'] = $this->db->result_first("SELECT content FROM `" . DB_TABLEPRE . "answer` WHERE qid=" . $question['id'] . " AND adopttime>0 ");
            $question['avatar'] = get_avatar_dir($question['authorid']);
            $question['description'] = highlight(cutstr(checkwordsglobal(strip_tags($question['description'])), 240, '...'), $title);
            $questionlist[] = $question;
        }
    }

    /**
     * 获得相关结果关键词
     */
    function get_related_words()
    {
        $words = array();
        if ($this->base->setting['xunsearch_open'])
            $words = $this->search->getRelatedQuery();
        return $words;
    }

    /**
     * 获得热门搜索词
     * @param type $size
     * @return type
     */
    function get_hot_words($size = 8)
    {
        $words = array();
        if ($this->base->setting['xunsearch_open'])
            $words = array_keys($this->search->getHotQuery($size, "currnum"));
        return $words;
    }

    function get_corrected_word()
    {
        $words = array();
        if ($this->base->setting['xunsearch_open'])
            $words = $this->search->getCorrectedQuery();
        return $words;
    }

    /* 防采集 */

    function stopcopy()
    {
        $ip = $this->base->ip;
        $bengintime = $this->base->time - 60;
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent = strtolower($useragent);
        $allowagent = explode("\n", $this->base->setting['stopcopy_allowagent']);
        $allow = false;
        foreach ($allowagent as $agent) {
            if (false !== strpos($useragent, $agent)) {
                $allow = true;
                break;
            }
        }
        !$allow && exit('access deny');
        $stopagent = explode("\n", $this->base->setting['stopcopy_stopagent']);
        foreach ($stopagent as $agent) {
            if (false !== strpos($useragent, $agent)) {
                exit('access deny');
            }
        }
        $visits = $this->db->fetch_total('visit', " time>$bengintime AND ip='$ip' ");
        if ($visits > $this->base->setting['stopcopy_maxnum']) {
            $userip = explode(".", $ip);
            $expiration = 3600 * 24;
            $this->db->query("INSERT INTO `" . DB_TABLEPRE . "banned` (`ip1`,`ip2`,`ip3`,`ip4`,`admin`,`time`,`expiration`) VALUES ('{$userip[0]}', '{$userip[1]}', '{$userip[2]}', '{$userip[3]}', 'SYSTEM', '{$this->base->time}', '{$expiration}')");
            exit('你采集的速度太快了吧 : ) ');
        } else {
            $this->db->query("INSERT INTO " . DB_TABLEPRE . "visit (`ip`,`time`) values ('$ip','{$this->base->time}')"); //加入数据库记录visit表中
        }
    }

    function makeindex()
    {
        if ($this->base->setting['xunsearch_open']) {
            $this->index->clean();
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "question ");
            while ($question = $this->db->fetch_array($query)) {
                $data = array();
                $data['id'] = $question['id'];
                $data['cid'] = $question['cid'];
                $data['cid1'] = $question['cid1'];
                $data['cid2'] = $question['cid2'];
                $data['cid3'] = $question['cid3'];
                $data['author'] = $question['author'];
                $data['authorid'] = $question['authorid'];
                $data['authoritycontrol'] = $question['authoritycontrol'];
                $data['answers'] = $question['answers'];
                $data['price'] = $question['price'];
                $data['attentions'] = $question['attentions'];
                $data['shangjin'] = $question['shangjin'];
                $data['status'] = $question['status'];
                $data['time'] = $question['time'];
                $data['title'] = $question['title'];
                $data['description'] = $question['description'];
                $doc = new XSDocument;
                $doc->setFields($data);
                $this->index->add($doc);
            }
        }
    }

}

?>
