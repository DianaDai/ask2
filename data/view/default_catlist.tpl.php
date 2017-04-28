<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/category.css" /><? $adlist = $this->fromcache("adlist"); ?><div class="container collection index">
  <div class="row">
    <div class="col-xs-24 col-sm-16 main">
      <!-- 专题头部模块 -->
      <div class="main-top">
        <a class="avatar-collection" href="http://172.16.1.208/?cat-<?=$catmodel['id']?>.html">
  <img src="<?=$catmodel['bigimage']?>" alt="240">
</a>       <? if($is_followed) { ?> <a class="btn btn-default following" id="attenttouser_<?=$catmodel['id']?>" onclick="attentto_cat(<?=$catmodel['id']?>)"><i class="fa fa-check"></i><span>已关注</span></a>
    <? } else { ?> <a class="btn btn-success follow" id="attenttouser_<?=$catmodel['id']?>" onclick="attentto_cat(<?=$catmodel['id']?>)"><i class="fa fa-plus"></i><span>关注</span></a>
    <? } ?> 
 
            <div class="btn btn-hollow js-contribute-button" onclick="window.location.href='http://172.16.1.208/?user/addxinzhi.html';">
              投稿
            </div>

        <div class="title">
          <a class="name" href="http://172.16.1.208/?cat-<?=$catmodel['id']?>.html"> <?=$catmodel['name']?></a>
        </div>
        <div class="info">
          收录了<?=$rownum?>篇文章 ·<?=$catmodel['questions']?>个问题 · <?=$catmodel['followers']?>人关注
        </div>
      </div>
      <ul class="trigger-menu" data-pjax-container="#list-container">
      <li class="active"><a href="http://172.16.1.208/?cat-<?=$catmodel['id']?>.html">
      <i class="fa fa-sticky-note-o"></i> 全部文章</a>
      </li>
 
    <li >
      <a href="http://172.16.1.208/?c-<?=$catmodel['id']?>.html"><i class="fa fa-sticky-note-o"></i> 相关问题</a>
      </li>
      </ul>
      <div id="list-container">
        <!-- 文章列表模块 -->
<ul class="note-list" >
        <? if($topiclist==null) { ?>         <div class="no-comment"></div>
            <div class="text">
            沙发正空，不想<a>发表一点想法</a>咩~
          </div>
          <? } ?>              
<? if(is_array($topiclist)) { foreach($topiclist as $index => $topic) { ?>
    
                
    <li id="note-<?=$topic['id']?>" data-note-id="<?=$topic['id']?>" <? if($topic['image']!=null) { ?>  class="have-img" <? } else { ?>class="" <? } ?>>
    <? if($topic['image']!=null) { ?>  
      <a class="wrap-img"  href="http://172.16.1.208/?article-<?=$topic['id']?>.html"  target="_blank">
            <img src="<?=$topic['image']?>">
        </a>
            <? } ?>        <div class="content">
            <div class="author">
            
            
               
                
                   
    
        <a class="avatar" target="_blank" href="http://172.16.1.208/?u-<?=$topic['authorid']?>.html">
                    <img src="<?=$topic['avatar']?>" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="http://172.16.1.208/?u-<?=$topic['authorid']?>.html"><?=$topic['author']?></a>
                
      
        
                
                <span class="time" data-shared-at="<?=$topic['viewtime']?>"><?=$topic['viewtime']?></span>
            </div>
            </div>
            <a class="title" target="_blank"  href="http://172.16.1.208/?article-<?=$topic['id']?>.html"   ><?=$topic['title']?></a>
            <p class="abstract">
                <? echo strip_tags($topic['description']); ?>                
            </p>
            <div class="meta">
               
                <a target="_blank"  href="http://172.16.1.208/?article-<?=$topic['id']?>.html"  >
                    <i class="fa fa-eye"></i> <?=$topic['views']?>
                </a>        <a target="_blank"  href="http://172.16.1.208/?article-<?=$topic['id']?>.html#comments" >
                <i class="fa fa-comment-o"></i> <?=$topic['articles']?>
            </a>      <span><i class=" fa fa-heart-o"></i>  <?=$topic['attentions']?></span>
            </div>
        </div>
    </li>

    
<? } } ?>
 

</ul>

      </div>
    </div>
    <div class="col-xs-24 col-sm-7 col-sm-offset-1 aside">
        <p class="title">专题公告</p>
        <div class="description js-description">
         <? if($catmodel['miaosu']=='') { ?>         暂无专题描述
         <? } else { ?>         <?=$catmodel['miaosu']?>
         <? } ?>          
        </div>
             <? if($catmodel['followers']>0) { ?>             <div><div class="title">关注的人(<?=$catmodel['followers']?>)</div> <ul class="list collection-follower">
             
               
<? if(is_array($followerlist)) { foreach($followerlist as $fuser) { ?>
             <li><a href="http://172.16.1.208/?u-<?=$fuser['followerid']?>.html" target="_blank" class="avatar">
             <img src="<?=$fuser['avatar']?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?=$fuser['follower']?> · <?=$fuser['format_time']?> 关注"></a>
             </li>
             
<? } } ?>
        
             <a class="function-btn"><i class="fa fa-ellipsis-h"></i></a> <!----></ul>
     </div>
     <? } ?>       <div class="share">
        <span>分享至</span>
        <a href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','<?=$catmodel['bigimage']?>', '《<?=$catmodel['name']?>》（ 分享自 @Ask2问答平台创始人）','http://172.16.1.208/?cat-<?=$catmodel['id']?>.html','页面编码gb2312|utf-8默认gb2312'));"><i class="fa fa-weibo text-success"></i></a>
        <a data-action="weixin-share " class="share-weixin"><i class="fa fa-wechat text-danger"></i></a>
        
        <script type="text/javascript">document.write(['<a class="share-circle" data-toggle="tooltip"  target="_blank" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_blank"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));</script>
      </div>
      <div>
            <div class="recommend"><div class="title"><span>站长推荐文章</span></div>
   <ul class="list">

   <? $topiclist=$this->fromcache('hottopiclist'); ?>  
<? if(is_array($topiclist)) { foreach($topiclist as $nindex => $topic) { ?>
   <li>

  
   <a target="_blank" class="li-a-title" title=" <?=$topic['title']?>" href="http://172.16.1.208/?article-<?=$topic['id']?>.html" >
   <?=$topic['title']?>
   </a>
 
   </li>
 


  
<? } } ?>
      </ul>
       <a href="/recommendations/users?utm_source=desktop&amp;utm_medium=index-users" target="_blank" class="find-more">
    查看全部<i class="fa fa-angle-right mar-ly-1"></i></a></div>
     

     </div>

    </div>
  </div>
</div>
<!-- 微信分享 -->
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="http://172.16.1.208/?q-<?=$question['id']?>.html" class="qrcode" title="http://172.16.1.208/?q-<?=$question['id']?>.html"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script>
var qrurl="http://172.16.1.208/?cat-<?=$catmodel['id']?>.html";
$(function(){
//微信二维码生成
$('#qr_wxcode').qrcode(qrurl);
 //显示微信二维码
 $(".share-weixin").click(function(){

 $(".share-wechat").show();
 });
 //关闭微信二维码
 $(".close").click(function(){
 $(".share-wechat").hide();
 $(".pay-money").hide();
 });
});

</script>
<? include template(footer ); ?>
