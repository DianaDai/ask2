<?php
!defined('IN_ASK2')&&exit('Access Denied');
/**
 * email_msg short summary.
 *
 * email_msg description.
 *
 * @version 1.0
 * @author wujie
 */
class email_msgmodel
{
    
    var $base;
    var $db;
    
    function email_msgmodel(&$base){
    
        $this->base= $base;
        $this->db=$base->db;
    }
    
    /*获取模板信息  type 模板的类型 ，  action；  具体的动作,$tmpid   模板   */
    function get_msg($type,$action,$tmpid=0){
    //消息模板只有一条
    $query = $this->db->fetch_first("SELECT * FROM ".DB_TABLEPRE."email_msg where available='1' and type ='$type' and action='$action' and templateid='$tmpid' ");

    return $query;
            
    }
    
    
    
    /*新增问题通知领域专家 */
    function question_add($zjxm ,$lymc,$wtbt,$url){
        $msg =$this->get_msg('问题','新增');
        //暂时想不到好的对应方法
        //{zjxm},{lymc},{wtbt}
        $msg['content']= str_replace('{zjxm}',$zjxm,$msg['content']);
        $msg['content']= str_replace('{lymc}',$lymc,$msg['content']);
        $msg['content']=str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']= str_replace('{url}',$url,$msg['content']);
        return $msg;
        
    }
    /* 新增问题，邀请回答*/
    function question_invite($zjxm,$zzxm,$wtbt,$url){
    
        $msg = $this->get_msg('问题','邀请回答');
        $msg['content']= str_replace('{zjxm}',$zjxm,$msg['content']);
        $msg['content']= str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content']=str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']=str_replace('{url}',$url,$msg['content']);
        return $msg;
        
        
    }
    
    /*问题回答通知信息   */
    function question_answer($zzxm,$wtbt,$url){
   
        $msg = $this->get_msg('问题','回答',2);
        
        $msg['content']=str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content']=str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']=str_replace('{url}',$url,$msg['content']);
   
        return $msg;
    }
    /* 有多少个关注人，就查询多少次数据库。。。先这样吧    */
    function question_answer_with($gzzxm,$wtbt,$url){
        $msg =$this->get_msg('问题','回答',3);
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content']=str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']=str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    /*追问 关注着*/
    function question_ask($gzzxm,$wtbt,$url){
    
        $msg =$this->get_msg('问题','追问',3);
        $msg['content']=str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content']=str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']=str_replace('{url}',$url,$msg['content']);
        return $msg;
        
    }
    /*追问评论者或回答者*/
    function question_comment($plrmc,$wtbt,$url){
        $msg =$this->get_msg('问题','追问',4);
        $msg['content']=str_replace('{plrmc}',$plrmc,$msg['content']);
        $msg['content']=str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']=str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    
    
    /* 追答  通知作者*/
    function question_ask_ans($zzxm,$wtbt,$url){
    
        $msg = $this->get_msg('问题','追答',2);
        $msg['content'] =str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    /*追答 通知关注着*/
    
    function question_ask_with($gzzxm,$wtbt,$url){
        $msg =$this->get_msg('问题','追答',3);
        $msg['content']=str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content']= str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']= str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    /* 采纳问题通知提问者*/
    function question_adopt($zzxm,$wtbt,$wthd){
        $msg = $this->get_msg('问题','采纳',2);
        $msg['content']= str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content']= str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']= str_replace('{wthd}',$wthd,$msg['content']);
        return $msg;
    }
    
    /* 采纳问题通知关注者*/
    
    function question_adopt_with($gzzxm,$wtbt,$url){
        $msg =$this->get_msg('问题','采纳',3);
        $msg['content']= str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content']= str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content']= str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    /* 采纳问题通知回答者*/
    
    function question_adopt_ans($plrmc,$wtbt){
        $msg =$this->get_msg('问题','采纳',4);
        $msg['content']= str_replace('{plrmc}',$plrmc,$msg['content']);
        $msg['content']= str_replace('{wtbt}',$wtbt,$msg['content']);
        return $msg;
    }
    
    
    function question_atto($zzxm,$wtbt,$gzzxm){
        $msg = $this->get_msg('问题','关注');
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        return $msg;
    }
    function question_ok($plrmc,$wtbt){
        $msg = $this->get_msg('问题','点赞');
        $msg['content'] =str_replace('{plrmc}',$plrmc,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content'])   ;
        return $msg;
    
    }
    
    
    function question_edit($zzxm,$wtbt,$glymc,$time,$url){
        $msg =$this->get_msg('问题','编辑问题');
        $msg['content']= str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{glymc}',$glymc,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        $msg['content'] = str_replace('{time}',$time,$msg['content']);
        return $msg;
        
    }
    //编辑答案
    function question_edit_ans($plrmc,$wtbt,$glymc,$time,$url){
        $msg = $this->get_msg('问题','编辑答案');
        $msg['content'] =str_replace('{plrmc}',$plrmc,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{glymc}',$glymc,$msg['content']);
        $msg['content'] = str_replace('{time}',$time,$msg['content']);
        $msg['content']= str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    //关闭问题
    
    function question_close($zzxm,$wtbt,$glymc,$time){
        $msg = $this->get_msg('问题','关闭问题');
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{glymc}',$glymc,$msg['content']);
        $msg['content'] = str_replace('{time}',$time,$msg['content']);
        return $msg;
    }
    //删除问题
    
    function question_del($zzxm,$wtbt,$glymc,$time){
        $msg =$this->get_msg('问题','删除问题');
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{glymc}',$glymc,$msg['content']);
        $msg['content'] = str_replace('{time}',$time,$msg['content']);
        return $msg;
    }
    
    //文章修改
    function topic_edit($gzzxm,$wzbt,$url){
        $msg= $this->get_msg('文章','编辑');
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content'] = str_replace('{wzbt}',$wzbt,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    function topic_ans($zzxm,$wzbt,$url){
        $msg =$this->get_msg('文章','评论',2);
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wzbt}',$wzbt,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    function topic_ans_fav($gzzxm,$wzbt,$url){
        $msg =$this ->get_msg('文章','评论',3);
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content'] = str_replace('{wzbt}',$wzbt,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return  $msg;
    }
    
    function topic_save($zzxm,$wzbt,$time,$gzzxm){
        $msg = $this->get_msg('文章','收藏');
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content'] = str_replace('{wzbt}',$wzbt ,$msg['content']);
        $msg['content'] = str_replace('{time}',$time, $msg['content']);
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        return $msg;
    }
    //目前文章还没有点赞表
    //要么不做要么创建表做个点赞功能
    function topic_ok($zzxm,$wzbt){
        $msg = $this->get_msg('文章','点赞');
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wzbt}',$wzbt ,$msg['content']);
        return $msg;
    }
    //公告通知粉丝。。。
    function notice_info($yhxm,$ggbt,$url) {
        $msg = $this->get_msg('公告','新增');
        $msg['content'] = str_replace('{yhxm}',$yhxm,$msg['content']);
        $msg['content'] = str_replace('{ggbt}',$ggbt ,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    //公告评论
    function notice_comment($zzxm,$ggbt,$url){
        $msg = $this->get_msg('公告','评论');
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{ggbt}',$ggbt,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    //用户 被关注
    
    
    function user_follow($yhxm ,$gzzxm,$time){
        $msg = $this->get_msg('用户','被关注');
        $msg['content'] = str_replace('{yhxm}',$yhxm,$msg['content']);
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content'] = str_replace('{time}',$time,$msg['content']);
        
        return $msg;
    }
    
    function user_msg($yhxm,$url){
        $msg = $this->get_msg('用户','私信');
        $msg['content'] = str_replace('{yhxm}',$yhxm,$msg['content']);
        $msg['content'] = str_replace('url',$url,$msg['content']);
        return $msg;
    }
    
    function user_update($yhxm,$djmc){
        $msg = $this->get_msg('用户','头衔变更');
        $msg['content'] = str_replace('{yhxm}',$yhxm,$msg['content']);
        $msg['content'] = str_replace('{djmc}',$djmc,$msg['content']);
        return $msg;
    }
    
    
    function user_replace($yhxm,$spmc,$gymc){
        $msg = $this->get_msg('用户','兑换');
        $msg['content'] = str_replace('{yhxm}',$yhxm,$msg['content']);
        $msg['content'] = str_replace('{spmc}',$spmc,$msg['content']);
        $msg['content'] = str_replace('{gymc}',$gymc,$msg['content']);
        return $msg;
    }
    
    function special($gzzxm,$lymc,$url){
        $msg = $this->get_msg('专题','新增文章');
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content'] = str_replace('{lymc}',$lymc,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    
    function speacial_pro($gzzxm,$lymc,$zjxm,$url){
        $msg = $this->get_msg('专题','新增专家',5);
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        $msg['content'] = str_replace('{lymc}',$lymc,$msg['content']);
        $msg['content'] = str_replace('{zjxm}',$zjxm,$msg['content']);
        $msg['content'] = str_replace('{url}',$url,$msg['content']);
        return $msg;
    }
    //
    function sepeacial_uppro($zjxm,$lymc){
        $msg = $this->get_msg('专题','新增专家',6);
        $msg['content'] = str_replace('{zjxm}',$zjxm,$msg['content']);
        $msg['content'] = str_replace('{lymc}',$lymc,$msg['content']);
        return $msg;
    }
    
    
}
