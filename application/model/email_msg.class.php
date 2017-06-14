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
        $msg['content']=$msg['content'].=$url;
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
        $msg = $this->get_msg('问题','关注',2);
        $msg['content'] = str_replace('{zzxm}',$zzxm,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content']);
        $msg['content'] = str_replace('{gzzxm}',$gzzxm,$msg['content']);
        return $msg;
    }
    function question_ok($plrmc,$wtbt){
        $msg = $this->get_msg('问题','点赞',4);
        $msg['content'] =str_replace('{plrmc}',$plrmc,$msg['content']);
        $msg['content'] = str_replace('{wtbt}',$wtbt,$msg['content'])   ;
        return $msg;
    
    }
    
    
    
    
    
}
