<?php

/*
	[Tipask!] (C)2001-2009 Tipask Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: func.inc.php 2009-3-22 11:15  Cral $
*/

if(!defined('IN_ASK2')) {
	exit('Access Denied');
}

function show_msg($error_no, $error_msg = 'ok', $success = 1, $quit = TRUE) {
	if(VIEW_OFF) {
		$error_code = $success ? 0 : constant(strtoupper($error_no));
		$error_msg = empty($error_msg) ? $error_no : $error_msg;
		$error_msg = str_replace('"', '\"', $error_msg);
		$str = "<root>\n";
		$str .= "\t<error errorCode=\"$error_code\" errorMessage=\"$error_msg\" />\n";
		$str .= "</root>";
		echo $str;
		exit;
	} else {
		show_header();
		global $step;

		$title = lang($error_no);
		$comment = lang($error_no.'_comment', false);
		$errormsg = '';

		if($error_msg) {
			if(!empty($error_msg)) {
				foreach ((array)$error_msg as $k => $v) {
					if(is_numeric($k)) {
						$comment .= "<li><em class=\"red\">".lang($v)."</em></li>";
					}
				}
			}
		}

		if($step > 0) {
			echo "<div class=\"desc\"><b>$title</b><ul>$comment</ul>";
		} else {
			echo "</div><div class=\"main\" style=\"margin-top: -123px;\"><b>$title</b><ul style=\"line-height: 200%; margin-left: 30px;\">$comment</ul>";
		}

		if($quit) {
			echo '<br /><span class="red">'.lang('error_quit_msg').'</span><br /><br /><br />';
		}

		echo '<input type="button" onclick="history.back()" value="'.lang('click_to_back').'" /><br /><br /><br />';

		echo '</div>';

		$quit && show_footer();
	}
}

function check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre) {
	if(!function_exists('mysql_connect')) {
		show_msg('undefine_func', 'mysql_connect', 0);
	}
	if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
		$errno = mysql_errno();
		$error = mysql_error();
		if($errno == 1045) {
			show_msg('database_errno_1045', $error, 0);
		} elseif($errno == 2003) {
			show_msg('database_errno_2003', $error, 0);
		} else {
			show_msg('database_connect_error', $error, 0);
		}
	} else {
		if($query = mysql_query("SHOW TABLES FROM $dbname")) {
			while($row = mysql_fetch_row($query)) {
				if(preg_match("/^$tablepre/", $row[0])) {
					return false;
				}
			}
		}
	}
	return true;
}





function dirfile_check(&$dirfile_items) {
	foreach($dirfile_items as $key => $item) {
		$item_path = $item['path'];
		if($item['type'] == 'dir') {
			if(!dir_writeable(ASK2_ROOT.$item_path)) {
				if(is_dir(ASK2_ROOT.$item_path)) {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nodir';
				}
			} else {
				$dirfile_items[$key]['status'] = 1;
				$dirfile_items[$key]['current'] = '+r+w';
			}
		} else {
			if(file_exists(ASK2_ROOT.$item_path)) {
				if(is_writable(ASK2_ROOT.$item_path)) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				}
			} else {
				if(dir_writeable(dirname(ASK2_ROOT.$item_path))) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nofile';
				}
			}
		}
	}
}

function env_check(&$env_items) {
	foreach($env_items as $key => $item) {
		if($key == 'php') {
			$env_items[$key]['current'] = PHP_VERSION;
		} elseif($key == 'attachmentupload') {
			$env_items[$key]['current'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
		} elseif($key == 'gdversion') {
			$tmp = function_exists('gd_info') ? gd_info() : array();
			$env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
			unset($tmp);
		} elseif($key == 'diskspace') {
			if(function_exists('disk_free_space')) {
				$env_items[$key]['current'] = floor(disk_free_space(ASK2_ROOT) / (1024*1024)).'M';
			} else {
				$env_items[$key]['current'] = 'unknow';
			}
		} elseif(isset($item['c'])) {
			$env_items[$key]['current'] = constant($item['c']);
		}

		$env_items[$key]['status'] = 1;
		if($item['r'] != 'notset' && strcmp($env_items[$key]['current'], $item['r']) < 0) {
			$env_items[$key]['status'] = 0;
		}
	}
}

function function_check(&$func_items) {
	foreach($func_items as $item) {
		function_exists($item) or show_msg('undefine_func', $item, 0);
	}
}

function show_env_result(&$env_items, &$dirfile_items, &$func_items) {

	$env_str = $file_str = $dir_str = $func_str = '';
	$error_code = 0;

	foreach($env_items as $key => $item) {
		if($key == 'php' && strcmp($item['current'], $item['r']) < 0) {
			show_msg('php_version_too_low', $item['current'], 0);
		}
		$status = 1;
		if($item['r'] != 'notset') {
			if(intval($item['current']) && intval($item['r'])) {
				if(intval($item['current']) < intval($item['r'])) {
					$status = 0;
					$error_code = ENV_CHECK_ERROR;
				}
			} else {
				if(strcmp($item['current'], $item['r']) < 0) {
					$status = 0;
					$error_code = ENV_CHECK_ERROR;
				}
			}
		}
		if(VIEW_OFF) {
			$env_str .= "\t\t<runCondition name=\"$key\" status=\"$status\" Require=\"$item[r]\" Best=\"$item[b]\" Current=\"$item[current]\"/>\n";
		} else {
			$env_str .= "<tr>\n";
			$env_str .= "<td>".lang($key)."</td>\n";
			$env_str .= "<td class=\"padleft\">".lang($item['r'])."</td>\n";
			$env_str .= "<td class=\"padleft\">".lang($item['b'])."</td>\n";
			$env_str .= ($status ? "<td class=\"w pdleft1\">" : "<td class=\"nw pdleft1\">").$item['current']."</td>\n";
			$env_str .= "</tr>\n";
		}
	}

	foreach($dirfile_items as $key => $item) {
		$tagname = $item['type'] == 'file' ? 'File' : 'Dir';
		$variable = $item['type'].'_str';

		if(VIEW_OFF) {
			if($item['status'] == 0) {
				$error_code = ENV_CHECK_ERROR;
			}
			$$variable .= "\t\t\t<File name=\"$item[path]\" status=\"$item[status]\" requirePermisson=\"+r+w\" currentPermisson=\"$item[current]\" />\n";
		} else {
			$$variable .= "<tr>\n";
			$$variable .= "<td>$item[path]</td><td class=\"w pdleft1\">".lang('writeable')."</td>\n";
			if($item['status'] == 1) {
				$$variable .= "<td class=\"w pdleft1\">".lang('writeable')."</td>\n";
			} elseif($item['status'] == -1) {
				$error_code = ENV_CHECK_ERROR;
				$$variable .= "<td class=\"nw pdleft1\">".lang('nodir')."</td>\n";
			} else {
				$error_code = ENV_CHECK_ERROR;
				$$variable .= "<td class=\"nw pdleft1\">".lang('unwriteable')."</td>\n";
			}
			$$variable .= "</tr>\n";
		}
	}

	if(VIEW_OFF) {

		$str = "<root>\n";
		$str .= "\t<runConditions>\n";
		$str .= $env_str;
		$str .= "\t</runConditions>\n";
		$str .= "\t<FileDirs>\n";
		$str .= "\t\t<Dirs>\n";
		$str .= $dir_str;
		$str .= "\t\t</Dirs>\n";
		$str .= "\t\t<Files>\n";
		$str .= $file_str;
		$str .= "\t\t</Files>\n";
		$str .= "\t</FileDirs>\n";
		$str .= "\t<error errorCode=\"$error_code\" errorMessage=\"\" />\n";
		$str .= "</root>";
		echo $str;
		exit;

	} else {

		show_header();

		echo "<h2 class=\"title\">".lang('env_check')."</h2>\n";
		echo "<table class=\"tb table\" style=\"margin:20px 0 20px 55px;\">\n";
		echo "<tr>\n";
		echo "\t<th>".lang('project')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('ask_required')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('ask_best')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('curr_server')."</th>\n";
		echo "</tr>\n";
		echo $env_str;
		echo "</table>\n";

		echo "<h2 class=\"title\">".lang('priv_check')."</h2>\n";
		echo "<table class=\"tb table\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
		echo "\t<tr>\n";
		echo "\t<th>".lang('step1_file')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('step1_need_status')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('step1_status')."</th>\n";
		echo "</tr>\n";
		echo $file_str;
		echo $dir_str;
		echo "</table>\n";

		foreach($func_items as $item) {
			$status = function_exists($item);
			$func_str .= "<tr>\n";
			$func_str .= "<td>$item()</td>\n";
			if($status) {
				$func_str .= "<td class=\"w pdleft1\">".lang('supportted')."</td>\n";
				$func_str .= "<td class=\"padleft\">".lang('none')."</td>\n";
			} else {
				$error_code = ENV_CHECK_ERROR;
				$func_str .= "<td class=\"nw pdleft1\">".lang('unsupportted')."</td>\n";
				$func_str .= "<td><font color=\"red\">".lang('advice_'.$item)."</font></td>\n";
			}
		}
		echo "<h2 class=\"title\">".lang('func_depend')."</h2>\n";
		echo "<table class=\"tb table\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
		echo "<tr>\n";
		echo "\t<th>".lang('func_name')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('check_result')."</th>\n";
		echo "\t<th class=\"padleft\">".lang('suggestion')."</th>\n";
		echo "</tr>\n";
		echo $func_str;
		echo "</table>\n";

		show_next_step(2, $error_code);

		show_footer();

	}

}

function show_next_step($step, $error_code) {
	echo "<form action=\"index.php\" method=\"get\">\n";
	echo "<input type=\"hidden\" name=\"step\" value=\"$step\" />";
	if(isset($GLOBALS['hidden'])) {
		echo $GLOBALS['hidden'];
	}
	if($error_code == 0) {
		$nextstep = "<input class=\"btn btn-default\" type=\"button\" onclick=\"history.back();\" value=\"".lang('old_step')."\"><input class=\"btn btn-default\" type=\"submit\" value=\"".lang('new_step')."\">\n";
	} else {
		$nextstep = "<input class=\"btn btn-default\" type=\"button\" disabled=\"disabled\" value=\"".lang('not_continue')."\">\n";
	}
	echo "<div class=\"btnbox marginbot\">".$nextstep."</div>\n";
	echo "</form>\n";
}

function show_form(&$form_items, $error_msg, $remote=0) {

	global $step;

	if(empty($form_items) || !is_array($form_items)) {
		return;
	}

	show_header();
	if($remote)
		show_setting('remotestart');
	else 
		show_setting('start');

	show_setting('hidden', 'step', $step);
	$is_first = 1;
	foreach($form_items as $key => $items) {
		global ${'error_'.$key};
		if($is_first == 0) {
			echo '</table>';
		}

		if(!${'error_'.$key}) {
			show_tips('tips_'.$key);
		} else {
			show_error('tips_admin_config', ${'error_'.$key});
		}

		if($is_first == 0) {
			echo '<table class="table">';
		}

		foreach($items as $k => $v) {
			global $$k;
			if(!empty($error_msg)) {
				$value = isset($_POST[$key][$k]) ? $_POST[$key][$k] : '';
			} else {
				if(isset($v['value']) && is_array($v['value'])) {
					if($v['value']['type'] == 'constant') {
						$value = defined($v['value']['var']) ? constant($v['value']['var']) : '';
					} elseif($v['value']['type'] == 'var') {
						$value = $GLOBALS[$v['value']['var']];
					} elseif($v['value']['type'] == 'string') {
						$value = $v['value']['var'];
					}
				} else {
					$value = '';
				}
			}
			if($v['type'] == 'checkbox') {
				$value = '1';
			}
			show_setting($k, $key.'['.$k.']', $value, $v['type'], isset($error_msg[$key][$k]) ? $key.'_'.$k.'_invalid' : '');
		}

		if($is_first) {
			$is_first = 0;
		}
	}
	if($remote)
		show_setting('', 'submitname', 'remote_submitname', 'submit');
	else 
		show_setting('', 'submitname', 'new_step', 'submit');
	
	show_setting('end');
	show_footer();
}

function show_license() {
	global $self, $uchidden, $step;
	$next = $step + 1;
	if(VIEW_OFF) {

		show_msg('license_contents', lang('license'), 1);

	} else {

		show_header();

		$license = str_replace('  ', '&nbsp; ', lang('license'));
		$lang_agreement_yes = lang('agreement_yes');
		$lang_agreement_no = lang('agreement_no');
		echo <<<EOT
</div>
<div class="main" style="margin-top:-123px;">
	<div class="licenseblock">$license</div>
	<div class="btnbox marginbot">
		<form method="get" action="index.php">
		<input type="hidden" name="step" value="$next">
		$uchidden
		<input class="btn btn-default" type="submit" name="submit" value="{$lang_agreement_yes}" style="padding: 2px">&nbsp;
		<input class="btn btn-default" type="button" name="exit" value="{$lang_agreement_no}" style="padding: 2px" onclick="javascript: window.close(); return false;">
		</form>
	</div>
EOT;

		show_footer();

	}
}

if(!function_exists('file_put_contents')) {
	function file_put_contents($filename, $s) {
		$fp = @fopen($filename, 'w');
		@fwrite($fp, $s);
		@fclose($fp);
		return TRUE;
	}
}

function createtable($sql) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
	(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=".DBCHARSET : " TYPE=$type");
}

function dir_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

function dir_clear($dir) {
	global $lang;
	$directory = dir($dir);
	while($entry = $directory->read()) {
		$filename = $dir.'/'.$entry;
		if(is_file($filename)) {
			@unlink($filename);
		}
	}
	$directory->close();
	@touch($dir.'/index.htm');
}

function show_header() {
	define('SHOW_HEADER', TRUE);
	global $step;
	$version = ASK2_VERSION;
	$release = ASK2_RELEASE;
	$name=SOFT_NAME;
	$install_lang = lang(INSTALL_LANG);
	$title = lang('title_install');
	$charset = CHARSET;
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=$charset" />
<title>$title</title>
<link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="../static/css/dist/css/zui.min.css" type="text/css" media="all" />
<script type="text/javascript">
	function $(id) {
		return document.getElementById(id);
	}

	function showmessage(message) {
		$('notice').value += message + "\\r\\n";
	}
</script>
<meta content="Ask2 Inc." name="Copyright" />
</head>
<div>
</div>

<div class="container">
	<div class="header" >
		<h1>$title</h1>
		<span style="position:relative;top:-10px;">V$version $install_lang $release</span>
EOT;

	$step > 0 && show_step($step);
}

function show_footer($quit = true) {

	echo <<<EOT
		<div class="footer">&copy;2016 - 2025 <a href="http://www.ask2.cn/" target="_blank">ask2问答系统</a> Inc.</div>
	</div>
</div>
</body>
</html>
EOT;
	$quit && exit();
}

function loginit($logfile) {
	global $lang;
	showjsmessage($lang['init_log'].' '.$logfile);
	if($fp = @fopen('./data/logs/'.$logfile.'.php', 'w')) {
		fwrite($fp, '<'.'?PHP exit(); ?'.">\n");
		fclose($fp);
	}
}

function showjsmessage($message) {
	if(VIEW_OFF) return;
	echo '<script type="text/javascript">showmessage(\''.addslashes($message).' \');</script>'."\r\n";
	flush();
//	ob_flush();
}

function random($length) {
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

function redirect($url) {

	echo "<script>".
	"function redirect() {window.location.replace('$url');}\n".
	"setTimeout('redirect();', 0);\n".
	"</script>";
	exit();

}

function get_onlineip() {
	$onlineip = '';
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	return $onlineip;
}

function config_edit() {
	extract($GLOBALS, EXTR_SKIP);
	$config = "<?php \r\ndefine('DB_HOST', '$dbhost');\r\n";
	$config .= "define('DB_USER', '$dbuser');\r\n";
	$config .= "define('DB_PW', '$dbpw');\r\n";
	$config .= "define('DB_NAME', '$dbname');\r\n";
	$config .= "define('DB_CHARSET', '".DBCHARSET."');\r\n";
	$config .= "define('DB_TABLEPRE', '$tablepre');\r\n";
	$config .= "define('DB_CONNECT', 0);\r\n";
	$config .= "define('ASK2_CHARSET', '".CHARSET."');\r\n";
	$config .= "define('ASK2_VERSION', '".ASK2_VERSION."');\r\n";
	$config .= "define('ASK2_RELEASE', '".ASK2_RELEASE."');\r\n";
	$fp = fopen(CONFIG, 'w');
	fwrite($fp, $config);
	fclose($fp);
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;	// 随机密钥长度 取值 0-32;
				// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
				// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
				// 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function generate_key() {
	$random = random(32);
	$info = md5($_SERVER['SERVER_SOFTWARE'].$_SERVER['SERVER_NAME'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_PORT'].$_SERVER['HTTP_USER_AGENT'].time());
	$return = '';
	for($i=0; $i<64; $i++) {
		$p = intval($i/2);
		$return[$i] = $i % 2 ? $random[$p] : $info[$p];
	}
	return implode('', $return);
}

function show_install() {
	global  $step;
	$next = $step+1;
	if(VIEW_OFF) return;
?>
<script type="text/javascript">
function showmessage(message) {
	document.getElementById('notice').value += message + "\r\n";
}
function initinput() {
	window.location='<?php echo 'index.php?step='.($GLOBALS['step']);?>';
}
</script>
	<div class="main">
		<form method="POST" action="index.php">
		<input type="hidden" name="step" value="<?=$next;?>">
		<div class="btnbox"><textarea name="notice" style="width: 80%;"  readonly="readonly" id="notice"></textarea></div>
		<div class="btnbox marginbot">
	    <input class="btn btn-default" type="submit" name="submit" value="<?=lang('install_in_processed')?>" disabled style="height: 25" id="step3">
	</div>
<?php
}

function runquery($sql) {
	global $lang, $tablepre, $db;

	if(!isset($sql) || empty($sql)) return;

	$sql = str_replace("\r", "\n", str_replace(' '.ORIG_TABLEPRE, ' '.$tablepre, $sql));
	$ret = array();
	$num = 0;

	foreach(explode(";\n", trim($sql)) as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);

	foreach($ret as $query) {
		$query = trim($query);
		if($query) {

			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
				showjsmessage(lang('create_table').' '.$name.' ... '.lang('succeed'));
				$db->query(createtable($query));
			} else {
				$db->query($query);
			}

		}
	}

}

function charcovert($string) {
	if(!get_magic_quotes_gpc()) {
		$string = str_replace('\'', '\\\'', $string);
	} else {
		$string = str_replace('\"', '"', $string);
	}
	return $string;
}

function insertconfig($s, $find, $replace) {
	if(preg_match($find, $s)) {
		$s = preg_replace($find, $replace, $s);
	} else {
		$s .= "\r\n".$replace;
	}
	return $s;
}

function getgpc($k, $t='GP') {
	$t = strtoupper($t);
	switch($t) {
		case 'GP' : isset($_POST[$k]) ? $var = &$_POST : $var = &$_GET; break;
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	return isset($var[$k]) ? $var[$k] : '';
}

function var_to_hidden($k, $v) {
	return "<input type=\"hidden\" name=\"$k\" value=\"$v\" />\n";
}

function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].(isset($matches['query']) && $matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;

	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}

function check_env() {

	global $lang, $attachdir;

	$errors = array('quit' => false);
	$quit = false;

	if(!function_exists('mysql_connect')) {
		$errors[] = 'mysql_unsupport';
		$quit = true;
	}
    if(!function_exists('imagecreatetruecolor')) {
		$errors[] = 'gd_unsupport';
		$quit = true;
	}
	if(PHP_VERSION < '4.3') {
		$errors[] = 'php_version_430';
		$quit = true;
	}

	if(!file_exists(DISCUZ_ROOT.'./config.php')) {
		$errors[] = 'config_nonexistence';
		$quit = true;
	} elseif(!is_writeable(DISCUZ_ROOT.'./config.php')) {
		$errors[] = 'config_unwriteable';
		$quit = true;
	}

	$checkdirarray = array(
		'attach' => $attachdir,
		'data' => './data',
	'upload' => './data/upload',
	'editor' => './data/editor',
		'cache' => './data/cache',
		'view' => './data/view',
		
		'log' => './data/logs'
	);

	foreach($checkdirarray as $key => $dir) {
		if(!dir_writeable(DISCUZ_ROOT.$dir)) {
			$langkey = $key.'_unwriteable';
			$errors[] = $key.'_unwriteable';
			if(!in_array($key, array('ftemplate'))) {
				$quit = TRUE;
			}
		}
	}

	$errors['quit'] = $quit;
	return $errors;

}

function show_error($type, $errors = '', $quit = false) {

	global $lang, $step;

	$title = lang($type);
	$comment = lang($type.'_comment', false);
	$errormsg = '';
	if($errors) {
		if(!empty($errors)) {
			foreach ((array)$errors as $k => $v) {
				if(is_numeric($k)) {
					$comment .= "<li><em class=\"red\">".lang($v)."</em></li>";
				}
			}
		}
	}

	if($step > 0) {
		echo "<div class=\"desc\"><b>$title</b><ul>$comment</ul>";
	} else {
		echo "</div><div class=\"main\" style=\"margin-top: -123px;\"><b>$title</b><ul style=\"line-height: 200%; margin-left: 30px;\">$comment</ul>";
	}

	if($quit) {
		echo '<br /><span class="red">'.$lang['error_quit_msg'].'</span><br /><br /><br /><br /><br /><br />';
	}

	echo '</div>';

	$quit && show_footer();
}

function show_tips($tip, $title = '', $comment = '', $style = 1) {
	global $lang;
	$title = empty($title) ? lang($tip) : $title;
	$comment = empty($comment) ? lang($tip.'_comment', FALSE) : $comment;
	if($style) {
		echo "<div class=\"desc\"><b>$title</b>";
	} else {
		echo "</div><div class=\"main\" style=\"margin-top: -123px;\">$title<div class=\"desc1 marginbot\"><ul>";
	}
	$comment && print('<br>'.$comment);
	echo "</div>";
}

function show_setting($setname, $varname = '', $value = '', $type = 'text|password|checkbox', $error = '') {
	if($setname == 'start') {
		echo "<form method=\"post\" class=\"form-horizontal\" action=\"index.php\">\n<table class=\"table\">\n";
		return;
	}elseif($setname == 'remotestart'){
		echo "<form method=\"post\" action=\"http://localhost/tipcounter/index.php?siteinfo/add\">\n<table class=\"table\">\n";
		return;
	} elseif($setname == 'end') {
		echo "\n</table>\n</form>\n";
		return;
	} elseif($setname == 'hidden') {
		echo "<input class=\"form-control\" type=\"hidden\" name=\"$varname\" value=\"$value\">\n";
		return;
	}

	echo "\n".'<tr><th class="tbopt'.($error ? ' red' : '').'">&nbsp;'.(empty($setname) ? '' : lang($setname).':')."</th>\n<td>";
	if($type == 'text' || $type == 'password') {
		$value = htmlspecialchars($value);
		if($varname=='dbinfo[tablepre]'){
			echo "<input class=\"form-control\" readonly=\"true\" type=\"$type\" name=\"$varname\" value=\"$value\" size=\"35\" class=\"txt\">";
		}else{
			echo "<input class=\"form-control\"  type=\"$type\" name=\"$varname\" value=\"$value\" size=\"35\" class=\"txt\">";
		}
		
	} elseif($type == 'submit') {
		$value = empty($value) ? 'next_step' : $value;
		echo "<input type=\"submit\" name=\"$varname\" value=\"".lang($value)."\" class=\"btn btn-default\">\n";
	} elseif($type == 'checkbox') {
		if(!is_array($varname) && !is_array($value)) {
			echo'<label><input class=\"form-control\"  type="checkbox" name="'.$varname.'" value="'.$value."\" style=\"border: 0\">".lang($setname.'_check_label')."</label>\n";
		}
	} else {
		echo $value;
	}

	echo "</td>\n<td>&nbsp;";
	if($error) {
		$comment = '<span class="red">'.(is_string($error) ? lang($error) : lang($setname.'_error')).'</span>';
	} else {
		$comment = lang($setname.'_comment', false);
	}
	echo "$comment</td>\n</tr>\n";
	return true;
}

function show_step($step) {

	global $method;

	$laststep = 4;
	$title = lang('step_'.$method.'_title');
	$comment = lang('step_'.$method.'_desc');

	$stepclass = array();
	for($i = 1; $i <= $laststep; $i++) {
		$stepclass[$i] = $i == $step ? 'current' : ($i < $step ? '' : 'unactivated');
	}
	$stepclass[$laststep] .= ' last';

	echo <<<EOT
	<div class="setup step{$step}">
		<h2>$title</h2>
		<p>$comment</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="$stepclass[1]">1</li>
			<li class="$stepclass[2]">2</li>
			<li class="$stepclass[3]">3</li>
			<li class="$stepclass[4]">4</li>
		</ul>
		<div class="stepstatbg stepstat1"></div>
	</div>
</div>
<div class="main">
EOT;

}

function show_siteinfo(){
	
}
function lang($lang_key, $force = true) {
	return isset($GLOBALS['lang'][$lang_key]) ? $GLOBALS['lang'][$lang_key] : ($force ? $lang_key : '');
}

function check_adminuser($username, $password, $email) {

	@include ASK2_ROOT.'./config.php';
	include ASK2_ROOT.'./uc_client/client.php';
	$error = '';
	$uid = uc_user_register($username, $password, $email);
	/*
	-1 : 用户名不合法
	-2 : 包含不允许注册的词语
	-3 : 用户名已经存在
	-4 : email 格式有误
	-5 : email 不允许注册
	-6 : 该 email 已经被注册
	>1 : 表示成功，数值为 UID
	*/
	if($uid == -1 || $uid == -2) {
		$error = 'admin_username_invalid';
	} elseif($uid == -4 || $uid == -5 || $uid == -6) {
		$error = 'admin_email_invalid';
	} elseif($uid == -3) {
		$ucresult = uc_user_login($username, $password);
		list($tmp['uid'], $tmp['username'], $tmp['password'], $tmp['email']) = uc_addslashes($ucresult);
		$ucresult = $tmp;
		if($ucresult['uid'] <= 0) {
			$error = 'admin_exist_password_error';
		} else {
			$uid = $ucresult['uid'];
			$email = $ucresult['email'];
			$password = $ucresult['password'];
		}
	}

	if(!$error && $uid > 0) {
		$password = md5($password);
		uc_user_addprotected($username, '');
	} else {
		$uid = 0;
		$error = empty($error) ? 'error_unknow_type' : $error;
	}
	return array('uid' => $uid, 'username' => $username, 'password' => $password, 'email' => $email, 'error' => $error);
}

	/*http请求*/
	function topen($url, $timeout = 15, $post = '', $cookie = '', $limit = 0, $ip = '',  $block = TRUE) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;

		if($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			//$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= 'Content-Length: '.strlen($post)."\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
			$out .= $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			//$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if(!$fp) {
			return '';
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if(!$status['timed_out']) {
				while (!feof($fp)) {
					if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
						break;
					}
				}

				$stop = false;
				while(!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
					$return .= $data;
					if($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}
			@fclose($fp);
			return $return;
		}
	}

 