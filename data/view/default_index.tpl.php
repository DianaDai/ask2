<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
﻿
<? include template('header'); $adlist = $this->fromcache("adlist"); ?>   <? if(0!=$user['uid']) { ?>     <? if($setting['register_on']==1&&$user['active']!=1) { ?><div class="alert alert-success-inverse text-center">
 <button type="button" class="close text-whtie" data-dismiss="alert" aria-hidden="true">×</button>
<p>
您的邮箱还没有激活<a href="http://172.16.1.208/?user/editemail.html" class="mar-ly-1 ">点击激活邮件</a>
</p>
</div>
   <? } ?>   <? } ?><div class="container index slideInDown animated">

    <div class="row">
    <div class="col-xs-16 main  ">
    <div class="recommend-collection">
            
        
        
         <? $categorylist=$this->fromcache('categorylist'); ?>                
<? if(is_array($categorylist)) { foreach($categorylist as $category1) { ?>
            
                
                   <a class="collection" target="_blank" href="http://172.16.1.208/?c-<?=$category1['id']?>.html">
            <img src="<?=$category1['image']?>" alt="195" style="height:32px;width:32px;">
            <div class="name"><?=$category1['name']?></div>
        </a>   
                
<? } } ?>
 
        
        
               <a class="more-hot-collection" target="_blank" href="http://172.16.1.208/?category/viewtopic/hot.html">
        更多热门专题 <i class="fa fa-angle-right mar-ly-1"></i>
    </a>        </div>
    <div class="split-line"></div>
    <div id="list-container">
    <!-- 文章列表模块 -->
    <ul class="note-list" >
    
                 
                
<? if(is_array($nosolvelist)) { foreach($nosolvelist as $index => $question) { ?>
                
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
                <? if($question['askuid']>0) { ?>                      对<span class="text-danger"><?=$question['askuser']['username']?></span>
                  <? } ?>        <? if($question['articleclassid']!=null) { ?>                发布了一篇文章
          <? } else { ?>  
          提了一个问题
            <? } ?>     
                <span class="ico_point">.</span>
                <span class="time" data-shared-at="<?=$question['format_time']?>"><?=$question['format_time']?></span>
            
            
                        <? if($question['askuid']>0) { ?>                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="邀请<?=$question['askuser']['username']?>回答"  class="icon_zise"><i class="fa fa-twitch mar-r-03"></i>邀请回答</span>
                  <? } ?>            </div>
            </div>
            <a class="title" target="_blank"  <? if($question['articleclassid']!=null) { ?> href="http://172.16.1.208/?article-<?=$question['id']?>.html"  <? } else { ?>  href="http://172.16.1.208/?q-<?=$question['id']?>.html" <? } ?> ><?=$question['title']?></a>
            <p class="abstract">
                <? echo strip_tags($question['description']); ?>                
            </p>
            <div class="meta">
                <a class="collection-tag" target="_blank" <? if($question['articleclassid']!=null) { ?> href="http://172.16.1.208/?cat-<?=$question['articleclassid']?>.html <? } else { ?>  href="http://172.16.1.208/?c-<?=$question['cid']?>.html <? } ?> "><?=$question['category_name']?></a>
                <a target="_blank" <? if($question['articleclassid']!=null) { ?> href="http://172.16.1.208/?article-<?=$question['id']?>.html"  <? } else { ?>  href="http://172.16.1.208/?q-<?=$question['id']?>.html" <? } ?>>
                    <i class="fa fa-eye"></i> <?=$question['views']?>
                </a>        <a target="_blank" <? if($question['articleclassid']!=null) { ?> href="http://172.16.1.208/?article-<?=$question['id']?>.html#comments"  <? } else { ?>  href="http://172.16.1.208/?q-<?=$question['id']?>.html#comments" <? } ?>>
                <i class="fa fa-comment-o"></i> <?=$question['answers']?>
            </a>      <span><i class=" fa fa-heart-o"></i>  <?=$question['attentions']?></span>
            </div>
        </div>
    </li>

    
<? } } ?>
    </ul>
    <!-- 文章列表模块 -->
    </div>
    </div>

    <!--右边栏目-->
    <div class="col-xs-7    col-xs-offset-1 aside rightpanel">


         
<? include template('sider_author'); ?>
            
            
<? include template('sider_hotarticle'); ?>
                  
<? include template('cms'); ?>
    </div>





        </div>


    </div>
<? include template('footer'); ?>
