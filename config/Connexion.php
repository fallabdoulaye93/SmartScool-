<?php
/**
 * Created by PhpStorm.
 * User: developpeur3
 * Date: 01/02/2016
 * Time: 10:58
 */
class Connexion

{
    function Connection(){

        $conn = NULL;


        try{
            $this->pdo = new PDO("mysql:host=mysql-layefall93.alwaysdata.net;dbname=layefall93_scool", "221763_root", "layeFALL93");
		    $conn = new PDO("mysql:host=mysql-layefall93.alwaysdata.net;dbname=layefall93_scool", "221763_root", "layeFALL93");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            return -1;
        }


    }



    public function CloseConnexion($dbh)
    {
        $dbh=null;

    }


}
?>
