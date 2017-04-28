<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<section class="ui-container">
 <div class="note-list">
 <div class="top-title">动态</div> 
 <ul class="u-list">
     
<? if(is_array($nosolvelist)) { foreach($nosolvelist as $index => $question) { ?>
                
    <li id="note-<?=$question['id']?>" data-note-id="<?=$question['id']?>" <? if($question['image']!=null) { ?>  class="have-img" <? } else { ?>class="" <? } ?>>
    <? if($question['image']!=null) { ?>  
      <a class="wrap-img" <? if($question['articleclassid']!=null) { ?> href="http:///?article-<?=$question['id']?>.html"  <? } else { ?>  href="http:///?q-<?=$question['id']?>.html" <? } ?> target="_blank">
            <img src="<?=$question['image']?>">
        </a>
            <? } ?>        <div class="content">
            <div class="author">
            
            
               
                
                   
        <? if($question['hidden']==1) { ?>  
          <a class="avatar"  href="javascript:void(0)">
                    <img src="<?=$question['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>
                
                
        <? } else { ?>        <a class="avatar" target="_blank" href="http:///?u-<?=$question['authorid']?>.html">
                    <img src="<?=$question['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="http:///?u-<?=$question['authorid']?>.html"><?=$question['author']?></a>
                
        <? } ?>        
                <? if($question['askuid']>0) { ?>                      对<span class="text-danger"><?=$question['askuser']['username']?></span>
                  <? } ?>        <? if($question['articleclassid']!=null) { ?>                发布了一篇文章
          <? } else { ?>  
          提了一个问题
            <? } ?>     
               
               
            </div>
            </div>
            <a class="title" target="_blank"  <? if($question['articleclassid']!=null) { ?> href="http:///?article-<?=$question['id']?>.html"  <? } else { ?>  href="http:///?q-<?=$question['id']?>.html" <? } ?> ><?=$question['title']?></a>
          
           <div class="meta">
           
                        <? if($question['askuid']>0) { ?>                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="邀请<?=$question['askuser']['username']?>回答"  class="icon_zise"><i class="fa fa-twitch mar-r-03"></i>邀请回答</span>
                  <? } ?>           </div>
            <div class="meta">
              
                <a target="_blank" <? if($question['articleclassid']!=null) { ?> href="http:///?article-<?=$question['id']?>.html"  <? } else { ?>  href="http:///?q-<?=$question['id']?>.html" <? } ?>>
                    <i class="fa fa-eye"></i> <?=$question['views']?>
                </a>        <a target="_blank" <? if($question['articleclassid']!=null) { ?> href="http:///?article-<?=$question['id']?>.html#comments"  <? } else { ?>  href="http:///?q-<?=$question['id']?>.html#comments" <? } ?>>
                <i class="fa fa-comment-o"></i> <?=$question['answers']?>
            </a>      <span><i class=" fa fa-heart-o"></i>  <?=$question['attentions']?></span>
             <span class="time" data-shared-at="<?=$question['format_time']?>"><?=$question['format_time']?></span>
              
            </div>
        </div>
    </li>

    
<? } } ?>
              </ul> </div>
</section>
<? include template('footer'); ?>
