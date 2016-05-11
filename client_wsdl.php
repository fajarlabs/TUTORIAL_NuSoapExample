<?php
// Includekan library nusoap
require_once('lib/nusoap.php');

// URL Server WSDL-nya
$wsdl="http://localhost:81/nusoap/server_wsdl.php?wsdl";

// Buat instansi client-nya
$client =new nusoap_client($wsdl,true);

// periksa errornya
$err = $client->getError();
if ($err) {
    // Menampilkan pesan errornya
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

// Panggil metode SOAP-nya
$result = $client->call('hello', array('name' => 'Scott'));

// Periksa kegagalan metode
if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
    // Periksa errornya
	$err = $client->getError();
	if ($err) {
        // Tampilkan errornya
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
        // Tampilkan hasilnya
		echo '<h2>Result</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
}
// Tampilkan request dan responnya
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

// Tampilkan pesan debug
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>