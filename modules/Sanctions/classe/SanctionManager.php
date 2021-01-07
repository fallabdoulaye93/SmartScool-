<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Sanction.php');
require_once("../manager.php");

class SanctionManager extends manager{
    protected $_listSanctions; // array
    protected $_nbreSanction;

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
        $this->_listSanctions[] = $obj;
        $this->_nbreSanction++;

    }

    // liste de tous les abonnements
    public function getSanctions($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Sanction($donnee));
        }
        return $this->getListSanctions();

    }

    //liste d'un abonnement
    public function getSanction($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Sanction($donnee));
        }
        return $this->getListSanctions();
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
    public function getListSanctions()
    {
        return $this->_listSanctions;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListSanctions($listSanctions)
    {
        $this->_listSanctions = $listSanctions;
    }

    /**
     * @return mixed
     */
    public function getNbreSanction()
    {
        return $this->_nbreSanction;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreSanction($nbreSanction)
    {
        $this->_nbreSanction = $nbreSanction;
    }





}
