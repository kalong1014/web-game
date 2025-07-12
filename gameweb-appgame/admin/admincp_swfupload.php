<?php
/**
 * swfupload上传
 */
define('D_BUG', '0');

@error_reporting(E_ERROR);

$_SGLOBAL = $_SCONFIG = $_SBLOCK = $_TPL = $_SCOOKIE = $_SN = $space = array();


define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
include_once(S_ROOT.'./source/function_common.php');
require_once(S_ROOT.'./source/image.func.php');
include_once(S_ROOT.'config.php'); 

$magic_quote = get_magic_quotes_gpc();

if(empty($magic_quote)) {

	$_GET = saddslashes($_GET);

	$_POST = saddslashes($_POST);

}
$mtime = explode(' ', microtime());

$_SGLOBAL['timestamp'] = $mtime[1];

$_SGLOBAL['supe_starttime'] = $_SGLOBAL['timestamp'] + $mtime[0];

include_once(S_ROOT.'./source/lib.php');

dbconnect();

/*
***********************

//上传 

function Upload(){  } 

************************
*/

$dopost=$_REQUEST['dopost'];

$id=intval($_REQUEST['id']);

$img=$_REQUEST['img'];

$type=$_REQUEST['type']?$_REQUEST['type']:"apple";

$cfg_ddimg_width=100;

$cfg_ddimg_height=100;

$picfile=$_REQUEST['picfile'];

if(empty($dopost))

{

    ini_set('html_errors', '0');

	$Filedata=$_FILES['Filedata'];

    if ( empty($Filedata) || !is_uploaded_file($Filedata['tmp_name']))

    {	

        echo 'ERROR: Upload Error! ';

        exit(0);

    }

	

    //把文件移动到临时目录

    $tmpdir =S_ROOT."/attachment/temp/images/";
	

    if(!is_dir($tmpdir))

    {

        mkdir($tmpdir,0755,true);

        CloseFtp();

        if(!is_dir($tmpdir))

        {

            echo "ERROR: Create {$tmpdir} dir Error! ";

            exit(0);

        }

    }

 

    $FiledataNew = str_replace("\\", '/', $Filedata['tmp_name']);

    //$FiledataNew = $tmpdir.'/'.preg_replace("/(.*)[\/]/isU", "", $FiledataNew);

	$FiledataNew = $tmpdir.preg_replace("/(.*)[\/]/isU", "", $FiledataNew);
	move_uploaded_file($Filedata['tmp_name'], $FiledataNew);
    $info = $ftype = $sname = '';

    $srcInfo = GetImageSize($FiledataNew, $info);

    //检测文件类型

    if (!is_array($srcInfo))

    {

        @unlink($Filedata['tmp_name']);

        echo "ERROR: Image info Error! ";

        exit(0);

    }

    else

    {

        switch ($srcInfo[2])

        {

            case 1:

                $ftype = 'image/gif';

                $sname = '.gif';

                break;

            case 2:

                $ftype = 'image/jpeg';

                $sname = '.jpg';

                break;

            case 3:

                $ftype = 'image/png';

                $sname = '.png';

                break;

            case 6:

                $ftype = 'image/bmp';

                $sname = '.bmp';

                break;

        }

    }

    if($ftype=='')

    {

        @unlink($Filedata['tmp_name']);

        echo "ERROR: Image type Error! ";

        exit(0);

    }

   

    //保存原图

	$file= S_ROOT."/attachment/".$type;

	if(!is_dir($file)){ 

       // mkdir($filedir, $cfg_dir_purview,true);

		 mkdir($file,0755,true);

    }

    $filedir = $file."/images/".date("ym",time());



    if(!is_dir($filedir)){ 

       // mkdir($filedir, $cfg_dir_purview,true);

		 mkdir($filedir,0755,true);

    }

    $filename = date('ymdHis', time()); 

    if( file_exists($filedir.'/'.$filename.$sname) )
    {

        for($i=50; $i <= 5000; $i++)

        {

            if( !file_exists($filedir.'/'.$filename.'-'.$i.$sname) )

            {

                $filename = $filename.'-'.$i;

                break;

            }

        }

    }

    $fileurl = $filedir.'/'.$filename.$sname;

	$fileurl2="/attachment/".$type."/images/".date("ym",time()).'/'.$filename.$sname;

    $rs = copy($FiledataNew, $fileurl);

    unlink($FiledataNew);

    if(!$rs)

    {

        echo "ERROR: Copy Uploadfile Error! ";

        exit(0);

    }

    WaterImg($cfg_basedir.$fileurl, 'up');

    $title = $filename.$sname;

	$uploads=array("title"=>$title,"url"=>$fileurl2,"mediatype"=>$ftype,"width"=>0,"height"=>0,"playtime"=>0,"filesize"=>filesize($fileurl),"uptime"=>time(),"uid"=>$_SGLOBAL['supe_uid']);

    

	

	$fid=inserttable("uploads",$uploads,1);

	session_id($_POST['PHPSESSID2']);

	session_start();

    AddMyAddon($fid, $fileurl2);



	

    //生成缩略图

    ob_start();

    ImageResizeNew($fileurl, $cfg_ddimg_width, $cfg_ddimg_height, '', false);

    $imagevariable = ob_get_contents();

    ob_end_clean();

    //保存信息到 session

    if (!isset($_SESSION['file_info'])) $_SESSION['file_info'] = array();

    if (!isset($_SESSION['bigfile_info'])) $_SESSION['bigfile_info'] = array();

    if (!isset($_SESSION['fileid'])) $_SESSION['fileid'] = 1;

    else $_SESSION['fileid']++;

    $_SESSION['bigfile_info'][$_SESSION['fileid']] = $fileurl2;

    $_SESSION['file_info'][$_SESSION['fileid']] = $imagevariable;

    echo "FILEID:".$_SESSION['fileid'];

    exit(0);

}

/************************

//生成缩图

function GetThumbnail(){  }

*************************/

else if($dopost=='thumbnail')

{

	session_start();

    if( empty($id) )

    {

        header('HTTP/1.1 500 Internal Server Error');

        echo 'No ID';

        exit(0);

    }

    if (!is_array($_SESSION['file_info']) || !isset($_SESSION['file_info'][$id]))

    {

        header('HTTP/1.1 404 Not found');

        exit(0);

    }

    header('Content-type: image/jpeg');

    header('Content-Length: '.strlen($_SESSION['file_info'][$id]));

    echo $_SESSION['file_info'][$id];

    exit(0);

}

/************************

//删除指定ID的图片

*************************/

else if($dopost=='del')

{

    if(!isset($_SESSION['bigfile_info'][$id]))

    {

        echo '';

        exit();

    }

    $dsql="DELETE FROM `uploads` WHERE url LIKE '{$_SESSION['bigfile_info'][$id]}'; ";

	$_SGLOBAL['db']->query($dsql);

    @unlink(S_ROOT.$_SESSION['bigfile_info'][$id]);

    $_SESSION['file_info'][$id] = '';

    $_SESSION['bigfile_info'][$id] = '';

    echo "<b>已删除！</b>";

    exit();

}

/************************

//获取图片地址

*************************/

else if($dopost=='addtoedit')

{

    if(!isset($_SESSION['bigfile_info'][$id]))

    {

        echo '';

        exit();

    }

	echo $_SESSION['bigfile_info'][$id];

	exit();

}

/************************

//获取本地图片的缩略预览图

function GetddImg(){  }

*************************/

else if($dopost=='ddimg')

{

    //生成缩略图

    ob_start();

    if(!preg_match("/^(http:\/\/)?([^\/]+)/i", $img)) $img = S_ROOT.$img;

    ImageResizeNew($img, $cfg_ddimg_width, $cfg_ddimg_height, '', false);

    $imagevariable = ob_get_contents();

    ob_end_clean();
    header('Content-type: image/jpeg');

    header('Content-Length: '.strlen($imagevariable));

    echo $imagevariable;

    exit();

}

/************************

//删除指定的图片(编辑图集时用)

*************************/

else if($dopost=='delold')

{

    $imgfile = $picfile;
	
	$chkimgfile = pathinfo($imgfile);
	
	if($chkimgfile['extension']=="png" || $chkimgfile['extension']=="jpg" || $chkimgfile['extension']=="gif"){
		$imgfile=S_ROOT.str_replace("http://".$_SC['sitehost'].$_SC['installdir'],'',$imgfile);
		if(file_exists($imgfile) && !is_dir($imgfile)){
			@unlink($imgfile);
		}
		$dsql="DELETE FROM `uploads` WHERE url LIKE '{$picfile}'; ";
		$_SGLOBAL['db']->query($dsql);
		echo "<b>图片文件已删除！请保存修改</b>";
		exit();
	}else{
		echo "<b>当前属于非法操作</b>";
        exit();
	}

}





function AddMyAddon($fid, $filename)

{

    $cacheFile = S_ROOT.'data/cache/addon-'.session_id().'.inc';
	 if(!is_dir(S_ROOT.'data/cache/'))
    {
        mkdir(S_ROOT.'data/cache/',0755,true);
        if(!is_dir(S_ROOT.'data/cache/'))
        {
            echo "ERROR: Create ".S_ROOT.'data/cache/'." dir Error! ";
            exit(0);
        }
    }

    if(!file_exists($cacheFile))

    {

        $fp = fopen($cacheFile, 'w');

        fwrite($fp, '<'.'?php'."\r\n");

        fwrite($fp, "\$myaddons = array();\r\n");

        fwrite($fp, "\$maNum = 0;\r\n");

        fclose($fp);

    }

    include($cacheFile);

    $fp = fopen($cacheFile, 'a');

    $arrPos = $maNum;

    $maNum++;

    fwrite($fp, "\$myaddons[\$maNum] = array('$fid', '$filename');\r\n");

    fwrite($fp, "\$maNum = $maNum;\r\n");

    fclose($fp);

}