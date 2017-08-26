<?php

	class DB
	{
		var $host;
		var $user;
		var $password;
		var $dbase;
		var $port;
		var $connected = FALSE;
		var $SQL;
		var $mysql_link;
		
		############################

		function getInsertId()
		{
			return mysql_insert_id($this->mysql_link);
		}

		function init()
		{
			if ($this->mysql_link=mysql_connect($this->host, $this->user, $this->password))
			{
				if (mysql_select_db($this->dbase, $this->mysql_link))
				{
					$this->connected = TRUE;
				}
				else
				{
					exit("Not select DB: " . mysql_error($this->mysql_link));
				}
			}
			else
			{
				exit("Not connect to BD: " . mysql_error($this->mysql_link));
			}
		}

		############################

		function insert($arr, $table, &$id)
		{
			$SQ_F = "";
			$SQ_V = "";
			if (count($arr)>0)
			{
				foreach ($arr as $k=>$v)
				{
					$SQ_F .= "`".mysql_real_escape_string($k)."`, ";
					$SQ_V .= "'".mysql_real_escape_string($v)."', ";
				}
				$SQ_F = trim($SQ_F, ", ");
				$SQ_V = trim($SQ_V, ", ");
				$SQL = "INSERT INTO `".$table."` ( ".$SQ_F." ) values ( ".$SQ_V." ) ";
				if ($this->Query($SQL))
				{
					$id = $this->getInsertId();
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
			$SQL = "";
		}

		############################

		function update($arr, $table, $SQ="")
		{
			$SQ_F = "";
			if ($SQ!="")
			{
				if (count($arr)>0)
				{
					foreach ($arr as $k=>$v)
					{
						$SQ_F .= "`".mysql_real_escape_string($k)."` = '".mysql_real_escape_string($v)."', ";
					}
					$SQ_F = trim($SQ_F, ", ");
					$SQL = "UPDATE `".$table."` SET " . $SQ_F . " WHERE " . $SQ;
					if ($this->Query($SQL))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		############################

		function getDBData($field, $table, $where, $order="", $group="", $limit="")
		{
			$SQL = "SELECT `$field` FROM `$table` WHERE 1=1 $where $order $group $limit";
			$ROW = $this->getRowBySQL($SQL);
			if ($ROW[$field]!="")
			{
				return $ROW[$field];
			}
			else
			{
				return FALSE;
			}
		}

		############################

		function getRowBySQL($SQL)
		{
			if ($RS=$this->Query($SQL))
			{
				if ($RW=$this->Fetch($RS))
				{
					return $RW;
				}
				else
				{
					return FALSE;
				}
			}
		}

		############################

		function getRowsBySQL($SQL, $start=0)
		{
			$result = Array();
			if ($RS=$this->Query($SQL))
			{
				$n = $start;
				$i = 0;
				while ($RW=$this->Fetch($RS))
				{
					$n++;
					$RW['even'] = ($n/2==ceil($n/2)) ? "1" : "0";
					$RW['key'] = $i;
					$RW['num'] = $n;
					$RW['color'] = ($n/2==ceil($n/2))?("#FEF4DE"):("#F0F0F0");
					array_push($result, $RW);
					$i++;
				}
			}
			if (count($result)>0)
			{
				$result[count($result)-1]['last'] = "1";
			}
			return $result;
		}

		############################

		function Query($SQL)
		{
			global $SQL_ARR;
			$start = time();
			$res = mysql_query($SQL, $this->mysql_link);
			$tm = time() - $start;
			$SQL_ARR[] = array("SQL"=>$SQL, "TIME"=>$tm);
			if ($res)
			{
				return $res;
			}
			else
			{
				$this->saveReport(mysql_error($this->mysql_link));
				return FALSE;
			}
			
		}

		############################

		function saveReport($rep, $out=1)
		{
			if ($out==0)
			{
				if ($f=fopen(MYSQL_ERROR_LOG, "a"))
				{
					fwrite($f, date("Y-m-d H:i:s")." - ERROR - ".$_SERVER['QUERY_STRING']." -\r\n\r\n".$rep."\r\n\r\n-------------------------------------------\r\n");
					fclose($f);
				}
			}
			else
			{
				echo $rep;
			}
		}

		############################

		function Fetch($res)
		{
			if ($row = mysql_fetch_assoc($res))
			{ 
				return $row;
			}
			else
			{
				return FALSE;
			}
		}

		###########################
	}

?>