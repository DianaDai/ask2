<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/space.css" />






<!--用户中心-->


    <div class="container person">

        <div class="row ">
            <div class="col-xs-16 main">
            <!-- 用户title部分导航 -->
        
             <!-- title结束标记 -->
       <!-- 内容页面 -->  
    <div class="row">
                 <div class="col-sm-24">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">个人信息</strong>
                         </p>
                        <ul class="nav nav-secondary">
        <li class="active"><a href="http://172.16.1.208/?user/profile.html">个人资料</a></li>
                    <li ><a href="http://172.16.1.208/?user/uppass.html">修改密码</a></li>
                     <li ><a href="http://172.16.1.208/?user/editemail.html">修改邮箱</a></li>
                    <li ><a href="http://172.16.1.208/?user/editimg.html">修改头像</a></li>
                    <li>
                    <a href="http://172.16.1.208/?user/mycategory.html">我的设置</a>
                    </li>
             </ul>
                         <hr>
                      
 
                    <form class="form-horizontal"  method="POST" name="upinfoForm"  action="http://172.16.1.208/?user/profile.html" >
 <div class="form-group">
          <p class="col-md-4 text-left">用户名:</p>
          <div class="col-md-8">
             <?=$user['username']?>
          </div>
        </div>
     
        
         <div class="form-group">
          <p class="col-md-4 text-left">消息设置:</p>
          <div class="col-md-14">
             <span><input class="normal_checkbox" type="checkbox" <? if(1 & $user['isnotify']) { ?>checked<? } ?> value="1" name="messagenotify" />站内消息&nbsp;&nbsp;</span>
                        <span><input class="normal_checkbox"  type="checkbox" <? if(2 & $user['isnotify']) { ?>checked<? } ?> value="2" name="mailnotify" />邮件通知</span>
          </div>
        </div>
           <div class="form-group">
          <p class="col-md-4 text-left ">邮箱地址：</p>
          <div class="col-md-12">
             <input type="text" name="email" id="email"  value="<?=$user['email']?>" placeholder="" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-4 text-left ">性别:</p>
          <div class="col-md-14">
            <span><input type="radio" value="1" class="normal_radio" name="gender" <? if((1 == $user['gender'])) { ?> checked <? } ?> />男&nbsp;&nbsp;</span>
                        <span><input type="radio" value="0" class="normal_radio" name="gender" <? if((0 == $user['gender'])) { ?> checked <? } ?>/>女 &nbsp;&nbsp;</span>
                        <span><input type="radio" value="2" class="normal_radio" name="gender" <? if((2 == $user['gender'])) { ?> checked <? } ?> />保密</span>
          </div>
        </div>
        
         <div class="form-group">
          <p class="col-md-4 text-left ">生日：</p>
          <div class="col-md-14">
             <? $bdate=explode("-",$user['bday']); ?>                        <select id="birthyear" name="birthyear" onchange="showbirthday();" class="normal_select">
                            <? $curyear=date("Y"); ?>                            <? $yearlist = range(1911,$curyear); ?>                            
<? if(is_array($yearlist)) { foreach($yearlist as $year) { ?>
                            <option value="<?=$year?>" <? if($bdate['0']==$year) { ?>selected<? } ?> ><?=$year?></option>
                            
<? } } ?>
                        </select> 年&nbsp;&nbsp;
                        <select id="birthmonth" name="birthmonth" onchange="showbirthday();" class="normal_select">
                            <? $monthlist = range(1,12); ?>                            
<? if(is_array($monthlist)) { foreach($monthlist as $month) { ?>
                            <option value="<?=$month?>" <? if($bdate['1']==$month) { ?>selected<? } ?>><?=$month?></option>
                            
<? } } ?>
                        </select> 月&nbsp;&nbsp;
                        <select id="birthday" name="birthday" class="normal_select">
                            <? $dayhlist = range(1,31); ?>                            
<? if(is_array($dayhlist)) { foreach($dayhlist as $day) { ?>
                            <option  value="<?=$day?>" <? if($bdate['3']==$day) { ?>selected<? } ?>><?=$day?></option>
                            
<? } } ?>
                        </select>日
          </div>
        </div>
        
         <div class="form-group">
          <p class="col-md-4 text-left ">手机：</p>
          <div class="col-md-12">
             <input type="text"  name="phone" id="phone"  value="<?=$user['phone']?>" placeholder="" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-4 text-left ">QQ：</p>
          <div class="col-md-12">
             <input type="text"  name="qq" id="qq"   value="<?=$user['qq']?>" placeholder="" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-4 text-left ">MSN：</p>
          <div class="col-md-12">
             <input type="text"  name="msn" id="msn"  value="<?=$user['msn']?>" placeholder="" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-4 text-left ">身份介绍</p>
          <div class="col-md-24">
            <textarea name="introduction" id="introduction" style="width:488px;height:89px;" class="form-control" ><?=$user['introduction']?></textarea>
            
   
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-4 text-left ">签名</p>
          <div class="col-md-24">
                                    <textarea name="signature" id="signature" style="width:488px;height:89px;" class="form-control" maxlength="200"><?=$user['signature']?></textarea>
          </div>
        </div>
        
        
         
        
        <div class="form-group">
          <div class=" col-md-10">
             <input type="submit" id="submit" name="submit" class="btn btn-success" value="保存" data-loading="稍候..."> 
          </div>
        </div>
 </form>
                     </div>
                 </div>


             </div>
            </div>
           
            <!--右侧栏目-->
            <div class="col-xs-7 col-xs-offset-1 aside ">


              

                <!--导航列表-->

               
<? include template('user_menu'); ?>
                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>




<!--用户中心结束-->
<? include template('footer'); ?>
