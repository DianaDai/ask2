<?php

!defined('IN_ASK2') && exit('Access Denied');

class indexcontrol extends base {
var $whitelist;
    function indexcontrol(& $get, & $post) {
        $this->base($get, $post);
          $this->whitelist="notfound";
        
    }

    function  checkexist($topdata,$data){
        foreach ($topdata as $key=> $value)
        {
            if($value['id'] == $data['id']){
                return true;
            }
        }
        return false;
    }
    function ondefault() {
        $choosetype=$this->get[2]?$this->get[2]:'all';
    	$this->load('setting');
        $this->load('category');
        $this->load('topic');
        $this->load('note');
        //显示置顶内容
        if(!isset($this->setting['list_topdatanum'])){
            $topicdatalist = $_ENV['topic']->get_indextoplist(1,0,3,10);
        }else{
            $topicdatalist = $_ENV['topic']->get_indextoplist(1,0,$this->setting['list_topdatanum'],10);
        }

        if(!isset($this->setting['list_topdatanum'])){
            $notedatalist = $_ENV['note']->get_toplist(0,3);
        }else{
            $notedatalist = $_ENV['note']->get_toplist(0,$this->setting['list_topdatanum']);
        }

//        $topictoplist=$this->fromcache('topictopdata');
//        $notetoplist=$this->fromcache('notetopdata');

    	// if(!is_mobile()){

        $tnosolvelist=$this->fromcache('nosolvelist');
        foreach ($tnosolvelist as $key=> $value)
        {
            $tnosolvelist[$key]['flag']=1;//1 代表问题
            $tnosolvelist[$key]['temptitle']='提了一个问题';
            $tnosolvelist[$key]['tempurl']="?question/view/".$value['id'];
            $tnosolvelist[$key]['tempcomments']="?question/view/".$value['id'] ."#comments";
        }
    	// }else{
    	 	//$nosolvelist=$this->fromcache('nosolvelist');
    	// }
         $temp_notelist=$this->fromcache('notelist');
        $notelist = array();
        foreach ($temp_notelist as $key=> $value)
        {
            $temp_notelist[$key]['flag']=2;//2 代表公告
            $temp_notelist[$key]['temptitle']='发布了一篇公告';
            //$note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}"
            if($temp_notelist[$key]['url']){
                $temp_notelist[$key]['tempurl']=$value['url'];
                $temp_notelist[$key]['tempcomments']=$value['url'];
            }else{
                $temp_notelist[$key]['tempurl']="?note/view/".$value['id'];
                $temp_notelist[$key]['tempcomments']="?note/view/".$value['id'] ."#comments";
            }
            $temp_notelist[$key]['answers'] = $value['comments'];
            //不是首页置顶的加入
            if($this->checkexist($notedatalist,$temp_notelist[$key])) {
                $notelist[] = $temp_notelist[$key];
            }
        }
    	 $temp_topiclist=$this->fromcache('topiclist');
        $topiclist = array();
        foreach ($temp_topiclist as $key=> $value)
        {
            $temp_topiclist[$key]['flag']=3;//3 代表文章
            $temp_topiclist[$key]['temptitle']='发布了一篇文章';
            $temp_topiclist[$key]['tempurl']="?topic/getone/".$value['id'];
            $temp_topiclist[$key]['tempcomments']="?topic/getone/".$value['id']."#comments";
            //不是首页置顶的加入
            if($this->checkexist($topicdatalist,$temp_topiclist[$key])) {
                $topiclist[] = $temp_topiclist[$key];
            }
        }
    	// if(!is_mobile()){

        switch ($choosetype) {
            case 'all':
                $nosolvelist=array_merge($tnosolvelist,$topiclist,$notelist);
                $typename = "全部";
                break;
            case 'topic':
                $nosolvelist=$topiclist;
                $typename = "文章";
                break;
            case 'question':
                $nosolvelist=$tnosolvelist;
                $typename = "问题";
                break;
            case 'note':
                $nosolvelist=$notelist;
                $typename = "公告";
                break;
        }

    	$nosolvelist=$this->getnewlist_bytime($nosolvelist);
    	// }
        
        foreach ($nosolvelist as $key=> $value)
        {
            if (array_key_exists('cid', $value)) //null  false
            { 
            	$navtemp=$this-> getnavtitle($value['cid']); //调用方法要$this-> 坑死
            }else
            {
            	$navtemp=$this->getnavtitle($value['articleclassid']);
            }
            $nosolvelist[$key]['srcs']=$navtemp;
        }

//    	foreach ($nosolvelist as $key=>$val){
//    		
//    		echo $val['title'].'----'.$val['format_time']."---".$val['sortime']."<br>";
//    	}
//
//exit();
        /* SEO */
        $this->setting['seo_index_title'] && $seo_title = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_index_title']);
        $this->setting['seo_index_description'] && $seo_description = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_index_description']);
        $this->setting['seo_index_keywords'] && $seo_keywords = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_index_keywords']);
        $navtitle = $this->setting['site_alias'];


    	$art_rownum=$_ENV['topic']->rownum_by_user_article();
    	$userarticle=$_ENV['topic']->get_user_articles(0,5);

    
  	include template('index');
  

 
    
    }
  
    
    
    
    function getnavtitle($cid){
        $topicsrc=  $_ENV['category']->get_navigation($cid,true);
        $toptemp =0;
        $count = count($topicsrc);
        for ($i = 0; $i < $count; $i++)
        {
            $toptemp.=$topicsrc[$i]['name'].'/';
        }
        $toptemp= substr($toptemp,1,strlen($toptemp)-1);
        return $toptemp;
    }
    
    
    function getnewlist_bytime($arr){
    	
    	$i=0;
    	$len=count($arr);
    	$j=0;
    	$d=0;
    	for($i;$i<$len;$i++){
    		for($j=0;$j<$len;$j++){
    		   if ($arr[$i]['sortime'] > $arr[$j]['sortime']) {
                $d = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $d;
            }
    		}
    	}
    	return $arr;
//    	//定义一个空数组
//    	$temparr=array();
//    	//定义一个值，假定这个值是最大的
//    	$maxtime=0;
//    	$i=0;
//    foreach ($arr as $key=>$val){
//	
//    	//如果数组等于空就假定第一个值是最大的
//    	if($temparr==null){
//    		//$val['sortime']=strtotime($val['format_time']);
//    		$maxtime=$val['sortime'];
//    		array_push($temparr, $val);
//    	}else{
//    	//如果下一个值比当前值小就插入数组屁股后面，如果比当前值大就插入数组开始位置
//    	//$val['sortime']=strtotime($val['format_time']);
//	    	if($maxtime>$val['sortime']){
//	    		array_push($temparr, $val);
//	    	}else{
//	    		//如果当前值比最初值大就重新赋值
//	    		$maxtime=$val['sortime'];
//	    		$tmp_maxarr=array();
//	    		array_push($tmp_maxarr, $val);
//	    	  array_splice($temparr,$i-1,0,$tmp_maxarr);
//	    	}
//    	}
//    	$i++;
//    	
//      }
//    	return $temparr;
    }

    function onhelp() {
       $this->message("即将跳转网站教程中...","cat-219");
    }

    function ondoing() {
        include template("doing");
    }
     function onnotfound(){
     	  include template("404");
     }
    /* 查询图片是否需要点击放大 */

    function onajaxchkimg() {
        list($width, $height, $type, $attr) = getimagesize($this->post['imgsrc']);
        ($width > 300) && exit('1');
        exit('-1');
    }

    function ononline() {
        $navtitle = "当前在线";
        $this->load('user');
        @$page = max(1, intval($this->get[2]));
        $pagesize = 30;
        $startindex = ($page - 1) * $pagesize;
        $onlinelist = $_ENV['user']->list_online_user($startindex, $pagesize);
        $onlinetotal = $_ENV['user']->rownum_onlineuser();
        $departstr = page($onlinetotal, $pagesize, $page, "index/online");
        include template("online");
    }

}

?>