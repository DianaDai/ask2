<?php

!defined('IN_ASK2') && exit('Access Denied');

class api_usercontrol extends base
{

    var $apikey = '';
    var $whitelist;

    //构造函数
    function app_usercontrol(& $get, & $post)
    {
        $this->base($get, $post);
        $this->load('user');
        $this->whitelist = "bindloginapi";

    }

    //-----------------------------------用户注册录接口函数
    function onbindregisterapi()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (!strstr($useragent, 'MicroMessenger')) {
            exit("只能微信里绑定哟，您就别费劲想耍花招了");
        }
        $openid = trim($this->post['openid']); //openid
        $username = strip_tags(trim($this->post['uname']));//用户注册名字，strip_tags第一层过滤
        $password = trim($this->post['upwd']);//用户注册密码

        $repassword = trim($this->post['rupwd']);//用户注册密码

        $this->checkdeepstring($username);
        $usernamecensor = $_ENV['user']->check_usernamecensor($username);
        if (FALSE == $usernamecensor)
            exit('用户包含敏感词');
        $this->checkstring($password);
        $this->checkstring($repassword);
        $email = $this->post['email'];//用户邮箱

        $emailaccess = $_ENV['user']->check_emailaccess($email);
        if (FALSE == $emailaccess
        ) {
            exit("邮件地址被禁止注册");
        }


        $groupid = 7;//角色ID
        if ($repassword != $password) {
            exit("两次输入密码不一样");//用户密码不能为空
        }
        if ('' == $username || '' == $password) {
            exit("reguser_cant_null");//用户密码不能为空
        } else if (!preg_match("/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", $email)) {
            exit("regemail_Illegal");//注册邮箱不合法
        } else if ($this->db->fetch_total('user', " email='$email' ")) {
            exit("regemail_has_exits");//注册邮箱已经存在
        } else if (!$_ENV['user']->check_usernamecensor($username)) {
            exit("regemail_cant_use");//注册邮箱不能使用
        }

        $user = $_ENV['user']->get_by_username($username);
        $user && exit("reguser_has_exits");//注册用户已经存在

        //ucenter注册。
        if ($this->setting["ucenter_open"]) {
            $this->load('ucenter');
            $msg = $_ENV['ucenter']->ajaxregister($username, $password, $email);
            if ($msg == 'ok') {
                // $uid = $_ENV['user']->adduserapi($username, $password, $email,$groupid);//插入model/user.class.php里adduserapi函数里
                $user = $_ENV['user']->get_by_username($username);
                $uid = $user['uid'];
                $_ENV['user']->refresh($uid);
                $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `openid`='$openid' WHERE `uid`=$uid");
                $sitename = $this->setting['site_name'];

                $this->credit($uid, $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分

                if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {

                    $activecode = md5(rand(10000, 50000));
                    $url = SITE_URL . 'index.php?user/checkemail/' . $this->user['uid'] . '/' . $activecode;
                    $message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
                    $v = md5("yanzhengask2email");
                    $v1 = md5("yanzhengask2time");
                    setcookie("emailsend");
                    setcookie("useremailcheck");
                    $expire1 = time() + 60; // 设置1分钟的有效期
                    setcookie("emailsend", $v1, $expire1); // 设置一个名字为var_name的cookie，并制定了有效期
                    $expire = time() + 86400; // 设置24小时的有效期
                    setcookie("useremailcheck", $v, $expire); // 设置一个名字为var_name的cookie，并制定了有效期
                    $_ENV['user']->update_emailandactive($email, $activecode, $this->user['uid']);
                    $_ENV['user']->refresh($this->user['uid'], 1);
                    sendmailto($email, "邮箱验证提醒-$sitename", $message, $this->user['username']);


                }
                //   $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分


                if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
                    exit("reguser_ok1");
                    // exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
                } else {
                    exit("reguser_ok");
                }

            } else {
                exit($msg);
            }


        }

        $uid = $_ENV['user']->adduserapi($username, $password, $email, $groupid);//插入model/user.class.php里adduserapi函数里
        $_ENV['user']->refresh($uid);
        $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `openid`='$openid' WHERE `uid`=$uid");
        $sitename = $this->setting['site_name'];

        $this->credit($uid, $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分

        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {

            $activecode = md5(rand(10000, 50000));
            $url = SITE_URL . 'index.php?user/checkemail/' . $this->user['uid'] . '/' . $activecode;
            $message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
            $v = md5("yanzhengask2email");
            $v1 = md5("yanzhengask2time");
            setcookie("emailsend");
            setcookie("useremailcheck");
            $expire1 = time() + 60; // 设置1分钟的有效期
            setcookie("emailsend", $v1, $expire1); // 设置一个名字为var_name的cookie，并制定了有效期
            $expire = time() + 86400; // 设置24小时的有效期
            setcookie("useremailcheck", $v, $expire); // 设置一个名字为var_name的cookie，并制定了有效期
            $_ENV['user']->update_emailandactive($email, $activecode, $this->user['uid']);
            $_ENV['user']->refresh($this->user['uid'], 1);
            sendmailto($email, "邮箱验证提醒-$sitename", $message, $this->user['username']);


        }
        //   $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分


        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            exit("reguser_ok1");
            // exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
        } else {
            exit("reguser_ok");
        }

    }

    //-----------------------------------用户注册录接口函数
    function onregisterapi()
    {
        // $this->check_apikey();//判断是否为正确的http请求
        if (trim($this->post['seccode_verify']) == '') {
            exit('验证码不能为空');
        }
        if (strtolower(trim($this->post['seccode_verify'])) != $_ENV['user']->get_code()) {
            exit('验证码错误');
        }
        if (!$this->setting['allow_register']) {
            exit("系统注册功能暂时处于关闭状态!");
        }
        if (isset($this->setting['max_register_num']) && $this->setting['max_register_num'] && !$_ENV['user']->is_allowed_register()) {
            exit("您的当前的IP已经超过当日最大注册数目，如有疑问请联系管理员!");

        }
        $username = strip_tags(trim($this->post['uname']));//用户注册名字，strip_tags第一层过滤
        $password = trim($this->post['upwd']);//用户注册密码
        $phone = trim($this->post['phone']);//用户注册密码
        $repassword = trim($this->post['rupwd']);//用户注册密码

        $this->checkdeepstring($username);
        $usernamecensor = $_ENV['user']->check_usernamecensor($username);

        if ($this->setting['smscanuse'] == 1) {

            if (!preg_match("/^1[34578]{1}\d{9}$/", $phone)) {


                exit("手机号码不正确");
            }
        }


        if (FALSE == $usernamecensor)
            exit('用户包含敏感词');
        $this->checkstring($password);
        $this->checkstring($repassword);
        $email = $this->post['email'];//用户邮箱

        $emailaccess = $_ENV['user']->check_emailaccess($email);
        if (FALSE == $emailaccess
        ) {
            exit("邮件地址被禁止注册");
        }


        $groupid = 7;//角色ID
        if ($repassword != $password) {
            exit("两次输入密码不一样");//用户密码不能为空
        }
        if ('' == $username || '' == $password) {
            exit("reguser_cant_null");//用户密码不能为空
        } else if (!preg_match("/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", $email)) {
            exit("regemail_Illegal");//注册邮箱不合法
        } else if ($this->db->fetch_total('user', " email='$email' ")) {
            exit("regemail_has_exits");//注册邮箱已经存在
        } else if (!$_ENV['user']->check_usernamecensor($username)) {
            exit("regemail_cant_use");//注册邮箱不能使用
        }

        $user = $_ENV['user']->get_by_username($username);
        $user && exit("reguser_has_exits");//注册用户已经存在


        //ucenter注册。
        if ($this->setting["ucenter_open"]) {
            $this->load('ucenter');
            $msg = $_ENV['ucenter']->ajaxregister($username, $password, $email);
            if ($msg == 'ok') {
                // $uid = $_ENV['user']->adduserapi($username, $password, $email,$groupid);//插入model/user.class.php里adduserapi函数里
                $user = $_ENV['user']->get_by_username($username);
                $uid = $user['uid'];
                $_ENV['user']->refresh($uid);
                $sitename = $this->setting['site_name'];
                $this->load("doing");
                $_ENV['doing']->add($uid, $username, 12, $uid, "欢迎您注册了$sitename");
                $this->credit($uid, $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分

                if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {

                    $activecode = md5(rand(10000, 50000));
                    $url = SITE_URL . 'index.php?user/checkemail/' . $this->user['uid'] . '/' . $activecode;
                    $message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
                    $v = md5("yanzhengask2email");
                    $v1 = md5("yanzhengask2time");
                    setcookie("emailsend");
                    setcookie("useremailcheck");
                    $expire1 = time() + 60; // 设置1分钟的有效期
                    setcookie("emailsend", $v1, $expire1); // 设置一个名字为var_name的cookie，并制定了有效期
                    $expire = time() + 86400; // 设置24小时的有效期
                    setcookie("useremailcheck", $v, $expire); // 设置一个名字为var_name的cookie，并制定了有效期
                    $_ENV['user']->update_emailandactive($email, $activecode, $this->user['uid']);
                    $_ENV['user']->refresh($this->user['uid'], 1);
                    sendmailto($email, "邮箱验证提醒-$sitename", $message, $this->user['username']);


                }
                //   $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分


                if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {

                    exit("reguser_ok1");
                    // exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
                } else {
                    exit("reguser_ok");
                }

            } else {
                exit($msg);
            }


        }
        $uid = 0;
        if ($this->setting['smscanuse'] == 1) {
            $userone = $_ENV['user']->get_by_phone($phone);
            if ($userone != null) {
                exit("手机号已存在!");
            }
        }
        if ($this->setting['smscanuse'] == 1) {
            $uid = $_ENV['user']->adduserapi($username, $password, $email, $groupid, 0, $phone);//插入model/user.class.php里adduserapi函数里
        } else {
            $uid = $_ENV['user']->adduserapi($username, $password, $email, $groupid);
        }

        $_ENV['user']->refresh($uid);
        $sitename = $this->setting['site_name'];
        $this->load("doing");
        $_ENV['doing']->add($uid, $username, 12, $uid, "欢迎您注册了$sitename");
        $this->credit($uid, $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分

        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {

            $activecode = md5(rand(10000, 50000));
            $url = SITE_URL . 'index.php?user/checkemail/' . $this->user['uid'] . '/' . $activecode;
            $message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
            $v = md5("yanzhengask2email");
            $v1 = md5("yanzhengask2time");
            setcookie("emailsend");
            setcookie("useremailcheck");
            $expire1 = time() + 60; // 设置1分钟的有效期
            setcookie("emailsend", $v1, $expire1); // 设置一个名字为var_name的cookie，并制定了有效期
            $expire = time() + 86400; // 设置24小时的有效期
            setcookie("useremailcheck", $v, $expire); // 设置一个名字为var_name的cookie，并制定了有效期
            $_ENV['user']->update_emailandactive($email, $activecode, $this->user['uid']);
            $_ENV['user']->refresh($this->user['uid'], 1);
            sendmailto($email, "邮箱验证提醒-$sitename", $message, $this->user['username']);


        }
        //   $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分


        if (isset($this->setting['register_on']) && $this->setting['register_on'] == '1') {
            exit("reguser_ok1");
            // exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
        } else {
            exit("reguser_ok");
        }

    }

    //检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
    function check_apikey()
    {

        if ($_SESSION["apikey"] == null || $this->post['apikey'] == null) {
            echo '非法操作!';
            exit();
        }
        if ($_SESSION["apikey"] != $this->post['apikey']) {
            echo '非法操作!';
            exit();
        }


    }
    //---------------------------用户登录接口函数
    /*
     * 
     * 
     * uname:用户名
     * 
     * upwd:用户密码
     */
    function onloginapi()
    {

        //$this->check_apikey();//判断是否为正确的http请求
//    	if($this->post['seccode_verify']==null||$this->post['seccode_verify']==''){
//    		 exit('验证码不能为空');	 
//    	}
        //if (strtolower(trim($this->post['seccode_verify'])) != $_ENV['user']->get_code()) {
        // exit('验证码错误');
        //}
        $username = trim($this->post['uname']); //用户名
        //判断是否包含特殊字符
        $orgpassword = trim($this->post['upwd']); //原始用户密码
        $password = md5(trim($this->post['upwd']));//用户密码

        $this->checkdeepstring($username);

        $this->checkstring($password);
        if ('' == $username || '' == $password) {
            exit('login_null');//登录参数为空
        }


        //ucenter登陆。
        if ($this->setting["ucenter_open"]) {
            $this->load('ucenter');
            $msg = $_ENV['ucenter']->ajaxlogin($username, $password);
            if ($msg == 'ok') {
                $user = $_ENV['user']->get_by_username($username);
                $cookietime = 2592000;
                $this->credit($this->user['uid'], $this->setting['credit1_login'], $this->setting['credit2_login']); //登录增加积分
                $_ENV['user']->refresh($user['uid'], 1, $cookietime);
                //exit('login_ok');//登录成功
                if($user['username']!='admin') {
                    if ($user['identity'] == 0 || $user['active'] != 1) {
                        exit('login_check');//身份邮箱验证
                    } else {
                        exit('login_ok');//登录成功
                    }
                }else{
                    exit('login_ok');//登录成功
                }
            } else {
                exit($msg);
            }
        }

        $user = $_ENV['user']->get_by_username($username);

        $cookietime = 2592000;
        if (is_array($user)) //登录用户存在
        {
            if (is_array($user) && ($password == $user['password'])) {
                if ($user['isblack'] == 1) {
                    exit('用户被列入网站黑名单!');//登录参数为空
                }


                $this->credit($this->user['uid'], $this->setting['credit1_login'], $this->setting['credit2_login']); //登录增加积分
                $_ENV['user']->refresh($user['uid'], 1, $cookietime);

                //exit('login_ok');//登录成功
                if($user['username']!='admin') {
                    if ($user['identity'] == 0 || $user['active'] != 1) {
                        exit('login_check');//身份邮箱验证
                    } else {
                        exit('login_ok');//登录成功
                    }
                }else{
                    exit('login_ok');//登录成功
                }
            }
        }
        //增加域网络验证功能  前面用户验证不通过；   不管是用户存在密码不对或者用户不存在；下面开始域认证
        $isadmin = strtolower($username) != 'admin';
        if ($isadmin == true) {
            $domainidentity = $this->domainidentityverify($username, $orgpassword);
            if ($domainidentity['verify_flag'] != 'success') {
                exit($domainidentity['ex_message']);
            }
        }
        $user = $_ENV['user']->get_by_username($username);

        if (is_array($user)) {
            if ($isadmin == true) { //域用户验证通过；但是密码不对应该是 ewn密码修改了；或者域密码修改了
                $_ENV['user']->uppass($user['uid'], $orgpassword);
                $_ENV['user']->refresh($user['uid'], 1, $cookietime);
                $user = $_ENV['user']->get_by_username($username);
                $this->credit($this->user['uid'], $this->setting['credit1_login'], $this->setting['credit2_login']); //登录增加积分
                //exit('login_ok');//登录成功
                if($user['username']!='admin') {
                    if ($user['identity'] == 0 || $user['active'] != 1) {
                        exit('login_check');//身份邮箱验证
                    } else {
                        exit('login_ok');//登录成功
                    }
                }else{
                    exit('login_ok');//登录成功
                }
            }
        } else {     //通过域认证 ；但是用户查不到信息应该是没有登录过ewen或者是用户被删掉了；重新添加登录信息
            $uid = $_ENV['user']->add($username, $orgpassword);
            $user = $_ENV['user']->get_by_username($username);
            $this->credit($this->user['uid'], $this->setting['credit1_login'], $this->setting['credit2_login']); //登录增加积分
            $_ENV['user']->refresh($user['uid'], 1, $cookietime);
            //exit('login_ok');//登录成功
            if($user['username']!='admin') {
                if ($user['identity'] == 0 || $user['active'] != 1) {
                    exit('login_check');//身份邮箱验证
                } else {
                    exit('login_ok');//登录成功
                }
            }else{
                exit('login_ok');//登录成功
            }
        }
        exit('login_user_or_pwd_error');//用户名或者密码错误
    }

    function domainidentityverify($user, $pwd)
    {
        $identity = array("displayname" => "", "cn" => "", "mail" => "", "sn" => "", "givenname" => "", "ex_message" => "", "verify_flag" => "fail");
        $host = "ldap://digiwin.biz";
        $domain_user_name = "digiwin\\" . $user;
        $dn = "OU=DIGIWIN,DC=digiwin,DC=biz";
        try {
            $ad = ldap_connect($host) or die ("无法连接到域网络digiwin.biz");
            if ($ad) {
                ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
                $bd = ldap_bind($ad, $domain_user_name, $pwd) or die ("域账户验证失败，请重试");
                $attrs = array("displayname", "cn", "mail", "sn", "givenname");
                $filter = "(sAMAccountName=" . $user . ")";
                $search = ldap_search($ad, $dn, $filter, $attrs) or die ("无法匹配用户信息");
                $entries = ldap_get_entries($ad, $search);
                if ($entries["count"] > 0) {
                    $identity["displayname"] = $entries[0]["displayname"][0];
                    $identity["cn"] = $entries[0]["cn"][0];
                    $identity["mail"] = $entries[0]["mail"][0];
                    $identity["sn"] = $entries[0]["sn"][0];
                    $identity["givenname"] = $entries[0]["givenname"][0];
                    $identity["ex_message"] = "域账户验证成功";
                    $identity["verify_flag"] = "success";
                } else {
                    $identity["ex_message"] = "无法匹配用户信息";
                }
            } else {
                $identity["ex_message"] = "无法连接到域网络digiwin.biz";
            }
        } catch (Exception $e) {
            $identity["ex_message"] = "域账户验证异常：" . $e->getMessage();
        }
        return $identity;
    }




















    //---------------------------绑定微信登录接口函数
    /*
     * 
     * 
     * uname:用户名
     * 
     * upwd:用户密码
     */
    function onbindloginapi()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (!strstr($useragent, 'MicroMessenger')) {
            exit("只能微信里绑定哟，您就别费劲想耍花招了");
        }
        $openid = trim($this->post['openid']); //openid
        $username = trim($this->post['uname']); //用户名
        //判断是否包含特殊字符

        $password = md5(trim($this->post['upwd']));//用户密码

        $this->checkdeepstring($username);

        $this->checkstring($password);
        if ('' == $username || '' == $password) {
            exit('login_null');//登录参数为空
        }


        //ucenter登录
        if ($this->setting["ucenter_open"]) {
            $this->load('ucenter');
            $msg = $_ENV['ucenter']->ajaxlogin($username, $password);
            if ($msg == 'ok') {
                $user = $_ENV['user']->get_by_username($username);
                $cookietime = 2592000;
                $this->credit($this->user['uid'], $this->setting['credit1_login'], $this->setting['credit2_login']); //登录增加积分
                $_ENV['user']->refresh($user['uid'], 1, $cookietime);
                $uid = $user['uid'];
                $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `openid`='$openid' WHERE `uid`=$uid");
                exit('login_ok');//登录成功
            } else {
                exit($msg);
            }


        }

        $user = $_ENV['user']->get_by_username($username);
        $cookietime = 2592000;
        if (is_array($user) && ($password == $user['password'])) {
            if ($user['isblack'] == 1) {
                exit('用户被列入网站黑名单!');//登录参数为空
            }
            $uid = $user['uid'];
            $this->credit($uid, $this->setting['credit1_login'], $this->setting['credit2_login']); //登录增加积分
            $_ENV['user']->refresh($uid, 1, $cookietime);
            $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `openid`='$openid' WHERE `uid`=$uid");
            exit('login_ok');//登录成功
        }
        exit('login_user_or_pwd_error');//用户名或者密码错误
    }

    //---------------------------------登录退出接口函数
    function onloginoutapi()
    {
        if (!isset($_SESSION)) {
            session_start();
        }


        session_destroy(); //清空以创建的所有SESSION
        $_ENV['user']->logout();
        exit('loginout_ok');//退出成功


    }

    //--------------------------修改密码接口
    function oneditpwdapi()
    {
        $this->check_apikey();//判断是否为正确的http请求
        $uid = intval(trim($this->post['uid'])); //用户名
        //判断是否包含特殊字符

        $newpwd = trim($this->post['newpwd']);//用户密码
        $_ENV['user']->uppass($uid, trim($newpwd));
        exit('editpwd_ok');//退出成功
    }

    //检查特殊字符函数
    function checkstring($str)
    {
        if (preg_match("/[\'<>{}]|\]|\[|\/|\\\|\"|\|/", $str)) {
            exit('用户名或者密码不能包含特殊字符');//参数不合法
        }

    }

    //检查特殊字符函数
    function checkdeepstring($str)
    {
        if (preg_match("/[\',:;*?~`!#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $str)) {
            exit('用户名或者密码不能包含特殊字符');//参数不合法
        }
    }


}

?>