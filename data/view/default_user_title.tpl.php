<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
  <div class="main-top">
  <a class="avatar" href="http://172.16.1.208/?user/default.html">
    <img src="<?=$user['avatar']?>" alt="240">
</a>
    <a class="btn btn-success  follow" href="http://172.16.1.208/?user/profile.html"><i class="fa fa-gear"></i><span>个人设置</span></a>
  

  <div class="title">
    <a class="name" href="/u/yZq3ZV"><?=$user['username']?></a>
  </div>
  <div class="info">
    <ul>
      <li>
        <div class="meta-block">
          <a href="http://172.16.1.208/?user/answer/1.html">
            <p><?=$user['answers']?></p>
            回答 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>
      <li>
        <div class="meta-block">
          <a href="http://172.16.1.208/?user/ask/1.html">
            <p><?=$user['questions']?></p>
            提问 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>
        <li>
        <div class="meta-block">
         <a href="http://172.16.1.208/?ut-<?=$user['uid']?>.html">
            <p><?=$user['articles']?></p>
            文章 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>
      <li>
        <div class="meta-block">
         
            <p><?=$user['followers']?></p>
            粉丝 
       </div>
      </li>
      <li>
        <div class="meta-block">
         
            <p><?=$user['attentions']?></p>
            关注用户
       </div>
      </li>
      <li>
        <div class="meta-block">
          <p><?=$user['supports']?></p>
          <div>赞同</div>
        </div>
      </li>
    </ul>
  </div>
</div>
 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li <? if($regular=="user/space") { ?> class="active" <? } ?>><a href="http://172.16.1.208/?user/default.html">
 <i class="fa fa-clipboard"></i> 动态</a>
 </li>
 <li <? if($regular=="user/space_answer") { ?> class="active" <? } ?>><a href="http://172.16.1.208/?user/answer/1.html"><i class="fa fa-commenting-o"></i> 回答</a></li>
 <li <? if($regular=="user/space_ask") { ?> class="active" <? } ?>><a href="http://172.16.1.208/?user/ask/1.html">
 <i class="fa fa-question-circle-o"></i> 提问</a>
 </li>
 <li <? if($regular=="topic/userxinzhi") { ?> class="active" <? } ?>><a href="http://172.16.1.208/?ut-<?=$user['uid']?>.html"><i class="fa fa-rss-square"></i> 文章</a></li>
  <li <? if($regular=="user/follower") { ?> class="active" <? } ?>><a href="http://172.16.1.208/?user/follower.html"><i class="fa fa-user-circle-o"></i> 粉丝</a></li>
 <li <? if($regular=="user/attention") { ?> class="active" <? } ?>>
  <? if($regular=="user/attention"&&$attentiontype!='question') { ?> 
 <a href="http://172.16.1.208/?user/attention.html"  >
 <i class="fa fa-user-circle"></i>

  关注用户
   
  </a>
    <? } else { ?>   <a href="http://172.16.1.208/?user/attention/question.html"  >
 <i class="fa fa-user-circle"></i>

  关注问题 
   
  </a>
  <? } ?>  
  </li>
 
 </ul>
