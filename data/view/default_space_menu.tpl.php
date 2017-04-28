<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
      <div class="title">个人介绍</div>
  <div class="description">
    <div class="js-intro"><? if($member['signature']) { ?><?=$member['signature']?><? } else { ?>暂无介绍<? } ?>    </div>


  </div>
  <ul class="list user-dynamic">
    <li>
      <a href="http://172.16.1.208/?u-<?=$member['uid']?>.html">
        <i class="fa fa-home"></i> <span>TA的首页</span>
</a>    </li>
    <li>
      <a href="http://172.16.1.208/?uask-<?=$member['uid']?>/1.html">
        <i class="fa fa-question-circle-o"></i> <span>TA的提问</span>
</a>    </li>

   <li>
      <a href="http://172.16.1.208/?ua-<?=$member['uid']?>.html">
        <i class="fa fa-commenting-o"></i> <span>TA的回答</span>
</a>    </li>

   <li>
      <a href="http://172.16.1.208/?ut-<?=$member['uid']?>.html">
        <i class="fa fa-sticky-note"></i> <span>TA的文章</span>
</a>    </li>

  </ul>
