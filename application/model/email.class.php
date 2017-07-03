<?php

!defined('IN_ASK2')&&exit('Access Denied');
/**
 * email short summary.
 *
 * email description.
 *
 * @version 1.0
 * @author wujie
 */
class emailmodel
{
    var $db;
    var $base;
    function emailmodel(&$base){
    
        $this->base =$base;
        $this->db = $base->db;
        
    }
    
    /*  写入要发送邮件     */
    function sendmail($tomail ,$subject ,$content){

        $this->db->query("INSERT INTO ".DB_TABLEPRE."email (`mailto`,`subject`,`content`) values('$tomail','$subject','$content')");
    }
    
    
    
    
    
    
}
