<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('meta'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/login.css" />
<body class="no-padding reader-black-font">
<div class="sign">
   <!-- <div class="logo"><a href="/"><img src="<?=$setting['site_logo']?>" alt="Logo"></a></div>-->
    <div class="main">
      

<h4 class="title">
  <div class="normal-title">
    <a class="active" href="http://172.16.1.208/?user/login.html">登录</a>
<!--    <b>·</b>
    <a id="js-sign-up-btn" class="" href="http://172.16.1.208/?user/register.html">注册</a>-->
  </div>
</h4>
<div class="js-sign-in-container">
  <form id="new_session"  accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="fmDZC5B2M/Cj9fddniQd+UZf9QK++PqX3Jt3VhlwLByyM5eNbhuYXUrfQJeyap54s8abx05bTKo6WDqxqrartg==">
<input type="hidden"  id="forward" name="return_url" value="<?=$forward?>">
 <input type="hidden" id="usersid" name="usersid" value='<?=$_SESSION["userid"]?>'/>
  <input type="hidden" id="apikey" name="apikey" value='<?=$_SESSION["apikey"]?>'/>
    <!-- 正常登录登录名输入框 -->
      <div class="input-prepend restyle js-normal">
        <input placeholder="账号密码同EFGP" type="text" id="xm-login-user-name" >
        <i class="fa fa-user"></i>
      </div>

    <!-- 海外登录登录名输入框 -->

    <div class="input-prepend">
      <input placeholder="密码" type="password" id="xm-login-user-password">
      <i class="fa fa-lock"></i>
    </div>
   
    <div class="remember-btn">
      <input type="checkbox" value="1" name="net_auto_login" checked="checked" ><span>记住我</span>
    </div>
<!--    <div class="forget-btn">
      <a class=""  href="http://172.16.1.208/?user/getpass.html">登录遇到问题?</a>
     
    </div>-->
      <div id="being_login" style="width:100%;text-align:center;display:none;position:relative">
<p style="margin:0px;padding:0px;">正在登录...<p/>
<img src="<?=SITE_URL?>static/css/images/being_login.gif"></img>
</div>
    <input type="button" id="login_submit" value="登录" class="sign-in-button">
</form>
<? include template('openlogin'); ?>
</div>

    </div>
  </div>
   <script>
       $(document).keyup(function (event) {
           if (event.keyCode == 13) {
               $("#login_submit").trigger("click");
           }
       });



$("#login_submit").click(function(){
 var _forward=$("#forward").val();
    var _uname=$("#xm-login-user-name").val();
    var _upwd=$("#xm-login-user-password").val();
    var _apikey=$("#apikey").val();
   
    
    $.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:"<?=SITE_URL?>/?api_user/loginapi",
        //提交的数据
        data:{uname:_uname,upwd:_upwd,apikey:_apikey},
        //返回数据的格式
        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
        beforeSend: function () {
            
            //ajaxloading("提交中...");
            $("#being_login").css("top", "-40px");
            $("#being_login").show();
         },
        //成功返回之后调用的函数
        success:function(data){
        	data=$.trim(data);

            if(data=='login_ok'){
            
             	
             	
             	
             	
               window.location.href="<?=$forward?>";
               
             
            	
            	
            
            }else{
            	  switch(data){
            	  case 'login_null':
            		  alert("用户名或者密码为空");
            		  break;
 case 'login_user_or_pwd_error':
  alert("用户名或者密码错误");
            		  break;
default:
alert(data);
break;
            	  }
            }
        }   ,
        complete: function () {
            //removeajaxloading();
            $("#being_login").hide();
         },
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }
    });
});


</script>
<? include template('footer'); ?>
