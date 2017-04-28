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
      
<? if(is_array($doinglist)) { foreach($doinglist as $index => $question) { ?>
                
    <li id="note-<?=$question['id']?>" data-note-id="<?=$question['id']?>" <? if($question['image']!=null) { ?>  class="have-img" <? } else { ?>class="" <? } ?>>
    <? if($question['image']!=null) { ?>  
      <a class="wrap-img" href="<?=$question['url']?>" target="_blank">
            <img src="<?=$question['image']?>">
        </a>
            <? } ?>        <div class="content">
            <div class="author">
            
            
               
                
   
        <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$question['authorid']?>.html">
                    <img src="<?=$question['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="http://172.16.1.208/?u-<?=$question['authorid']?>.html"><?=$question['author']?><?=$question['actiondesc']?></a>
                
     
                
                <span class="time" data-shared-at="<?=$question['doing_time']?>"><?=$question['doing_time']?></span>
            </div>
            </div>
          
            
            <? if($question['action']==10) { ?>            <div class="follow-detail">
      <div class="info">
        <a class="avatar-collection" href="<?=$question['url']?>">
          <img src="<?=$question['category']['bigimage']?>" alt="180">
</a>       <? if($question['category']['follow']) { ?> <a class="btn btn-default following" id="attenttouser_<?=$question['category']['id']?>" onclick="attentto_cat(<?=$question['category']['id']?>)"><i class="fa fa-check"></i><span>已关注</span></a>
    <? } else { ?> <a class="btn btn-success follow" id="attenttouser_<?=$question['category']['id']?>" onclick="attentto_cat(<?=$question['category']['id']?>)"><i class="fa fa-plus"></i><span>关注</span></a>
    <? } ?>  
        <a class="title" href="<?=$question['url']?>"><?=$question['category']['name']?></a>
        <p>
          
          <?=$question['category']['questions']?> 个问题， <?=$question['category']['followers']?> 人关注
        </p>
      </div>
        <div class="signature">
        <?=$question['category']['miaosu']?>
        </div>
    </div>
           
            <? } ?>  
                  <? if($question['action']==11) { ?>            <div class="follow-detail">
      <div class="info">
        <a class="avatar" href="<?=$question['url']?>">
          <img src="<?=$question['spaceuser']['avatar']?>" alt="180">
</a>  

   <? if($question['spaceuser']['hasfollower']) { ?><a class="btn btn-default following" id="attenttouser_<?=$question['spaceuser']['uid']?>" onclick="attentto_user(<?=$question['spaceuser']['uid']?>)"><i class="fa fa-check"></i><span >已关注</span></a>
 <? } else { ?>    <a class="btn btn-success follow" id="attenttouser_<?=$question['spaceuser']['uid']?>" onclick="attentto_user(<?=$question['spaceuser']['uid']?>)"><i class="fa fa-plus"></i><span>关注</span></a>
      <? } ?>           
  
   
        <a class="title" href="<?=$question['url']?>"><?=$question['spaceuser']['username']?></a>
        <p>写了 <?=$question['spaceuser']['articles']?> 篇文章，被<?=$question['spaceuser']['followers']?> 人关注，获得了 <?=$question['spaceuser']['supports']?> 个赞</p>
      </div>
        <div class="signature">
         <?=$question['spaceuser']['signature']?> 
        </div>
    </div>   
    <? } ?>       
             <? if($question['action']!=10&&$question['action']!=11) { ?>              <a class="title" target="_blank"  href="<?=$question['url']?>"  ><?=$question['content']?></a>
             <p class="abstract">
            
                <? echo strip_tags($question['description']); ?>                
            </p>
             <? } ?>  
           
        </div>
    </li>

    
<? } } ?>
   


   
   

   


   
   

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
