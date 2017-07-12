<?php

!defined('IN_ASK2') && exit('Access Denied');

class newcontrol extends base {
	

    function newcontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load('category');
        $this->load('question');
        $this->load("topic");
    }
    /**
     * 替换掉之前的查询
     */
    function ondefaulttemp() {
    	 $this->load('question');
         $this->load('category');
    	  $navtitle ="最近更新_";
    	  $seo_description=$this->setting['site_name']. '最近更新相关内容。';
             $seo_keywords= '最近更新';
    	 //回答分页      
        @$page=1;  
     @$page = max(1, intval($this->get[2]));
       $pagesize =50;// $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
      $rownum = $_ENV['question']->rownum_by_cfield_cvalue_status('', 'all', 1); //获取总的记录数
        $questionlist = $_ENV['question']->list_by_cfield_cvalue_status('', 'all', 1, $startindex, $pagesize); //问题列表数据
        $departstr = page($rownum, $pagesize, $page, "new-"); //得到分页字符串
//        
 $this->load('tag');
foreach ($questionlist as $key=>$val){
	

    
    $quesrc=  $_ENV['category']->get_navigation($val['cid'],true);
    $quetemp =0;
    $count = count($quesrc);
    for ($i = 0; $i < $count; $i++)
    {
        $quetemp.=$quesrc[$i]['name'].'/';
    }
    $quesrc= substr($quetemp,1,strlen($quetemp)-1);
    
    
    $questionlist[$key]["srcs"]=$quesrc;
	   $taglist = $_ENV['tag']->get_by_qid($val['id']);
	
	$questionlist[$key]['tags']=$taglist;
        
	
}
               // $questionlist = $_ENV['question']->list_by_cfield_cvalue_status('', 0, 1,$startindex, $pagesize);
    	include template('new');
    }
    
    //category/view/1/2/10
    //cid，status,第几页？
    function ondefault() {
        $cid = intval($this->get[2])?$this->get[2]:'all';
        $status = isset($this->get[3]) ? $this->get[3] : 'all';
        @$page = max(1, intval($this->get[4]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
        if ($cid != 'all') {
            $category = $this->category[$cid]; //得到分类信息
            $navtitle = $category['name'];
            $cfield = 'cid' . $category['grade'];
        } else {
            $category = $this->category;
            $navtitle = '问答列表';
            $cfield = '';
            $category['pid'] = 0;
        }
        if ($cid != 'all') {
            $category=$_ENV['category']->get($cid);
        }
        
        $statusword="";
        switch ($status){
        	case '1':
        		$statusword='待解决';
        		break;
            case '2':
                $statusword='已解决';
        		break;
            case '4':
                $statusword='高悬赏';
        		break;
            case '6':
                $statusword='推荐';
        		break;
            case 'all':
                $statusword='全部';
                break;
        }
        $is_followed = $_ENV['category']->is_followed($cid, $this->user['uid']);
        $rownum = $_ENV['question']->rownum_by_cfield_cvalue_status($cfield, $cid, $status); //获取总的记录数
        $questionlist = $_ENV['question']->list_by_cfield_cvalue_status($cfield, $cid, $status, $startindex, $pagesize); //问题列表数据
        //$topiclist = $_ENV['topic']->get_bycatid($cid, 0, 8);
        $followerlist=$_ENV['category']->get_followers($cid,0,8); //获取导航
        $departstr = page($rownum, $pagesize, $page, "new/default/$cid/$status/"); //得到分页字符串
        $navlist = $_ENV['category']->get_navigation($cid); //获取导航
        $sublist = $_ENV['category']->list_by_cid_pid($cid, $category['pid']); //获取子分类
        $this->load('tag');
        foreach ($questionlist as $key=>$val){
            

            
            $quesrc=  $_ENV['category']->get_navigation($val['cid'],true);
            $quetemp =0;
            $count = count($quesrc);
            for ($i = 0; $i < $count; $i++)
            {
                $quetemp.=$quesrc[$i]['name'].'/';
            }
            $quesrc= substr($quetemp,1,strlen($quetemp)-1);
            
            
            $questionlist[$key]["srcs"]=$quesrc;
            $taglist = $_ENV['tag']->get_by_qid($val['id']);
            
            $questionlist[$key]['tags']=$taglist;
            
            
        }
       // $trownum = $this->db->fetch_total('topic',"articleclassid in($cid)");
        $seo_description="";
        $seo_keywords="";
        
        if($category['alias']){
        	$navtitle=$category['alias'];
        }
        
        
        include template('new');
    }
    
    //分类未解决问题
    function onnosolvequs(){
        $cid = intval($this->get[2])?$this->get[2]:'all';
        @$page = max(1,intval($this->get[3]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page-1)*$pagesize;
        if ($cid!='all')
        {
        	$category =$this->category[$cid];
            $navtitle = $category['name'];
            $cfield = 'cid'.$category['grade'];
        }else
        {
            $category =$this->category;
            $navtitle ='问答列表';
            $cfield='';
            $category['pid'] =0; //获取根分类
        	    
        }
        if ($cid != 'all') {
            $category=$_ENV['category']->get($cid);
        }
        $is_followed = $_ENV['category']->is_followed($cid, $this->user['uid']);
        $rownum = $_ENV['question']->rownum_by_nosove_list($cfield,$cid);
        $questionlist = $_ENV['question']->list_by_nosove_list($cfield,$cid,$startindex,$pagesize);
        $followerlist=$_ENV['category']->get_followers($cid,0,8); //获取导航
        $departstr = page($rownum, $pagesize, $page, "new/nosolvequs/$cid"); //得到分页字符串
        $navlist = $_ENV['category']->get_navigation($cid); //获取导航
        $sublist = $_ENV['category']->list_by_cid_pid($cid, $category['pid']); //获取子分类
        $this->load('tag');
        foreach ($questionlist as $key=>$val){
            

            
            $quesrc=  $_ENV['category']->get_navigation($val['cid'],true);
            $quetemp =0;
            $count = count($quesrc);
            for ($i = 0; $i < $count; $i++)
            {
                $quetemp.=$quesrc[$i]['name'].'/';
            }
            $quesrc= substr($quetemp,1,strlen($quetemp)-1);
            
            
            $questionlist[$key]["srcs"]=$quesrc;
            $taglist = $_ENV['tag']->get_by_qid($val['id']);
            
            $questionlist[$key]['tags']=$taglist;
            
            
        }
        $seo_description="";
        $seo_keywords="";
        
        if($category['alias']){
        	$navtitle=$category['alias'];
        }
        include template('nosolvequs');
        
    }
    
    
    
    //分类提问未回答问题
    
    
    function onasknosolve(){
        $cid = intval($this->get[2])?$this->get[2]:'all';
        @$page = max(1, intval( $this->get[3]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page-1)*$pagesize;
        
        if ($cid!='all')
        {
        	$category =$this->category[$cid];
            $navtitle = $category['name'];
            $cfield = 'cid'.$category['grade'];
        }else
        {
            $category =$this->category;
            $navtitle ='问答列表';
            $cfield='';
            $category['pid'] =0; //获取根分类
            
        }
        if ($cid != 'all') {
            $category=$_ENV['category']->get($cid);
        }
        $is_followed = $_ENV['category']->is_followed($cid, $this->user['uid']);
        $rownum = $_ENV['question']->rownum_by_asknosove_list($cfield,$cid);
        $questionlist = $_ENV['question']->list_by_asknosove_list($cfield,$cid,$startindex,$pagesize);
   
        $followerlist=$_ENV['category']->get_followers($cid,0,8); //获取导航
        $navlist = $_ENV['category']->get_navigation($cid); //获取导航
        $departstr = page($rownum, $pagesize, $page, "new/asknosolve/$cid"); //得到分页字符串
        $sublist = $_ENV['category']->list_by_cid_pid($cid, $category['pid']); //获取子分类
        $this->load('tag');
        foreach ($questionlist as $key=>$val){
            

            
            $quesrc=  $_ENV['category']->get_navigation($val['cid'],true);
            $quetemp =0;
            $count = count($quesrc);
            for ($i = 0; $i < $count; $i++)
            {
                $quetemp.=$quesrc[$i]['name'].'/';
            }
            $quesrc= substr($quetemp,1,strlen($quetemp)-1);
            
            
            $questionlist[$key]["srcs"]=$quesrc;
            $taglist = $_ENV['tag']->get_by_qid($val['id']);
            
            $questionlist[$key]['tags']=$taglist;
            
            
        }
        $seo_description="";
        $seo_keywords="";
        
        if($category['alias']){
        	$navtitle=$category['alias'];
        }
        include  template('noasknosolve');
        
    }
    
    
    
    
    
 function onmaketag() {
    	 $this->load('question');
    	  $navtitle ="最近更新_";
    	  $seo_description=$this->setting['site_name']. '最近更新相关内容。';
             $seo_keywords= '最近更新';
    	 //回答分页      
        @$page=1;  
     @$page = max(1, intval($this->get[2]));
       $pagesize =50;// $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
      $rownum = $_ENV['question']->rownum_by_cfield_cvalue_status('', 'all', 1); //获取总的记录数
        $questionlist = $_ENV['question']->list_by_cfield_cvalue_status('', 'all', 1, $startindex, $pagesize); //问题列表数据
        $departstr = page($rownum, $pagesize, $page, "new/maketag"); //得到分页字符串
//        
 $this->load('tag');
foreach ($questionlist as $key=>$val){
	

	  
	

        $taglist=dz_segment(htmlspecialchars($val['title']));
        	$questionlist[$key]['tags']=$taglist;
        $taglist && $_ENV['tag']->multi_add(array_unique($taglist), $val['id']);
	
}
              
    	include template('maketag');
    }
}