<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/space.css" />
<div class="container person">
  <div class="row">
    <div class="col-xs-16 main">
          <!-- 用户title部分导航 -->
              
<? include template('user_title'); ?>
     
      <div id="list-container">
        <!-- 文章列表模块 -->
<ul class="note-list">
   <? if($questionlist) { ?>   
      
<? if(is_array($questionlist)) { foreach($questionlist as $question) { ?>
                
    <li id="note-<?=$question['id']?>" data-note-id="<?=$question['id']?>" <? if($question['image']!=null) { ?>  class="have-img" <? } else { ?>class="" <? } ?>>
    <? if($question['image']!=null) { ?>  
      <a class="wrap-img" <? if($question['articleclassid']!=null) { ?> href="http://172.16.1.208/?article-<?=$question['id']?>.html"  <? } else { ?>  href="http://172.16.1.208/?q-<?=$question['id']?>.html" <? } ?> target="_blank">
            <img src="<?=$question['image']?>">
        </a>
            <? } ?>        <div class="content">
            <div class="author">
            
            
               
                
                   
        <? if($question['hidden']==1) { ?>  
          <a class="avatar"  href="javascript:void(0)">
                    <img src="<?=$question['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>
                
                
        <? } else { ?>        <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$question['authorid']?>.html">
                    <img src="<?=$question['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="http://172.16.1.208/?u-<?=$question['authorid']?>.html"><?=$question['author']?></a>
                
        <? } ?>        
                
                <span class="time" data-shared-at="<?=$question['format_time']?>">.关注时间：<?=$question['attention_time']?></span>
            </div>
            </div>
            <a class="title" target="_blank"   href="http://172.16.1.208/?q-<?=$question['id']?>.html"  ><?=$question['title']?></a>
            <p class="abstract">
                <? echo strip_tags($question['description']); ?>                
            </p>
            <div class="meta">

                <a target="_blank"  href="http://172.16.1.208/?q-<?=$question['id']?>.html" >
                    <i class="fa fa-eye"></i> <?=$question['views']?>
                </a>        <a target="_blank"   href="http://172.16.1.208/?q-<?=$question['id']?>.html#comments" >
                <i class="fa fa-comment-o"></i> <?=$question['answers']?>
            </a>      <span><i class=" fa fa-heart-o"></i>  <?=$question['attentions']?></span>
            </div>
        </div>
    </li>

    
<? } } ?>
      <? } else { ?>       <div class="text">
            抱歉，您还没有关注过任何问题~
          </div>
          <? } ?>                    
     
   


   
   

   


   
   

</ul>
  <div class="pages" ><?=$departstr?></div>   
      </div>
    </div>
    
<div class="col-xs-7 col-xs-offset-1 aside">
   
<? include template('user_menu'); ?>
</div>

  </div>
</div>
<? include template('footer'); ?>
