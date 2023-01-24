<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Transport.php');
require_once("../manager.php");

class TransportManager extends manager{
    protected $_listTransports; // array
    protected $_nbreTransport;

    /**
     * EvenementManager constructor.
     * @param $_db
     * @param $_table
     */
    public function __construct($db,$table)
    {
        parent::__construct($db,$table);
    }
    public function add($obj)
    {
        $this->_listTransports[] = $obj;
        $this->_nbreTransport++;

    }

    // liste de tous les abonnements
    public function getTransports($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Niveau($donnee));
        }
        return $this->getListTransports();

    }

    //liste d'un abonnement
    public function getTransport($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Transport($donnee));
        }
        return $this->getListTransports();
    }


    function insert($values) {
        $donnees=parent::insert($values);
        return $donnees;
    }



    function modifier($values,$idField,$idValue) {
        $info=parent::modifier($values,$idField,$idValue);
        return $info;
    }

    public function supprimer($fieldId,$idValue)
    {
        $info=parent::supprimer($fieldId,$idValue);
        return $info;
    }

    /**
     * @return mixed
     */
    public function getListTransports()
    {
        return $this->_listTransports;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setlistTransports($listTransports)
    {
        $this->_listTransports = $listTransports;
    }

    /**
     * @return mixed
     */
    public function getNbreTransport()
    {
        return $this->_nbreTransport;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreTransport($nbreTransport)
    {
        $this->_nbreTransport = $nbreTransport;
    }





}
