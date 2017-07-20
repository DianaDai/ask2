<?php

!defined('IN_ASK2') && exit('Access Denied');

class topiccontrol extends base {
var $whitelist;
    function topiccontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load('topic');
         $this->load('topic_tag');
  
          $this->load('category');
            $this->load('question');
            $this->load('email_msg');
            $this->load('email');
            $this->whitelist="getuserarticles,getnewlist,getbycatidanduid,view";
    }

   
    function onsearch() {
    	
      $hidefooter='hidefooter';
         
        $type="topic";
        $word =urldecode($this->get[2]);
        
        if ($this->post['word']) {
            header("Location:" . SITE_URL . '?topictag-' . urlencode($this->post['word']));
            exit();
        }
        
        
        $word = str_replace(array("\\","'"," ","/","&"),"", $word);
        $word = strip_tags($word);
        $word = htmlspecialchars($word);
        $word = taddslashes($word, 1);
        (!$word) && $this->message("搜索关键词不能为空!", 'BACK');
       
        if(isset($_SERVER['HTTP_X_REWRITE_URL'])){
        		
         if(function_exists("iconv")&&$this->get[2]!=null){
       	$word= iconv("GB2312", "UTF-8//IGNORE", $this->get[2]);
       	
       }
        }
         $navtitle = $word ;
           $cid = intval($this->get[3])?$this->get[3]:'all';
        @$page = max(1, intval($this->get[4]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
          $seo_description=$word;
     $seo_keywords= $word;
        $topiclist=null;//定义空文章数组
       //$rownum = $_ENV['topic']->rownum_by_tag($word);
   
           // $topiclist = $_ENV['topic']->list_by_tag($word, $startindex, $pagesize);
          // if($topiclist==null){
           	
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
        

            $topiclist = $_ENV['topic']->get_bylikename($word, $startindex, $pagesize,$cfield,$cid);
          
            $rownum=$_ENV['topic']->rownum_by_title($word,$cfield,$cid);
            
       

          // }
           
            $sublist = $_ENV['category']->query_list_by_cid_pid($cid); //获取子分类 
            
            foreach ($sublist as $key => $val)
            {
            	$relrownum= $_ENV['topic']->rownum_by_title($word,'cid'.$val['grade'],$val['id']);
                $sublist[$key]['topics']=$relrownum;
            }
            

          
foreach ($topiclist as $key=>$val){


    $topicsrc=  $_ENV['category']->get_navigation($val['articleclassid'],true);
    $toptemp =0;
    $count = count($topicsrc);
    for ($i = 0; $i < $count; $i++)
    {
        $toptemp.=$topicsrc[$i]['name'].'/';
    }
    $toptemp= substr($toptemp,1,strlen($toptemp)-1);
    $taglist = $_ENV['topic_tag']->get_by_aid($val['id']);

    $topiclist[$key]['tags']=$taglist;
    $topiclist[$key]['srcs']=$toptemp;
        
	
}

        $departstr = page($rownum, $pagesize, $page, "topictag-$word/$cid");
        include template('topictag');
    }
    
    
    
    
    
    
    
    function oncancelhot(){
    	
    	$id=intval($this->get[2]);
    	$_ENV['topic']->updatetopichot($id,'0');
    	$this->message("取消顶置成功!",urlmap('topic/hotlist'));
    }
    function onpushhot(){
    	
    	$id=intval($this->get[2]);
    	$_ENV['topic']->updatetopichot($id,'1');
    	$this->message("推荐到首页成功!",urlmap('topic/hotlist'));
    }
    function onajaxpostsupportcomment(){
    	$message=array();
    		$cmid=intval($this->post['cmid']);
    		$this->load("articlecomment");
    		$_ENV['articlecomment']->updatecmsupport($cmid);
 
  		$message['state']=1;
  		
  		echo json_encode($message);
  		exit();
  
  	
    }
    function onajaxpostcomment(){
    	$message=array();
    	if($this->user['uid']<=0){
    		$message['state']=-1;
    		$message['msg']="登录后可发布评论";
    		echo json_encode($message);
    		exit();
    	}
    	//现在支持问题提交html内容
    	$content=$this->post['content'];
        $contentarray = checkwords($content);
        
        if ($contentarray[0]==2)
        {
            $message['state']=0;
            $message['msg'] = '内容包含非法关键词，发布失败!';
            echo json_encode($message);
            exit();
        }
        $content = $contentarray[1];
        
        $content_temp = str_replace('<p>', '', $content);
        $content_temp = str_replace('</p>', '', $content_temp);
        $content_temp = str_replace('&nbsp;', '', $content_temp);
        $content_temp = preg_replace("/\s+/", '', $content_temp);
        $content_temp = preg_replace('/s(?=s)/', '', $content_temp);
        $content_temp = trim($content_temp);
        if (trim($content_temp) == '') {
            $message['state']=0;
            $message['msg'] = '回答不能为空！';
            echo json_encode($message);
            exit();
        }
        
    	$title=strip_tags($this->post['title']);
    	$tid=intval($this->post['tid']);
    	$this->load("articlecomment");
    	
  	$onecorder=$_ENV['articlecomment']->checkhascomment($tid,$this->user['uid']);
  	if($onecorder!=null){
  		$message['state']=0;
  		$message['msg']="您已经评论过了!";
  		echo json_encode($message);
  		exit();
  	}
    	$status=1;
    	$supports=rand(1, 5);
    	$id=$_ENV['articlecomment']->add_seo($tid,$title,$content,$this->user['uid'],$this->user['realname'],$status,$supports);
    	if($id>0){
            //通知作者
            $topic = $_ENV['topic']->get($tid);
            $touser = $_ENV['user']->get_by_uid($topic['authorid']);
            $viewurl = urlmap('topic/getone/' . $tid, 2);
            $weburl='<br> <a href="' . SITE_URL . $this->setting['seo_prefix'] . $viewurl . $this->setting['seo_suffix'] . '">点击查看文章</a>';

            $msginfo = $_ENV['email_msg']->topic_ans($touser['realname'],$title,$weburl);
            $this->sendmsg($touser,$msginfo['title'],$msginfo['content']);
            
            //通知关注着
            $this->load('favorite');
            $favusers = $_ENV['favorite']->get_list_bytid_fav($tid);
            
            foreach ($favusers as $fav)
            {
            	$msginfo = $_ENV['email_msg']->topic_ans_fav($fav['realname'],$title,$weburl);
                $this->sendmsg($fav,$msginfo['title'],$msginfo['content']);
            }
            
    		$message['state']=1;
    		$message['msg']="评论成功!";
    		 $this->load("doing");
            
             $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 14, $tid, $content);
    	}else{
    		$message['state']=0;
    		$message['msg']="评论失败!";
    	}
    	
    	echo json_encode($message);
    		exit();
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
    
    
    
    
    
    function onhotlist(){
    	 $navtitle = "最新文章推荐";
        $seo_description= "推荐问答最新文章，图文展示文章内容。";
        $seo_keywords= "问答文章";
        @$page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total('topic','ispc=1');
  
    	$topiclist= $_ENV['topic']->get_hotlist(1,  $startindex, $pagesize, 12);
    	 $departstr = page($rownum, $pagesize, $page, "topic/hotlist");
    
    	$art_rownum=$_ENV['topic']->rownum_by_user_article();
    	$userarticle=$_ENV['topic']->get_user_articles(0,5);
    	   include template('topichot');
    }
   
    //获取最新文章
    function ongetnewlist(){
    	 @$page = max(1, intval($this->get[2]));
        $pagesize = 6;
        $startindex = ($page - 1) * $pagesize;
        $wzrownum = $this->db->fetch_total('topic');
        $topiclist = $_ENV['topic']->get_list(2, $startindex, $pagesize);
        
        echo json_encode($topiclist);
        exit();
    }
    
    function ongetbycatidanduid(){
    	 $pagesize = 6;
    	 $muid=intval($this->get[2]);
    	 
    	 @$page = max(1, intval($this->get[4]));
    	 $startindex = ($page - 1) * $pagesize;
    	 if($this->get[3]=='all'){
    	 	
    	 	$topiclist=$_ENV['topic']->get_list_byuid($muid,$startindex, $pagesize);
    	 echo json_encode($topiclist);
    	exit();
    	 }
    	$cid=intval($this->get[3]);
    	
    	$topiclist = $_ENV['topic']->get_list_bycidanduid($cid,$muid,$startindex, $pagesize);
    	
    	echo json_encode($topiclist);
    	exit();
    	
    	
    }
    
    //获取用户相关的文章数和关注数
 function ongetuserarticles(){
    	 @$page = max(1, intval($this->get[2]));
        $pagesize = 8;
        $startindex = ($page - 1) * $pagesize;
        $userrownum =  $_ENV['topic']->rownum_by_user_article();
  
    	$topiclist= $_ENV['topic']->get_user_articles( $startindex, $pagesize);
    	echo json_encode($topiclist);
    	exit();
    	
    }
 
 /**
  * 支持文章分类的访问方式
  * 
  */

 function ondefault(){


     $cid =intval($this->get[2])?$this->get[2]:'all';
     @$page =max(1,intval($this->get[3]));
     $pagesize =$this->setting['list_default'];
     $startindex=($page-1)*$pagesize;
     if ($cid!='all')
     {
         $category=$this->category[$cid]; //获取分类信息
         $navtitle= $category['name'];
         $cfield ='cid'.$category['grade']; //获取当前分类的节点
         //置顶内容显示
         if(!isset($this->setting['list_topdatanum'])){
             $topictoplist = $_ENV['topic']->get_indextoplistbycid(1,0,3,10,$cid);
         }else{
             $topictoplist = $_ENV['topic']->get_indextoplistbycid(1,0,$this->setting['list_topdatanum'],10,$cid);
         }
     }else
     {
         $category=$this->category;
         $category['pid']=0;
         $cfield ='';
         $navtitle = '文章列表';
         //置顶内容显示
         if(!isset($this->setting['list_topdatanum'])){
             $topictoplist = $_ENV['topic']->get_indextoplist(1,0,3,10);
         }else{
             $topictoplist = $_ENV['topic']->get_indextoplist(1,0,$this->setting['list_topdatanum'],10);
         }
     }
     
     if ($cid != 'all') {
         $category=$_ENV['category']->get($cid);
     }

     
     $rownum =$_ENV['topic']->rownum_by_topic_articleid($cfield,$cid); 

     $topiclist= $_ENV['topic']->get_topic_byarticle($cfield,$cid,$startindex,$pagesize);
     foreach ($topiclist as $key=>$val){
         $topicsrc=  $_ENV['category']->get_navigation($val['articleclassid'],true);
         $toptemp =0;
         $count = count($topicsrc);
         for ($i = 0; $i < $count; $i++)
         {
             $toptemp.=$topicsrc[$i]['name'].'/';
         }
         $toptemp= substr($toptemp,1,strlen($toptemp)-1);

         $taglist = $_ENV['topic_tag']->get_by_aid($val['id']);
         $topiclist[$key]['srcs']=$toptemp;
         $topiclist[$key]['tags']=$taglist;
         
         
     }
     
  
     $navlist = $_ENV['category']->get_navigation($cid); //获取导航
     $sublist = $_ENV['category']->list_by_cid_pid($cid, $category['pid']); //获取子分类
 
     $departstr = page($rownum, $pagesize, $page, "topic/default/$cid"); //得到分页字符串
     $metadescription = '精彩推荐列表';
     $art_rownum=$_ENV['topic']->rownum_by_user_article();
     $userarticle=$_ENV['topic']->get_user_articles(0,5);
     include template('topic');
     
 }
 
    function ondefaulttemp() {
         $navtitle = "最新文章专栏推荐";
        $seo_description= "推荐问答最新文章专栏，热门文章和最新文章推荐。";
        $seo_keywords= "问答文章专栏";
        @$page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total('topic');
        $pages = @ceil($rownum/$pagesize);
        $topiclist = $_ENV['topic']->get_list(2, $startindex, $pagesize);
    foreach ($topiclist as $key=>$val){
        $topicsrc=  $_ENV['category']->get_navigation($val['articleclassid'],true);
        $toptemp =0;
        $count = count($topicsrc);
        for ($i = 0; $i < $count; $i++)
        {
            $toptemp.=$topicsrc[$i]['name'].'/';
        }
        $toptemp= substr($toptemp,1,strlen($toptemp)-1);

	   $taglist = $_ENV['topic_tag']->get_by_aid($val['id']);
       $topiclist[$key]['srcs']=$toptemp;
	$topiclist[$key]['tags']=$taglist;
        
	
}
        $departstr = page($rownum, $pagesize, $page, "topic/default");
        $metakeywords = $navtitle;
        $metadescription = '精彩推荐列表';
       	$art_rownum=$_ENV['topic']->rownum_by_user_article();
    	$userarticle=$_ENV['topic']->get_user_articles(0,5);
        include template('topic');
    }
    function oncatlist(){

    	$catid=$this->get[2];
  
    	     $is_followed = $_ENV['category']->is_followed($catid, $this->user['uid']);
    	      $followerlist=$_ENV['category']->get_followers($catid,0,8); //获取导航
    	 @$page = max(1, intval($this->get[3]));
    	 $catmodel=$_ENV['category']->get($catid);
    	 	$navtitle=$catmodel['name'];
    	 	  $cids=array();
      
    	 	 //如果这是顶级分类
    	 if($catmodel['pid']==0){
    	 	
    	 //获取当前分类下的子分类--二级分类
    	 $catlist=	$_ENV['category']->list_by_pid($catid);
    	
    	 //把顶级分类id写入数组
    	   array_push($cids, $catid);
    	   //循环获取顶级分类下的子分类
    	   foreach ($catlist as $key=>$val){
         	
    	   	//子分类写入数组
            array_push($cids, $val['id']);
            //获取子分类下的三级分类
           $catlist1=	$_ENV['category']->list_by_pid($val['id']);
            foreach ($catlist1 as $key1=>$val1){
            	 array_push($cids, $val1['id']);
            }
           
         }
        
    	 }else{
    	 	
    	 	//如果不是顶级分类，先将分类id写入数组
    	 	array_push($cids, $catid);
    	 	
    	 	//获取该分类下的父亲级别的分类
    	  // $catlist=$_ENV['category']->list_by_pid($catmodel['pid']);
    	   
    	   //获取该分类下的子分类
    	    $catlist=	$_ENV['category']->list_by_pid($catid);
    	    
    	   
    	    if($catlist){
    	   
    	    //遍历子分类写入数组
            foreach ($catlist as $key=>$val){
            	 array_push($cids, $val['id']);
            }
             
    	   
    	    }
            
              if($catmodel['grade']==3){
              
              	
              	   $catlist=	$_ENV['category']->list_by_pid($catmodel['pid']);
            
              
                   //$catmodel=$_ENV['category']->get($catmodel['pid']); //不知道为要显示上一级分类
              	 
              	
              }
    	 	 
    	 	  
    	 	 // var_dump($catmodel);exit();
    	 }
        
    	
         //echo var_dump($catmodel);
         //exit();
       
         $cid=implode(',', $cids);
       
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
         $rownum = $this->db->fetch_total('topic',"articleclassid in($cid)");
         //分类置顶
        if(!isset($this->setting['list_topdatanum'])){
            $topictoplist = $_ENV['topic']->get_categorytoplistbycid(1,0,3,10,$catid);
        }else{
            $topictoplist = $_ENV['topic']->get_categorytoplistbycid(1,0,$this->setting['list_topdatanum'],10,$catid);
        }

        $topiclist = $_ENV['topic']->get_bycatid($cid, $startindex, $pagesize);
         

foreach ($topiclist as $key=>$val){
	

	   $taglist = $_ENV['topic_tag']->get_by_aid($val['id']);

	$topiclist[$key]['tags']=$taglist;
        
	
}
        $departstr = page($rownum, $pagesize, $page, "topic/catlist/$catid");
        
         /* SEO */
         $seo_keywords=$navtitle;
         $seo_description=$this->setting['site_name'].$navtitle.'频道，提供'.$navtitle.'相关文章。';
        if ($this->setting['seo_category_title']) {
            $seo_title = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_category_title']);
            $seo_title = str_replace("{flmc}", $navtitle, $seo_title);
            if($page==1){
            	
            }else{
            	 $seo_title=$seo_title.'_第'.$page."页";
            }
            
        }else{
          if($page==1){
            	
            }else{
            	$navtitle=$navtitle.'_第'.$page."页";
            }
        	
        }
              
        if ($this->setting['seo_category_description']) {
            $seo_description = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_category_description']);
            $seo_description = str_replace("{flmc}", $navtitle, $seo_description);
        }
        if ($this->setting['seo_category_keywords']) {
            $seo_keywords = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_category_keywords']);
            $seo_keywords = str_replace("{flmc}", $navtitle, $seo_keywords);
        }

        
        include template('catlist');
    
    }

    function ongetone(){
    	
    	$useragent = $_SERVER['HTTP_USER_AGENT']; 
 
      
 
    	
    	
     $menu="topic";
     $topicid=intval($this->get[2]);
    	$topicone = $_ENV['topic']->get($topicid);
    	$topicone['describtion']=checkwordsglobal($topicone['describtion']);
        if(!$_ENV['topic']->checkisallowed($topicone)){
            $this->message('您没有权限查看此问题！');
        }
    	$cat_model=$_ENV['category']->get($topicone['articleclassid']);
        $nav_article = $_ENV['category']->get_navigation($topicone['articleclassid'],true); //获取文章分类列表

        $toptemp =0;
        $count = count($nav_article);
        for ($i = 0; $i < $count; $i++)
        {
            $toptemp.=$nav_article[$i]['name'].'/';
        }
        $toptemp= substr($toptemp,1,strlen($toptemp)-1);
        $nav_article=$toptemp;
     $taglist = $_ENV['topic_tag']->get_by_aid($topicone['id']);
     $cid=$topicone['articleclassid'];
     $category = $this->category[$cid]; //得到分类信息
         $ctopiclist = $_ENV['topic']->get_bycatid($cid);  
            $cfield = 'cid' . $category['grade'];
     // $questionlist=$_ENV['question']->list_by_condition(" ");
        $questionlist = $_ENV['question']->list_by_cfield_cvalue_status($cfield, $cid, 'all', 0, 8); //问题列表数据
           $topicone['tags']=$taglist;
    	$topicone['views']=$topicone['views']+1;
        //这个地方也要更新
    	 $_ENV['topic']->updatetopic($topicone['id'], $topicone['title'], $topicone['describtion'],$topicone['image'],$topicone['isphone'],$topicone['views'],$topicone['articleclassid'],$topicone['ispc'],$topicone['authoritycontrol'],$topicone['cid1'],$topicone['cid2'],$topicone['cid3']);
    	 $navtitle = $topicone['title'];
    	    $this->load("favorite");
   	    $followerlist=$_ENV['favorite']->get_list_bytid($topicid);//收藏的人
    	 $metakeywords = $navtitle;
        $metadescription = $topicone['title'];
        
         $member = $_ENV['user']->get_by_uid($topicone['authorid'], 2);
             $is_followed = $_ENV['user']->is_followed($member['uid'], $this->user['uid']);
          $topiclist1 = $_ENV['topic']->get_list_byuid($member['uid'],0,8);
           $topiclist3 = $_ENV['topic']->get_list(1, 8);
            $is_followedauthor = $_ENV['user']->is_followed($member['uid'], $this->user['uid']);
           $this->load("articlecomment");
           $tid=$topicone['id'];
     //评论分页      
        @$page=0;  
        if(strpos($this->get[4], 'a') !== false ){
        	@$page = 1;
        	 
        }else{
        	@$page = max(1, intval($this->get[3]));
        }
          $pagesize =5;// $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
    
        $commentlist=$_ENV['articlecomment']->list_by_tid($tid,1,$startindex,$pagesize);
        
        $commentrownum = $this->db->fetch_total("articlecomment", " tid=$tid AND status=1 ");
                       
                      $departstr = page($commentrownum, $pagesize, $page, "topic/getone/$topicid" );

  
    		include template('topicone');
 
    }
    
    
    function onajaxhasssupport(){
        $tid = intval($this->get[2]);
        $has = $_ENV['topic']->get_support_by_sid_aid($this->user['sid'],$tid);
        $ret =$has ?'1' :'-1'; //?输出数字不行？
        exit($ret);
    }
    
    function onajaxaddsupport(){
        $topicid = intval($this->get[2]);
        $topic = $_ENV['topic']->get($topicid);
        $_ENV['topic']->add_support($this->user['sid'], $topicid, $topic['authorid']);
        $topic = $_ENV['topic']->get($topicid);
        if ($this->user['uid']) {
            $this->load('doing');
            $_ENV['doing']->add($this->user['uid'], $this->user['realname'], 15, $topicid, $topic['title']);
            $touser =$_ENV['user']->get_by_uid($topic['authorid']);
            $msginfo = $_ENV['email_msg']->topic_ok($touser['realname'],$topic['title']);
            $this-> sendmsg($touser,$msginfo['title'],$msginfo['content']);
            
        }
        exit($topic['supports']);
    }
    
    
    
    

    function onuserxinzhi(){
    	$uid=$this->get[2];
    	if($uid==null){
    		exit("非法操作");
    	}
    	 $member = $_ENV['user']->get_by_uid($uid, 2);
    	  $is_followed = $_ENV['user']->is_followed($member['uid'], $this->user['uid']);
    $navtitle = $member['username'].'的专栏列表';
        
        @$page = max(1, intval($this->get[3]));
        $pagesize = 5;//$this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        //$rownum = $this->db->fetch_total('topic',"authorid=$uid");
        $rownum = $_ENV['topic']->rownumbycondition("authorid=$uid");
        $topiclist = $_ENV['topic']->get_list_byuid($uid, $startindex, $pagesize);
        	 $pages = @ceil($rownum / $pagesize);
        $catags= $_ENV['topic']->get_article_by_uid($uid);
foreach ($topiclist as $key=>$val){
	

	   $taglist = $_ENV['topic_tag']->get_by_aid($val['id']);

	$topiclist[$key]['tags']=$taglist;
        
	
}
        $departstr = page($rownum, 5, $page, "topic/userxinzhi/$uid");
        $metakeywords = $navtitle;
        $metadescription = $member['username'].'的专栏列表';
      
        

    		include template('userxinzhi');
    
             
       
    }

    //取消首页置顶
    function oncancelindextop(){
        $id=intval($this->get[2]);
        $_ENV['topic']->update_indextop(0,$id);
        //cleardir(ASK2_ROOT . '/data/cache'); //清除缓存文件
        $this->message("取消文章首页置顶成功!");
    }
    //首页置顶
    function onaddindextop(){
        $id=intval($this->get[2]);
        $_ENV['topic']->update_indextop(1,$id);
        //cleardir(ASK2_ROOT . '/data/cache'); //清除缓存文件
        $this->message("文章首页置顶成功!");
    }
    //取消分类置顶
    function oncancelcategorytop(){
        $id=intval($this->get[2]);
        $_ENV['topic']->update_categorytop(0,$id);
        //cleardir(ASK2_ROOT . '/data/cache'); //清除缓存文件
        $this->message("取消文章分类置顶成功!");
    }
    //分类置顶
    function onaddcategorytop(){
        $id=intval($this->get[2]);
        $_ENV['topic']->update_categorytop(1,$id);
        //cleardir(ASK2_ROOT . '/data/cache'); //清除缓存文件
        $this->message("文章分类置顶成功!");
    }
}

?>