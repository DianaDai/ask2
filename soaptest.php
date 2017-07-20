<?php

header('Content-type:text/html;charset=utf-8');
require_once('lib/nusoap/nusoap.php');


$client = new soapclient('http://192.168.9.132/webapp/Service1.asmx?wsdl',true);

$client->soap_defencoding = 'utf-8';   
$client->decode_utf8 = false;   
$client->xml_encoding = 'utf-8';

$pars = array('info'=>'中集销售部');

$result = $client->call('GetTable',$pars);

$dom = new DOMDocument();

$dom->loadXML($result['GetTableResult']);

$node= $dom->documentElement;

var_dump($node);


var_dump($result);

