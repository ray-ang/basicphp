<?php

class EncryptionController
{

	public function index()
	{
		$page_title = 'Data Encryption';
		$plaintext = 'ABC123';
		$encrypted = Basic::encrypt($plaintext);
		$decrypted = Basic::decrypt($encrypted);

		Basic::view('encryption', compact('page_title', 'plaintext', 'encrypted', 'decrypted'));
	}

}
