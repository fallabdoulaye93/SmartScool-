<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/FraisInscription.php');
require_once("../manager.php");

class FraisInscriptionManager extends manager{
    protected $_listFraisInscriptions; // array
    protected $_nbreFraisInscription;

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
        $this->_listFraisInscriptions[] = $obj;
        $this->_nbreFraisInscription++;

    }

    // liste de tous les abonnements
    public function getFraisInscriptions($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new FraisInscription($donnee));
        }
        return $this->getListFraisInscriptions();

    }

    public function supprimer($fieldId,$idValue)
    {
        $info=parent::supprimer($fieldId,$idValue);
        return $info;
    }

    //liste d'un abonnement
    public function getFraisInscription($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new FraisInscription($donnee));
        }
        return $this->getListFraisInscriptions();
    }


    function insert($values) {
        $donnees=parent::insert($values);
        return $donnees;
    }



    function modifier($values,$idField,$idValue) {
        $info=parent::modifier($values,$idField,$idValue);
        return $info;
    }

    /**
     * @return mixed
     */
    public function getListFraisInscriptions()
    {
        return $this->_listFraisInscriptions;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListFraisInscriptions($listFraisInscriptions)
    {
        $this->_listFraisInscriptions = $listFraisInscriptions;
    }

    /**
     * @return mixed
     */
    public function getNbreFraisInscription()
    {
        return $this->_nbreFraisInscription;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreFraisInscription($nbreFraisInscription)
    {
        $this->_nbreFraisInscription = $nbreFraisInscription;
    }





}
