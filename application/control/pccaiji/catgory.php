<?php

!defined('IN_ASK2') && exit('Access Denied');

class pccaiji_catgorycontrol extends base {

    function pccaiji_catgorycontrol(& $get, & $post) {
        $this->base($get,$post);
      
        $this->load('category');
         $this->load('topic');
        $this->load('user');
    }

     function ondefault() {
     $file=	$this->getfolders();
     
     	
     }
function getfolders() {
	 $file=array();
 	$file_dir="caijiimage";
 	 $shili = $file_dir ; 
       if ( !file_exists ( $shili )){ 
         return  '0'; 
      }else{   
       $i = 0; 
      
         if ( is_dir ( $shili )){                   //检测是否是合法目录 
           if ($shi = opendir ( $shili )){          //打开目录 
              while ($li = readdir( $shi )){       //读取目录 
              
              	
              	if(strpos($li, 'jpg')>0||strpos($li, 'png')>0)
                 array_push($file, $li);
                
                } } }     //输出目录中的内容 
         
         closedir ( $shi ) ;
        return $file;  
      } 
 }
function removeLinks($str){
    if(empty($str))return    '';
    $str    =preg_replace('/(http)(.)*([a-z0-9\-\.\_])+/i','',$str);
    return    $str;
}
function onaddtopic() {
	
	//$stream = fopen("aa.txt", "w+");
//fwrite($stream, $this->post['classid'].'----'.$this->post['articlevalue'].'!!!!!!!!!!!!!!!'.$this->post['title']."!!!!!!!!!".$this->post['content']);
$code=$this->setting['hct_logincode']!=null? $this->setting['hct_logincode']:rand(111111, 9999999);

	if($this->post['title']!=''){
		
		$article=$_ENV['topic']->get_byname($this->post['title']);
		$classid=$this->post['classid'];
		$title=$this->post['title'];
				$content=$this->post['content'];
			if($code!=$this->post['articlevalue']){
				echo '没有发布权限!';
				exit();
			}
		if($article!=null){
			
			echo '文章已存在，发布时间为'.$article['viewtime'];
			exit();
		}else{
				
    //   $content=$this->removeLinks($this->post['content']);
 
    $content=preg_replace("#<a[^>]*>(.*?)</a>#is", "$1", $content);
    	 $userlist = $_ENV['user']->get_caiji_list(0, 40);
    	 $mwtuid=array_rand($userlist,1);
    	 $uid=$userlist[$mwtuid]['uid'];
    	 $username=$userlist[$mwtuid]['username'];
    	 $file=$this->getfolders();
	
  //  for($i=1;$i<=60;$i++){
    	//array_push($classarr, $i);
   // }
    	 $url='http://www.ask2.cn/data/attach/topic/topic6DYxVY.jpg';
    	$img_url=getfirstimg($content);
    	//*[@id="contentText"]/p[14]
    	//*[@id="contentText"]/ul
    	////*[@id="contentText"]/p[17]
//		 $img_arr=getfirstimgs($content);
//    	 	   	 	 if($img_arr[1]!=null){
//    	 	 for($i=0;$i<count($img_arr[1]);$i++){
//	$img_url=getImageFile($img_arr[1][$i],rand(100000, 99999999).".jpg","upload/",1);
//	$desc=str_replace($img_arr[1][$i],$img_url, $desc);
//}
//    	 	   	 	 }
    	 if($file!='0'){
    	 	$mwtfid=array_rand($file,1);
     	
    	 	$url=SITE_URL.'static/caijiimage/'.$file[$mwtfid];
    	 }
		if($img_url==""){
    		$img_url=$url;
    	}
			if(ckabox=='true'||ckabox=='on'){
	 $content=filter_outer($content);
}
if(trim($content)!=''){
	$aid=$_ENV['topic']->addtopic($title,$content,$img_url,$username,$uid,rand(1, 30),$classid);
if($aid>0){
	 //$this->load("topic_tag");
	 // $tagarr= dz_segment($this->post['title'],$this->post['content']);
	      // $tagarr && $_ENV['topic_tag']->multi_add(array_unique($tagarr),  $aid);
	        $this->load("doing");
               $_ENV['doing']->add($uid, $username, 9, $aid, $title);
	echo '发布成功';
}else{
		
		echo "发布失败";
		
	}
}else{
	echo "发布失败,内容不能为空";
}
	
		
		
	
		
	
		}
	
     	

}else{
	echo '标题不能为空';
}

}
    function onlist() {
    	
          $cid = intval($this->get[2])?$this->get[2]:'all';
          $navlist = $_ENV['category']->list_by_pid(0); //获取导航
         $cat_string='';
          foreach ($navlist as $nav){
         	$cat_string=$cat_string.','.$nav['name'].'|'.$nav['id'];
         }
         echo $cat_string;
          
    }
    function onselectlist() {
    	echo("<select>");
          $cid = intval($this->get[2])?$this->get[2]:'all';
          $navlist = $_ENV['category']->list_by_grade(); //获取导航
         $cat_string='';
          foreach ($navlist as $nav){
       
         	echo "<option value='".$nav['id']."'>".$nav['name']."</option>";
         	if($nav['sublist']!=null){
         	foreach ($nav['sublist'] as $nav1){
         			echo "<option value='".$nav1['id']."'>--".$nav1['name']."</option>";
         	}
         	}
         	
         }
       echo("</select>");
          
    }


}

?>