<?php
!defined('IN_ASK2') && exit('Access Denied');
class downloadcontrol extends base {

    function downloadcontrol(& $get, & $post) {
        parent::__construct($get, $post);
       
    }
    
    function ondefault() {
    	
    	  $navtitle ="ask2问答系统下载";
    	  $seo_description=$this->setting['site_name']. '最新下载。';
             $seo_keywords= 'ask2问答系统下载,php问答系统下载';
    	  include template('download');
    }
    
}