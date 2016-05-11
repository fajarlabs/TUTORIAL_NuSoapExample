<?php

// Include library nusoap
require_once('lib/nusoap.php');

// URL Schema
$URL = "http://localhost:81/nusoap/";

// Instansiasi SOAP SERVER
$server = new soap_server;

// Membuat metode service-nya
$server->configureWSDL('login', $URL);
$server->wsdl->schemaTargetNamespace = $URL;

$server->register('login', 							// nama metodenya
				   array(
				   		'username' => 'xsd:string', // Parameter awalnya
				   		'password'=> 'xsd:string'   // Parameter akhirnya
				   	),
				   array('return'=>'xsd:string'),   // Tipe returnya
				   $URL);                           // URLnya

// Ini metode-nya
function login($username,$password) { 
	
	// Periksa apakah username-nya belum di isi ?
	if (!$username)
		return new soap_fault('Client', '', 'Harus ada nilainya!', '');

	if ($conn = mysql_connect("localhost", "root", "")) {

		if ($db = mysql_select_db("soa")) {
			$passMD5 = md5($password);
			$result = mysql_query("SELECT * FROM customer WHERE username = '$username' and password='$passMD5'");
			$totalRows = mysql_num_rows($result);

			while ($row = mysql_fetch_array($result)) {
				$id = $row["id_customer"];
				$username = $row["username"];
				$nama = $row["nama"];
				$alamat = $row["alamat"];
				$email = $row["email"];
				$telp = $row["telp"];
			}

		} else
			return new soap_fault('Database Server', '', 'Koneksi ke database gagal!', '');

	} else
		return new soap_fault('Database Server', '', 'Koneksi ke database gagal!', '');

	if($totalRows > 0)
		return "$id";
	else
		return "Login Salah";
}

// Buka service-nya
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);

exit();

?>