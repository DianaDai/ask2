daixy
主要修改的文件已经大概内容：

1、权限系统和邮件认证发送：

    application/control/api/user.php
    application/control/pccaiji/catgory.php  
    application/control/topic.php  
    application/control/question.php
    application/control/user.php
    application/model/topic.class.php
    application/model/question.class.php
    application/model/user.class.php
    application/model/base.class.php
    application/view/default/ask.html
    application/view/default/editquestion.html
    application/view/default/editxinzhi.html
    application/view/default/addxinzhi.html
    application/view/default/editemail.html
    application/view/default/popcheck.html
    application/view/default/login.html
    application/view/default/poplogin.html
    application/view/default/index.html
    application/view/default/header.html
    application/view/fronzewap/ask.html
    application/view/fronzewap/editquestion.html
    lib/global.func.php
    lib/email.class.php
  
2、网站UI、统一性小修 

    1）.移除各处提交前验证码检查
    2）.发表、回答、评论、保存称呼统一，快捷键修正为ctrl+enter
    3）.暂时移除注册功能
    4）.添加2个外网连接地址：
    5）.移除首页-->消息 下无用的页面(若能找到对应的页面添加上也可)
    
主要文件如下:

    application\control\message.php
    application\control\note.php
    application\control\question.php
    application\control\user.php
    application\control\answer.php
    application\view\default\nosolve.html
    application\view\default\qus.html
    application\view\default\resetpass.html
    application\view\default\supply.html
    application\view\default\ask.html
    application\view\default\catask.html
    application\view\default\editanswer.html
    application\view\default\editquestion.html
    application\view\default\getpass.html
    application\view\default\note.html
    application\view\default\sendmsg.html
    application\view\default\solve.html
    application\view\default\viewmessage.html
    application\view\default\appendanswer.html
    application\view\default\uppass.html
    application\view\default\topicone.html
    application\view\fronzewap\ask.html
    application\view\fronzewap\note.html
    application\view\fronzewap\solve.html
    application\view\fronzewap\uppass.html
    application\view\fronzewap\appendanswer.html
    application\view\fronzewap\editquestion.html
    application\view\fronzewap\getpass.html
    application\view\fronzewap\editanswer.html