<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/detail.css" />
   <script src="<?=SITE_URL?>static/js/jquery.qrcode.min.js" type="text/javascript"></script> 
<div class="container index">
<div class="row">
   <div class="col-xs-16 main">
   <div class="note">
    <div class="post">
        <div class="article">
            <h1 class="title"> <?=$topicone['title']?> </h1>

            <!-- 作者区域 -->
            <div class="author">
                <a class="avatar" href="http://172.16.1.208/?u-<?=$member['uid']?>.html">
                    <img src="<?=$member['avatar']?>" alt="144">
                </a>          <div class="info">
                <span class="tag">作者</span>
                <span class="name"><a href="http://172.16.1.208/?u-<?=$member['uid']?>.html"><?=$topicone['author']?></a></span>
                <!-- 关注用户按钮 -->
                             <? if($is_followedauthor) { ?>  <a class="btn btn-default following" id="attenttouser_<?=$member['uid']?>" onclick="attentto_user(<?=$member['uid']?>)"><i class="fa fa-check"></i><span>已关注</span></a>
 
  <? } else { ?>  
         <a class="btn btn-success follow" id="attenttouser_<?=$member['uid']?>" onclick="attentto_user(<?=$member['uid']?>)"><i class="fa fa-plus"></i><span>关注</span></a>

  <? } ?>  
                <!-- 文章数据信息 -->
                <div class="meta">
                    <!-- 如果文章更新时间大于发布时间，那么使用 tooltip 显示更新时间 -->
                    <span class="publish-time" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="最后编辑于 <?=$question['format_time']?>"><?=$question['viewtime']?></span>
                    <span class="wordage">字数 <?=$topicone['artlen']?></span>
                    <span class="views-count">阅读 <?=$topicone['views']?></span><span class="comments-count">评论 <?=$topicone['articles']?></span><span class="likes-count">喜欢 <?=$topicone['likes']?></span></div>
            </div>
            <? if($user['grouptype']==1||$user['uid']==$member['uid']) { ?>                <!-- 如果是当前作者，加入编辑按钮 -->
                <a href="javascript:void(0)"  data-toggle="dropdown" class="edit dropdown-toggle">操作 <i class="fa fa-angle-down mar-lr-05"></i> </a>
                 <ul class="dropdown-menu" role="menu">
                <? if($user['grouptype']==1) { ?>                       <li>
                  
                  
                    <a href="http://172.16.1.208/?topic/pushhot/<?=$topicone['id']?>.html" data-toggle="tooltip" data-html="true" data-original-title="被推荐文章将会在首页展示">
                        <i class="fa fa-star-o"></i><span>推荐文章</span>
                    </a>        
                      </li>
                      <? } ?>                           <li>
                  
                    <a href="http://172.16.1.208/?user/editxinzhi/<?=$topicone['id']?>.html">
                        <i class="fa fa-edit"></i><span>编辑文章</span>
                    </a>        
                      </li>
                        <li>
                  
                    <a href="http://172.16.1.208/?user/deletexinzhi/<?=$topicone['id']?>.html">
                        <i class="fa fa-trash-o"></i><span>删除文章</span>
                    </a>        
                      </li>
                      
                             </ul>
                               <? } ?>   
            </div>
            <!-- -->

            <!-- 文章内容 -->
            <div class="show-content art-content">
            
                <p>
                <? echo replacewords($topicone['describtion']);     ?>     
                </p>
            </div>
            <!--  -->

            <div class="show-foot">
                <a class="notebook" href="http://172.16.1.208/?cat-<?=$cat_model['id']?>.html" data-toggle="tooltip" data-html="true" data-original-title="问题归属分类">
                    <i class="fa fa-file-text"></i> <span><?=$cat_model['name']?></span>
                </a>          <div class="copyright" data-toggle="tooltip" data-html="true" data-original-title="转载请联系作者获得授权，并标注“文章作者”。">
                © 著作权归作者所有
            </div>
                <div class="modal-wrap" data-report-note="">
                    <a id="report-modal">举报问题</a>
                </div>
            </div>
        </div>

    <div class="meta-bottom">
      <div class="like"><div class="btn like-group"><div class="btn-like"><a href="http://172.16.1.208/?favorite/topicadd/<?=$topicone['id']?>.html"><i class="fa fa-heart-o"></i>喜欢</a></div> <div class="modal-wrap"><a> <?=$topicone['likes']?></a></div></div> <!----></div>
      <div class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','<?=$topicone['image']?>', '推荐 <?=$topicone['author']?> 的文章《<?=$topicone['title']?>》（ 分享自 @Ask2问答平台创始人）','http://172.16.1.208/?article-<?=$topicone['id']?>.html','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>
         
           
         
  
  <script type="text/javascript">document.write(['<a class="share-circle" data-toggle="tooltip"  target="_blank" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_blank"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));</script>
    
      </div>
    </div>

      

        <div><div id="comment-list" class="comment-list"><div>
            <? if($user['uid']!=0) { ?> <form class="new-comment">
  <input type="hidden" id="artitle" value="<?=$topicone['title']?>" />
    <input type="hidden" id="artid" value="<?=$topicone['id']?>" />
 <a class="avatar">
 <img src="<?=$user['avatar']?>">
 </a> 
 <textarea onkeydown="return topickeydownlistener(event)"  placeholder="写下你的评论..." class="comment-area"></textarea> 
 <div class="write-function-block"> <div class="hint">Ctrl+Return 发表</div> 
 <a class="btn btn-send btn-cm-submit" name="comments" id="comments">发送</a> <a class="cancel">取消</a></div>
 </form>
   <? } else { ?>  <form class="new-comment"><a class="avatar"><img src="<?=$user['avatar']?>"></a> <div class="sign-container"><a href="http://172.16.1.208/?user/login.html" class="btn btn-sign">登录</a> <span>后发表评论</span></div></form>
 
            <? } ?>        
        </div> 
        <div id="normal-comment-list" class="normal-comment-list">
        <div>
        <div>
        <div class="top">
        <span><?=$topicone['articles']?>条评论</span>
         <a class="author-only">只看作者</a>
          <a class="close-btn" style="display: none;">关闭评论</a>
           <div class="pull-right">
           <a class="active">按喜欢排序</a>
           <a class="">按时间正序</a>
           <a class="">按时间倒序</a>
           </div>
           </div>
           </div> 
           <!----> <!---->
            <? if($commentlist==null) { ?>   
            <div class="no-comment"></div>
    
               <div class="text">
           还没有人评论过~
          </div>
      
              <? } ?>   
          
<? if(is_array($commentlist)) { foreach($commentlist as $index => $comment) { ?>
       
            <div id="comment-<?=$comment['id']?>" class="comment">
            <div>
            <div class="author">
            <a href="http://172.16.1.208/?u-<?=$comment['authorid']?>.html" target="_blank" class="avatar">
            <img src="<?=$comment['avatar']?>">
            </a> 
            <div class="info">
            <a href="http://172.16.1.208/?u-<?=$comment['authorid']?>.html" target="_blank" class="name"><?=$comment['author']?></a> 
            <!---->
             <div class="meta">
             <span><? echo ++$index; ?>楼 · <?=$comment['time']?></span>
             </div>
             </div>
             </div> 
             <div class="comment-wrap">
             <p>
              <?=$comment['content']?>
             </p> 
          
                </div>
                </div> 
                <div class="sub-comment-list hide"><!----> <!----></div>
                </div>
 
<? } } ?>
   
  <div class="pages" ><?=$departstr?></div>   
             <div class="comments-placeholder" style="display: none;"><div class="author"><div class="avatar"></div> <div class="info"><div class="name"></div> <div class="meta"></div></div></div> <div class="text"></div> <div class="text animation-delay"></div> <div class="tool-group"><i class="iconfont ic-zan-active"></i><div class="zan"></div> <i class="iconfont ic-list-comments"></i><div class="zan"></div></div></div></div></div> <!----> <!---->
             </div>
             </div>
    </div>

    <div class="side-tool"><ul><li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="回到顶部" >
    <a href="#" class="function-button"><i class="fa fa-angle-up"></i></a>
    </li>
    
      <li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="收藏文章"><a href="http://172.16.1.208/?favorite/topicadd/<?=$topicone['id']?>.html" class="function-button"><i class="fa fa-star"></i></a></li>
      </ul></div>
</div>
   </div>
   <div class="col-xs-7 col-xs-offset-1 aside rightpanel">
   <div class="recommend">
   <div class="title"><span>Ta的文章</span></div>
   <ul class="list">



 
         
<? if(is_array($topiclist1)) { foreach($topiclist1 as $index => $topic) { ?>
                       <li ><a  class="li-a-title" target="_blank" href="http://172.16.1.208/?article-<?=$topic['id']?>.html" title="<?=$topic['title']?>"><?=$topic['title']?></a></li>
                       
<? } } ?>
      </ul>
       <a href="http://172.16.1.208/?ut-<?=$member['uid']?>.html" target="_blank" class="find-more">
    查看全部<i class="fa fa-angle-right mar-ly-1"></i>
    </a>
    

    </div>
  

            
<? include template('sider_hotarticle'); ?>
          <? if($topicone['likes']>0) { ?>             <div><div class="title">收藏的人(<?=$topicone['likes']?>)</div> <ul class="list collection-follower">
             
               
<? if(is_array($followerlist)) { foreach($followerlist as $fuser) { ?>
             <li><a href="http://172.16.1.208/?u-<?=$fuser['followerid']?>.html" target="_blank" class="avatar">
             <img src="<?=$fuser['avatar']?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?=$fuser['username']?> · <?=$fuser['format_time']?> 关注"></a>
             </li>
             
<? } } ?>
        
             <a class="function-btn"><i class="fa fa-ellipsis-h"></i></a> <!----></ul>
     </div>
     <? } ?>   </div>
</div>
</div>
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="http://172.16.1.208/?article-<?=$topicone['id']?>.html" class="qrcode" title="http://172.16.1.208/?article-<?=$topicone['id']?>.html"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script src="<?=SITE_URL?>static/ckplayer/ckplayer.js" type="text/javascript"></script>
<script src="<?=SITE_URL?>static/ckplayer/video.js" type="text/javascript"></script>
<script>
if(typeof($(".art-content").find("img").attr("data-original"))!="undefined"){
var imgurl=$(".art-content").find("img").attr("data-original");
$(".art-content").find("img").attr("src",imgurl);
}
$(".art-content").find("img").attr("data-toggle","lightbox");
$(".art-content").find("img").attr("class","img-thumbnail").css({"display":"block","margin-top":"3px"});
$(function(){

//微信二维码生成
$('#qr_wxcode').qrcode("http://172.16.1.208/?article-<?=$topicone['id']?>.html");
     //显示微信二维码
     $(".share-weixin").click(function(){
    	 $(".share-wechat").show();
     });
     //关闭微信二维码
     $(".close").click(function(){
    	 $(".share-wechat").hide();
     })
})
</script>
<? include template('footer'); ?>
