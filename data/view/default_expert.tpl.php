<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/activelist.css" />
<div class="container recommend">
  <img class="recommend-banner" src="<?=SITE_URL?>static/css/bianping/images/activeexpert.png" alt="Recommend author">
  <div class="row">
      


      

        
<? if(is_array($expertlist)) { foreach($expertlist as $expert) { ?>
              
         
                <div class="col-xs-8">
  <div class="wrap expert-list">
    <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$expert['uid']?>.html">
      <img src="<?=$expert['avatar']?>" alt="180">
</a>    <h4>
      <a target="_blank" href="http://172.16.1.208/?u-<?=$expert['uid']?>.html"><?=$expert['username']?></a>
      
    </h4>
    <p class="description"><?=$expert['signature']?></p><? if($expert['hasfollower']==1) { ?>      <a class="btn btn-default following" id="attenttouser_<?=$expert['uid']?>" onclick="attentto_user(<?=$expert['uid']?>)"><i class="fa fa-check"></i><span>已关注</span></a><? } else { ?>      <a class="btn btn-success follow" id="attenttouser_<?=$expert['uid']?>" onclick="attentto_user(<?=$expert['uid']?>)"><i class="fa fa-check"></i><span>关注</span></a><? } ?>  <? if($expert['mypay']>0) { ?>   <a data-placement="bottom" data-toggle="tooltip" data-original-title="付费<?=$expert['mypay']?>元咨询" class="btn  btn-ask-pay" <? if($user['uid']==0) { ?> href="javascript:login()" <? } else { ?> href="http://172.16.1.208/?question/add/<?=$expert['uid']?>.html" <? } ?>>                        
                                            <i class="fa fa-twitch"></i><span>付费咨询</span>        
 </a>
    <? } else { ?>     <a class="btn  btn-ask" <? if($user['uid']==0) { ?> href="javascript:login()" <? } else { ?> href="http://172.16.1.208/?question/add/<?=$expert['uid']?>.html" <? } ?>>                        
                                            <i class="fa fa-twitch"></i><span>免费咨询</span>
              
 </a>
      <? } ?>  <hr>
   <div class="meta ">擅长分类</div>
    <div class="recent-update-expert ">
           
<? if(is_array($expert['category'])) { foreach($expert['category'] as $category) { ?>
                        <a target="_blank" href="http://172.16.1.208/?c-<?=$category['cid']?>.html">
                       
                        <label class="label"> <?=$category['categoryname']?></label>
                        </a>
                        
<? } } ?>
     
    </div>
    <hr>
    <div class="meta ">精选解答</div>
    <div class="recent-update ">
        
<? if(is_array($expert['bestanswer'])) { foreach($expert['bestanswer'] as $index => $question) { ?>
                          <? if($index<=2) { ?>                          <a class="new new-question" target="_blank" title="<?=$question['title']?>" href="http://172.16.1.208/?q-<?=$question['qid']?>.html"><?=$question['title']?></a>
                          <? } ?>                        
<? } } ?>
     
    </div>
  </div>
</div>
                
<? } } ?>
      


  </div>

    <div class="pages"><?=$departstr?></div>   
</div>
<? include template('footer'); ?>
