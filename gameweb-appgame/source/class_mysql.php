<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
class dbstuff {
	var $querynum = 0;
	var $querytime=0;
	var $link;
	var $charset;
	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE) {
		if($pconnect) {
			if(!$this->link = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$halt && $this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = @mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$halt && $this->halt('Can not connect to MySQL server');
			}
		}
		
		if($this->version() > '4.1') {
			if($this->charset) {
				@mysql_query("SET character_set_connection=$this->charset, character_set_results=$this->charset, character_set_client=binary", $this->link);
			}
			if($this->version() > '5.0.1') {
				@mysql_query("SET sql_mode=''", $this->link);
			}
		}
		if($dbname) {
			@mysql_select_db($dbname, $this->link);
		}
	}
	
	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}
	
	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	function query($sql, $type = '') {	
		$time_start=explode(" ",microtime());
		if(D_BUG) {
			global $_SGLOBAL;
			$sqlstarttime = $sqlendttime = 0;
			$mtime = explode(' ', microtime());
			$sqlstarttime = number_format(($mtime[1] + $mtime[0] - $_SGLOBAL['supe_starttime']), 6) * 1000;
		}
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		if(D_BUG) {
			$mtime = explode(' ', microtime());
			$sqlendttime = number_format(($mtime[1] + $mtime[0] - $_SGLOBAL['supe_starttime']), 6) * 1000;
			$sqltime = round(($sqlendttime - $sqlstarttime), 3);
			
			$explain = array();
			$info = mysql_info();
			if($query && preg_match("/^(select )/i", $sql)) {
				$explain = mysql_fetch_assoc(mysql_query('EXPLAIN '.$sql, $this->link));
			}
			$_SGLOBAL['debug_query'][] = array('sql'=>$sql, 'time'=>$sqltime, 'info'=>$info, 'explain'=>$explain);
		}
		$this->querynum++;
		$time_end=explode(" ",microtime());
		$c=$time_end[0]+$time_end[1]-$time_start[0]-$time_start[1];
		$this->querytime=floatval($c)+floatval($this->querytime);
		return $query;
	}
	///当更新space时删除相应的memcache
	function delspacememcache($sql)
	{
		global $_SGLOBAL, $_SCONFIG,$_SC;
		if (stristr($sql, "UPDATE uchome_space")==true)
		{
			$uidstr=stristr(str_replace('`','',$sql),"uid=");
			$uid=substr($uidstr,5,strlen ($uidstr)-6);
			$mc = new memcached($_SC['memcache']);
			$cachename = "space_".$uid."_uid";
			//echo $cachename;
			$mc->delete($cachename);
		}
	}
	
	//把update的sql语句放到memcache。方便合成
	function addtomemecahe($sqlstr)
	{
		global $_SGLOBAL, $_SCONFIG,$_SC;
		$exptime=60*1;//分钟为单位	
		if (stristr($sqlstr, "update ")==true)
		{
			$mc = new memcached($_SC['memcache']);
			$cachename = "space_update_sql";
			$res=$mc->get($cachename);
			//$mc->delete($cachename);
			if(empty($res))
			{
				$res=array();
				array_push($res ,$sqlstr);		
				$mc->add($cachename,$res,$exptime);
			}
			else
			{				
				array_push($res ,$sqlstr);
				$mc->replace($cachename,$res,$exptime);				
			}			
		}
		if (stristr($sqlstr, "insert ")==true)
		{						
			$mc = new memcached($_SC['memcache']);
			$cachename = "space_insert_sql";
			$res2=$mc->get($cachename);
			//$mc->delete($cachename);
			if(empty($res2))
			{
				$res2=array();
				array_push($res2 ,$sqlstr);		
				$mc->add($cachename,$res2,$exptime);
			}
			else
			{				
				array_push($res2 ,$sqlstr);
				$mc->replace($cachename,$res2,$exptime);				
			}			
		}
	}
	
	function affected_rows() {
		return mysql_affected_rows($this->link);
	}
	
	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}
	
	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());

	}
	
	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}
	
	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}
	
	function num_fields($query) {
		return mysql_num_fields($query);
	}
	
	function free_result($query) {
		return mysql_free_result($query);
	}
	
	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}
	
	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}
	
	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}
	
	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));
	}
	
	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}
	function version() {
		return mysql_get_server_info($this->link);
	}
	
	function close() {
		return mysql_close($this->link);
	}
	function ping(){
		global $_SGLOBAL, $_SC;
		if(!mysql_ping($this->link)){
			mysql_close($this->link); //注意：一定要先执行数据库关闭，这是关键
			$_SGLOBAL['db'] = new dbstuff;
			$_SGLOBAL['db']->charset = $_SC['dbcharset'];
			$_SGLOBAL['db']->connect($_SC['dbhost'], $_SC['dbuser'], $_SC['dbpw'], $_SC['dbname'], $_SC['pconnect']);
		}	
	} 
	function halt($message = '', $sql = '') {
		$dberror = $this->error();
		$dberrno = $this->errno();
		$path=S_ROOT."/data/log/".date('Y-m')."/";
		if(!is_dir($path)){
			mkdir($path);
		}
		$file=$path.date('Y-m-d').".txt";
		$msg="错误信息：".$dberror."; MYSQL语句：".$sql."  操作日期：".date('Y-m-d H:i')."\r\n";
		$open=fopen($file,"a+");
		fwrite($open,$msg);
		fclose($open);
		echo "数据库操作错误";
		exit();
	}
}
?>