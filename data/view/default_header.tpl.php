<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('meta'); ?>
<body lang="zh-CN" class="reader-black-font">
<!--[if lt IE 8]>
<div class="alert alert-danger">您正在使用 <strong>过时的</strong> 浏览器. 是时候 <a href="http://browsehappy.com/">更换一个更好的浏览器</a>
    来提升用户体验.
</div>
<![endif]-->

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="width-limit">
        <!-- 左上方 Logo -->
        <a class="logo bounceIn animated " href="/"><img src="<?=$setting['site_logo']?>" alt="Logo" /></a>

        <!-- 右上角 -->

          <? if(0!=$user['uid']) { ?>        <!-- 登录显示写文章 -->
         <a class="btn write-btn" target="_blank" href="http://172.16.1.208/?question/add.html">
        <i class="fa fa-magic"></i>来提问
</a>      
        <a class="btn write-btn" target="_blank" href="http://172.16.1.208/?user/addxinzhi.html">
            <i class="fa fa-pencil"></i>写文章
        </a>
        <!-- 如果用户登录，显示下拉菜单 -->
        <div class="user">
            <div data-hover="dropdown">
                <a class="avatar" href="http://172.16.1.208/?user/default.html"><img src="<?=$user['avatar']?>" alt="120" /></a>
            </div>
            <ul class="dropdown-menu">
                 <? if($user['groupid']<=3) { ?>        
                                  
                                     <li>
                    <a href="<?=SITE_URL?>index.php?admin_main">
                        <i class="fa fa-gear"></i><span>后台管理</span>
                    </a>          </li>
            
                
                                    <? } ?> 
                                    
                <li>
                    <a href="http://172.16.1.208/?user/default.html">
                        <i class="fa fa-user"></i><span>我的主页</span>
                    </a>          </li>
             
                <li>
                    <a href="http://172.16.1.208/?ut-<?=$user['uid']?>.html}">
                        <i class="fa fa-rss-square"></i><span>我的文章</span>
                    </a>          </li>
              
                <li>
                    <a href="http://172.16.1.208/?user/attention/question.html">
                        <i class="fa fa-star"></i><span>我的收藏</span>
                    </a>          </li>
                <li>
                    <a href="http://172.16.1.208/?user/ask/1.html">
                        <i class="fa fa-question-circle-o"></i><span>我的问题</span>
                    </a>          </li>
                <li>
                    <a rel="nofollow" data-method="delete" href="http://172.16.1.208/?user/logout.html">
                        <i class="fa fa-power-off"></i><span>退出</span>
                    </a>          </li>
            </ul>
        </div>
  <? } else { ?>           <!-- 未登录显示登录/注册/写文章/提问题 -->
           <a class="btn write-btn" target="_blank" href="http://172.16.1.208/?question/add.html">
        <i class="fa fa-magic"></i>来提问
</a>      
      <a class="btn write-btn" target="_blank" href="http://172.16.1.208/?user/addxinzhi.html">
        <i class="fa fa-pencil"></i>写文章
</a>     <!-- <a class="btn sign-up" href="http://172.16.1.208/?user/register.html">注册</a>-->
      <a class="btn log-in" href="http://172.16.1.208/?user/login.html">登录</a>
        
       <? } ?>        <div id="view-mode-ctrl">
        </div>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="menu">
             <ul class="nav navbar-nav">
             
                     <? if(0!=$user['uid']) { ?>                           <li class="active">
                        <a href="/">
                            <span class="menu-text">发现</span><i class="fa fa-leaf menu-icon"></i>
                        </a>            </li>
                        <li >
              <a class="app-download-btn" href="http://172.16.1.208/?user/activelist.html"><span class="menu-text">作者</span><i class="fa fa-lemon-o menu-icon"></i></a>
            </li>
                      <li >
              <a class="app-download-btn" href="http://172.16.1.208/?expert.html"><span class="menu-text">专家</span><i class="fa fa-user-circle-o menu-icon"></i></a>
            </li>
               <li >
              <a class="app-download-btn" href="http://172.16.1.208/?note/list.html"><span class="menu-text">公告</span><i class="fa fa-bullhorn menu-icon"></i></a>
            </li>
             
                    <li class="notification v-notification-dropdown-menu ">
                        <a class="notification-btn"  data-hover="dropdown">
                            <span class="menu-text">消息</span>
                            <i class="fa fa-bell-o menu-icon"></i>
                            <span class="badge msg-count hide"></span>
                        </a>
                        <ul class="dropdown-menu">
                      
                            <li>
                            <a href="javascrpt:void(0)"><i class="fa  fa-gittip"></i>
                             <span>关注</span> <!----></a>
                             </li>
                             <li>
                             <a href="javascrpt:void(0)"><i class="fa fa-paypal"></i> 
                             <span>赞赏</span> <!---->
                             </a></li>
                              <li>
                  
                    <a href="http://172.16.1.208/?message/system.html">
                        <i class="fa fa-envelope"></i><span>系统私信</span>
                        <span class="badge s-msg-count"></span>
                    </a>        
                      </li>
                           <li>
                  
                    <a href="http://172.16.1.208/?message/system.html">
                        <i class="fa fa-envelope-o"></i><span>个人私信</span>
                            <span class="badge p-msg-count"></span>
                    </a>        
                      </li>
                     
                        <li>
                           <a href="javascrpt:void(0)"><i class="fa fa-heart"></i>
                            <span>喜欢和赞</span> <!---->
                            </a>
                            </li>
                             <li>
                             <a href="javascrpt:void(0)"><i class="fa fa-flickr"></i> 
                             <span>其他消息</span> <!---->
                             </a>
                             </li>
                             </ul>
                    </li>
                           <? } else { ?>                           <li class="active">
              <a href="/">
                <span class="menu-text">首页</span><i class="fa fa-home menu-icon"></i>
</a>            </li>

<li >
              <a class="app-download-btn" href="http://172.16.1.208/?user/activelist.html"><span class="menu-text">作者</span><i class="fa fa-lemon-o menu-icon"></i></a>
            </li>
             <li >
              <a class="app-download-btn" href="http://172.16.1.208/?expert.html"><span class="menu-text">专家</span><i class="fa fa-user-circle-o menu-icon"></i></a>
            </li>
            <li >
              <a class="app-download-btn" href="http://172.16.1.208/?note/list.html"><span class="menu-text">公告</span><i class="fa fa-bullhorn menu-icon"></i></a>
            </li>
                             <? } ?>              
                    <li class="search">
                        <form target="_blank"  name="searchform" action="http://172.16.1.208/?question/search.html" method="post" accept-charset="UTF-8" >
                        <input name="utf8" type="hidden" value="&#x2713;"  />
                            <input type="text" tabindex="1"  name="word" id="search-kw" value="<?=$word?>" placeholder="<?=$setting['search_placeholder']?>"  class="search-input" />
                        
                            <a class="search-btn" href="javascript:void(null)">
                               <button type="submit" class="btnup">
                            <i class="fa fa-search"></i>
                             </button>
                            </a>
                            
                          
                           
                          
                        </form>          </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
