<? if(!defined('IN_ASK2')) exit('Access Denied'); include template(header,admin); ?>
<script type="text/javascript">
    function selectCell(obj) {
        var trid=obj.value;
        $("#"+trid+" input[name='regular_code[]']").each(function(){
            this.checked = obj.checked;
        });
    }
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat<?=$setting['seo_suffix']?>" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置组权限</div>
</div><? if(isset($message)) { $type=isset($type)?$type:'correctmsg';  ?><table class="table">
    <tr>
        <td class="<?=$type?>"><?=$message?></td>
    </tr>
</table><? } ?><form action="index.php?admin_usergroup/regular/<?=$group['groupid']?><?=$setting['seo_suffix']?>" method="post">
    <input type="hidden" name="groupid" value="<?=$group['groupid']?>">
    <table class="table">
        <tbody>
            <tr class="header" >
                <td>
                    <input type="button" style="cursor:pointer" onclick="document.location.href='index.php?admin_usergroup<?=$setting['seo_suffix']?>'" value="会员用户组" />&nbsp;&nbsp;&nbsp;
                    <input type="button" style="cursor:pointer" onclick="document.location.href='index.php?admin_usergroup/system<?=$setting['seo_suffix']?>'" value="系统用户组" />&nbsp;&nbsp;&nbsp;
设置组权限
                </td>
            </tr>
    </table>
    <table width="100%" cellspacing="1" cellpadding="4" align="center" class="tableborder">
        <tr class="header">
            <td colspan="2">系统操作权限设置</td>
        </tr>
        <tr id="regular_view">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_view"  class="checkbox" type="checkbox" onclick="selectCell(this);">页面浏览（前台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/register,user/editimg"  <? if(false!==strpos($group['regulars'],'user/register')) { ?>checked<? } ?>  class="checkbox" type="checkbox">用户注册
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="index/default"  <? if(false!==strpos($group['regulars'],'index/default')) { ?>checked<? } ?>  class="checkbox" type="checkbox">首页浏览
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="category/view"  <? if(false!==strpos($group['regulars'],'category/view')) { ?>checked<? } ?>  class="checkbox" type="checkbox">分类浏览
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="category/list"  <? if(false!==strpos($group['regulars'],'category/list')) { ?>checked<? } ?>  class="checkbox" type="checkbox">列表浏览
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/view"  <? if(false!==strpos($group['regulars'],'question/view')) { ?>checked<? } ?>  class="checkbox" type="checkbox">浏览问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/follow"  <? if(false!==strpos($group['regulars'],'question/follow')) { ?>checked<? } ?>  class="checkbox" type="checkbox">查看问题关注者
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="topic/default"  <? if(false!==strpos($group['regulars'],'topic/default')) { ?>checked<? } ?>  class="checkbox" type="checkbox">知识专题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="note/list"  <? if(false!==strpos($group['regulars'],'note/list')) { ?>checked<? } ?>  class="checkbox" type="checkbox">公告列表
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="note/view"  <? if(false!==strpos($group['regulars'],'note/view')) { ?>checked<? } ?>  class="checkbox" type="checkbox">公告浏览
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="rss/category"  <? if(false!==strpos($group['regulars'],'rss/category')) { ?>checked<? } ?>  class="checkbox" type="checkbox">分类RSS
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="rss/list"  <? if(false!==strpos($group['regulars'],'rss/list')) { ?>checked<? } ?>  class="checkbox" type="checkbox">列表RSS
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="rss/question"  <? if(false!==strpos($group['regulars'],'rss/question')) { ?>checked<? } ?>  class="checkbox" type="checkbox">问题RSS
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/scorelist"  <? if(false!==strpos($group['regulars'],'user/scorelist')) { ?>checked<? } ?>  class="checkbox" type="checkbox">用户排行榜
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/activelist"  <? if(false!==strpos($group['regulars'],'user/activelist')) { ?>checked<? } ?>  class="checkbox" type="checkbox">活跃用户
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="expert/default"  <? if(false!==strpos($group['regulars'],'expert/default')) { ?>checked<? } ?>  class="checkbox" type="checkbox">专家列表
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/qqlogin"  <? if(false!==strpos($group['regulars'],'user/qqlogin')) { ?>checked<? } ?>  class="checkbox" type="checkbox">QQ登录
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="gift/default,gift/search,gift/add"  <? if(false!==strpos($group['regulars'],'gift/default,gift/search,gift/add')) { ?>checked<? } ?>  class="checkbox" type="checkbox">礼品商店
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/search"  <? if(false!==strpos($group['regulars'],'question/search')) { ?>checked<? } ?>  class="checkbox" type="checkbox">问题搜索
                </div>

                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/add"  <? if(false!==strpos($group['regulars'],'question/add')) { ?>checked<? } ?>  class="checkbox" type="checkbox">提问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/answer"  <? if(false!==strpos($group['regulars'],'question/answer')) { ?>checked<? } ?>  class="checkbox" type="checkbox">回答问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="doing/default"  <? if(false!==strpos($group['regulars'],'doing/default')) { ?>checked<? } ?>  class="checkbox" type="checkbox">动态
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/space_ask,user/space_answer,user/space"  <? if(false!==strpos($group['regulars'],'user/space_ask,user/space_answer,user/space')) { ?>checked<? } ?>  class="checkbox" type="checkbox">用户空间
                </div>
                <? if(3!=$group['grouptype']) { ?>                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="answer/append"  <? if(false!==strpos($group['regulars'],'answer/append')) { ?>checked<? } ?>  class="checkbox" type="checkbox">追问
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="answer/addcomment"  <? if(false!==strpos($group['regulars'],'answer/addcomment')) { ?>checked<? } ?>  class="checkbox" type="checkbox">回答评论
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/edittag"  <? if(false!==strpos($group['regulars'],'question/edittag')) { ?>checked<? } ?>  class="checkbox" type="checkbox">编辑问题标签
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="favorite/add"  <? if(false!==strpos($group['regulars'],'favorite/add')) { ?>checked<? } ?>  class="checkbox" type="checkbox">收藏问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="inform/add"  <? if(false!==strpos($group['regulars'],'inform/add')) { ?>checked<? } ?>  class="checkbox" type="checkbox">举报回答
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/answercomment"  <? if(false!==strpos($group['regulars'],'question/answercomment')) { ?>checked<? } ?>  class="checkbox" type="checkbox">问题评论
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="note/addcomment"  <? if(false!==strpos($group['regulars'],'note/addcomment')) { ?>checked<? } ?>  class="checkbox" type="checkbox" />公告评论
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/attentto"  <? if(false!==strpos($group['regulars'],'question/attentto')) { ?>checked<? } ?>  class="checkbox" type="checkbox" />关注问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/attentto"  <? if(false!==strpos($group['regulars'],'user/attentto')) { ?>checked<? } ?>  class="checkbox" type="checkbox" />关注用户
                </div>
                <? } ?>            </td>
        </tr>

        <? if(3!=$group['grouptype']) { ?>        <tr id="regular_user">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_user"  class="checkbox" type="checkbox" onclick="selectCell(this);">用户相关（前台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/register"  <? if(false!==strpos($group['regulars'],'user/register')) { ?>checked<? } ?>  class="checkbox" type="checkbox">注册用户
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/recommend"  <? if(false!==strpos($group['regulars'],'user/recommend')) { ?>checked<? } ?>  class="checkbox" type="checkbox">为我推荐
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/default,user/score"  <? if(false!==strpos($group['regulars'],'user/default,user/score')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的积分
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/userbank"  <? if(false!==strpos($group['regulars'],'user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/userbank')) { ?>checked<? } ?>  class="checkbox" type="checkbox">财富充值
                </div>
                 
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/ask"  <? if(false!==strpos($group['regulars'],'user/ask')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的提问
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/answer"  <? if(false!==strpos($group['regulars'],'user/answer')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的回答
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/follower,user/attention"  <? if(false!==strpos($group['regulars'],'user/follower,user/attention')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的关注
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="favorite/default,favorite/delete,question/addfavorite"  <? if(false!==strpos($group['regulars'],'favorite/default,favorite/delete,question/addfavorite')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的收藏
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/profile"  <? if(false!==strpos($group['regulars'],'user/profile')) { ?>checked<? } ?>  class="checkbox" type="checkbox">个人资料
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/uppass"  <? if(false!==strpos($group['regulars'],'user/uppass')) { ?>checked<? } ?>  class="checkbox" type="checkbox">修改密码
                </div>

                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/editimg,user/saveimg"  <? if(false!==strpos($group['regulars'],'user/editimg,user/saveimg')) { ?>checked<? } ?>  class="checkbox" type="checkbox">编辑头像
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/mycategory,user/unchainauth"  <? if(false!==strpos($group['regulars'],'user/mycategory,user/unchainauth')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/level"  <? if(false!==strpos($group['regulars'],'user/level')) { ?>checked<? } ?>  class="checkbox" type="checkbox">我的等级
                </div>
            </td>
        </tr>
        <tr id="regular_question">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_question"  class="checkbox" type="checkbox" onclick="selectCell(this);">问题相关（前台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="attach/uploadimage"  <? if(false!==strpos($group['regulars'],'attach/uploadimage')) { ?>checked<? } ?>  class="checkbox" type="checkbox">上传图片
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/adopt"  <? if(false!==strpos($group['regulars'],'question/adopt')) { ?>checked<? } ?>  class="checkbox" type="checkbox">采纳答案
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/edit"  <? if(false!==strpos($group['regulars'],'question/edit,')) { ?>checked<? } ?>  class="checkbox" type="checkbox">编辑问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/close"  <? if(false!==strpos($group['regulars'],'question/close')) { ?>checked<? } ?>  class="checkbox" type="checkbox">关闭问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/supply"  <? if(false!==strpos($group['regulars'],'question/supply')) { ?>checked<? } ?>  class="checkbox" type="checkbox">补充问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/addscore"  <? if(false!==strpos($group['regulars'],'question/addscore')) { ?>checked<? } ?>  class="checkbox" type="checkbox">提高悬赏
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/editanswer"  <? if(false!==strpos($group['regulars'],'question/editanswer')) { ?>checked<? } ?>  class="checkbox" type="checkbox">修改答案
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/search"  <? if(false!==strpos($group['regulars'],'question/search')) { ?>checked<? } ?>  class="checkbox" type="checkbox">问题搜索
                </div>
            </td>
        </tr>

        <tr id="regular_message">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_message"  class="checkbox" type="checkbox" onclick="selectCell(this);">站内消息（前台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/send"  <? if(false!==strpos($group['regulars'],'message/send')) { ?>checked<? } ?>  class="checkbox" type="checkbox">发消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/new"  <? if(false!==strpos($group['regulars'],'message/new')) { ?>checked<? } ?>  class="checkbox" type="checkbox">收件箱
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/personal"  <? if(false!==strpos($group['regulars'],'message/personal')) { ?>checked<? } ?>  class="checkbox" type="checkbox">私人消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/system"  <? if(false!==strpos($group['regulars'],'message/system')) { ?>checked<? } ?>  class="checkbox" type="checkbox">系统消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/outbox"  <? if(false!==strpos($group['regulars'],'message/outbox')) { ?>checked<? } ?>  class="checkbox" type="checkbox">发件箱
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/view"  <? if(false!==strpos($group['regulars'],'message/view')) { ?>checked<? } ?>  class="checkbox" type="checkbox">浏览消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/remove,message/removedialog"  <? if(false!==strpos($group['regulars'],'message/remove,message/removedialog')) { ?>checked<? } ?>  class="checkbox" type="checkbox">删除消息
                </div>
            </td>
        </tr>
        <? if(1==$group['grouptype']) { ?>        <tr id="regular_setting">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_setting"  class="checkbox" type="checkbox" onclick="selectCell(this);">网站设置（后台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_main/default,admin_main/header,admin_main/menu,admin_main/stat,admin_main/login,admin_main/logout"  <? if(false!==strpos($group['regulars'],'admin_main/default,admin_main/header,admin_main/menu,admin_main/stat,admin_main/login,admin_main/logout')) { ?>checked<? } ?>  class="checkbox" type="checkbox">后台登录
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/base,admin_setting/default"  <? if(false!==strpos($group['regulars'],'admin_setting/base,admin_setting/default')) { ?>checked<? } ?>  class="checkbox" type="checkbox">基本设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/list"  <? if(false!==strpos($group['regulars'],'admin_setting/list')) { ?>checked<? } ?>  class="checkbox" type="checkbox">列表显示
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/register"  <? if(false!==strpos($group['regulars'],'admin_setting/register')) { ?>checked<? } ?>  class="checkbox" type="checkbox">注册设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/mail"  <? if(false!==strpos($group['regulars'],'admin_setting/mail')) { ?>checked<? } ?>  class="checkbox" type="checkbox">邮件设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/credit"  <? if(false!==strpos($group['regulars'],'admin_setting/credit')) { ?>checked<? } ?>  class="checkbox" type="checkbox">积分设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/seo"  <? if(false!==strpos($group['regulars'],'admin_setting/seo')) { ?>checked<? } ?>  class="checkbox" type="checkbox">seo设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/static"  <? if(false!==strpos($group['regulars'],'admin_setting/static')) { ?>checked<? } ?>  class="checkbox" type="checkbox">html纯静态
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/word"  <? if(false!==strpos($group['regulars'],'admin_setting/word')) { ?>checked<? } ?>  class="checkbox" type="checkbox">词语过滤
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/cache"  <? if(false!==strpos($group['regulars'],'admin_setting/cache')) { ?>checked<? } ?>  class="checkbox" type="checkbox">更新缓存
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/passport"  <? if(false!==strpos($group['regulars'],'admin_setting/passport')) { ?>checked<? } ?>  class="checkbox" type="checkbox">通行证
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/ucenter"  <? if(false!==strpos($group['regulars'],'admin_setting/ucenter')) { ?>checked<? } ?>  class="checkbox" type="checkbox">UCenter
                </div>
            </td>
        </tr>

        <tr id="regular_manage">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_manage"  class="checkbox" type="checkbox" onclick="selectCell(this);">网站管理（后台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_category/default,admin_category/add,admin_category/edit,admin_category/view,admin_category/remove,admin_category/reorder,admin_category/postadd,admin_category/editalias,admin_category/editmiaosu,admin_category/getmiaosu"  <? if(false!==strpos($group['regulars'],'admin_category/default,admin_category/add,admin_category/edit,admin_category/view,admin_category/remove,admin_category/reorder,admin_category/postadd,admin_category/editalias,admin_category/editmiaosu,admin_category/getmiaosu')) { ?>checked<? } ?>  class="checkbox" type="checkbox">分类管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_question/default,admin_question/searchquestion,admin_question/searchanswer,admin_question/removequestion,admin_question/removeanswer,admin_question/edit,admin_question/examine,admin_question/examineanswer,admin_question/verify,admin_question/delete"  <? if(false!==strpos($group['regulars'],'admin_question/default,admin_question/searchquestion,admin_question/searchanswer,admin_question/removequestion,admin_question/removeanswer,admin_question/edit,admin_question/examine,admin_question/examineanswer,admin_question/verify,admin_question/delete')) { ?>checked<? } ?>  class="checkbox" type="checkbox">问题管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_user/default,admin_user/search,admin_user/add,admin_user/remove,admin_user/edit"  <? if(false!==strpos($group['regulars'],'admin_user/default,admin_user/search,admin_user/add,admin_user/remove,admin_user/edit')) { ?>checked<? } ?>  class="checkbox" type="checkbox">用户管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_usergroup/default,admin_usergroup/add,admin_usergroup/remove,admin_usergroup/edit"  <? if(false!==strpos($group['regulars'],'admin_usergroup/default,admin_usergroup/add,admin_usergroup/remove,admin_usergroup/edit')) { ?>checked<? } ?>  class="checkbox" type="checkbox">用户组管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_note/default,admin_note/add,admin_note/edit,admin_note/remove"  <? if(false!==strpos($group['regulars'],'admin_note/default,admin_note/add,admin_note/edit,admin_note/remove')) { ?>checked<? } ?>  class="checkbox" type="checkbox">公告管理
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_link/default,admin_link/add,admin_link/edit,admin_link/remove,admin_link/reorder"  <? if(false!==strpos($group['regulars'],'admin_link/default,admin_link/add,admin_link/edit,admin_link/remove,admin_link/reorder')) { ?>checked<? } ?>  class="checkbox" type="checkbox">友链管理
                </div>
            </td>
        </tr>
        <? } ?>        <? } ?>        </tbody>
    </table>
    <? if(6!=$group['groupid'] && $group['grouptype']!=1) { ?>    <table class="table">
        <tr class="header">
            <td colspan="2">其他权限设置</td>
        </tr>
        
    
        <tr>
<td class="altbg1" width="45%"><b>是否允许发布文章:</b><br><span class="smalltxt">选择是这个用户组可以发布文章，默认可以</span></td>
<td class="altbg2">
<input class="radio"  type="radio"  <? if($group['doarticle']==1) { ?>checked<? } ?>  value="1" name="doarticle"><label for="majia">是</label>&nbsp;&nbsp;&nbsp;
<input class="radio"    type="radio"   <? if($group['doarticle']==0) { ?>checked<? } ?>  value="0" name="doarticle"><label for="majia">否</label>
</td>
</tr>
         <tr>
            <td class="altbg1" width="45%"><b>每小时文章数限制:</b><br><span class="smalltxt">设置允许会员每小时最多的提问数量，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="articlelimits" value="<?=$group['articlelimits']?>" class="txt"></td>
        </tr>
            <tr>
            <td class="altbg1" width="45%"><b>每小时提问数限制:</b><br><span class="smalltxt">设置允许会员每小时最多的提问数量，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="questionlimits" value="<?=$group['questionlimits']?>" class="txt"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>每小时回答数限制:</b><br><span class="smalltxt">设置允许会员每小时最多的回答数量，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="answerlimits" value="<?=$group['answerlimits']?>" class="txt"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>每天最大评分值:</b><br><span class="smalltxt">设置允许会员每天最大的评分数值，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="credit3limits" value="<?=$group['credit3limits']?>" class="txt"></td>
        </tr>
    </table>
    <? } ?>    <input type="submit" class="btn btn-success" name="submit" value="提交" />
</form>
<br>
<? include template(footer,admin); ?>
