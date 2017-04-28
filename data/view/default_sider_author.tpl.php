<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
  <div class="recommend"><div class="title"><span>推荐作者</span>
   
   </div> 
        <ul class="list">
     
       
<? if(is_array($userarticle)) { foreach($userarticle as $index => $uarticle) { ?>
        <li>
        <a href="http://172.16.1.208/?u-<?=$uarticle['uid']?>.html" target="_blank" class="avatar">
        <img src="<?=$uarticle['avatar']?>">
        </a> 
        
          <? if($uarticle['hasfollower']) { ?>   <a class="following" id="attenttouser_<?=$uarticle['uid']?>" onclick="attentto_user_index(<?=$uarticle['uid']?>)"><i class="fa fa-check"></i><span>已关注</span></a>
  <? } else { ?>    <a class="follow" id="attenttouser_<?=$uarticle['uid']?>" onclick="attentto_user_index(<?=$uarticle['uid']?>)"><i class="fa fa-plus"></i>关注
        </a> 

  <? } ?>  
      
        <a href="http://172.16.1.208/?u-<?=$uarticle['uid']?>.html" target="_blank" class="name">
            <?=$uarticle['username']?>
        </a>
         <p>
             <?=$uarticle['followers']?>关注· <?=$uarticle['answers']?>回答 · 写了<?=$uarticle['num']?>文章 
        </p></li>
         
<? } } ?>
        </ul>
         <a href="http://172.16.1.208/?user/activelist.html" target="_blank" class="find-more">
            查看全部<i class="fa fa-angle-right mar-ly-1"></i></a></div>