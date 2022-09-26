<?php
/**
 * HTTP-RPC Controller
 * 
 * Endpoint: api/httprpc (Basic::setHttpRpc())
 * Parameters: ?action=HttpRpc.calcDouble&num=5&token=12345
 * Result: 10
 */

class HttpRpcController extends Basic
{
	private $token = '12345';

	public function __construct()
	{
		$this->_verify_access();
	}

	public function _verify_access()
	{
		if (empty($_GET['token']) || $_GET['token'] !== $this->token) {
			self::apiResponse(401, 'Invalid token.');
		}
	}

	public function calcSingle()
	{
		$num = $_GET['num'];
		if (! is_numeric($num)) self::apiResponse(400, 'Error: Num parameter should be a number.');
		$res = $num;
		
		return $res;
	}

	public function calcDouble()
	{
		$num = $_GET['num'];
		if (! is_numeric($num)) self::apiResponse(400, 'Error: Num parameter should be a number.');
		$res = $num * 2;
		
		return $res;
	}

}
