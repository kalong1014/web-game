<?php
define('IN_YYJIA', TRUE);
error_reporting(0);
session_start();
$_SGLOBAL = $_SCONFIG = $_SBLOCK = array();

//程序目录
define('S_ROOT', substr(dirname(__FILE__), 0, -7));

//获取时间
$_SGLOBAL['timestamp'] = time();

include_once(S_ROOT.'./source/function_common.php');
if(!@include_once(S_ROOT.'./config.php')) {
	@include_once(S_ROOT.'./config.new.php');
	show_msg('您需要首先将程序根目录下面的 "config.new.php" 文件重命名为 "config.php"', 999);
}
//GPC过滤
if(!(get_magic_quotes_gpc())) {
	$_GET = saddslashes($_GET);
	$_POST = saddslashes($_POST);
}

//启用GIP
if ($_SC['gzipcompress'] && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}

$formhash = formhash();

$theurl = 'index.php';
$sqlfile = S_ROOT.'./data/install.sql';
if(!file_exists($sqlfile)) {
	show_msg('请上传最新的 install.sql 数据库结构文件到程序的 ./data 目录下面，再重新运行本程序', 999);
}
$configfile = S_ROOT.'./config.php';

//变量
$domainhost=$_SERVER['HTTP_HOST'];
$siteurl=$domainhost;
$pattern='/^(.*)\.[A-Za-z]+$/';
$cookiedomain=preg_match($pattern,$domainhost,$cookiedomain);

if($cookiedomain==""){
	$cookiedomain="";
}else{
	$arr=explode(".",$domainhost);
	$cookiedomain=".".$arr[count($arr)-2].".".$arr[count($arr)-1];
}

$step = empty($_GET['step'])?0:intval($_GET['step']);
$action = empty($_GET['action'])?'':trim($_GET['action']);
$nowarr = array('','','','','','','');

$lockfile = S_ROOT.'./data/install.lock';
if(file_exists($lockfile)) {
	show_msg('警告!您已经安装过YYJia<br>
		为了保证数据安全，请立即手动删除 install/index.php 文件<br>
		如果您想重新安装YYJia，请删除 data/install.lock 文件,再运行安装文件');
}

//检查config是否可写
if(!@$fp = fopen($configfile, 'a')) {
	show_msg("文件 $configfile 读写权限设置错误，请设置为可写，再执行安装程序");
} else {
	@fclose($fp);
}

//提交处理
if($_POST[sqsubmit]){
		
		$starttime=time();
		$wkey=$_POST['wkey'];
		$_SESSION[wkey]=$wkey;
		$domain=$_SERVER['HTTP_HOST'];
		$protype=7;
		$url="http://www.yyjia.com/sqapi.php?ac=shouquan&wkey=".$wkey."&domain=".$domain."&starttime=".$starttime."&protype=".$protype;
		$contents=file_get_contents($url);
		$content=json_decode($contents,true);
		$_SESSION[siteid]=$content[id];
	if($content!=0){
		$_SESSION['pass']='ture';
		show_msg('授权码匹配成功，进入下一步操作', ($step+1), 1);
	}else{
		$_SESSION['pass']='ture';
		show_msg('189提醒：破解成功，进入下一步操作', ($step+1), 1);
	}
	

}elseif(!empty($_POST['sqlsubmit'])) {
	$step = 2;
	
	//先写入config文件
	
	$configcontent = sreadfile($configfile);
	$keys = array_keys($_POST['db']);
	foreach ($keys as $value) {
		$configcontent = preg_replace("/[$]\_SC\[\'".$value."\'\](\s*)\=\s*[\"'].*?[\"']/is", "\$_SC['".$value."']\\1= '".$_POST['db'][$value]."'", $configcontent);
	}
	if(!$fp = fopen($configfile, 'w')) {
		show_msg("文件 $configfile 读写权限设置错误，请设置为可写后，再执行安装程序");
	}
	fwrite($fp, trim($configcontent));
	fclose($fp);


	//判断YYJia数据库
	$havedata = false;
	if(!@mysql_connect($_POST['db']['dbhost'], $_POST['db']['dbuser'], $_POST['db']['dbpw'])) {
		showmessage('数据库连接信息填写错误，请确认');
	}
	if(mysql_select_db($_POST['db']['dbname'])) {	
		if(mysql_query("SELECT COUNT(*) FROM {$_POST['db']['tablepre']}")) {
			$havedata = true;
		}
	} else {
		if(!mysql_query("CREATE DATABASE `".$_POST['db']['dbname']."`")) {
			show_msg('设定的YYJia数据库无权限操作，请先手工操作后，再执行安装程序');
		}
	}

	if($havedata) {
		show_msg('危险!指定的YYJia数据库已有数据，如果继续将会清空原有数据!', ($step+1));
	} else {
		show_msg('数据库配置成功，进入下一步操作', ($step+1), 1);
	}

} elseif ($_POST['opensubmit']) {

	//设置管理员
	include_once(S_ROOT.'./data/data_config.php');
	$step = 5;
	dbconnect();

	//同步获取用户源
	$_SGLOBAL['timestamp'] = time();


	//更新本地用户库
	inserttable('member', $setarr, 0, true);

	//清理在线session
	insertsession($setarr);

}

if(empty($step)) {

	show_header();

	//检查权限设置
	$checkok = true;
	$perms = array();
	if(!checkfdperm(S_ROOT.'./config.php', 1)) {
		$perms['config'] = '失败';
		$checkok = false;
	} else {
		$perms['config'] = 'OK';
	}
	if(!checkfdperm(S_ROOT.'./attachment/')) {
		$perms['attachment'] = '失败';
		$checkok = false;
	} else {
		$perms['attachment'] = 'OK';
	}
	if(!checkfdperm(S_ROOT.'./data/')) {
		$perms['data'] = '失败';
		$checkok = false;
	} else {
		$perms['data'] = 'OK';
	}
	//安装阅读
	print<<<END
	<script type="text/javascript">
	function readme() {
		var tbl_readme = document.getElementById('tbl_readme');
		if(tbl_readme.style.display == '') {
			tbl_readme.style.display = 'none';
		} else {
			tbl_readme.style.display = '';
		}
	}
	</script>
	<table class="showtable">
	<tr><td>
	<strong>欢迎您使用YYJia</strong><br>
	感谢您选择189手游，希望我们的努力能为您快速搭建APP网站。189手游的云数据中心，囊括数百万计应用，实时更新。还解决了数据、带宽和存储空间等后顾之忧，让站长有更多的时间专注于内容优化和网站推广。
	<br><a href="javascript:;" onclick="readme()"><strong>请先认真阅读我们的软件使用授权协议</strong></a>
	</td></tr>
	</table>

	<table>
	</td></tr>
	<tr><td>
	<strong>文件/目录权限设置</strong><br>
	在您执行安装文件进行安装之前，先要设置相关的目录属性，以便数据文件可以被程序正确读/写/删/创建子目录。<br>
	推荐您这样做：<br>使用 FTP 软件登录您的服务器，将服务器上以下目录、以及该目录下面的所有文件的属性设置为777，win主机请设置internet来宾帐户可读写属性<br>
	<table class="datatable">
	<tr style="font-weight:bold;"><td>名称</td><td>所需权限属性</td><td>说明</td><td>检测结果</td></tr>
	<tr><td><strong>./config.php</strong></td><td>读/写</td><td>系统配置文件</td><td>$perms[config]</td></tr>
	<tr><td><strong>./attachment/</strong> (包括本目录、子目录和文件)</td><td>读/写/删</td><td>附件目录</td><td>$perms[attachment]</td></tr>
	<tr><td><strong>./data/</strong> (包括本目录、子目录和文件)</td><td>读/写/删</td><td>站点数据目录</td><td>$perms[data]</td></tr>
	</table>
	</td></tr>
	</table>
END;

	if(!$checkok) {
		echo "<table><tr><td><b>出现问题</b>:<br>系统检测到以上目录或文件权限没有正确设置<br>强烈建议正常设置权限后再刷新本页面以便继续安装<br>否则系统可能会出现无法预料的问题 [<a href=\"$theurl?step=1\">强制继续</a>]</td></tr></table>";
	} else {
		$ucapi = empty($_POST['ucapi'])?'/':$_POST['ucapi'];
		$ucfounderpw = empty($_POST['ucfounderpw'])?'':$_POST['ucfounderpw'];
		print <<<END
		<form id="theform" method="post" action="$theurl?step=1">
			<table class=button>
				<tr>
					<td><input type="submit" id="startsubmit" name="startsubmit" value="接受授权协议，开始安装YYJia"></td>
				</tr>
			</table>
			<input type="hidden" name="ucapi" value="$ucapi" />
			<input type="hidden" name="ucfounderpw" value="$ucfounderpw" />
			<input type="hidden" name="formhash" value="$formhash">
		</form>
END;
	}

	print<<<END
	<table id="tbl_readme" style="display:none;" class="showtable">
	<tr>
	<td><strong>请您务必仔细阅读下面的许可协议:</strong> </td></tr>
	<tr>
	<td>
	<div>中文版授权协议 适用于中文用户
	</p><p>感谢您选择189手游，希望我们的努力能为您快速搭建APP网站。189手游的云数据中心，囊括数百万计应用，实时更新。还解决了数据、带宽和存储空间等后顾之忧，让站长有更多的时间专注于内容优化和网站推广。
	</p><p>YYJia 著作权已在中华人民共和国国家版权局注册，著作权受到法律和国际公约保护。使用者：无论个人或组织、盈利与否、用途如何
	（包括以学习和研究为目的），均需仔细阅读本协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 YYJia 软件。
	</p>
	<ul type=i>
	<li><b>协议许可的权利</b>
	<ul type=1>
	<li>您可以在协议规定的约束和限制范围内修改 YYJia 源代码(如果被提供的话)或界面风格以适应您的网站要求。
	<li>您拥有使用本软件构建的站点中全部会员资料、文章及相关信息的所有权，并独立承担与文章内容的相关法律义务。
	<li>获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，
	自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见
	将被作为首要考虑，但没有一定被采纳的承诺或保证。 </li></ul>
	<p></p>
	<li><b>协议规定的约束和限制</b>
	<ul type=1>
	<li>未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆http://www.yyjia.com参考相关说明。
	<li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。
	<li>禁止在 YYJia 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。
	<li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。 </li></ul>
	<p></p>
	<li><b>有限担保和免责声明</b>
	<ul type=1>
	<li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。
	<li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，
	也不承担任何因使用本软件而产生问题的相关责任。
	</ul></li></ul>
	<p>有关 YYJia 最终用户授权协议、商业授权与技术服务的详细内容，均由 YYJia 官方网站独家提供。
	<p>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 YYJia，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。 </p></div>
	</td></tr>
	</table>
END;

	show_footer();

}elseif($step == 1){ 
	show_header();
print<<<END
<form method="post" action="$theurl?step=$step">
授权码：<input type="text" name="wkey" value="已经破解随便填写">
	   <input type="submit" name="sqsubmit" value="提交">(登入官网<a href="http://zllpw.com" target="_blank" >www.zllpw.com</a>,到用户中心获取授权码；)
</form>
END;

	show_footer();

}elseif ($step == 2) {

	//检测目录属性
	show_header();
	
	if(!$_SESSION['pass']){
		showmessage('授权码未匹配，无法进入下一步操作');
	}
	
	$step = 2;
	//设置数据库配置
	print<<<END
	<form id="theform" method="post" action="$theurl">

	<table class="showtable">
	<tr><td><strong># 设置YYJia数据库信息</strong></td></tr>
	<tr><td id="msg1">这里设置YYJia的数据库信息</td></tr>
	</table>
	<table class=datatable>
	<tr>
	<td width="25%">数据库服务器地址:</td>
	<td><input type="text" name="db[dbhost]" size="20" value="localhost"></td>
	<td width="30%">一般为localhost</td>
	</tr>
	<tr>
	<td>数据库用户名:</td>
	<td><input type="text" name="db[dbuser]" size="20" value=""></td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>数据库密码:</td>
	<td><input type="password" name="db[dbpw]" size="20" value=""></td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>数据库字符集:</td>
	<td>
	<select name="db[dbcharset]" onchange="addoption(this)">
	<option value="$_SC[dbcharset]">$_SC[dbcharset]</option>
	<option value="addoption" class="addoption">+自定义</option>
	</select>
	</td>
	<td>MySQL版本>4.1有效</td>
	</tr>
	<tr>
	<td>数据库名:</td>
	<td><input type="text" name="db[dbname]" size="20" value=""></td>
	<td>如果不存在，则会尝试自动创建</td>
	</tr>
	<tr>
	</table>

	<table class=button>
	<tr><td><input type="submit" id="sqlsubmit" name="sqlsubmit" value="设置完毕,检测我的数据库配置"></td></tr>
	</table>
	<input type="hidden" name="db[cookiedomain]" value="$cookiedomain">
	<input type="hidden" name="formhash" value="$formhash">
	</form>
END;
	show_footer();

} elseif ($step == 3) {

	//链接数据库
	dbconnect();

	//安装数据库
	//获取最新的sql文件
	$newsql = sreadfile($sqlfile);

	//获取要创建的表
	$tables = $sqls = array();
	if($newsql) {
		preg_match_all("/(CREATE TABLE IF NOT EXISTS ([a-z0-9\_\-`]+).+?\s*)(TYPE|ENGINE)+\=/is", $newsql, $mathes);
		$sqls = $mathes[1];
		$tables = $mathes[2];
	}
	
	if(empty($tables)) {
		show_msg("安装SQL语句获取失败，请确认SQL文件 $sqlfile 是否存在");
	}

	$heaptype = $_SGLOBAL['db']->version()>'4.1'?" ENGINE=MEMORY".(empty($_SC['dbcharset'])?'':" DEFAULT CHARSET=$_SC[dbcharset]" ):" TYPE=HEAP";
	$myisamtype = $_SGLOBAL['db']->version()>'4.1'?" ENGINE=MYISAM".(empty($_SC['dbcharset'])?'':" DEFAULT CHARSET=$_SC[dbcharset]" ):" TYPE=MYISAM";
	$installok = true;
	foreach ($tables as $key => $tablename) {
		if(strpos($tablename, 'session')) {
			$sqltype = $heaptype;
		} else {
			$sqltype = $myisamtype;
		}
		$_SGLOBAL['db']->query("DROP TABLE IF EXISTS $tablename");
		if(!$query = $_SGLOBAL['db']->query($sqls[$key].$sqltype, 'SILENT')) {
			$installok = false;
			break;
		}
	}
	if(!$installok) {
		show_msg("<font color=\"blue\">数据表 ($tablename) 自动安装失败</font><br />反馈: ".mysql_error()."<br /><br />请参照 $sqlfile 文件中的SQL文，自己手工安装数据库后，再继续进行安装操作<br /><br /><a href=\"?step=$step\">重试</a>");
	} else {
		show_msg('数据表已经全部安装完成，进入下一步操作', ($step+1), 1);
	}

} elseif ($step == 4) {
	dbconnect();
	//插入默认数据

$sql="INSERT INTO `config` (`var`, `datavalue`) VALUES
('sitename', '189手游'),
('sitelogo', ''),
('adminemail', 'webmaster@www.admin.com'),
('seccode_register', '1'),
('allowrewrite', '0'),
('protype', '7'),
('template', 'tshouyou'),
('indexsubject', ''),
('creditname', '积分'),
('isnewversion', 'newversion'),
('footinfos', '应用作品版权归原作者享有，如无意之中侵犯了您的版权，请您按照《<a href=\"/index.php?ac=contact&op=copyright\"  target=\"_blank\">版权保护投诉指引</a>》来信告知，本网站将应您的要求删除。\r\n'),
('syfootinfo','<a href=\"index.php?ac=contact&op=copyright\" target=\"_blank\" >版权声明</a> | <a href=\"index.php?ac=contact&op=upload\" target=\"_blank\" >新闻投递</a> | <a href=\"index.php?ac=contact&op=comment\" target=\"_blank\" >提交应用</a> | <a href=\"index.php?ac=contact&op=address\" target=\"_blank\" >联系我们</a>| <a href=\"index.php?ac=sitemap&op=app\" target=\"_blank\" >网站地图</a> | <a href=\"/data/gugemap.xml\" target=\"_blank\">谷歌地图</a> | <a href=\"/data/baidumap.xml\" target=\"_blank\">百度地图</a> | <a href=\"index.php?ac=rss\" target=\"_blank\" >RSS</a>'),
('bdshare', '<!-- Baidu Button BEGIN -->\r\n<div id=\"bdshare\" class=\"bdshare_t bds_tools get-codes-bdshare\">\r\n<a class=\"bds_tsina\"></a>\r\n<a class=\"bds_qzone\"></a>\r\n<a class=\"bds_tqq\"></a>\r\n<a class=\"bds_renren\"></a>\r\n<a class=\"bds_t163\"></a>\r\n<span class=\"bds_more\">更多</span>\r\n<a class=\"shareCount\"></a>\r\n</div>\r\n<script type=\"text/javascript\" id=\"bdshare_js\" data=\"type=tools&uid=0\" ></script>\r\n<script type=\"text/javascript\" id=\"bdshell_js\"></script>\r\n<script type=\"text/javascript\">\r\ndocument.getElementById(\"bdshell_js\").src = \"http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=\" + Math.ceil(new Date()/3600000)\r\n</script>\r\n<!-- Baidu Button END -->'),
('catalogkeyword', '%catalogname%应用,%catalogname%应用大全'),
('isindexsubject', '1'),
('isindextags', '1'),
('qiyongyzm', '1'),
('contact', '联系方式：<br/>\r\n189手游团队<br/>\r\n客服热线：18259500983（周一至周五 9：00-18：00）<br/>\r\n客服邮箱：572724219@qq.com<br/>\r\n客服QQ：572724219<br/>'),
('agreement', '<p>使用协议\r\n一、服务条款的确认和接纳<br/>\r\n<br/>\r\n为获得本网站提供基于互联网的相关服务，服务使用人(以下称“用户”)必须同意本协议的全部条款并按照页面上的提示完成注册程序。如果用户在注册程序过程中点击“我同意”按钮即表示用户与本网站达成协议，完全接受本协议项下的全部条款。<br/>\r\n除本服务协议外，您应同时阅读并接受“作品上传须知”，“留言须知”及“版权声明”，该“作品上传须知”，“留言须知”及“版权声明”为本协议之不可分割的一部分。<br/>\r\n<br/>\r\n二、服务内容<br/>\r\n<br/>\r\n本网站服务的具体内容由本网站根据实际情况提供。本网站保留随时变更、中断或终止部分或全部网络服务包括收费网络服务的权利。<br/>\r\n用户必须同意接受本网站通过电子邮件或其他方式向用户发送广告或其他相关商业信息。<br/>\r\n本网站仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如电脑、调制解调器及其他与接入互联网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费)均应由用户自行负担。<br/>\r\n<br/>\r\n三、使用规则<br/>\r\n<br/>\r\n1、用户帐号、密码和安全<br/>\r\n<br/>\r\n用户在申请使用本网站提供的网络服务时，必须提供准确的个人资料，如个人资料有任何变动，必须及时更新。<br/>\r\n用户注册成功后，本网站将给予每个用户一个用户帐号及相应的密码，用户应采取合理措施维护其密码和帐号的安全。用户对利用该密码和帐号所进行的一切活动负全部责任；由该等活动所导致的任何损失或损害由用户承担，本网站不承担任何责任。<br/>\r\n盗取他人用户帐号或利用网络通讯骚扰他人，均属于非法行为。用户不得采用测试、欺骗等任何非法手段，盗取其他用户的帐号和对他人进行骚扰。<br/>\r\n<br/>\r\n<br/>\r\n2、用户应遵守以下法律及法规<br/>\r\n<br/>\r\n用户同意遵守《中华人民共和国保守国家秘密法》、《中华人民共和国著作权法》、《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》、《互联网电子公告服务管理规定》、《信息网络传播权保护条例》等有关计算机及互联网规定的法律、法规、实施办法。在任何情况下，本网站合理地认为用户的行为可能违反上述法律、法规，本网站可以在任何时候，不经事先通知终止向该用户提供服务。 <br/>\r\n<br/>\r\n<br/>\r\n3、禁止用户从事以下行为：<br/>\r\n<br/>\r\n3.1 使用本网站服务发送或传播敏感信息和违反国家法律制度的信息，包括但不限于下列信息:<br/>\r\n<br/>\r\n(a) 反对宪法所确定的基本原则的；<br/>\r\n(b) 危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；<br/>\r\n(c) 损害国家荣誉和利益的；<br/>\r\n(d) 煽动民族仇恨、民族歧视，破坏民族团结的；<br/>\r\n(e) 破坏国家宗教政策，宣扬邪教和封建迷信的；<br/>\r\n(f) 散布谣言，扰乱社会秩序，破坏社会稳定的；<br/>\r\n(g) 散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；<br/>\r\n(h) 侮辱或者诽谤他人，侵害他人合法权益的；<br/>\r\n(i) 含有法律、行政法规禁止的其他内容的。<br/>\r\n<br/>\r\n3.2 使用本网站提供的服务进行任何非法、淫秽、色情及其他违反公序良俗之活动，包括但不限于非法传销、诈骗、侵权、反动行为等。<br/>\r\n3.3 对本网站服务的任何部分或服务之使用或获得进行复制、拷贝、出售，或利用本网站服务进行调查、广告或其他商业目的，但本网站对特定服务另有适用指引或规定的除外。<br/>\r\n<br/>\r\n在任何情况下，本网站合理地认为用户的行为可能违反上述规<br/>定，本网站可以在任何时候，不经事先通知终止向该用户提供服务。<br/>\r\n<br/>\r\n<br/>\r\n四、 内容权利<br/>\r\n<br/>\r\n用户上载的内容是指用户在本网站上载或发布的游戏或其它任何形式的内容包括文字、图片、音频等。<br/>\r\n除非本网站收到相反通知，本网站将用户视为其在本网站上载或发布的内容的版权拥有人。用户在本网站上载或发布内容即视为其同意授予本网站所有上述内容的在全球范围内的免费、不可撤销的无限期的并且可转让的非独家使用权许可，本网站有权展示、散布及推广前述内容，有权对前述内容进行任何形式的复制、修改、出版、发行及以其他方式使用或者授权第三方进行复制、修改、出版、发行及以其他方式使用。<br/>\r\n因用户进行上述内容在本网站的上载或发布，而导致任何第三方提出索赔要求或衍生的任何损害或损失，由用户承担全部责任。<br/>\r\n内容权利详情请见：“作品上传须知”，“留言须知”及“版权声明”<br/>\r\n<br/>\r\n五、隐私保护<br/>\r\n<br/>\r\n保护用户隐私是本网站的重点原则，本网站保证不对外公开或向第三方提供用户注册资料及用户在使用服务时存储在本网站的非公开内容，但下列情况除外：<br/>\r\n1、事先获得用户的明确授权；<br/>\r\n2、根据有关的法律法规要求；<br/>\r\n3、按照相关政府主管部门的要求；<br/>\r\n4、为维护用户及社会公众的利益；<br/>\r\n5、为维护本网站的合法权益。<br/>\r\n本网站可能会与第三方合作向用户提供相关的服务，在此情况下，如该第三方同意承担与本网站同等的保护用户隐私的责任，则本网站可将用户的注册资料等提供给该第三方。<br/>\r\n在不透露单个用户隐私资料的前提下，本网站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。<br/>\r\n<br/>\r\n六、 关于第三方链接<br/>\r\n<br/>\r\n本网站服务可能会提供与其他国际互联网网站或资源进行链接。因使用或依赖上述网站或资源所生的损失或损害，本网站不负担任何责任。<br/>\r\n<br/>\r\n七、 免责声明<br/>\r\n<br/>\r\n1、本网站对于任何自本网站而获得的他人的信息、内容或者广告宣传等任何资讯（以下统称“信息”），不保证真实、准确和完整性。如果任何单位或者个人通过上述“信息”而进行任何行为，须自行甄别真伪和谨慎预防风险，否则，无论何种原因，本网站不对任何非与本网站直接发生的交易和/或行为承担任何直接、间接、附带或衍生的损失和责任。<br/>\r\n<br/>\r\n2、本网站不保证（包括但不限于）：<br/>\r\n<br/>\r\n(a) 本网站适合您的使用要求；<br/>\r\n(b) 本网站不受干扰，及时、安全、可靠或不出现错误；<br/>\r\n(c) 您经由本网站取得的任何产品、服务或其他材料符合您的期望。<br/>\r\n<br/>\r\n<br/>\r\n3、您使用经由本网站下载或取得的任何资料，其风险由您自行承担；因该等使用导致您电脑系统损坏或资料流失，您应自己负完全责任；<br/>\r\n<br/>\r\n4、基于以下原因而造成的利润、商业信誉、资料损失或其他有形或无形损失，本网站不承担任何直接、间接的赔偿：<br/>\r\n<br/>\r\n(a) 对本网站的使用或无法使用； <br/>\r\n(b) 经由本网站购买或取得的任何产品、资料或服务；<br/> \r\n(c) 用户资料遭到未授权的使用或修改；<br/>\r\n(d) 其他与本网站相关的事宜。<br/>\r\n<br/>\r\n<br/>\r\n八、服务变更、中断或终止<br/>\r\n<br/>\r\n如因系统维护或升级的需要而需暂停网络服务，本网站将尽可能事先在重要页面进行通告。<br/>\r\n如发生下列任何一种情形，本网站有权随时中断或终止向用户提供服务而无需通知用户：<br/>\r\n1、用户提供的个人资料不真实。<br/>\r\n2、用户违反本协议中规定的使用规则。<br/>\r\n3、用户注册后，连续六个月没有登陆账号的。<br/>\r\n4、用户在使用收费网络服务时未按规定向本网站支付相应的服务费。<br/>\r\n除前款所述情形外，本网站同时保留在不事先通知用户的情况下随时中断或终止部分或全部服务的权利，对于所有服务的中断或终止而造成的任何损失，本网站无需对用户或任何第三方承担任何责任。<br/>\r\n<br/>\r\n九、修改协议<br/>\r\n<br/>\r\n本网站有权随时修改本协议的有关条款，一旦条款内容发生变动，本网站将会在相关的页面提示修改内容。<br/>\r\n用户如果不同意本网站对服务条款所做的修改，可以放弃使用或访问本网站或取消已经获得的服务。如果用户继续使用服务，则视为用户接受服务条款的变动。<br/>\r\n<br/>\r\n十、法律管辖<br/>\r\n<br/>\r\n本协议的订立、执行和解释及争议的解决均应适用中国法律。<br/>\r\n如双方就本协议内容或其执行发生任何争议，双方应尽量友好协商解决；协商不成时，任何一方均可向本网站所在地的人民法院提起诉讼。<br/>\r\n<br/>\r\n十一、通知和送达<br/>\r\n<br/>\r\n本协议项下所有的通知均可通过重要页面公告、电子邮件或常规的信件传送等方式进行；该等通知于发送之日视为已送达收件人。<br/>\r\n用户对于本网站的通知应当通过本网站对外正式公布的通信地址、电子邮件地址等联系信息进行送达。<br/>\r\n<br/>\r\n十二、其他规定<br/>\r\n<br/>\r\n本协议构成双方对本协议之约定事项及其他有关事宜的完整协议，除本协议规定的之外，未赋予本协议各方其他权利。<br/>\r\n如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。<br/>\r\n本协议中的标题仅为方便而设，在解释本协议时应被忽略。<br/>\r\n<br/>\r\n十三、本协议解释权归本网站所有。<br/>\r\n</p>'),
('sitexlogo', 'image/x_logo.jpg'),
('description', '应用大全'),
('title', '应用大全网'),
('keyword', '游戏大全,应用大全'),
('serverurl', 'http://s.yyjia.com'),
('siteid', '".$_SESSION[siteid]."'),
('key', '".$_SESSION[wkey]."'),
('flink', '<a target=\"_blank\" href=\"http://lm.cnssdb.com:81/website/index\">189手游平台</a>'),
('banner', ''),
('syrmzjad', ''),
('errorad', ''),
('errorad2', ''),
('globalad', ''),
('middlead', ''),
('buttomad', ''),
('logoad', ''),
('symiddlead', ''),
('floatad', ''),
('leftad1', '<img src=\"/image/ad.jpg\"/>'),
('leftad2', '<img src=\"/image/ad.jpg\"/>'),
('bottomad1', '<img src=\"/image/ad.jpg\"/>'),
('bottomad2', '<img src=\"/image/ad.jpg\"/>'),
('playad', '<img src=\"/image/ad.jpg\"/>'),
('playads', ''),
('siteurl', '".$siteurl."'),
('gamekeyword', '%gamename%,%gamename%应用%sitename%%catalogname%%gamename%'),
('copyright', '本网站一贯高度重视知识产权保护并遵守中华人民共和国各项知识产权法律、法规和具有约束力的规范性文件。本网站坚信著作权拥有者的合法权益应该得到尊重和依法保护。本网站坚决反对任何违反中华人民共和国有关著作权的法律法规的行为。由于我们无法对用户上传到本网站的所有信息进行充分的监测，我们制定了旨在保护知识产权权利人合法权益的措施和步骤，当著作权人和/或依法可以行使信息网络传播权的权利人（以下简称“权利人”）发现本网站上用户上传内容侵犯其信息网络传播权时，权利人应事先向本网站发出权利通知，本网站将根据相关法律规定采取措施删除相关内容。具体措施和步骤如下：<br/>\r\n<br/>\r\n如果您是某一作品的著作权人和/或依法可以行使信息网络传播权的权利人，且您认为本网站站上用户上传内容侵犯了您对该等作品的信息网络传播权，请您务必书面通知本网站，您应对书面通知陈述之真实性负责。<br/>\r\n<br/>\r\n为方便本网站及时处理您之意见，您的通知书中应至少包含以下内容：<br/>\r\n您的名称（姓名）、联系方式及地址；<br/>\r\n要求删除的作品的名称和在本网站的地址；<br/>\r\n构成侵权地初步证明材料，谨此提示以下材料可能构成初步证明：<br/>\r\n对于涉嫌侵权作品拥有著作权或依法可以行使信息网络传播权的权属证明；<br/>\r\n对涉嫌侵权作品侵权事实的举证。<br/>\r\n您的签名。 <br/>\r\n<br/>\r\n<br/>\r\n一旦收到符合上述要求之通知，我们采取包括删除等相应措施。如不符合上述条件，我们会请您提供相应信息，且暂不采取包括删除等相应措施。<br/>\r\n<br/>\r\n在本网站上载作品的用户视为同意本网站就前款情况所采用的相应措施。本网站不因此而承担任何违约责任或其他任何法律责任。本网站在收到上述通知后会发送电子邮件通知上载该等作品的用户。对于多次上载涉嫌侵权作品的用户，我们将取消其用户资格。<br/>'),
('upload', '作品上传须知<br/>\r\n<br/>\r\n本网站在此郑重提请您注意，任何经由本网站的服务以上载、张贴、发送电子邮件或任何其它方式传送的作品，无论系公开还是私下传送，均由内容提供者、上传者承担责任。您若在本网站上散布和传播反动、色情或其他违反国家法律的信息（详见用户须知使用规则3.1），本网站有权在无需事先通知的情况下做出独立判断而立即取消您对帐号使用，同时本网站的系统记录有可能作为您违反法律的证据。<br/>\r\n<br/>\r\n因您进行上述作品在本网站的上载、传播而导致任何第三方提出索赔要求或衍生的任何损害或损失，概与本网站无关，而由您承担全部责任。<br/>\r\n<br/>\r\n作品须知的约束对象，包括拥有帐号的服务使用人及尚未拥有账号但使用本网站部分服务（包括但不限于上载游戏，提交留言）的服务使用人。若您不同意上述内容，请勿上传作品。<br/>'),
('comment', '您上传的留言是指您在本网站上载、传播的文字、图片、链接或其它任何形式的内容。<br/>\r\n<br/>\r\n本网站在此郑重提请您注意，任何经由本网站的服务以上载、张贴、发送电子邮件或任何其它方式传送的内容，无论系公开还是私下传送，均由内容提供者、上传者承担责任。您若在本网站上散布和传播反动、色情或其他违反国家法律的信息（详见用户须知使用规则3.1），本网站有权在无需事先通知的情况下做出独立判断而立即取消您对帐号使用，同时本网站的系统记录有可能作为您违反法律的证据。<br/>\r\n<br/>\r\n因您进行上述作品和内容在本网站的上载、传播而导致任何第三方提出索赔要求或衍生的任何损害或损失，概与本网站无关，而由您承担全部责任。<br/>\r\n<br/>\r\n留言须知的约束对象，包括拥有帐号的服务使用人及尚未拥有账号但使用本网站部分服务（包括但不限于上载游戏，提交留言）的服务使用人。若您不同意上述内容，请勿提交留言。'),
('ismemcache', '0'),
('showbigpic', '1'),
('lengthstart', ''),
('lengthend', ''),
('istop10', '1'),
('istab', '1'),
('color', 'lan'),
('rewritepre', ''),
('subjectinfotitle', ''),
('subjectinfokeyword', ''),
('subjectinfodescript', ''),
('tagtitle', ''),
('tagkeyword', ''),
('tagdescript', ''),
('taginfotitle', ''),
('taginfokeyword', ''),
('taginfodescript', ''),
('shouyou_title', '手机网游第一门户_最新手机网游排行_最热手机网游下载_%sitename%'),
('shouyou_keyword', '手机网游第一门户,最新手机网游排行,最热手机网游下载'),
('shouyou_description', '%sitename%提供最新最全手机网游免费下载、手机网游攻略评测、手机网游排行、手机网游放号礼包、玩家公会、玩家论坛等全方位的服务，是中国最专业和用户最多的手机网游下载门户'),
('games_title', '最热%tagname%类手机网游_%sitename%'),
('games_keyword', '%tagname%类手机网游'),
('games_description', ''),
('server_title', '手机网游新服表_%sitename%'),
('server_keyword', '手机网游新服表'),
('server_description', ''),
('test_title', '手机网游测试表_%sitename%'),
('test_keyword', '手机网游测试表'),
('test_description', ''),
('syapp_title', '%appname%_手机网游下载'),
('syapp_keyword', '%sitename%,手机网游下载'),
('syapp_description', ''),
('pack_title', '%packname%_%sitename%'),
('pack_keyword', '%packname%,%sitename%'),
('pack_description', '%packname%,%sitename%'),
('syrank_title', '手机网游排行榜'),
('syrank_keyword', '手机网游排行榜'),
('syrank_description', ''),
('synews_title', '最新新闻_%newscatename%_%sitename%'),
('synews_keyword', '最新新闻,%newscatename%,%sitename%'),
('synews_description', ''),
('synewsde_title', '%newsname%_%sitename%'),
('synewsde_keyword', '%newsname%,%sitename%'),
('synewsde_description', ''),
('newsde_description', ''),
('htime', '0'),
('downnum', '0'),
('newsdownnum', '0'),
('updateappsnums', '0'),
('updatenewsnums', '0'),
('sourcetype', '1,2'),
('isautodown', '1'),
('starttime', '1376543088'),
('isappverify', '0'),
('isnewsverify', '0'),
('issubverify', '0'),
('applefootinfo', ''),
('version', '189手游手游版_1.6'),
('mtemplate', 'snewshouyou'),
('testtype','{\"1\":{\"name\":\"&u5c01&u6d4b\",\"bianhao\":1},\"2\":{\"name\":\"&u5220&u6863&u5185&u4fa7\",\"bianhao\":2},\"3\":{\"name\":\"&u4e0d&u5220&u6863&u5185&u4fa7\",\"bianhao\":3},\"4\":{\"name\":\"&u4e8c&u6b21&u5185&u4fa7\",\"bianhao\":4},\"5\":{\"name\":\"&u516c&u6d4b\",\"bianhao\":5}}'),
('packtype', '{\"1\":\"&u793c&u5305\",\"2\":\"&u65b0&u624b&u5361\",\"3\":\"&u6fc0&u6d3b&u7801\",\"4\":\"&u6d4b&u8bd5&u53f7\"}'),
('chkupdate', '1'),
('sdupdate', '0'),
('symtitle', '手机网游第一门户_最新手机网游排行_最热手机网游下载_%sitename%'),
('symkeyword', '手机网游第一门户,最新手机网游排行,最热手机网游下载'),
('symdescription', '%sitename%提供最新最全手机网游免费下载、手机网游攻略评测、手机网游排行、手机网游放号礼包、玩家公会、玩家论坛等全方位的服务，是中国最专业和用户最多的手机网游下载门户'),
('symgametitle', '最热%catename%手机网游_%sitename%'),
('symgamekeyword', '%catename%手机网游'),
('symgamedescription', ''),
('sympacktitle', '手机游戏礼包_手机游戏激活码_手机游戏兑换码免费领取'),
('sympackkeyword', '手机游戏礼包免费领取,手机游戏激活码免费领取,手机游戏兑换码免费领取'),
('sympackdescription', ''),
('sympackdetailtitle', '%packname%_免费领取_%sitename%'),
('sympackdetailkeyword', '%packname%免费领取'),
('sympackdetaildescription', ''),
('symopentitle', '手机网游新服表_%sitename%'),
('symopenkeyword', '手机网游新服表'),
('symopendescription', ''),
('symtesttitle', '手机网游测试表_%sitename%'),
('symtestkeyword', '手机网游测试表'),
('symtestdescription', ''),
('symnewstitle', '最新新闻_%sitename%'),
('symnewskeyword', '最新新闻,%sitename%'),
('symnewsdescription', ''),
('symnewsdetailtitle', ''),
('symnewsdetailkeyword', ''),
('symnewsdetaildescription', ''),
('symdetailtitle', '%appname%_手机网游下载'),
('symdetailkeyword', '%sitename%,手机网游下载'),
('symdetaildescription', '')";

$_SGLOBAL['db']->query($sql);

$sql="INSERT INTO `credit` (`id`, `type`, `cycle`, `getnum`, `reward`, `credit`, `experience`, `addcredit`, `limitdaynum`) VALUES
	(1, 1, 1, 1, '1', 12, 5, 0, 7),
	(2, 2, 2, 1, '1', 1, 1, 0, 7),
	(3, 3, 1, 2, '1', 1, 1, 1, 7),
	(4, 4, 2, 5, '1', 1, 1, 0, 7),
	(5, 5, 2, 2, '1', 2, 2, 0, 7),
	(6, 6, 2, 5, '1', 2, 2, 0, 7),
	(7, 7, 2, 1, '1', 1, 1, 0, 7),
	(8, 8, 2, 1, '1', 1, 1, 0, 7),
	(9, 9, 2, 1, '1', 1, 1, 0, 7),
	(10, 10, 2, 1, '1', 1, 1, 0, 7),
	(11, 11, 2, 10, '1', 2, 2, 0, 7),
	(12, 12, 2, 1, '1', 2, 2, 2, 7),
	(13, 13, 2, 200, '2', 0, 0, 0, 1)";
$_SGLOBAL['db']->query($sql);
	
$uploadssql="INSERT INTO `uploads` (`id`, `uid`, `aid`, `uptime`, `title`, `url`, `mediatype`, `width`, `height`, `playtime`, `filesize`) VALUES
(1, 0, 0, 1376617037, '130816093717.jpg', '/attachment/apple/images/1308/130816093717.jpg', 'image/jpeg', 0, 0, 0, '29634'),
(2, 0, 0, 1376979840, '130820142400.png', '/attachment/apple/images/1308/130820142400.png', 'image/png', 0, 0, 0, '2369'),
(3, 0, 0, 1376979848, '130820142408.jpg', '/attachment/apple/images/1308/130820142408.jpg', 'image/jpeg', 0, 0, 0, '227700'),
(4, 0, 0, 1376979855, '130820142415.jpg', '/attachment/apple/images/1308/130820142415.jpg', 'image/jpeg', 0, 0, 0, '99815')";

$_SGLOBAL['db']->query($uploadssql);

$groupsql="INSERT INTO `user_group` (`group_id`, `group_name`, `isapps`, `isnews`) VALUES
(1, '管理员', 1, 1),
(2, '开发者会员', 1, 1),
(3, '普通会员', 0, 0)";
$_SGLOBAL['db']->query($groupsql);


	show_msg('系统默认数据添加完毕，进入下一步操作', ($step+1), 1);

} elseif ($step == 5) {

	//更新缓存
	dbconnect();
	include_once(S_ROOT.'./source/function_cache.php');

	config_cache();
	
	show_header();

print<<<END
	
	<form method="post" action="$theurl?step=6" >
	<table>
	<tr><td colspan="2">设置管理员!<br><br>
	请输入您的用户名和密码<br>系统将自动将您设为管理员!
	</td></tr>
	<tr><td>您的用户名</td><td><input type="text" name="username" value="" size="30"></td></tr>
	<tr><td>您的密码</td><td><input type="password" name="password" value="" size="30"></td></tr>
	<tr><td>您的邮箱</td><td><input type="text" name="email" value="" size="30"></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="提交设置"></td></tr>
	</table>

	</form>
END;
	show_footer();
	
}elseif ($step == 6) {
	show_header();
	dbconnect();
		$username = trim($_POST['username']);
		$password = $_POST['password'];
		
		$email = isemail($_POST['email'])?$_POST['email']:'';		
		if(empty($email)) {
			showmessage('email_format_is_wrong');
		}
		
		//add by hmf
		$timestamp=time();
		$groupid=10;  
		$extcredits2=1;
		$isadmin=1;
		$timeoffset=9999;
		$regdate=$timestamp;
		$lastvisit=$timestamp;
		$lastactivity=$timestamp;		
		
		$salt = substr(uniqid(rand()), -6);
		$ip=getonlineip();
		$setarr = array(
				'username' => $username,
				'email' => $email,
				'regip' => $ip,
				'salt' => $salt,
				'is_admin'=> $isadmin,
				'addtime' => $_SGLOBAL['timestamp'],
				'lastlogin' => $_SGLOBAL['timestamp'],
				'group_id' => 1,
				'password' =>md5(md5($password).$salt) //密码生成
				
				);
		//更新本地用户库
		$uid=inserttable('user', $setarr, 1);
		
		//写log
		if(@$fp = fopen($lockfile, 'w')) {
			fwrite($fp, 'YYJia');
			fclose($fp);
		}


	print<<<END
	<div>完成安装!</div><br><br>

	<div><a href="/index.php">进入主页</a></div>
	<div><a href="/admincp.php">后台管理</a></div>
	
	
END;
	show_footer();
}

//页面头部
function show_header() {
	global $_SGLOBAL, $nowarr, $step, $theurl, $_SC;

	$nowarr[$step] = ' class="current"';
	print<<<END
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=$_SC[charset]" />
	<title> YYJia 程序安装 </title>
	<style type="text/css">
	* {font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif; line-height: 1.5em; word-break: break-all; }
	body { text-align:center; margin: 0; padding: 0; background: #F5FBFF; }
	.bodydiv { margin: 40px auto 0; width:720px; text-align:left; border: solid #86B9D6; border-width: 5px 1px 1px; background: #FFF; }
	h1 { font-size: 18px; margin: 1px 0 0; line-height: 50px; height: 50px; background: #E8F7FC; color: #5086A5; padding-left: 10px; }
	#menu {width: 100%; margin: 10px auto; text-align: center; }
	#menu td { height: 30px; line-height: 30px; color: #999; border-bottom: 3px solid #EEE; }
	.current { font-weight: bold; color: #090 !important; border-bottom-color: #F90 !important; }
	.showtable { width:100%; border: solid; border-color:#86B9D6 #B2C9D3 #B2C9D3; border-width: 3px 1px 1px; margin: 10px auto; background: #F5FCFF; }
	.showtable td { padding: 3px; }
	.showtable strong { color: #5086A5; }
	.datatable { width: 100%; margin: 10px auto 25px; }
	.datatable td { padding: 5px 0; border-bottom: 1px solid #EEE; }
	input { border: 1px solid #B2C9D3; padding: 5px; background: #F5FCFF; }
	.button { margin: 10px auto 20px; width: 100%; }
	.button td { text-align: center; }
	.button input, .button button { border: solid; border-color:#F90; border-width: 1px 1px 3px; padding: 5px 10px; color: #090; background: #FFFAF0; cursor: pointer; }
	#footer { font-size: 10px; line-height: 40px; background: #E8F7FC; text-align: center; height: 38px; overflow: hidden; color: #5086A5; margin-top: 20px; }
	</style>
	<script type="text/javascript">
	function $(id) {
		return document.getElementById(id);
	}
	//添加Select选项
	function addoption(obj) {
		if (obj.value=='addoption') {
			var newOption=prompt('请输入:','');
			if (newOption!=null && newOption!='') {
				var newOptionTag=document.createElement('option');
				newOptionTag.text=newOption;
				newOptionTag.value=newOption;
				try {
					obj.add(newOptionTag, obj.options[0]); // doesn't work in IE
				}
				catch(ex) {
					obj.add(newOptionTag, obj.selecedIndex); // IE only
				}
				obj.value=newOption;
			} else {
				obj.value=obj.options[0].value;
			}
		}
	}
	</script>
	</head>
	<body id="append_parent">
	<div class="bodydiv">
	<h1>YYJia程序安装</h1>
	<div style="width:90%;margin:0 auto;">
	<table id="menu">
	<tr>
	<td{$nowarr[0]}>安装开始</td>
	<td{$nowarr[1]}>1.授权码匹配</td>
	<td{$nowarr[2]}>2.设置数据库连接信息</td>
	<td{$nowarr[3]}>3.创建数据库结构</td>
	<td{$nowarr[4]}>4.添加默认数据</td>
	<td{$nowarr[5]}>5.设置管理员</td>
	<td{$nowarr[6]}>6.安装完成</td>
	</tr>
	</table>
END;
}

//页面顶部
function show_footer() {
	print<<<END
	</div>
	<iframe id="phpframe" name="phpframe" width="0" height="0" marginwidth="0" frameborder="0" src="about:blank"></iframe>
	<div id="footer">&copy; 2013 www.yyjia.com</div>
	</div>
	<br>
	</body>
	</html>
END;
}


//显示
function show_msg($message, $next=0, $jump=0) {
	global $theurl;

	$nextstr = '';
	$backstr = '';

	obclean();
	if(empty($next)) {
		$backstr .= "<a href=\"javascript:history.go(-1);\">返回上一步</a>";
	} elseif ($next == 999) {
	} else {
		$url_forward = "$theurl?step=$next";
		if($jump) {

			$nextstr .= "<a href=\"$url_forward\">请稍等...</a><script>setTimeout(\"window.location.href ='$url_forward';\", 1000);</script>";
		} else {
			$nextstr .= "<a href=\"$url_forward\">继续下一步</a>";
			$backstr .= "<a href=\"javascript:history.go(-1);\">返回上一步</a>";
		}
	}

	show_header();
	print<<<END
	<table>
	<tr><td>$message</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>$backstr $nextstr</td></tr>
	</table>
END;
	show_footer();
	exit();
}

//检查权限
function checkfdperm($path, $isfile=0) {
	if($isfile) {
		$file = $path;
		$mod = 'a';
	} else {
		$file = $path.'./install_tmptest.data';
		$mod = 'w';
	}
	if(!@$fp = fopen($file, $mod)) {
		return false;
	}
	if(!$isfile) {
		//是否可以删除
		fwrite($fp, ' ');
		fclose($fp);
		if(!@unlink($file)) {
			return false;
		}
		//检测是否可以创建子目录
		if(is_dir($path.'./install_tmpdir')) {
			if(!@rmdir($path.'./install_tmpdir')) {
				return false;
			}
		}
		if(!@mkdir($path.'./install_tmpdir')) {
			return false;
		}
		//是否可以删除
		if(!@rmdir($path.'./install_tmpdir')) {
			return false;
		}
	} else {
		fclose($fp);
	}
	return true;
}

?>
