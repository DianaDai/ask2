<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/space.css" />
<div class="container person">
  <div class="row">
    <div class="col-xs-16 main">
          <!-- 用户title部分导航 -->
          
           <? if($uid==$user['uid']) { ?>              
<? include template('user_title'); ?>
             <? } else { ?>                
<? include template('space_title'); ?>
               <? } ?>           

     
      <div id="list-container">
        <!-- 回答列表模块 -->
<ul class="note-list">
   <? if($topiclist) { ?>   
        
<? if(is_array($topiclist)) { foreach($topiclist as $index => $topic) { ?>
       
                
    <li id="note-<?=$topic['id']?>" data-note-id="<?=$topic['id']?>" <? if($topic['image']!=null) { ?>  class="have-img" <? } else { ?>class="" <? } ?>>
    <? if($topic['image']!=null) { ?>  
      <a class="wrap-img"  href="http://172.16.1.208/?article-<?=$topic['id']?>.html"  target="_blank">
            <img src="<?=$topic['image']?>">
        </a>
            <? } ?>        <div class="content">
            <div class="author">
            
            
               
                
                   
      
        <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$topic['authorid']?>.html">
                    <img src="<?=$topic['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="http://172.16.1.208/?u-<?=$topic['authorid']?>.html"><?=$topic['author']?></a>
                
   
        
                
                <span class="time" data-shared-at="<?=$topic['format_time']?>"><?=$topic['format_time']?></span>
            </div>
            </div>
            <a class="title" target="_blank"   href="http://172.16.1.208/?article-<?=$topic['id']?>.html"  ><?=$topic['title']?></a>
            <p class="abstract">
                <? echo strip_tags($topic['describtion']); ?>                
            </p>
            <div class="meta">

                <a target="_blank"  href="http://172.16.1.208/?article-<?=$topic['id']?>.html" >
                    <i class="fa fa-eye"></i> <?=$topic['views']?>
                </a>        <a target="_blank"   href="http://172.16.1.208/?article-<?=$topic['id']?>.html#comments" >
                <i class="fa fa-comment-o"></i> <?=$topic['articles']?>
            </a>      <span><i class=" fa fa-heart-o"></i>  <?=$topic['likes']?></span>
            </div>
        </div>
    </li>

    
<? } } ?>
      <? } else { ?>      
          <? } ?>                    
     
   


   
   

   


   
   

</ul>
  <div class="pages" ><?=$departstr?></div>   
      </div>
    </div>
    
<div class="col-xs-7 col-xs-offset-1 aside">
   
<? include template('space_menu'); ?>
</div>

  </div>
</div>
<? include template('footer'); ?>
