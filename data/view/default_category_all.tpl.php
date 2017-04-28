<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/topic.css" />
<div class="container recommend">
  <img class="recommend-banner" src="<?=SITE_URL?>static/images/tuijian.png" alt="Recommend collection">
  <ul class="trigger-menu" data-pjax-container="#list-container">
  <li <? if($status=='hot') { ?> class="active"<? } ?> >
  <a data-order-by="recommend" href="http://172.16.1.208/?category/viewtopic/hot.html">
  <i class="fa fa-book"></i> 推荐</a>
  </li>
  <li <? if($status=='new') { ?> class="active"<? } ?> ><a data-order-by="hot" href="http://172.16.1.208/?category/viewtopic/new.html">
  <i class="fa fa-hacker-news"></i> 最新</a>
  </li>
 
  </li>
  </ul>

  <div class="row" id="list-container">
  
    
<? if(is_array($catlist)) { foreach($catlist as $category1) { ?>
            
                
            
              <div class="col-xs-8">
  <div class="collection-wrap">
    <a class="avatar-collection" target="_blank" href="http://172.16.1.208/?c-<?=$category1['id']?>.html">
      <img src="<?=$category1['bigimage']?>" alt="180">
</a>    <h4><a target="_blank" href="http://172.16.1.208/?c-<?=$category1['id']?>.html"><?=$category1['name']?></a></h4>
    <p class="collection-description">
<?=$category1['miaosu']?>
</p><? if($category1['follow']) { ?> <a class="btn btn-default following" id="attenttouser_<?=$category1['id']?>" onclick="attentto_cat(<?=$category1['id']?>)"><i class="fa fa-check"></i><span>已关注</span></a>
    <? } else { ?> <a class="btn btn-success follow" id="attenttouser_<?=$category1['id']?>" onclick="attentto_cat(<?=$category1['id']?>)"><i class="fa fa-plus"></i><span>关注</span></a>
    <? } ?>  

  
    <hr>
    <div class="count"><a target="_blank" href="http://172.16.1.208/?c-<?=$category1['id']?>.html"><?=$category1['questions']?>个问题</a>·<?=$category1['followers']?>人关注</div>
  </div>
</div>

                
<? } } ?>
 
                



     
  </div>

    <div class="pages"><?=$departstr?></div>
</div>
<? include template('footer'); ?>
