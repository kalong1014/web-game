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

	preg_match_all("/\/attachment\/(.)*\.(jpg|png|jpeg|gif)/isU",stripslashes($body),$img_array);
	return $img_array[0];
}


?>