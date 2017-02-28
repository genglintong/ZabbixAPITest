<?php
// load ZabbixApi
require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;

try
{
	// connect to Zabbix API
	//zabbixAPI  账户 密码
	$api = new ZabbixApi('http://zabbix地址/zabbix/api_jsonrpc.php', '账号', '密码');

	// 获取所有主机
	$graphs = $api->hostGet();
	
	// 打印所有主机id
	foreach($graphs as $graph){
		echo $graph->hostid."<br>";
		//var_dump($graph)."<br>";
	}
	
	//获取所有主机ip,hostid
	$graphs = $api->hostGet(array(
	    //模糊匹配
		'output' => [ 'name', 'host' ] ,	
		//'selectInterfaces' => [ "interfaces", "ip" ]	
		//过滤 ip
	));
	// 打印所有主机ip
	foreach($graphs as $graph){
		echo $graph->host."    ".$graph->name."<br>";
		//var_dump($graph)."<br>";
	}
	//获取某一主机所有监控项id
	$items = $api->itemGet(array(
		'output' =>['itemid','name'],//若为extend 则为走做所有项
		'hostids' =>'10130',//主机id
		'search' => array()//可以设置搜索条件
	));
	$i =0;//计数，可忽略
	foreach ($items as $item){
		$i++;
		echo $item->itemid." ".$item->name."<br>";
		//var_dump($item);
	}
	echo $i;
	
	$datas = $api->historyGet(array(
		'history' => '0',//获取所有数据
		//"time_from":"1398873600",   //起始时间
		//"time_till":"1399046400",   //终止时间 
		//
		//'hostids' =>'10130',//主机id
		'itemids' => '25016',
		'output' => 'extend',
		'search' =>array(),
		'limit' =>10	//获取十条
		
			
	));
	echo "data";
	foreach ($datas as $data){
		//echo "data";
		var_dump($data);
		echo $data->itemid."<br>";
	}
	
	// get all graphs named "CPU"
	$cpuGraphs = $api->graphGet(array(
			'output' => 'extend',
			'search' => array('name' => 'Http')
	));
	
	// print graph ID with graph name
	foreach($cpuGraphs as $graph)
		printf("id:%d name:%s\n", $graph->graphid, $graph->name);
	/* ... do your stuff here ... */
}
catch(Exception $e)
{
	// Exception in ZabbixApi catched
	echo $e->getMessage();
}
?>
