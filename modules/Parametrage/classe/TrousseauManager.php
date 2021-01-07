<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Trousseau.php');
require_once("../manager.php");

class TrousseauManager extends manager{
    protected $_listTrousseaux; // array
    protected $_nbreTrousseau;

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
        $this->_listTrousseaux[] = $obj;
        $this->_nbreTrousseau++;

    }

    // liste de tous les abonnements
    public function getTrousseaux($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Trousseau($donnee));
        }
        return $this->getListTrousseaux();

    }

    //liste d'un abonnement
    public function getTrousseau($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Trousseau($donnee));
        }
        return $this->getListTrousseaux();
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
    public function getListTrousseaux()
    {
        return $this->_listTrousseaux;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListTrousseaux($listTrousseaux)
    {
        $this->_listTrousseaux = $listTrousseaux;
    }

    /**
     * @return mixed
     */
    public function getNbreTrousseau()
    {
        return $this->_nbreTrousseau;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreTrousseau($nbreTrousseau)
    {
        $this->_nbreTrousseau = $nbreTrousseau;
    }





}
