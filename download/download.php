<?php
require_once 'vendor/autoload.php';

function download($url, $method = 'GET') {
	$client = new \GuzzleHttp\Client ();//http://docs.guzzlephp.org/en/stable/
	$headers = [ 
			'headers' => [ 
					'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:64.0) Gecko/20100101 Firefox/64.0'//26dez2018 
			],
		    'http_errors' => false
		    //http://docs.guzzlephp.org/en/stable/request-options.html#http-errors
	];
	$res = $client->request ( $method, $url, $headers );
	if ($res->getStatusCode () == 200) {
		return $res->getBody ();
	} else {
		return false;
	}
}
?>
