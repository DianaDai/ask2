<?php


header('Content-type:text/html; charset=utf-8');

$server= '172.16.1.161';
$id = 'sa';
$pwd = '123abcABC';
$dbname = 'CM';

$msdb = mssql_connect($server,$id,$pwd);


if (!$msdb)
{
	echo "can't connect mssqlserver'";
    exit();
}

mssql_select_db($dbname);


$query = "select ADMIN_UNIT_ID, ADMIN_UNIT_CODE ,ADMIN_UNIT_NAME from ADMIN_UNIT  ";


$result = mssql_query($query,$msdb);

while ($row = mssql_fetch_array($result))
{
	print_r($row);
}

mssql_free_result($result);

