<?php
$_SC = array();
$_SC['isdev']="0";
$_SC['isSAE']="0";//是否在bae的平台上运行。如果是调用bae的memcache和mysql
$_SC['dbhost']  		= 'localhost'; //服务器地址
$_SC['dbuser']  		= 'cutemicn_a'; //用户
$_SC['dbpw'] 	 		= 'dgwz126'; //密码
$_SC['dbcharset'] 		= 'utf8'; //字符集
$_SC['pconnect'] 		= 0; //是否持续连接
$_SC['dbname']  		= 'cutemicn_ab'; //数据库
$_SC['datadir']=str_replace( '\\' , '/' , dirname(__FILE__));
$_SC['dataurl']="";
$_SC['charset'] ="utf-8";
$_SC["refer"] = empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
$_SC["host"] = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$_SC['sitehost']=$_SERVER['HTTP_HOST'];
$_SC['siteurl']='http://'.$_SC['sitehost'];
$_SC['ismemcache'] = 1;//是否开启缓存
$_SC['cookiepre'] 		= '02play_'; //COOKIE前缀
$_SC['cookiedomain'] 	= '.02play.com'; //COOKIE作用域
$_SC['attachdir']		= '/attachment/'; //附件本地保存位置(服务器路径, 属性 777, 必须为 web 可访问到的目录, 相对目录务必以 "./"尾加 "/") 开头, 末
$_SC['attachurl']		= '/attachment/';
$_SC['cookiepath'] 		= '/';
$_SC['is_location']		= 0;
$_SC['templatenum']	= 1;
$_SC['memcache']="127.0.0.1";
$_SC['sitename']		= "";//站点名称，用来在评论列表显示
?>