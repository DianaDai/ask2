<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/activelist.css" />
<div class="container recommend">
  <img class="recommend-banner" src="<?=SITE_URL?>static/css/bianping/images/activeuser.png" alt="Recommend author">
  <div class="row">
      


      

    
<? if(is_array($userlist)) { foreach($userlist as $activeuser) { ?>
              
         
                <div class="col-xs-8">
  <div class="wrap">
    <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$activeuser['uid']?>.html">
      <img src="<?=$activeuser['avatar']?>" alt="180">
</a>    <h4>
      <a target="_blank" href="http://172.16.1.208/?u-<?=$activeuser['uid']?>.html"><?=$activeuser['username']?></a>
      
    </h4>
    <p class="description"><?=$activeuser['signature']?></p><? if($activeuser['hasfollower']==1) { ?>      <a class="btn btn-default following" id="attenttouser_<?=$activeuser['uid']?>" onclick="attentto_user(<?=$activeuser['uid']?>)"><i class="fa fa-check"></i><span>已关注</span></a><? } else { ?>      <a class="btn btn-success follow" id="attenttouser_<?=$activeuser['uid']?>" onclick="attentto_user(<?=$activeuser['uid']?>)"><i class="fa fa-check"></i><span>关注</span></a><? } ?>    <hr>
    <div class="meta ">战绩</div>
    <div class="recent-update ">
       
        <div class="news"><span>粉丝  <?=$activeuser['followers']?>个</span>.<span>文章  <?=$activeuser['articles']?>篇</span>.<span>问题  <?=$activeuser['questions']?>个</span></div>
     
       
    </div>
  </div>
</div>
                
<? } } ?>
      


  </div>

    <div class="pages"><?=$departstr?></div>   
</div>
<? include template('footer'); ?>
