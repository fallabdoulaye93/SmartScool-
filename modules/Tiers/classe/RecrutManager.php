<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Recrut.php');
require_once("../manager.php");

class RecrutManager extends manager{
    protected $_listRecruts; // array
    protected $_nbreRecrut;

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
        $this->_listRecruts[] = $obj;
        $this->_nbreRecrut++;

    }

    // liste de tous les abonnements
    public function getRecruts($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Recrut($donnee));
        }
        return $this->getListRecruts();

    }

    //liste d'un abonnement
    public function getRecrut($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Recrut($donnee));
        }
        return $this->getListRecruts();
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
    public function getListRecruts()
    {
        return $this->_listRecruts;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListRecruts($listRecruts)
    {
        $this->_listRecruts = $listRecruts;
    }

    /**
     * @return mixed
     */
    public function getNbreRecrut()
    {
        return $this->_nbreRecrut;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreRecrut($nbreRecrut)
    {
        $this->_nbreRecrut = $nbreRecrut;
    }





}
