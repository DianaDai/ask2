<?php

!defined('IN_ASK2') && exit('Access Denied');

class categorymodel {

    var $db;
    var $base;

    function categorymodel(&$base) {
        $this->base = $base;
        $this->db = $base->db;
    }

    /* 获取分类信息 */

    function get($id) {
        $category= $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "category WHERE id='$id'");
    $category['image']=get_cid_dir($category['id'],'small');
        	 	$category['bigimage']=get_cid_dir($category['id'],'big');
        	 	return $category;
    }

    function get_list() {
        $categorylist = array();
        //当用户的identity = 3时，浏览问题、文章时，只能浏览 isFOSS=1的分类下的文章或问题
        if ($this->base->user['identity'] == 3 ) {
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "category  WHERE isFOSS=1");
        }else{
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "category");
        }
        while ($cate = $this->db->fetch_array($query)) {
            $cate['image']=get_cid_dir($cate['id'],'small');
            $cate['bigimage']=get_cid_dir($cate['id'],'big');
            $categorylist[] = $cate;
        }
        return $categorylist;
    }

    function listtopic($status,$start,$limit){
    	    $categorylist = array();
    	    $order='ORDER BY `followers` DESC';
    	    switch ($status){
    	    	case 'hot':
    	    		 $order='ORDER BY `followers` DESC';
    	    		break;
    	    		case 'new':
    	    			 $order='ORDER BY `id` DESC';
    	    		break;
    	    		
    	    }
        //当用户的identity = 3时，浏览问题、文章时，只能浏览 isFOSS=1的分类下的文章或问题
        if ($this->base->user['identity'] == 3 ) {
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "category WHERE isFOSS=1 $order  LIMIT $start,$limit");
        }else{
            $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "category $order  LIMIT $start,$limit");
        }
        while ($category = $this->db->fetch_array($query)) {
        	   	 	$category['image']=get_cid_dir($category['id'],'small');
        	 	$category['bigimage']=get_cid_dir($category['id'],'big');
        	 	 $category['follow'] = $this->is_followed($category['id'], $this->base->user['uid']);
        	 	$category['miaosu']=cutstr( checkwordsglobal(strip_tags($category['miaosu'])), 40,'...');
                 if($category['miaosu']==''){
                 	$category['miaosu']="该专题暂无描述";
                 }
        	 	$categorylist[] = $category;
        }
        return $categorylist;
    }
    
    /* 用于首页导航但是获取top10文章和问题最多的分类*/
    
    function list_by_gradetop(){

        $categorylist = array();
        //当用户的identity = 3时，浏览问题、文章时，只能浏览 isFOSS=1的分类下的文章或问题
        if ($this->base->user['identity'] == 3 ) {
            $query = $this->db->query("select id ,name ,questions,grade ,image ,questions+topics as num from " . DB_TABLEPRE . "category where isFOSS=1 and grade in( 1,2)  order by  num desc limit 0 ,10 ");
        }else{
            $query = $this->db->query("select id ,name ,questions,grade ,image ,questions+topics as num from " . DB_TABLEPRE . "category where  grade in( 1,2)  order by  num desc limit 0 ,10 ");
        }
        while ($category1= $this->db->fetch_array($query))
        {
        	$category1['image']=get_cid_dir($category1['id'],'small');
            $category1['bigimage']=get_cid_dir($category1['id'],'big');
            $categorylist[]= $category1;
        }
        return $categorylist;
        

    }
    
    
    /* 用于在首页左侧显示 */
    function list_by_grade($grade = 1) {
        $categorylist = array();
        //当用户的identity = 3时，浏览问题、文章时，只能浏览 isFOSS=1的分类下的文章或问题
        if ($this->base->user['identity'] == 3 ) {
            $query = $this->db->query("select id,name,questions,grade,image from " . DB_TABLEPRE . "category where isFOSS=1 and grade=1 order by displayorder asc,id asc");
        }else{
            $query = $this->db->query("select id,name,questions,grade,image from " . DB_TABLEPRE . "category where grade=1 order by displayorder asc,id asc");
        }
        while ($category1 = $this->db->fetch_array($query)) {
            	$category1['image']=get_cid_dir($category1['id'],'small');
            	$category1['bigimage']=get_cid_dir($category1['id'],'big');
        	$query2 = $this->db->query("select id,name,questions from " . DB_TABLEPRE . "category where pid=$category1[id] and grade=2 order by displayorder asc,id asc");
            $category1['sublist'] = array();
            
            while ($category2 = $this->db->fetch_array($query2)) {
            	$category2['image']=get_cid_dir($category2['id'],'small');
            	  	$category2['bigimage']=get_cid_dir($category2['id'],'big');
                $category1['sublist'][] = $category2;
            }
            $categorylist[] = $category1;
        }
        return $categorylist;
    }
    function filter($elem){
        return $elem['isFOSS'] == 1;
    }
    /**
     * 获得分类树
     *
     * @param array $allcategory
     * @return string
     */
    function get_categrory_tree() {

        $allcategory = $this->base->category;
        //当用户的identity = 3时，浏览问题、文章时，只能浏览 isFOSS=1的分类下的文章或问题
        if ($this->base->user['identity'] == 3 ) {
            $allcategory = array_filter($allcategory, 'filter');
        }
        $categrorytree = '';
        foreach ($allcategory as $key => $category) {
            if ($category['pid'] == 0) {
                $categrorytree .= "<option value=\"{$category['id']}\">{$category['name']}</option>";
                $categrorytree .=$this->get_child_tree($allcategory, $category['id'], 1);
            }
        }
        return $categrorytree;
    }

    function get_child_tree($allcategory, $pid, $depth = 1) {
        $childtree = '';
        foreach ($allcategory as $key => $category) {
            if ($pid == $category['pid']) {
                $childtree .= "<option value=\"{$category['id']}\">";
                $depthstr = str_repeat("--", $depth);
                $childtree .= $depth ? "&nbsp;&nbsp;|{$depthstr}&nbsp;{$category['name']}</option>" : "{$category['name']}</option>";
                $childtree .= $this->get_child_tree($allcategory, $category['id'], $depth + 1);
            }
        }
        return $childtree;
    }
  /* 后台管理编辑分类别名 */
    function update_by_id_alias($id,$alias){
    	
    	  $this->db->query("UPDATE `" . DB_TABLEPRE . "category` SET   `alias`='$alias' WHERE `id`=$id");
    }
  /* 后台管理编辑分类描述*/
    function update_by_id_miaosu($id,$miaosu){
    	
    	  $sql="UPDATE `" . DB_TABLEPRE . "category` SET   `miaosu`='$miaosu' WHERE `id`=$id";
    	 // runlog('sql.txt', $sql);
    	  $this->db->query($sql);
    }
    /* 获取某一根节点的所有分类 */

    function list_by_pid($pid, $limit = 100) {
        $categorylist = array();
        if($this->base->user['identity'] == 3) {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "category` WHERE `pid`=$pid  AND isFOSS=1 ORDER BY displayorder ASC,id ASC LIMIT $limit");
        }else{
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "category` WHERE `pid`=$pid ORDER BY displayorder ASC,id ASC LIMIT $limit");
        }
        while ($category = $this->db->fetch_array($query)) {
        	$category['image']=get_cid_dir($category['id'],'big');
            $categorylist[] = $category;
        }
        return $categorylist;
    }
    /*根据cid获取关注分类的人*/
 function get_followers($cid,$start,$limit){
    	   $followerlist = array();
        $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "categotry_follower WHERE cid=$cid ORDER BY `time` DESC LIMIT $start,$limit");
        while ($follower = $this->db->fetch_array($query)) {
        	$_user=$this->get_by_uid($follower['uid']);
        	$follower['follower']=$_user['username'];
            $follower['avatar'] = get_avatar_dir($follower['uid']);
              $follower['format_time'] = tdate($follower['time']);
            $followerlist[] = $follower;
        }
        return $followerlist;
    }
 
 //获取关注分类的用户
 function get_fol_sendmsg($cid){
     $followerlist = array();
     $query = $this->db->query("SELECT * FROM ".DB_TABLEPRE."categotry_follower WHERE cid=$cid ORDER BY `time` DESC ");
     while ($follower =$this->db->fetch_array($query))
     {
     	$_user = $this->get_by_uid($follower['uid']);
         $follower['username'] = $_user['username'];
         $follower['realname'] = $_user['realname'];
         $follower['uid'] = $_user['uid'];
         $follower['email'] = $_user['email'];
         $follower['isnotify'] = $_user['isnotify'];
         $follower['avatar'] = get_avatar_dir($follower['uid']);
         $follower['format_time'] = tdate($follower['time']);
         $followerlist[] = $follower;
     }
     return $followerlist;
     
 
 }
 
 
 
 
 
 
 
 

    /*根据uid获取用户名*/
    function get_by_uid($uid) {
        $user = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user WHERE uid='$uid'");
      
        return $user;
    }




    function rownumbycondition($condition){
        //用户是顾问则只查询 authoritycontrol = 2
        if ($this->base->user['identity']==3){
            $condition .=" and isFOSS=1 ";
            return $this->db->fetch_total('category',$condition);
        }else{
            return $this->db->fetch_total('category',$condition);
        }
    }
    
    /* 根据分类名检索 加入cid */

    function list_by_name($name, $start = 0, $limit = 10 ,$cid=0) {
        $categorylist = array();
        $condition = " ";
        ($cid!='all')&&$condition.=" AND pid =$cid ";
        if($this->base->user['identity'] == 3) {
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "category` WHERE isFOSS=1 AND `name` like '%$name%'  $condition ORDER BY topics DESC LIMIT $limit");
        }else{
            $query = $this->db->query("SELECT * FROM `" . DB_TABLEPRE . "category` WHERE `name` like '%$name%'  $condition ORDER BY topics DESC LIMIT $limit");
        }
        while ($category = $this->db->fetch_array($query)) {
        	  $category['follow'] = $this->is_followed($category['id'], $this->base->user['uid']);
        	$category['image']=get_cid_dir($category['id'],'big');
            $categorylist[] = $category;
        }
        return $categorylist;
    }

/* 分类浏览页面显示子分类 */

    function list_by_cid_pid($cid, $pid) {
        $sublist = array();
        if($this->base->user['identity'] == 3) {
            $query = $this->db->query("select id,name,questions,topics,grade,alias,miaosu,image,followers from " . DB_TABLEPRE . "category where pid=$cid and isFOSS=1 order by displayorder asc,id asc");
        }else{
            $query = $this->db->query("select id,name,questions,topics,grade,alias,miaosu,image,followers from " . DB_TABLEPRE . "category where pid=$cid order by displayorder asc,id asc");
        }
        $subcount = $this->db->affected_rows();
        if ($subcount <= 0) {
            if ($this->base->user['identity'] == 3) {
                $query = $this->db->query("select id,name,questions,topics,grade,alias from " . DB_TABLEPRE . "category where pid=$pid and isFOSS=1 order by displayorder asc,id asc");
            }else{
                $query = $this->db->query("select id,name,questions,topics,grade,alias from " . DB_TABLEPRE . "category where pid=$pid order by displayorder asc,id asc");
            }
        }
        while ($category = $this->db->fetch_array($query)) {
        	$category['image']=get_cid_dir($category['id'],'big');
            $sublist[] = $category;
        }
        return $sublist;
    }
    
    /*       query_list_by_cid_pid   搜索分类浏览 显示子分类           */
    
    function query_list_by_cid_pid($cid){
    
        $sublist = array();
        if($this->base->user['identity'] == 3) {
            $query = $this->db->query("select id,name,questions,topics,grade,alias,miaosu,image,followers from " . DB_TABLEPRE . "category where pid=$cid and isFOSS=1 order by displayorder asc,id asc");
        }else{
            $query = $this->db->query("select id,name,questions,topics,grade,alias,miaosu,image,followers from " . DB_TABLEPRE . "category where pid=$cid order by displayorder asc,id asc");
        }
        $subcount= $this->db->affected_rows();
        if ($subcount<=0)
        {
            ($cid=='all')&&$cid=0;
            if ($cid==0)
            {
                if($this->base->user['identity'] == 3) {
                    $query = $this->db->query("select id,name,questions,topics,grade,alias from " . DB_TABLEPRE . "category where pid=$cid and isFOSS=1 order by displayorder asc,id asc");
                }else{
                    $query = $this->db->query("select id,name,questions,topics,grade,alias from " . DB_TABLEPRE . "category where pid=$cid order by displayorder asc,id asc");
                }

            }else
            {
                if($this->base->user['identity'] == 3) {
                    $query = $this->db->query("select id,name,questions,topics,grade,alias from " . DB_TABLEPRE . "category where id=$cid and isFOSS=1 order by displayorder asc,id asc "); //获取当前分类
                }else{
                    $query = $this->db->query("select id,name,questions,topics,grade,alias from " . DB_TABLEPRE . "category where id=$cid order by displayorder asc,id asc ");
                }
            }
            
            
        }
        while($category = $this->db->fetch_array($query)){
            $category['image']=get_cid_dir($category['id'],'big');
            $sublist[] = $category;
            
        }
        return $sublist;
        
        
    }

    
    

    /* 用于提问时候分类的选择 */

    function get_js($cid = 0) {
        (!$cid) && $cid = $cid;
        $categoryjs = array();
        $category1 = $category2 = $category3 = '';
        if($this->base->user['identity'] == 3) {
            $query = $this->db->query("SELECT *  FROM " . DB_TABLEPRE . "category WHERE `id` != $cid and `isFOSS`=1 order by displayorder asc ");
        }else{
            $query = $this->db->query("SELECT *  FROM " . DB_TABLEPRE . "category WHERE `id` != $cid order by displayorder asc ");
        }

        while ($category = $this->db->fetch_array($query)) {
            switch ($category['grade']) {
                case 1:
                    $category1.='["' . $category['id'] . '","' . $category['name'] . '"],';
                    break;
                case 2:
                    $category2.='["' . $category['pid'] . '","' . $category['id'] . '","' . $category['name'] . '"],';
                    break;
                case 3:
                    $category3.='["' . $category['pid'] . '","' . $category['id'] . '","' . $category['name'] . '"],';
                    break;
            }
        }
        $categoryjs['category1'] = "[" . substr($category1, 0, -1) . "]";
        $categoryjs['category2'] = "[" . substr($category2, 0, -1) . "]";
        $categoryjs['category3'] = "[" . substr($category3, 0, -1) . "]";
        return $categoryjs;
    }
    function get_jsforcustomer($cid = 0) {
        (!$cid) && $cid = $cid;
        $categoryjs = array();
        $category1 = $category2 = $category3 = '';
        $query = $this->db->query("SELECT *  FROM " . DB_TABLEPRE . "category WHERE `id` != $cid and `isFOSS` =1 order by displayorder asc ");
        while ($category = $this->db->fetch_array($query)) {
            switch ($category['grade']) {
                case 1:
                    $category1.='["' . $category['id'] . '","' . $category['name'] . '"],';
                    break;
                case 2:
                    $category2.='["' . $category['pid'] . '","' . $category['id'] . '","' . $category['name'] . '"],';
                    break;
                case 3:
                    $category3.='["' . $category['pid'] . '","' . $category['id'] . '","' . $category['name'] . '"],';
                    break;
            }
        }
        $categoryjs['category1'] = "[" . substr($category1, 0, -1) . "]";
        $categoryjs['category2'] = "[" . substr($category2, 0, -1) . "]";
        $categoryjs['category3'] = "[" . substr($category3, 0, -1) . "]";
        return $categoryjs;
    }
    /*   专题页面显示特定分类  */
    
    function get_topnav($cid ,$grade=1){

        $relval = '';
        do
        {
            $category = $this->base->category[$cid]; //具体的分类记录
            if ($category&&$category['grade']==$grade)
            {
            	$relval=$category;
                break;
            }else if($category)
            {
            	$cid = $category['pid']; //准备获取上一个分类
            }
            
        } while($category&&$cid); 
        return $relval;
        
        
    }
    

    /* 分类显示页面分类导航 */

    function get_navigation($cid = 0, $contain = false) {
        $navlist = array();
        do {
            $category = $this->base->category[$cid];
            if ($category) {
                $cid = $category['pid'];
                $navlist[] = $category;
            }
        } while ($category && $cid);
        $navlist = array_reverse($navlist);
        !$contain && array_pop($navlist); //是否需要本分类
        return $navlist;
    }

    /* 后台管理批量添加分类 */

    function add($lines, $pid = 0, $displayorder = 0, $questions = 0) {
        $grade = (0 == $pid) ? 1 : $this->base->category[$pid]['grade'] + 1;
        $sql = "INSERT INTO `" . DB_TABLEPRE . "category`(`name` ,`dir` , `pid` , `grade` , `displayorder`,`questions`) VALUES ";
        foreach ($lines as $line) {
            $line = str_replace(array("\r\n", "\n", "\r"), '', $line);
            if (empty($line))
                continue;
            $name = trim($line);
            $categorydir = '';
            $sql .= "('$name','$categorydir', $pid,$grade,$displayorder,$questions),";
            $displayorder++;
        }
        $sql = substr($sql, 0, -1);
        return $this->db->query($sql);
    }

    /* 后台管理编辑分类 */

    function update_by_id($id, $name, $categorydir, $pid) {
        $grade = (0 == $pid) ? 1 : $this->base->category[$pid]['grade'] + 1;
        $this->db->query("UPDATE `" . DB_TABLEPRE . "category` SET  `pid`=$pid ,`grade`=$grade , `name`='$name', `dir`='$categorydir' WHERE `id`=$id");
    }

    /* 后台管理删除分类 */

    function remove($cids) {
        //$this->db->query("DELETE FROM `".DB_TABLEPRE."answer` WHERE `qid` IN  (SELECT id FROM `".DB_TABLEPRE."question` WHERE `cid` IN ($cid))");
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "category` WHERE `id` IN  ($cids)");
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "question` WHERE `cid` IN ($cids)");
    }

    /* 后台管理移动分类顺序 */

    function order_category($id, $order) {
        $this->db->query("UPDATE `" . DB_TABLEPRE . "category` SET 	`displayorder` = '{$order}' WHERE `id` = '{$id}'");
    }

 /* 是否关注分类 */

    function is_followed($cid, $uid) {
        return $this->db->result_first("SELECT COUNT(*) FROM " . DB_TABLEPRE . "categotry_follower WHERE uid=$uid AND cid=$cid");
    }
   
    /* 关注 */

    function follow($sourceid, $followerid) {
       
    	runlog('follow.txt', "INSERT INTO " . DB_TABLEPRE  . "categotry_follower(cid,uid,time) VALUES ($sourceid,$followerid,{$this->base->time})");
        $this->db->query("INSERT INTO " . DB_TABLEPRE  . "categotry_follower(cid,uid,time) VALUES ($sourceid,$followerid,{$this->base->time})");
        $this->db->query("UPDATE " . DB_TABLEPRE . "category SET followers=followers+1 WHERE `id`=$sourceid");
    }

    /* 取消关注 */

    function unfollow($sourceid, $followerid) {
     runlog('follow.txt', "DELETE FROM " . DB_TABLEPRE  . "categotry_follower WHERE cid=$sourceid AND uid=$followerid");
        $this->db->query("DELETE FROM " . DB_TABLEPRE  . "categotry_follower WHERE cid=$sourceid AND uid=$followerid");
        $this->db->query("UPDATE " . DB_TABLEPRE . "category SET followers=followers-1 WHERE `id`=$sourceid");
    }
}

?>
