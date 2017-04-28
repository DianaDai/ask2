<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); $adlist = $this->fromcache("adlist"); ?><!--内容部分--->

<div class="container index  ">

<div class="row">
<div class="col-xs-16 main">


    <div class="recommend-collection">
           公告列表
          </div>
    <div class="split-line"></div>


 <div id="list-container">
     <? if($notelist==null) { ?>     <div class="text"><span>目前还没发布公告</span> </div>
        <? } ?>    <!-- 文章列表模块 -->
    <ul class="note-list" >
    
                 
             
<? if(is_array($notelist)) { foreach($notelist as $index => $note) { ?>
                
   <li id="note-<?=$note['id']?>" data-note-id="<?=$note['id']?>" <? if($note['image']!=null) { ?>  class="have-img" <? } else { ?>class="" <? } ?>>
    <? if($note['image']!=null) { ?>  
      <a class="wrap-img"  <? if($note['url']) { ?> href="<?=$note['url']?>"  <? } else { ?>  href="http://172.16.1.208/?note/view/<?=$note['id']?>.html" <? } ?>  target="_blank">
            <img src="<?=$note['image']?>">
        </a>
            <? } ?>        <div class="content">
            <div class="author">
            
            
               
                
                   
      
        <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$note['authorid']?>.html">
                    <img src="<?=$note['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="http://172.16.1.208/?u-<?=$note['authorid']?>.html"><?=$note['author']?></a>
                
   
        
                
                <span class="time" data-shared-at="<?=$note['format_time']?>"><?=$note['format_time']?></span>
            </div>
            </div>
            <a class="title" target="_blank"   <? if($note['url']) { ?> href="<?=$note['url']?>"  <? } else { ?>  href="http://172.16.1.208/?note/view/<?=$note['id']?>.html" <? } ?> ><?=$note['title']?></a>
            <p class="abstract">
                <?=$note['content']?>
                
            </p>
            <div class="meta">

                <a target="_blank"  <? if($note['url']) { ?> href="<?=$note['url']?>"  <? } else { ?>  href="http://172.16.1.208/?note/view/<?=$note['id']?>.html" <? } ?> >
                    <i class="fa fa-eye"></i> <?=$note['views']?>
                </a>        <a target="_blank"   <? if($note['url']) { ?> href="<?=$note['url']?>"  <? } else { ?>  href="http://172.16.1.208/?note/view/<?=$note['id']?>.html#comments" <? } ?> >
                <i class="fa fa-comment-o"></i> <?=$note['comments']?>
            </a>     
            </div>
        </div>
    </li>
  
    
<? } } ?>
    </ul>
    <!-- 文章列表模块 -->
    </div>
    
    

    
                     <div class="pages"><?=$departstr?></div>
                     
                     
                      <!--广告位1-->
        <? if((isset($adlist['common']['left1']) && trim($adlist['common']['left1']))) { ?>        <div><?=$adlist['common']['left1']?></div>
        <? } ?></div>

<div class="col-xs-7 col-xs-offset-1 aside rightpanel">
  <!-- 热门文章排行 -->
    
<? include template('sider_hotarticle'); ?>
        
            <!--广告位2-->
              <div class="mar-t-1">
        <? if((isset($adlist['common']['right1']) && trim($adlist['common']['right1']))) { ?>        <div style="margin-top:5px;"><?=$adlist['common']['right1']?></div>
         </div>  
        <? } ?>         
            
</div>

</div>

</div>


<!--内容部分结束--->
<? include template('footer'); ?>
