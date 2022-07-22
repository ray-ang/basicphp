<?php

class EncryptionController
{

	public function index()
	{
		$page_title = 'Data Encryption';
		$plaintext = '{"username":"user","role":"admin"}';
		$encrypted = Basic::encrypt($plaintext, PASS_PHRASE, 'encv2');
		$decrypted = Basic::decrypt($encrypted, PASS_PHRASE, 'encv2');

		Basic::view('encryption', compact('page_title', 'plaintext', 'encrypted', 'decrypted'));
	}
}
