<?php
include_once(S_ROOT.'./source/dedehttpdown.class.php');
function MyDate($format='Y-m-d H:i:s',$timest=0)
{
	global $cfg_cli_time;
	$addtime = $cfg_cli_time * 3600;
	if(empty($format))
	{
		$format = 'Y-m-d H:i:s';
	}
	return gmdate ($format,$timest+$addtime);
}
function dd2char($ddnum)
{
	$ddnum = strval($ddnum);
	$slen = strlen($ddnum);
	$okdd = '';
	$nn = '';
	for($i=0;$i<$slen;$i++)
	{
		if(isset($ddnum[$i+1]))
		{
			$n = $ddnum[$i].$ddnum[$i+1];
			if( ($n>96 && $n<123) || ($n>64 && $n<91) )
			{
				$okdd .= chr($n);
				$i++;
			}
			else
			{
				$okdd .= $ddnum[$i];
			}
		}
		else
		{
			$okdd .= $ddnum[$i];
		}
	}
	return $okdd;
}
function GetCurContent($body,$type="news")
{
	global $_SC,$_SGLOBAL,$_SCONFIG;
	$cfg_basedir='';
	$cfg_uploaddir =$_SC['attachdir'].$type;
	$htd = new DedeHttpDown();
	
	$basehost = $_SCONFIG['siteurl'];
	$img_array = array();
	//preg_match_all("/src=[\"|'|\s]{0,}(http:\/\/([^>]*)\.(gif|jpg|png))/isU",$body,$img_array);
	
	preg_match_all("/src=[\"|'|\s]{0,}(http:\/\/([^>]*)\.(gif|jpg|png))(\"|'|\s)/isU",stripslashes($body),$img_array);
	$img_array = array_unique($img_array[1]);
	$imgUrl = $cfg_uploaddir.'/'.MyDate("Ymd",$_SGLOBAL["timestamp"]);
	$imgPath = $cfg_basedir.$imgUrl;
	$imgPath2=S_ROOT.$imgPath;
	if(!is_dir($imgPath2.'/'))
	{		
		mkdir($imgPath2,0755,true);
	}

	$milliSecond = MyDate('His',time());
	foreach($img_array as $key=>$value)
	{
		if(eregi($basehost,$value))
		{
			continue;
		}
		if(!eregi("^http://",$value))
		{
			continue;
		}
		$value=str_replace("\"","",$value);
		$itype = '.jpg';
		$isimg=0;
		if(stripos($value,"qq.com"))
		{
			$isimg=1;
		}else		
		{
			$htd->OpenUrl($value);
			$itype = $htd->GetHead("content-type");
			//echo eregi("(jpg|gif|png|jpeg)",$itype);
			
			if(eregi("(jpg|gif|png|jpeg)",$itype))			
			{
				if($itype=='image/gif')
				{
					$itype = ".gif";
				}elseif($itype=='image/png')
				{
					$itype = ".png";
				}
				else
				{
					$itype = '.jpg';
				}
				$isimg=1;
			}
		}
	
		$milliSecondN = dd2char($milliSecond.mt_rand(1000,8000));
		$value = trim($value);
		$rndFileName = $imgPath.'/'.$milliSecondN.'-'.$key.$itype;
		$fileurl = str_replace("./","/",$imgUrl).'/'.$milliSecondN.'-'.$key.$itype;
	
		//echo $fileurl;
		if($isimg==1)
		{
			$rs = $htd->SaveToBin(S_ROOT.$rndFileName);
			if($rs)		{
				$body = str_replace($value,$fileurl,$body);
			}
		}
	}
	$htd->Close();
	return $body;
}


?>