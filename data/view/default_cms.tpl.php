<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>
                       <!-- 第三方cms调用 -->  

            
              <? $articlelist=$this->fromcache('articlelist'); ?>               
    <? if($articlelist) { ?>    <div class="split-line"></div>
       <div class="recommend">
   <div class="title"><span>资讯浏览</span></div>
   <ul class="list">



          
<? if(is_array($articlelist)) { foreach($articlelist as $index => $article) { ?>
                       <li > <a class="li-a-title" title="<?=$article['title']?>" target="_blank" href="<?=$article['href']?>"> <?=$article['title']?></a></li>
                       
<? } } ?>
      </ul>
    
    

    </div>
            <? } ?>