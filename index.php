<?php
// load ZabbixApi
require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;

try
{
	// connect to Zabbix API
	//zabbixAPI  �˻� ����
	$api = new ZabbixApi('http://10.3.181.34/zabbix/api_jsonrpc.php', 'admin', 'zabbix');

	// ��ȡ��������
	$graphs = $api->hostGet();
	
	// ��ӡ��������id
	foreach($graphs as $graph){
		echo $graph->hostid."<br>";
		//var_dump($graph)."<br>";
	}
	
	//��ȡ��������ip,hostid
	$graphs = $api->hostGet(array(
	    //ģ��ƥ��
		'output' => [ 'name', 'host' ] ,	
		//'selectInterfaces' => [ "interfaces", "ip" ]	
		//���� ip
	));
	// ��ӡ��������ip
	foreach($graphs as $graph){
		echo $graph->host."    ".$graph->name."<br>";
		//var_dump($graph)."<br>";
	}
	//��ȡĳһ�������м����id
	$items = $api->itemGet(array(
		'output' =>['itemid','name'],//��Ϊextend ��Ϊ����������
		'hostids' =>'10130',//����id
		'search' => array()//����������������
	));
	$i =0;//�������ɺ���
	foreach ($items as $item){
		$i++;
		echo $item->itemid." ".$item->name."<br>";
		//var_dump($item);
	}
	echo $i;
	
	$datas = $api->historyGet(array(
		'history' => '0',//��ȡ��������
		//"time_from":"1398873600",   //��ʼʱ��
		//"time_till":"1399046400",   //��ֹʱ�� 
		//
		//'hostids' =>'10130',//����id
		'itemids' => '25016',
		'output' => 'extend',
		'search' =>array(),
		'limit' =>10	//��ȡʮ��
		
			
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