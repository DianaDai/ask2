<? if(!defined('IN_ASK2')) exit('Access Denied'); include template('header'); ?>
<link rel="stylesheet" media="all" href="<?=SITE_URL?>static/css/bianping/css/space.css" />


<script src="<?=SITE_URL?>static/js/neweditor/ueditor.config.js" type="text/javascript"></script> 
<script src="<?=SITE_URL?>static/js/neweditor/ueditor.all.min.js" type="text/javascript"></script> 


<!--用户中心-->

    <div class="container person">

        <div class="row ">
            <div class="col-xs-16 main">
           
       <!-- 内容页面 -->  
    <div class="row">
                 <div class="col-sm-24">
                     <div class="dongtai">
                         <p class="pull-left">
                             <strong class="font-18 ">发送消息</strong>
                         </p>
                       <a class="btn btn-success pull-right" href="http://172.16.1.208/?message/personal.html">返回消息列表</a>
                         <hr style="clear:both">
                      
 
                    <form class="form-horizontal"  action="http://172.16.1.208/?message/send.html" method="post">

         <div class="form-group">
          <p class="col-md-24 ">收件人</p>
          <div class="col-md-14">
             <input type="text" id="username" name="username"  value="<?=$sendto['username']?>" placeholder="" class="form-control">
          </div>
        </div>
        
         <div class="form-group">
          <p class="col-md-24 ">主题</p>
          <div class="col-md-14">
             <input type="text" id="subject" name="subject"  value="" placeholder="" class="form-control">
          </div>
        </div>
           <div class="form-group">
          <p class="col-md-24 ">内容</p>
          <div class="col-md-18">
             <script type="text/plain" id="content" name="content" style="height: 122px;width:500px;"></script>
                          
                       <script type="text/javascript">  
            var editor = UE.getEditor('content',{  
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个  
                toolbars:[[<?=$setting['editor_toolbars']?>]],
               
               
                //关闭字数统计  
                wordCount:false,  
                //关闭elementPath  
                elementPathEnabled:false,  
                //默认的编辑区域高度  
                initialFrameHeight:150  
                //更多其他参数，请参考ueditor.config.js中的配置项  
                //更多其他参数，请参考ueditor.config.js中的配置项  
            });  
        </script> 
          </div>
        </div>
            <? if($setting['code_message']) { ?>     
               
<? include template('code'); ?>
          <? } ?>        
         
        
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
            <div class="col-xs-7 col-xs-offset-1 aside">


              

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
