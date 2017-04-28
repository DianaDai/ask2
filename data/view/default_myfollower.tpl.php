<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/space.css" />
<div class="container person">
  <div class="row">
    <div class="col-xs-16 main">
          <!-- 用户title部分导航 -->
              
<? include template('user_title'); ?>
     
      <div id="list-container">
        <!-- 关注用户 -->
<ul class="user-list">
   
<? if(is_array($followerlist)) { foreach($followerlist as $follower) { ?>
                     
  <li>
  <a class="avatar" href="http://172.16.1.208/?u-<?=$follower['followerid']?>.html">
    <img src="<?=$follower['avatar']?>" alt="180">
</a>  <div class="info">
    <a class="name" href="http://172.16.1.208/?u-<?=$follower['followerid']?>.html"><?=$follower['follower']?></a>
    <div class="meta">
      <span>问题 <?=$follower['info']['questions']?></span><span>粉丝<?=$follower['info']['followers']?></span><span>文章 <?=$follower['info']['articles']?></span><span>回答 <?=$follower['info']['answers']?></span>
    </div>
    <div class="meta">
     <?=$follower['info']['signature']?>
    </div>
  </div>
  <? if($follower['hasfollower']) { ?>   <a class="btn btn-default following" id="attenttouser_<?=$follower['followerid']?>" onclick="attentto_user(<?=$follower['followerid']?>)"><i class="fa fa-check"></i><span>已关注</span></a>
  <? } else { ?>   <a class="btn btn-success follow" id="attenttouser_<?=$follower['followerid']?>" onclick="attentto_user(<?=$follower['followerid']?>)"><i class="fa fa-plus"></i><span>关注</span></a>
  <? } ?>   
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
