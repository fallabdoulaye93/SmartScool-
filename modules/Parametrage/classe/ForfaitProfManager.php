<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/ForfaitProf.php');
require_once("../manager.php");

class ForfaitProfManager extends manager{
    protected $_listFORFAIT_PROFESSEURx; // array
    protected $_nbreFORFAIT_PROFESSEUR;

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
        $this->_listFORFAIT_PROFESSEURx[] = $obj;
        $this->_nbreFORFAIT_PROFESSEUR++;

    }

    // liste de tous les abonnements
    public function getFORFAIT_PROFESSEURx($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new FORFAIT_PROFESSEUR($donnee));
        }
        return $this->getListFORFAIT_PROFESSEUR();

    }

    //liste d'un abonnement
    public function getFORFAIT_PROFESSEUR($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new FORFAIT_PROFESSEUR($donnee));
        }
        return $this->getListFORFAIT_PROFESSEUR();
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
    public function getListFORFAIT_PROFESSEUR()
    {
        return $this->_listFORFAIT_PROFESSEURx;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListFORFAIT_PROFESSEURx($listFORFAIT_PROFESSEURx)
    {
        $this->_listFORFAIT_PROFESSEURx = $listFORFAIT_PROFESSEURx;
    }

    /**
     * @return mixed
     */
    public function getNbreFORFAIT_PROFESSEUR()
    {
        return $this->_nbreFORFAIT_PROFESSEUR;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreFORFAIT_PROFESSEUR($nbreFORFAIT_PROFESSEUR)
    {
        $this->_nbreFORFAIT_PROFESSEUR = $nbreFORFAIT_PROFESSEUR;
    }





}
