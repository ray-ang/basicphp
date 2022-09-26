<?php
/**
 * HTTP-RPC Controller
 * 
 * Endpoint: api/httprpc (Basic::setHttpRpc())
 */

class HttpRpcController
{

	public function calcSingle()
	{
		$num = $_GET['num'];
		if (! is_numeric($num)) Basic::apiResponse(400, 'Error: Num parameter should be a number.');
		$res = $num;
		
		return $res;
	}

	public function calcDouble()
	{
		$num = $_GET['num'];
		if (! is_numeric($num)) Basic::apiResponse(400, 'Error: Num parameter should be a number.');
		$res = $num * 2;
		
		return $res;
	}

}
