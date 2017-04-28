<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
    <div class="split-line"></div>
       <div class="recommend">
   <div class="title"><span>推荐文章</span></div>
   <ul class="list">


  <? $topiclist=$this->fromcache('hottopiclist'); ?> 
        
<? if(is_array($topiclist)) { foreach($topiclist as $nindex => $topic) { ?>
                       <li ><a  class="li-a-title" target="_blank" href="http://172.16.1.208/?article-<?=$topic['id']?>.html" title="<?=$topic['title']?>"><?=$topic['title']?></a></li>
                       
<? } } ?>
      </ul>
       <a href="http://172.16.1.208/?topic/hotlist.html" target="_blank" class="find-more">
    查看全部<i class="fa fa-angle-right mar-ly-1"></i>
    </a>
    

    </div>