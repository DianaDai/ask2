<? if(!defined('IN_ASK2')) exit('Access Denied'); include template(header,admin); ?>
<script src="<?=SITE_URL?>static/js/neweditor/ueditor.config.js" type="text/javascript"></script> 
<script src="<?=SITE_URL?>static/js/neweditor/ueditor.all.js" type="text/javascript"></script> 
<script src="<?=SITE_URL?>static/js/jquery-ui/jquery-ui.js" type="text/javascript"></script>
<script src="<?=SITE_URL?>static/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#list").sortable({
        update: function(){
            var reorderid = "";
            var numValue = $("input[name='order[]']");
            for (var i = 0; i < numValue.length; i++){
            reorderid += $(numValue[i]).val() + ",";
            }
            $.post("index.php?admin_category/reorder<?=$setting['seo_suffix']?>", {order:reorderid});
        }
    });
 });
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat<?=$setting['seo_suffix']?>" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;分类管理</div>
</div><? if(isset($message)) { $type=isset($type)?$type:'correctmsg';  ?><table class="table">
    <tr>
        <td class="<?=$type?>"><?=$message?></td>
    </tr>
</table><? } ?><table class="table">
    <tr class="header"><td>分类列表&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-danger" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_category/add/new<?=$setting['seo_suffix']?>'" value="添加新分类" /></td></tr>
    <tr class="altbg1"><td>分类的排序可以通过鼠标拖动来改变，当鼠标在某一分类上面时，按住左键即可上下移动。</td></tr>
    <tr class="altbg2"><td>
            <a href="index.php?admin_category/default<?=$setting['seo_suffix']?>">根目录</a>
            <? if(isset($navlist)) { ?>            
<? if(is_array($navlist)) { foreach($navlist as $nav) { ?>
            &gt;&gt; <a href="index.php?admin_category/view/<?=$nav['id']?><?=$setting['seo_suffix']?>"><?=$nav['name']?></a>  
            
<? } } ?>
            <? } ?>            <? if(isset($category['name'])) { ?>&gt;&gt; <?=$category['name']?><? } ?></td></tr>
</table>

<form name="answerlist" onsubmit="return confirm('删除该分类会同时删除该分类下的子分类及其分类下的所有问题，确定继续?');" action="index.php?admin_category/remove<?=$setting['seo_suffix']?>" method="post">
    <table class="table">
        <tr class="header" align="center">
            <td class="" width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('cid[]')" type="checkbox" name="chkall"><label for="chkall">删除</label></td>
            <td class="" width="10%">专栏名称</td>
             <td class="" width="20%">专栏别名-seo用</td>
               <td class="" width="30%">专栏描述</td>
                <td class="" width="10%">专栏封面图(195*195)</td>
            <td  class="" width="5%">查看子分类</td>
            <td  class="" width="5%">添加子分类</td>
            <td  class="" width="5%">编辑</td>
        </tr>
    </table>
    <input type="hidden" name="hiddencid" value="<?=$pid?>" />
    <ul id="list" style="cursor: pointer;width:100%;float: right;" >
        
<? if(is_array($categorylist)) { foreach($categorylist as $cate) { ?>
        <li style="list-style:none;">
            <table  class="table"> 
                <tr align="center" class="smalltxt">
                    <td width="5%" class="altbg2 text-left"><input class="checkbox" type="checkbox" value="<?=$cate['id']?>" name="cid[]"></td>
                    <td width="10%" class="altbg2"><a href="index.php?admin_category/view/<?=$cate['id']?><?=$setting['seo_suffix']?>"><input name="order[]" type="hidden" value="<?=$cate['id']?>"/><strong><?=$cate['name']?></strong></a></td>
                      <td width="20%" class="altbg2">
                      <p>
                      <center>
                        <p class="palias">  <?=$cate['alias']?></p>
                      <? if($cate['alias']) { ?>                  
                       <button text="<?=$cate['alias']?>" cid="<?=$cate['id']?>" state="edit" type="button" class="btn btn-primary btnalias" data-moveable="true" data-toggle="modal" data-target="#mySmModal">修改别名</button>
                      <? } else { ?>                        <button cid="<?=$cate['id']?>"  state="add" type="button" class="btn btn-primary btnalias" data-moveable="true" data-toggle="modal" data-target="#mySmModal">增加别名</button>
                      <? } ?>                    
                      </center>
                      </p>
                      </td>
                       <td width="30%" class="altbg2" style="background:#fff">
                            <p>
                      <center>
                        <p class="palias">  <?=$cate['miaosu']?></p>
                      <? if($cate['miaosu']) { ?>                  
                       <button  cid="<?=$cate['id']?>" state="edit" type="button" class="btn btn-primary btnmiaosu" data-moveable="true" data-toggle="modal" data-target="#catSmModal">修改描述</button>
                      <? } else { ?>                        <button cid="<?=$cate['id']?>"  state="add" type="button" class="btn btn-primary btnmiaosu" data-moveable="true" data-toggle="modal" data-target="#catSmModal">添加描述</button>
                      <? } ?>                    
                      </center>
                      </p>
                      </td>
                       <td width="10%" class="altbg2" >
                            <p>
                      <center>
                        <p class="palias">
                        
                        <? if($cate['image']==""||$cate['image']==null) { ?>                         <img src="<?=SITE_URL?>static/images/defaulticon.jpg" style="width:80px;height:80px;">
                         <? } else { ?>                             <img src="<?=$cate['image']?>" style="width:80px;height:80px;">
                         <? } ?>                       
                     
                         
                         </p>
                      <? if($cate['image']) { ?>                  
                       <button text="<?=$cate['image']?>"  cid="<?=$cate['id']?>" state="edit" type="button" class="btn btn-primary btnimage" data-moveable="true" data-toggle="modal" data-target="#myimageSmModal">修改图片</button>
                      <? } else { ?>                        <button cid="<?=$cate['id']?>"  state="add" type="button" class="btn btn-primary btnimage" data-moveable="true" data-toggle="modal" data-target="#myimageSmModal">添加图片</button>
                      <? } ?>                    
                      </center>
                      </p>
                      </td>
                    <td width="5%" class="altbg2" align="center"><img src="<?=SITE_URL?>static/css/admin/view.png" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_category/view/<?=$cate['id']?><?=$setting['seo_suffix']?>'"></td>
                    <td width="5%" class="altbg2" align="center"><img src="<?=SITE_URL?>static/css/admin/add.png" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_category/add/<?=$cate['id']?>/<?=$cate['pid']?><?=$setting['seo_suffix']?>'"></td>
                    <td width="5%" class="altbg2" align="center"><img src="<?=SITE_URL?>static/css/admin/edit.png" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_category/edit/<?=$cate['id']?><?=$setting['seo_suffix']?>'"></td>
                </tr>
            </table>
        </li>
        
<? } } ?>
    </ul>
    <center><input class="btn btn-success" tabindex="3" type="submit" value=" 提 交 " name="submit" /></center>
</form>
<br>

<div class="modal fade" id="myimageSmModal">
<div class="modal-dialog">
  <div class="modal-content">
   <form class="form-horizontal" name="formcategoryimage" id="formcategoryimage"  method="post"  enctype="multipart/form-data">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">上传图片，尺寸195*195</h4>
    </div>
    <div class="modal-body ">
    
    <input type="file" id="file_upload" name="catimage">
       <input type="hidden" name="catid" value="" id="category_id"/>
    </div>
    <div class="modal-footer">
     
      <button type="button" id="catbtn" class="btn btn-primary">上传</button>
      
       <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
    </form>
  </div>
</div>
</div>
<div class="modal fade" id="mySmModal">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">分类别名</h4>
    </div>
    <div class="modal-body ">
    
     <input type="text" name="class_alias" id="class_alias" value="" class="form-control" placeholder="设置分类别名" style="width:100%">
    </div>
    <div class="modal-footer">
     
      <button type="button" id="btnsave" class="btn btn-primary">保存</button>
      
       <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="catSmModal">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">分类描述</h4>
    </div>
    <div class="modal-body ">
 <style>

 </style>
<script type="text/plain" id="edit_miaosu" name="edit_miaosu" style="height: 200px;"></script>
                         <script type="text/javascript">  
            var editor = UE.getEditor('edit_miaosu',{  
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个  
                  toolbars:[[  'link', 'unlink', 'Redo','bold']],
               
               
                //关闭字数统计  
                wordCount:false,  
                //关闭elementPath  
                elementPathEnabled:false,  
             
                focus:true
                //更多其他参数，请参考ueditor.config.js中的配置项  
                //更多其他参数，请参考ueditor.config.js中的配置项  
            });  
        </script> 
    </div>
    <div class="modal-footer">
     
      <button type="button" id="btnmiaosusave" class="btn btn-primary">保存</button>
      
       <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
  </div>
</div>
</div>


<script>
var catid=0;
$(".btnimage").click(function(){
catid=$(this).attr("cid");
    $("#category_id").val(catid);

});
$("#catbtn").click(function(){


    document.formcategoryimage.action = "<?=SITE_URL?>index.php?admin_category/editimg<?=$setting['seo_suffix']?>";
    document.formcategoryimage.submit();
});
function getmiaosu(){
 var myurl=g_site_url+"index.php?admin_category/getmiaosu<?=$setting['seo_suffix']?>";

$.ajax({
        type: "post",
         url: myurl,
         data:{'id':cid},
         dataType: "text",
         success: function (data) {
           
        	 $("#class_alias").val(data);
        	
               
    			
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
       }
 });
}
$(".btnalias").click(function(){
var cid=$(this).attr("cid");
var text=$(this).attr("text");
var state=$(this).attr("state");
switch(state){

case 'edit':
$("#class_alias").val(text);
break;

case 'add':
$("#class_alias").val("");
break;
}
var target=$(this);
$("#btnsave").click(function(){

 var myurl=g_site_url+"index.php?admin_category/editalias<?=$setting['seo_suffix']?>";

$.ajax({
        type: "post",
         url: myurl,
         data:{'id':cid,'alias':$("#class_alias").val()},
         dataType: "text",
         success: function (data) {
           
        	window.location.reload();
        	
               
    			
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
       }
 });
});

})
function getmiaosu(cid){

 var myurl=g_site_url+"index.php?admin_category/getmiaosu<?=$setting['seo_suffix']?>";

$.ajax({
   type: "post",
    url: myurl,
    data:{'id':cid},
    dataType: "text",
    success: function (data) {
      
       
    	editor.setContent(data);
          

    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
           alert(errorThrown);
  }
});
}
//编辑专栏描述
$(".btnmiaosu").click(function(){
var cid=$(this).attr("cid");

var state=$(this).attr("state");
 var eidtor_content= editor.getContent();
 getmiaosu(cid);
var target=$(this);
$("#btnmiaosusave").click(function(){

 var myurl=g_site_url+"index.php?admin_category/editmiaosu<?=$setting['seo_suffix']?>";

$.ajax({
        type: "post",
         url: myurl,
         data:{'id':cid,'miaosu':editor.getContent()},
         dataType: "text",
         success: function (data) {
           
        	window.location.reload();
        	
               
    			
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
       }
 });
});

})
</script>
<? include template(footer,admin); ?>
