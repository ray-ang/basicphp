<?php
/**
 * JSON-RPC Controller
 * 
 * Endpoint: api/jsonrpc (Basic::setJsonRpc())
 * 
 * Individual
 * Request: {"jsonrpc":"2.0","method":"JsonRpc.calcDouble","params":{"num":5},"id":2}
 * Response: {"jsonrpc":"2.0","result":"10","id":"2"}
 * 
 * Batch
 * Request: [{"jsonrpc":"2.0","method":"JsonRpc.calcSingle","params":{"num":5},"id":1},{"jsonrpc":"2.0","method":"JsonRpc.calcDouble","params":{"num":5},"id":2}]
 * Response: [{"jsonrpc":"2.0","result":"5","id":"1"},{"jsonrpc":"2.0","result":"10","id":"2"}]
 */

class JsonRpcController
{

	public function calcSingle($params=[], $id='')
	{
		// Request validation - Params and ID
		if (empty($params) && empty($id)) $res = '{"jsonrpc":"2.0","error":{"code":-32602,"message":"Parameters and ID must be set."}}';
		if (! empty($params) && empty($id)) $res = '{"jsonrpc":"2.0","error":{"code":-32602,"message":"ID must be set."}}';
		if (empty($params) && ! empty($id)) $res = '{"jsonrpc":"2.0","error":{"code":-32602,"message":"Parameters must be set."}}';

		if (! empty($params) && ! empty($id)) {
			$res = '{"jsonrpc":"2.0","result":"' . $params['num'] . '","id":"' . $id . '"}'; // Result = num
		}
		
		return $res;
	}

	public function calcDouble($params=[], $id='')
	{
		// Request validation - Params and ID
		if (empty($params) && empty($id)) $res = '{"jsonrpc":"2.0","error":{"code":-32602,"message":"Parameters and ID must be set."}}';
		if (! empty($params) && empty($id)) $res = '{"jsonrpc":"2.0","error":{"code":-32602,"message":"ID must be set."}}';
		if (empty($params) && ! empty($id)) $res = '{"jsonrpc":"2.0","error":{"code":-32602,"message":"Parameters must be set."}}';

		if (! empty($params) && ! empty($id)) {
			$res = '{"jsonrpc":"2.0","result":"' . $params['num'] * 2 . '","id":"' . $id . '"}'; // Result = num x 2
		}
		
		return $res;
	}

}
