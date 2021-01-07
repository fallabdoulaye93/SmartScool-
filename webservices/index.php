<?php
ini_set('display_errors', 0);
require("lib/nusoap.php");
require("lib.php");

$namespace = "http://www.numherit-labs.com/sunuecole/webservices";
$server = new soap_server();
$server->debug_flag = false;
$server->configureWSDL("SunuEcole Webservices", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;
// Methode CreateEntity

$server->register(
    'New_Souscription',                    // method name
    array
    (
        'nom_etab' => 'xsd:string',
        'sigle' => 'xsd:string',
        'adresse' => 'xsd:string',
        'telephone' => 'xsd:string',
        'ville' => 'xsd:string',
        'pays' => 'xsd:string',
        'email' => 'xsd:string',
        'siteweb' => 'xsd:string',
        'rc' => 'xsd:string',
        'ninea' => 'xsd:string',
        'prefixe' => 'xsd:string',
        'logo' => 'xsd:string',
        'nom' => 'xsd:string',
        'prenom' => 'xsd:string',
        'login' => 'xsd:string',
        'password' => 'xsd:string'
    ),          // input parameters
    array('return' => 'xsd:int'),    // output parameters
    $namespace,                         // namespace
    $namespace . '#New_Souscription',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'Créer un nouvel Etablissement'        // documentation
);

function New_Souscription($nom_etab, $sigle, $adresse, $telephone, $ville, $pays, $email, $siteweb, $rc, $ninea, $prefixe, $logo, $nom, $prenom, $login, $password)
{
    $testemail = GetIdEntity($email); //VERIFIE SI L'ETABLISSEMENT N'EXISTE PAS
    if ($testemail === 1) {
        $verif = VerifToken($login); //VERIFIE SI LE CLIENT N'EXISTE PAS
        if ($verif === 1) {
            $etab = AddEtablissement($nom_etab, $sigle, $adresse, $telephone, $ville, $pays, $email, $siteweb, $rc, $ninea, $prefixe, $logo);
            return ($etab !== 0 && $etab !== -403 && $etab !== -500 ) ?
                AddUser($nom, $prenom, $adresse, $telephone, $email, $login, $password, $etab, $prefixe) :
                ($etab * -1);
        } //sinon lentreprise n existe pas
        else return $verif;
    } //sinon lentreprise n existe pas
    else return $testemail;
}

$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($HTTP_RAW_POST_DATA);
exit();