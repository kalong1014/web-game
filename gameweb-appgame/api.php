<?php

/*

if(strstr($_SERVER['HTTP_USER_AGENT'],"Adr")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"android")){

	echo "android";	

}

if(strstr($_SERVER['HTTP_USER_AGENT'],"iPh")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"apple")){

	echo "apple";	

}

*/

include_once(dirname(__FILE__).'/common.php');

$_SCONFIG['template']="mobile";

define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);

$ac = $_REQUEST['ac']?$_REQUEST['ac']:'android';

$acs = array('index', 'igame','isoft', 'bizhi', 'recommend', 'news','isubject', 'detail','cate','search','newdetail','detail','rank','down','catelist','searchlist','zt','ztlist','ad','iindex', 'irecommend','idetail','icate','isearch','irank','isubjectdetail','icatelist','isearchlist','izt','iztlist','iad','index3','soft3','game3','subject3','detail3','subjectdetail3','search3','searchlist3','ad3','cate3','catelist3');



	if(!$ac){
		$ac="index";
	}



	if($_GET['input']){

		$ac="personal";

	}

//处理rewrite

if($_SCONFIG['allowrewrite'] && isset($_GET['rewrite'])) {

	$rws = explode('-', $_GET['rewrite']);

	if(isset($rws[0])) {

		$rw_count = count($rws);

		for ($rw_i=0; $rw_i<$rw_count; $rw_i=$rw_i+2) {

			$_GET[$rws[$rw_i]] = empty($rws[$rw_i+1])?'':$rws[$rw_i+1];

		}

	}

	unset($_GET['rewrite']);

}

$year = date("Y");

$month = date("m");

$day = date("d");

$dayBegin = mktime(0,0,0,$month,$day,$year);//当天开始时间戳

$dayEnd = mktime(23,59,59,$month,$day,$year);//当天结束时间戳

$between= $dayBegin." and ".$dayEnd;

$categorys=get_categorys(1,-1,-1,300,-1,"isrecommend");

$idcategorylist=$categorys['id'];

$engcategorylist=$categorys['engname'];

$recomcategorylist=$categorys['id'];

if(strstr($_SERVER['HTTP_USER_AGENT'],"iPh")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"iphone")){	

	$_SCONFIG['ios_title']=str_replace("%sitename%",$_SCONFIG['sitename'],str_replace("%channeltype%","iPhone",$_SCONFIG['ios_title']));

	$_SCONFIG['ios_keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],str_replace("%channeltype%","iPhone",$_SCONFIG['ios_keyword']));

	$_SCONFIG['ios_description']=str_replace("%sitename%",$_SCONFIG['sitename'],str_replace("%channeltype%","iPhone",$_SCONFIG['ios_description']));

	//今日条数

	$datenum=get_count(2,1,-1,$between);

	//总条数

	$totalnum=get_count(2,1,-1);

}else{

	$_SCONFIG['andr_title']=str_replace("%sitename%",$_SCONFIG['sitename'],str_replace("%channeltype%","Android",$_SCONFIG['andr_title']));

	$_SCONFIG['andr_keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],str_replace("%channeltype%","Android",$_SCONFIG['andr_keyword']));

	$_SCONFIG['andr_description']=str_replace("%sitename%",$_SCONFIG['sitename'],str_replace("%channeltype%","Android",$_SCONFIG['andr_description']));

	

	$datenum=get_count(2,-1,1,$between);

	//总条数

	$totalnum=get_count(2,-1,-1);

}

$currents=array($ac=>'class="current"');

include_once(S_ROOT.'./source/a_api_'.$ac.'.php');

?>