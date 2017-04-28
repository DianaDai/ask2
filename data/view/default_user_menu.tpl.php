<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
      <div class="title">个人介绍</div>
  <div class="description">
    <div class="js-intro"><? if($user['signature']) { ?><?=$user['signature']?><? } else { ?>暂无介绍<? } ?>    </div>


  </div>
  <ul class="list user-dynamic">
    <li>
      <a href="http://172.16.1.208/?user/default.html">
        <i class="fa fa-home"></i> <span>我的首页</span>
</a>    </li>



  <li>
      <a href="http://172.16.1.208/?user/level.html">
        <i class="fa fa-sort-amount-desc"></i> <span>我的等级</span>
</a>    </li>

                      <li>
      <a href="http://172.16.1.208/?user/recommend.html">
        <i class="fa fa-newspaper-o"></i> <span>为我推荐</span>
</a>    </li>
    <li>
      <a href="http://172.16.1.208/?user/ask/1.html">
        <i class="fa fa-question-circle-o"></i> <span>我的提问</span>
</a>    </li>

   <li>
      <a href="http://172.16.1.208/?user/answer/1.html">
        <i class="fa fa-commenting-o"></i> <span>我的回答</span>
</a>    </li>

   <li>
      <a href="http://172.16.1.208/?ut-<?=$user['uid']?>.html">
        <i class=" fa fa-rss-square"></i> <span>我的文章</span>
</a>    </li>
<li>
      <a href="http://172.16.1.208/?user/attention/question.html">
        <i class="fa fa-star-o"></i> <span>我关注的问题</span>
</a>    </li>
<li>
      <a href="http://172.16.1.208/?user/attention.html">
        <i class="fa fa-user-circle"></i> <span>我关注的用户</span>
</a>    </li>
  </ul>
