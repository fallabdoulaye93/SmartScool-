<?php
require("lib/nusoap.php");
require("lib.php");

$namespace = "http://www.numherit-labs.com/sunuecole/webservices";
$server = new soap_server();
$server->debug_flag = false;
$server->configureWSDL("SunuEcole Webservices", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;
// Methode CreateEntity

$server->register(
    'Connection',                    // method name
    array
    (
        'email' => 'xsd:string',
        'password' => 'xsd:string'
    ),          // input parameters
    array('return' => 'xsd:int'),    // output parameters
    $namespace,                         // namespace
    $namespace . '#Connection',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'Se Connecter à app SunuEcole'        // documentation
);

function Connection($email, $password)
{
//    return ConnectUser($email, $password);
    return 22;
}

$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($HTTP_RAW_POST_DATA);
exit();