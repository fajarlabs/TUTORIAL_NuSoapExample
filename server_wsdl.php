<?php
// Include-kan nusoap
require_once('lib/nusoap.php');

// Buat instansi soap server
$server = new soap_server();

// Inisialisasi WSDL support
$server->configureWSDL('server_wsdl', 'urn:server_wsdl');

// Register the method to expose
$server->register('hello',                // method name
    array('name' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:server_wsdl',                      // namespace
    'urn:server_wsdl#hello',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Says hello to the caller'            // documentation
    );

// Define the method as a PHP function
function hello($name) {
	return 'Hellooo, ' . $name;
}
// Use the request to (try to) invoke the service
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);
?>