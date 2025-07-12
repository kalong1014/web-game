<?php
$op=$_GET['op']?$_GET['op']:"";
if($op == "re"){
	delete_memcached();
	include_once(S_ROOT.'./source/function_cache.php');
	config_cache();
	subject_list();
	$dir=S_ROOT."data/tpl_cache";
	rmDirs($dir,false);
	$dir=S_ROOT."data/tmp";
	rmDirs($dir,false);	
	
	//更新词语屏蔽	
	censor_cache();
	showmessage("缓存清理成功！","admincp.php?ac=recache");
}elseif($op=="all"){
	delete_memcached("all");
	include_once(S_ROOT.'./source/function_cache.php');
	config_cache();
	$dir=S_ROOT."data/html";
	rmDirs($dir,false);
	$dir=S_ROOT."data/tpl_cache";
	rmDirs($dir,false);
	$dir=S_ROOT."data/tmp";
	rmDirs($dir,false);	
	
	//更新词语屏蔽	
	censor_cache();
	showmessage("缓存清理成功！","admincp.php?ac=recache");
}elseif($op=="template"){
	delete_memcached("template");
	$dir=S_ROOT."data/tpl_cache";
	rmDirs($dir,false);
	
	//更新词语屏蔽	
	//censor_cache();
	showmessage("模板缓存清理成功！","admincp.php?ac=recache");
}elseif($op=="jingtai"){
	delete_memcached("all");
	include_once(S_ROOT.'./source/function_cache.php');
	$dir=S_ROOT."data/html";
	rmDirs($dir,false);
	$ifile=S_ROOT."index.html";
	if(file_exists($ifile)){
		@unlink($ifile);
	}
	showmessage("静态页面缓存清理成功！","admincp.php?ac=recache");
}
$dangqianname=$ac.$op;
$dangqian=array($dangqianname=>'class=dangqian');
include_once template("recache");


function rmDirs ($dir, $rmself = true) {
	//如果给定路径末尾包含"/",先将其删除
	if(substr($dir,-1)=="/"){
		$dir=substr($dir,0,-1);
	}
	//如给出的目录不存在或者不是一个有效的目录，则返回
	if(!file_exists($dir)||!is_dir($dir)){
		return false;
		//如果目录不可读，则返回
	} elseif(!is_readable($dir)){
		return false;
	} else {
		//打开目录，
		$dirs= opendir($dir);
		//当目录不空时，删除目录里的文件
		while (false!==($entry=readdir($dirs))) {
			//过滤掉表示当前目录的"."和表示父目录的".."
			if ($entry!="."&&$entry!="..") {
				$path=$dir."/".$entry;
				//为子目录，则递归调用本函数
				if(is_dir($path)){
					rmDirs($path);
					//为文件直接删除
				} else {
					unlink($path);
				}
			}
		}
		//关闭目录
		closedir($dirs);
		//当$rmself==false时,只清空目录里的文件及目录,$rmself=true时,也删除$dir目录
		if($rmself){
			//删除目录
			if(!rmdir($dir)){
				return false;
			}
			return true;
		}
	}
}

function delFile ($file) {
	if ( !is_file($file) ) return false;
	@unlink($file);
	return true;
}


function subject_list(){
	global $_SGLOBAL;	
	cache_write('subject','_subject_list', $subject_lists);
}

?>