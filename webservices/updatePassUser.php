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
    'update_Password_Souscription',                    // method name
    array
    (
        'login' => 'xsd:string',
        'password' => 'xsd:string'
    ),          // input parameters
    array('return' => 'xsd:int'),    // output parameters
    $namespace,                         // namespace
    $namespace . '#New_Souscription',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'Modifier mot de passe utilisateur'        // documentation
);

function update_Password_Souscription($login, $password)
{
    return UpdatePassUser($login, $password);
}

$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($HTTP_RAW_POST_DATA);
exit();