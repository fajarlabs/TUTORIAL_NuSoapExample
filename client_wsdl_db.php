<?php
require_once('lib/nusoap.php');

// Autentikasi username dan passwordnya
$username = "user";
$password = "password";

// URL WSDL-nya
$wsdl = "http://localhost:81/nusoap/server_wsdl_db.php?wsdl";

// Buat instansi nusoap client
$client =new nusoap_client($wsdl,true);

// Panggil metode-nya
$parameter = array('username'=>$username,'password'=>$password);

// Hasil dari metode-nya setelah di panggil oleh client
$result = $client->call('login', $parameter);

// Periksa hasilnya
if( $result == "Login Salah" ) 
	echo "$result";
else {
	echo "id: $result <br />";
	echo "login sukses";
}

// Periksa content Requestnya
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';

// Periksa content responsenya
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

?>